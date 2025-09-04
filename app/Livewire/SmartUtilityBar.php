<?php

namespace App\Livewire;

use Livewire\Component;

class SmartUtilityBar extends Component
{
    public bool $isPinned = false;
    public bool $isExpanded = false;
    public string $lastAction = '';
    public int $actionCount = 0;
    public bool $showCopiedFeedback = false;
    public bool $showExportDropdown = false;
    public bool $isClearHolding = false;
    
    // Preferences
    public bool $rememberState = true;
    public int $inactivityTimeout = 60; // seconds
    public bool $autoPin = false;
    
    protected $listeners = [
        'utility-action' => 'handleUtilityAction',
        'show-copied-feedback' => 'showCopiedFeedback',
        'hide-copied-feedback' => 'hideCopiedFeedback',
    ];
    
    public function mount()
    {
        // Load saved preferences from localStorage via JavaScript
        $this->dispatch('load-utility-preferences');
    }

    public function togglePin()
    {
        $this->isPinned = !$this->isPinned;
        $this->isExpanded = false; // Collapse when toggling pin state
        
        // Save preference
        if ($this->rememberState) {
            $this->dispatch('save-utility-preference', [
                'key' => 'isPinned',
                'value' => $this->isPinned
            ]);
        }
        
        $this->dispatch('utility-state-changed', [
            'isPinned' => $this->isPinned,
            'action' => 'toggle-pin'
        ]);
    }
    
    public function expand()
    {
        if (!$this->isPinned) {
            $this->isExpanded = true;
            $this->dispatch('utility-expanded');
        }
    }
    
    public function collapse()
    {
        if (!$this->isPinned) {
            $this->isExpanded = false;
            $this->dispatch('utility-collapsed');
        }
    }
    
    public function copyText()
    {
        $this->trackAction('copy');
        $this->dispatch('premium-converter-action', ['action' => 'copy']);
        $this->showCopiedAnimation();
    }
    
    public function exportText($format = null)
    {
        $this->trackAction('export');
        
        if ($format) {
            $this->showExportDropdown = false;
            $this->dispatch('premium-converter-action', [
                'action' => 'export',
                'format' => $format
            ]);
        } else {
            $this->showExportDropdown = !$this->showExportDropdown;
        }
    }
    
    public function clearText()
    {
        $this->trackAction('clear');
        $this->dispatch('premium-converter-action', ['action' => 'clear']);
        $this->dispatch('show-clear-animation');
    }
    
    public function startClearHold()
    {
        $this->isClearHolding = true;
    }
    
    public function endClearHold()
    {
        $this->isClearHolding = false;
    }
    
    protected function trackAction($action)
    {
        $this->lastAction = $action;
        $this->actionCount++;
        
        // Auto-pin after repeated use
        if ($this->autoPin && $this->actionCount >= 5 && !$this->isPinned) {
            $this->isPinned = true;
            $this->dispatch('auto-pinned-notification');
        }
        
        $this->dispatch('reset-inactivity-timer');
    }
    
    protected function showCopiedAnimation()
    {
        $this->showCopiedFeedback = true;
        $this->dispatch('trigger-copied-animation');
        
        // Hide after animation
        $this->dispatch('hide-copied-feedback-delayed');
    }
    
    public function showCopiedFeedback()
    {
        $this->showCopiedFeedback = true;
    }
    
    public function hideCopiedFeedback()
    {
        $this->showCopiedFeedback = false;
    }
    
    public function updatePreferences($preferences)
    {
        $this->isPinned = $preferences['isPinned'] ?? false;
        $this->rememberState = $preferences['rememberState'] ?? true;
        $this->autoPin = $preferences['autoPin'] ?? false;
        $this->inactivityTimeout = $preferences['inactivityTimeout'] ?? 60;
    }
    
    public function minimize()
    {
        $this->isExpanded = false;
        $this->showExportDropdown = false;
        $this->dispatch('utility-minimized');
    }
    
    public function render()
    {
        return view('livewire.smart-utility-bar');
    }
}