#!/usr/bin/env node

/**
 * TaskMaster continuous mode watcher
 * Monitors task status changes and triggers auto-commit on completion
 */

const fs = require('fs');
const path = require('path');
const { spawn, execSync } = require('child_process');

// Configuration
const TASK_FILE = path.join(process.cwd(), '.taskmaster/tasks/tasks.json');
const STATE_FILE = path.join(process.cwd(), '.taskmaster/state.json');
const LOG_FILE = path.join(process.cwd(), 'logs/taskmaster-commit.log');
const COMMIT_SCRIPT = path.join(process.cwd(), 'scripts/commit_on_task_complete.sh');
const POLL_INTERVAL = 2000; // 2 seconds
const DEBOUNCE_DELAY = 500; // 500ms debounce for file changes

// State tracking
let lastKnownState = {};
let debounceTimer = null;
let isProcessing = false;

// Ensure log directory exists
const logDir = path.dirname(LOG_FILE);
if (!fs.existsSync(logDir)) {
    fs.mkdirSync(logDir, { recursive: true });
}

/**
 * Log message with timestamp
 */
function log(level, message) {
    const timestamp = new Date().toISOString();
    const logLine = `[${timestamp}] [${level}] ${message}`;
    
    // Console output
    if (level === 'ERROR') {
        console.error(`\x1b[31m[error]\x1b[0m ${message}`);
    } else if (level === 'INFO') {
        console.log(`\x1b[32m[info]\x1b[0m ${message}`);
    } else {
        console.log(`[${level.toLowerCase()}] ${message}`);
    }
    
    // File logging
    try {
        fs.appendFileSync(LOG_FILE, logLine + '\n');
    } catch (err) {
        console.error('Failed to write to log file:', err.message);
    }
}

/**
 * Safely read and parse JSON file
 */
function readJsonFile(filePath) {
    try {
        if (!fs.existsSync(filePath)) {
            return null;
        }
        const content = fs.readFileSync(filePath, 'utf8');
        return JSON.parse(content);
    } catch (err) {
        log('ERROR', `Failed to read/parse ${filePath}: ${err.message}`);
        return null;
    }
}

/**
 * Extract all tasks from the nested structure
 */
function extractTasks(tasksData) {
    const tasks = [];
    
    if (!tasksData) return tasks;
    
    // Handle different task file structures
    if (tasksData.master && tasksData.master.tasks) {
        tasks.push(...tasksData.master.tasks);
    } else if (Array.isArray(tasksData)) {
        tasks.push(...tasksData);
    } else if (tasksData.tasks) {
        tasks.push(...tasksData.tasks);
    }
    
    // Extract subtasks recursively
    tasks.forEach(task => {
        if (task.subtasks && Array.isArray(task.subtasks)) {
            tasks.push(...task.subtasks.map(st => ({
                ...st,
                id: `${task.id}.${st.id}`,
                parentId: task.id
            })));
        }
    });
    
    return tasks;
}

/**
 * Check for task status changes
 */
function checkTaskChanges() {
    if (isProcessing) {
        log('DEBUG', 'Skipping check - already processing');
        return;
    }
    
    const tasksData = readJsonFile(TASK_FILE);
    if (!tasksData) return;
    
    const tasks = extractTasks(tasksData);
    
    tasks.forEach(task => {
        const taskKey = String(task.id);
        const previousStatus = lastKnownState[taskKey];
        const currentStatus = task.status;
        
        // Check for transition to completed state
        if (previousStatus && previousStatus !== currentStatus) {
            if (currentStatus === 'done' || currentStatus === 'completed' || currentStatus === 'success') {
                log('INFO', `Task ${task.id} completed: ${task.title}`);
                triggerCommit(task.id, task.title);
            }
        }
        
        // Update state
        lastKnownState[taskKey] = currentStatus;
    });
}

/**
 * Trigger commit for completed task
 */
function triggerCommit(taskId, taskTitle) {
    isProcessing = true;
    
    try {
        // Execute commit script
        const result = execSync(`bash "${COMMIT_SCRIPT}" "${taskId}" "${taskTitle}"`, {
            encoding: 'utf8',
            stdio: 'pipe'
        });
        
        // Log one-line summary
        const commitSha = getLatestCommitSha();
        const timestamp = new Date().toISOString();
        console.log(`${timestamp} task:${taskId} "${taskTitle}" commit:${commitSha}`);
        
    } catch (err) {
        log('ERROR', `Failed to trigger commit for task ${taskId}: ${err.message}`);
    } finally {
        isProcessing = false;
        
        // Check for next task
        setTimeout(checkForNextTask, 1000);
    }
}

/**
 * Get latest commit SHA
 */
function getLatestCommitSha() {
    try {
        return execSync('git rev-parse --short HEAD', { encoding: 'utf8' }).trim();
    } catch {
        return 'unknown';
    }
}

/**
 * Check for next pending task and start it
 */
function checkForNextTask() {
    const tasksData = readJsonFile(TASK_FILE);
    if (!tasksData) return;
    
    const tasks = extractTasks(tasksData);
    const pendingTask = tasks.find(t => t.status === 'pending' && (!t.dependencies || t.dependencies.length === 0));
    
    if (pendingTask) {
        log('INFO', `Starting next task: ${pendingTask.id} - ${pendingTask.title}`);
        startTask(pendingTask.id);
    } else {
        const pendingWithDeps = tasks.find(t => t.status === 'pending');
        if (pendingWithDeps) {
            log('INFO', `Next task ${pendingWithDeps.id} has unmet dependencies`);
        } else {
            log('INFO', 'No more pending tasks');
        }
    }
}

/**
 * Start a task using task-master CLI
 */
function startTask(taskId) {
    try {
        execSync(`task-master set-status --id=${taskId} --status=in-progress`, {
            encoding: 'utf8',
            stdio: 'pipe'
        });
        log('INFO', `Task ${taskId} set to in-progress`);
    } catch (err) {
        log('ERROR', `Failed to start task ${taskId}: ${err.message}`);
    }
}

/**
 * Watch for file changes with debounce
 */
function watchFile(filePath) {
    fs.watchFile(filePath, { interval: POLL_INTERVAL }, (curr, prev) => {
        if (curr.mtime !== prev.mtime) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                log('DEBUG', `File changed: ${path.basename(filePath)}`);
                checkTaskChanges();
            }, DEBOUNCE_DELAY);
        }
    });
}

/**
 * Initialize watcher
 */
function initialize() {
    log('INFO', 'TaskMaster watcher starting...');
    
    // Check if files exist
    if (!fs.existsSync(TASK_FILE)) {
        log('ERROR', `Task file not found: ${TASK_FILE}`);
        process.exit(1);
    }
    
    if (!fs.existsSync(COMMIT_SCRIPT)) {
        log('ERROR', `Commit script not found: ${COMMIT_SCRIPT}`);
        process.exit(1);
    }
    
    // Load initial state
    const tasksData = readJsonFile(TASK_FILE);
    if (tasksData) {
        const tasks = extractTasks(tasksData);
        tasks.forEach(task => {
            lastKnownState[String(task.id)] = task.status;
        });
        log('INFO', `Loaded ${tasks.length} tasks`);
    }
    
    // Set up file watchers
    watchFile(TASK_FILE);
    if (fs.existsSync(STATE_FILE)) {
        watchFile(STATE_FILE);
    }
    
    // Initial check for pending tasks
    checkForNextTask();
    
    log('INFO', 'Watcher initialized and running');
    console.log('Press Ctrl+C to stop');
}

/**
 * Graceful shutdown
 */
process.on('SIGINT', () => {
    log('INFO', 'Shutting down watcher...');
    fs.unwatchFile(TASK_FILE);
    if (fs.existsSync(STATE_FILE)) {
        fs.unwatchFile(STATE_FILE);
    }
    process.exit(0);
});

// Start the watcher
initialize();