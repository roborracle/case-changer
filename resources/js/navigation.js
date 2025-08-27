// Navigation components
export function navigationDropdown() {
    return {
        open: false,
        
        toggle() {
            this.open = !this.open;
        },
        
        close() {
            this.open = false;
        }
    };
}

export function mobileMenu() {
    return {
        open: false,
        
        toggle() {
            this.open = !this.open;
            // Prevent body scroll when mobile menu is open
            if (this.open) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        },
        
        close() {
            this.open = false;
            document.body.style.overflow = '';
        }
    };
}

export function searchModal() {
    return {
        open: false,
        query: '',
        results: [],
        
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            }
        },
        
        close() {
            this.open = false;
            this.query = '';
            this.results = [];
        },
        
        search() {
            // Search functionality can be implemented here
            console.log('Searching for:', this.query);
        }
    };
}