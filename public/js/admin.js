/**
 * Admin Panel JavaScript
 * E-Commerce Application
 */

// Admin Panel Object
const AdminPanel = {
    init() {
        this.setupEventListeners();
        this.initSidebar();
        this.initDataTables();
        this.initFormValidation();
    },

    setupEventListeners() {
        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', () => {
            this.initCharts();
        });
    },

    initSidebar() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }
        
        if (mobileSidebarToggle && sidebar) {
            mobileSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }
        
        // Close sidebar on outside click (mobile only)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                sidebar && 
                sidebar.classList.contains('active') && 
                !sidebar.contains(e.target) && 
                e.target !== mobileSidebarToggle) {
                sidebar.classList.remove('active');
            }
        });
    },

    initDataTables() {
        // Simple data table functionality
        const tables = document.querySelectorAll('.data-table');
        
        tables.forEach(table => {
            const searchInput = table.querySelector('.table-search');
            const tableRows = table.querySelectorAll('tbody tr');
            
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase();
                    
                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
            
            // Sort functionality
            const sortableHeaders = table.querySelectorAll('th[data-sort]');
            
            sortableHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const sortKey = header.dataset.sort;
                    const sortDirection = header.dataset.direction === 'asc' ? 'desc' : 'asc';
                    
                    // Update header state
                    sortableHeaders.forEach(h => {
                        h.dataset.direction = '';
                        h.classList.remove('sorted-asc', 'sorted-desc');
                    });
                    
                    header.dataset.direction = sortDirection;
                    header.classList.add(`sorted-${sortDirection}`);
                    
                    // Sort rows
                    const sortedRows = Array.from(tableRows).sort((a, b) => {
                        const aValue = a.querySelector(`[data-sort-value="${sortKey}"]`)?.dataset.sortValue || 
                                      a.querySelector(`td:nth-child(${Array.from(header.parentNode.children).indexOf(header) + 1})`)?.textContent;
                        
                        const bValue = b.querySelector(`[data-sort-value="${sortKey}"]`)?.dataset.sortValue || 
                                      b.querySelector(`td:nth-child(${Array.from(header.parentNode.children).indexOf(header) + 1})`)?.textContent;
                        
                        if (sortDirection === 'asc') {
                            return aValue.localeCompare(bValue, undefined, { numeric: true });
                        } else {
                            return bValue.localeCompare(aValue, undefined, { numeric: true });
                        }
                    });
                    
                    // Reorder rows
                    const tbody = table.querySelector('tbody');
                    sortedRows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    },

    initFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        this.showFieldError(field, 'This field is required');
                    } else {
                        this.clearFieldError(field);
                    }
                });
                
                // Email validation
                const emailFields = form.querySelectorAll('input[type="email"]');
                emailFields.forEach(field => {
                    if (field.value && !this.isValidEmail(field.value)) {
                        isValid = false;
                        this.showFieldError(field, 'Please enter a valid email address');
                    }
                });
                
                // Number validation
                const numberFields = form.querySelectorAll('input[type="number"]');
                numberFields.forEach(field => {
                    if (field.value && isNaN(parseFloat(field.value))) {
                        isValid = false;
                        this.showFieldError(field, 'Please enter a valid number');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    App.showNotification('Please fix the errors in the form', 'error');
                }
            });
        });
    },

    showFieldError(field, message) {
        field.classList.add('error');
        
        let errorElement = field.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('form-error')) {
            errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            field.parentNode.insertBefore(errorElement, field.nextSibling);
        }
        
        errorElement.textContent = message;
    },

    clearFieldError(field) {
        field.classList.remove('error');
        
        const errorElement = field.nextElementSibling;
        if (errorElement && errorElement.classList.contains('form-error')) {
            errorElement.remove();
        }
    },

    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    initCharts() {
        // Placeholder for chart initialization
        // In a real application, you would use a charting library like Chart.js
        console.log('Charts would be initialized here');
    },

    // Admin-specific utility functions
    confirmDelete(message = 'Are you sure you want to delete this item?') {
        return confirm(message);
    },

    showImagePreview(input, previewElement) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    },

    slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    },

    updateSlugField(inputElement, slugElement) {
        const inputValue = inputElement.value;
        const slugValue = this.slugify(inputValue);
        slugElement.value = slugValue;
    },

    copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                App.showNotification('Copied to clipboard!', 'success');
            })
            .catch(err => {
                App.showNotification('Failed to copy text', 'error');
            });
    }
};

// Initialize Admin Panel
AdminPanel.init();
