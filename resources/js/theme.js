// Theme management system
export default function themeManager() {
    return {
        theme: localStorage.getItem('theme') || 'system',
        isDark: false,
        
        init() {
            this.applyTheme();
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.theme === 'system') {
                    this.applyTheme();
                }
            });
        },
        
        applyTheme() {
            let isDark = false;
            
            if (this.theme === 'dark') {
                isDark = true;
            } else if (this.theme === 'light') {
                isDark = false;
            } else {
                // System preference
                isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            
            this.isDark = isDark;
            
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        
        setTheme(theme) {
            this.theme = theme;
            localStorage.setItem('theme', theme);
            this.applyTheme();
        },
        
        cycleTheme() {
            const themes = ['light', 'dark', 'system'];
            const currentIndex = themes.indexOf(this.theme);
            const nextIndex = (currentIndex + 1) % themes.length;
            this.setTheme(themes[nextIndex]);
        }
    };
}