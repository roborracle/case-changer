import './bootstrap';
import { Application } from "@hotwired/stimulus"

// Import controllers
import NavigationDropdownController from "./controllers/navigation_dropdown_controller"
import MobileMenuController from "./controllers/mobile_menu_controller"
import ThemeToggleController from "./controllers/theme_toggle_controller"
import TextConverterController from "./controllers/text_converter_controller"
import CopyToClipboardController from "./controllers/copy_to_clipboard_controller"

// Start Stimulus application
window.Stimulus = Application.start()

// Register controllers
Stimulus.register("navigation-dropdown", NavigationDropdownController)
Stimulus.register("mobile-menu", MobileMenuController)
Stimulus.register("theme-toggle", ThemeToggleController)
Stimulus.register("text-converter", TextConverterController)
Stimulus.register("copy-to-clipboard", CopyToClipboardController)

// Apply initial theme
document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('case-changer-theme') || 'system';
    const root = document.documentElement;
    
    root.classList.remove('light', 'dark');
    
    if (theme === 'dark' || 
        (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        root.classList.add('dark');
    } else if (theme === 'light') {
        root.classList.add('light');
    }
});