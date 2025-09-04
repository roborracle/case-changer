<?php

namespace App\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    public bool $toolsDropdownOpen = false;
    public bool $mobileMenuOpen = false;
    public string $theme = 'light';
    
    public function mount()
    {
        $this->theme = session('theme', 'light');
    }
    
    public function toggleToolsDropdown()
    {
        $this->toolsDropdownOpen = !$this->toolsDropdownOpen;
    }
    
    public function closeToolsDropdown()
    {
        $this->toolsDropdownOpen = false;
    }
    
    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }
    
    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        session(['theme' => $this->theme]);
        $this->dispatch('theme-changed', theme: $this->theme);
    }
    
    public function render()
    {
        return view('livewire.navigation');
    }
}