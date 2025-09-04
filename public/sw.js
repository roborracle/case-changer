// Case Changer Service Worker
// Provides offline functionality and caching for the text transformation tool

const CACHE_NAME = 'case-changer-v1.2.0';
const STATIC_CACHE = `${CACHE_NAME}-static`;
const DYNAMIC_CACHE = `${CACHE_NAME}-dynamic`;

// Resources to cache immediately
const PRECACHE_RESOURCES = [
  '/',
  '/tool',
  '/manifest.json',
  '/js/text-transformer-worker.js',
  // CSS and JS files will be added by the install event
];

// Resources that should always be fetched from network
const NETWORK_FIRST_PATTERNS = [
  /\/livewire\//,
  /\/api\//,
  /\.php$/,
];

// Resources that can be served from cache first
const CACHE_FIRST_PATTERNS = [
  /\.css$/,
  /\.js$/,
  /\.png$/,
  /\.jpg$/,
  /\.jpeg$/,
  /\.svg$/,
  /\.gif$/,
  /\.webp$/,
  /\.woff2?$/,
  /\.ttf$/,
  /\.eot$/,
];

// Maximum cache age (in milliseconds)
const MAX_CACHE_AGE = 7 * 24 * 60 * 60 * 1000; // 7 days

// Install event - cache essential resources
self.addEventListener('install', event => {
  console.log('[SW] Installing service worker...');
  
  event.waitUntil(
    (async () => {
      const cache = await caches.open(STATIC_CACHE);
      
      // Get current build manifest if available
      try {
        const manifestResponse = await fetch('/build/manifest.json');
        if (manifestResponse.ok) {
          const manifest = await manifestResponse.json();
          const buildFiles = Object.values(manifest).map(file => `/${file.file}`);
          PRECACHE_RESOURCES.push(...buildFiles);
        }
      } catch (e) {
        console.log('[SW] Could not fetch build manifest, using default resources');
      }
      
      console.log('[SW] Precaching resources:', PRECACHE_RESOURCES);
      await cache.addAll(PRECACHE_RESOURCES);
      
      // Skip waiting to activate immediately
      self.skipWaiting();
    })()
  );
});

// Activate event - cleanup old caches
self.addEventListener('activate', event => {
  console.log('[SW] Activating service worker...');
  
  event.waitUntil(
    (async () => {
      // Clean up old caches
      const cacheNames = await caches.keys();
      const cachesToDelete = cacheNames.filter(name => 
        name.startsWith('case-changer-') && name !== STATIC_CACHE && name !== DYNAMIC_CACHE
      );
      
      await Promise.all(cachesToDelete.map(name => caches.delete(name)));
      
      // Take control of all clients immediately
      await self.clients.claim();
      
      console.log('[SW] Service worker activated and controlling all clients');
      
      // Notify clients that SW is ready
      const clients = await self.clients.matchAll();
      clients.forEach(client => {
        client.postMessage({
          type: 'SW_ACTIVATED',
          message: 'Service worker activated - offline support enabled'
        });
      });
    })()
  );
});

// Fetch event - handle all network requests
self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);
  
  // Skip non-GET requests and chrome-extension requests
  if (request.method !== 'GET' || url.protocol === 'chrome-extension:') {
    return;
  }
  
  event.respondWith(handleFetch(request));
});

// Main fetch handler with different strategies
async function handleFetch(request) {
  const url = new URL(request.url);
  
  // Network first for dynamic content (Livewire, APIs)
  if (NETWORK_FIRST_PATTERNS.some(pattern => pattern.test(url.pathname))) {
    return await networkFirst(request);
  }
  
  // Cache first for static assets
  if (CACHE_FIRST_PATTERNS.some(pattern => pattern.test(url.pathname))) {
    return await cacheFirst(request);
  }
  
  // Stale while revalidate for HTML pages
  return await staleWhileRevalidate(request);
}

// Network first strategy (with fallback)
async function networkFirst(request) {
  try {
    const networkResponse = await fetch(request);
    
    // Only cache successful responses
    if (networkResponse.status === 200) {
      const cache = await caches.open(DYNAMIC_CACHE);
      cache.put(request, networkResponse.clone());
    }
    
    return networkResponse;
  } catch (error) {
    console.log('[SW] Network failed, trying cache:', request.url);
    
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }
    
    // Return offline fallback for HTML requests
    if (request.headers.get('accept').includes('text/html')) {
      return await getOfflineFallback();
    }
    
    throw error;
  }
}

// Cache first strategy
async function cacheFirst(request) {
  const cachedResponse = await caches.match(request);
  
  if (cachedResponse) {
    // Check if cache is still fresh
    const cacheDate = cachedResponse.headers.get('sw-cache-date');
    if (cacheDate && (Date.now() - parseInt(cacheDate)) < MAX_CACHE_AGE) {
      return cachedResponse;
    }
  }
  
  try {
    const networkResponse = await fetch(request);
    
    if (networkResponse.status === 200) {
      const cache = await caches.open(STATIC_CACHE);
      
      // Add cache date header
      const responseToCache = new Response(networkResponse.body, {
        status: networkResponse.status,
        statusText: networkResponse.statusText,
        headers: {
          ...networkResponse.headers,
          'sw-cache-date': Date.now().toString()
        }
      });
      
      cache.put(request, responseToCache.clone());
      return responseToCache;
    }
    
    return networkResponse;
  } catch (error) {
    if (cachedResponse) {
      return cachedResponse;
    }
    throw error;
  }
}

// Stale while revalidate strategy
async function staleWhileRevalidate(request) {
  const cachedResponse = caches.match(request);
  
  const networkFetch = fetch(request).then(networkResponse => {
    if (networkResponse.status === 200) {
      const cache = caches.open(DYNAMIC_CACHE);
      cache.then(c => c.put(request, networkResponse.clone()));
    }
    return networkResponse;
  }).catch(() => {
    // Network failed, return cached version if available
    return cachedResponse;
  });
  
  return cachedResponse || networkFetch;
}

// Create offline fallback page
async function getOfflineFallback() {
  const offlineHTML = `
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Case Changer - Offline</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                text-align: center;
                padding: 20px;
            }
            .offline-container {
                max-width: 500px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                padding: 40px;
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .offline-icon {
                font-size: 64px;
                margin-bottom: 20px;
            }
            .offline-title {
                font-size: 2rem;
                margin-bottom: 20px;
                font-weight: 600;
            }
            .offline-message {
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 30px;
                opacity: 0.9;
            }
            .retry-button {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                cursor: pointer;
                font-size: 1rem;
                transition: all 0.3s ease;
            }
            .retry-button:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-2px);
            }
            .features {
                margin-top: 30px;
                text-align: left;
                font-size: 0.9rem;
                opacity: 0.8;
            }
            .features ul {
                list-style: none;
                padding: 0;
            }
            .features li {
                margin: 10px 0;
                padding-left: 20px;
                position: relative;
            }
            .features li:before {
                content: '✓';
                position: absolute;
                left: 0;
                color: #4ade80;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="offline-container">
            <div class="offline-icon">📱</div>
            <h1 class="offline-title">You're Offline</h1>
            <p class="offline-message">
                Don't worry! Case Changer works offline too. 
                Your basic text transformations are still available.
            </p>
            <button class="retry-button" onclick="location.reload()">
                Try Again
            </button>
            
            <div class="features">
                <h3>Available Offline:</h3>
                <ul>
                    <li>All basic text transformations</li>
                    <li>Character and word counting</li>
                    <li>Auto-save functionality</li>
                    <li>Export to files</li>
                    <li>Undo/redo operations</li>
                </ul>
            </div>
        </div>
        
        <script>
            // Check online status
            window.addEventListener('online', () => {
                location.reload();
            });
            
            // Show connection status
            if (navigator.onLine) {
                document.querySelector('.offline-message').innerHTML = 
                    'Connection restored! <a href="/" style="color: #4ade80;">Return to Case Changer</a>';
            }
        </script>
    </body>
    </html>
  `;
  
  return new Response(offlineHTML, {
    headers: {
      'Content-Type': 'text/html',
      'Cache-Control': 'no-cache'
    }
  });
}

// Message handler for communication with main thread
self.addEventListener('message', event => {
  const { type, data } = event.data;
  
  switch (type) {
    case 'SKIP_WAITING':
      self.skipWaiting();
      break;
      
    case 'GET_CACHE_INFO':
      getCacheInfo().then(info => {
        event.ports[0].postMessage(info);
      });
      break;
      
    case 'CLEAR_CACHE':
      clearCache().then(success => {
        event.ports[0].postMessage(success);
      });
      break;
      
    case 'CACHE_TEXT_TRANSFORMATION':
      cacheTextTransformation(data).then(success => {
        event.ports[0].postMessage(success);
      });
      break;
      
    default:
      console.log('[SW] Unknown message type:', type);
  }
});

// Get cache information
async function getCacheInfo() {
  const cacheNames = await caches.keys();
  const info = {
    cacheNames,
    size: 0,
    itemCount: 0
  };
  
  for (const name of cacheNames) {
    const cache = await caches.open(name);
    const keys = await cache.keys();
    info.itemCount += keys.length;
    
    // Estimate size (rough calculation)
    for (const key of keys) {
      const response = await cache.match(key);
      if (response) {
        const text = await response.text();
        info.size += text.length;
      }
    }
  }
  
  return info;
}

// Clear all caches
async function clearCache() {
  try {
    const cacheNames = await caches.keys();
    await Promise.all(cacheNames.map(name => caches.delete(name)));
    return true;
  } catch (error) {
    console.error('[SW] Error clearing cache:', error);
    return false;
  }
}

// Cache text transformation for offline use
async function cacheTextTransformation(data) {
  try {
    const cache = await caches.open(DYNAMIC_CACHE);
    const response = new Response(JSON.stringify(data), {
      headers: {
        'Content-Type': 'application/json',
        'sw-cache-date': Date.now().toString()
      }
    });
    
    const cacheKey = `transformation-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    await cache.put(new Request(cacheKey), response);
    return true;
  } catch (error) {
    console.error('[SW] Error caching transformation:', error);
    return false;
  }
}

// Periodic cache cleanup
setInterval(async () => {
  const cacheNames = await caches.keys();
  
  for (const name of cacheNames) {
    const cache = await caches.open(name);
    const requests = await cache.keys();
    
    for (const request of requests) {
      const response = await cache.match(request);
      const cacheDate = response.headers.get('sw-cache-date');
      
      if (cacheDate && (Date.now() - parseInt(cacheDate)) > MAX_CACHE_AGE) {
        await cache.delete(request);
        console.log('[SW] Cleaned up expired cache entry:', request.url);
      }
    }
  }
}, 60 * 60 * 1000); // Run every hour

console.log('[SW] Service worker script loaded');