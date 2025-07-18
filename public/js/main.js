
const App = {
    init() {
        this.setupEventListeners();
        this.initializeComponents();
        this.handlePageLoad();
    },

    setupEventListeners() {
        document.addEventListener('DOMContentLoaded', () => {
            this.hideLoadingScreen();
            this.initScrollReveal();
            this.initBackToTop();
        });

        window.addEventListener('scroll', this.handleScroll.bind(this));
        window.addEventListener('resize', this.handleResize.bind(this));
    },

    initializeComponents() {
        this.initDropdowns();
        this.initMobileMenu();
        this.initSearch();
        this.initAlerts();
        this.initTabs();
        this.initCart();
    },

    handlePageLoad() {

        const gridItems = document.querySelectorAll('.grid > *');
        if (gridItems.length > 0) {
            gridItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('animate-fade-in-up');
            });
        }
    },

    hideLoadingScreen() {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.classList.add('hidden');
                setTimeout(() => {
                    loadingScreen.remove();
                }, 500);
            }, 1000);
        }
    },

    handleScroll() {
        const header = document.getElementById('header');
        const backToTop = document.getElementById('back-to-top');


        if (window.scrollY > 100) {
            header?.classList.add('scrolled');
        } else {
            header?.classList.remove('scrolled');
        }

        if (window.scrollY > 500) {
            backToTop?.classList.add('visible');
        } else {
            backToTop?.classList.remove('visible');
        }

        this.handleScrollReveal();
    },

    handleResize() {
        const mobileMenu = document.getElementById('main-nav');
        const mobileToggle = document.getElementById('mobile-menu-toggle');

        if (window.innerWidth > 768) {
            mobileMenu?.classList.remove('active');
            mobileToggle?.classList.remove('active');
        }
    },

    initDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu');

            if (toggle && menu) {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    dropdowns.forEach(other => {
                        if (other !== dropdown) {
                            other.classList.remove('active');
                        }
                    });

                    dropdown.classList.toggle('active');
                });
            }
        });

        document.addEventListener('click', () => {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        });
    },

    initMobileMenu() {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('main-nav');

        if (toggle && menu) {
            toggle.addEventListener('click', () => {
                toggle.classList.toggle('active');
                menu.classList.toggle('active');
            });
        }
    },

    initSearch() {
        const searchForm = document.querySelector('.search-form');
        const searchInput = document.querySelector('.search-input');

        if (searchForm && searchInput) {

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                if (query.length > 2) {

                }
            });
        }
    },

    initAlerts() {
        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(alert => {

            setTimeout(() => {
                if (alert.parentElement) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }
            }, 5000);
        });
    },

    initTabs() {
        const tabLinks = document.querySelectorAll('.tab-link');

        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                const targetId = link.getAttribute('href').substring(1);
                const targetContent = document.getElementById(targetId);

                if (targetContent) {

                    document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));


                    link.classList.add('active');
                    targetContent.classList.add('active');
                }
            });
        });
    },

    initScrollReveal() {
        const revealElements = document.querySelectorAll('.scroll-reveal');

        if (revealElements.length > 0) {
            this.handleScrollReveal();
        }
    },

    handleScrollReveal() {
        const revealElements = document.querySelectorAll('.scroll-reveal:not(.revealed)');

        revealElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('revealed');
            }
        });
    },

    initBackToTop() {
        const backToTop = document.getElementById('back-to-top');

        if (backToTop) {
            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    },

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
            <button class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.insertBefore(notification, document.body.firstChild);

        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 5000);
    },

    async makeRequest(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        };

        const config = { ...defaultOptions, ...options };

        try {
            const response = await fetch(url, config);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Request failed');
            }

            return data;
        } catch (error) {
            console.error('Request error:', error);
            throw error;
        }
    },

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    },

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Cart functionality
    initCart() {
        this.bindCartEvents();
    },

    bindCartEvents() {
        // Add to cart buttons - multiple selectors for different button types
        document.addEventListener('click', (e) => {
            // Handle buttons with add-to-cart-btn class
            if (e.target.matches('.add-to-cart-btn') || e.target.closest('.add-to-cart-btn')) {
                e.preventDefault();
                const btn = e.target.matches('.add-to-cart-btn') ? e.target : e.target.closest('.add-to-cart-btn');
                const productId = btn.dataset.productId || btn.getAttribute('onclick')?.match(/addToCart\((\d+)\)/)?.[1];
                const quantity = btn.dataset.quantity || 1;
                if (productId) {
                    console.log('Adding to cart via class:', productId, quantity);
                    this.addToCart(productId, quantity);
                }
                return;
            }

            // Handle buttons with add-to-cart class (product detail page)
            if (e.target.matches('.add-to-cart') || e.target.closest('.add-to-cart')) {
                e.preventDefault();
                const btn = e.target.matches('.add-to-cart') ? e.target : e.target.closest('.add-to-cart');
                const productId = btn.dataset.productId;
                const quantity = btn.dataset.quantity || 1;
                if (productId) {
                    console.log('Adding to cart via detail page:', productId, quantity);
                    this.addToCart(productId, quantity);
                }
                return;
            }
        });

        // Quantity controls in cart
        document.addEventListener('click', (e) => {
            if (e.target.matches('.qty-btn') || e.target.closest('.qty-btn')) {
                e.preventDefault();
                const btn = e.target.matches('.qty-btn') ? e.target : e.target.closest('.qty-btn');
                const action = btn.dataset.action;
                const productId = btn.dataset.productId;
                const quantityInput = btn.parentElement.querySelector('.qty-input');

                if (action === 'increase') {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                } else if (action === 'decrease' && parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }

                this.updateCartItem(productId, quantityInput.value);
            }
        });

        // Remove from cart
        document.addEventListener('click', (e) => {
            // Handle both .remove-item and .remove-item-btn classes
            if (e.target.matches('.remove-item-btn, .remove-item') || e.target.closest('.remove-item-btn, .remove-item')) {
                e.preventDefault();
                const btn = e.target.matches('.remove-item-btn, .remove-item') ? e.target : e.target.closest('.remove-item-btn, .remove-item');
                const productId = btn.dataset.productId;
                console.log('Remove button clicked for product:', productId);
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    this.removeFromCart(productId);
                }
            }
        });
    },

    async addToCart(productId, quantity = 1) {
        console.log('addToCart called with:', productId, quantity);

        try {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF token:', csrfToken);

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            if (csrfToken) {
                formData.append('csrf_token', csrfToken);
            }

            console.log('Sending request to /cart/add');
            const response = await fetch('/cart/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Non-JSON response:', text);
                throw new Error('Server returned non-JSON response');
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.success) {
                this.showNotification(data.message, 'success');
                this.updateCartCount(data.cart_count);
            } else {
                this.showNotification(data.message || 'Failed to add item to cart', 'error');
            }
        } catch (error) {
            console.error('Add to cart error:', error);
            this.showNotification('Failed to add item to cart. Please try again.', 'error');
        }
    },

    async updateCartItem(productId, quantity) {
        try {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            const response = await fetch('/cart/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount(data.cart_count);
                this.updateCartTotals(data.item_total, data.cart_total);
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            console.error('Update cart error:', error);
            this.showNotification('Failed to update cart. Please try again.', 'error');
        }
    },

    async removeFromCart(productId) {
        try {
            const formData = new FormData();
            formData.append('product_id', productId);

            const response = await fetch('/cart/remove', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message, 'success');
                this.updateCartCount(data.cart_count);
                // Remove the cart item from DOM - look for cart item container
                const cartItem = document.querySelector(`.cart-item[data-product-id="${productId}"], .item-row[data-product-id="${productId}"]`);
                if (cartItem) {
                    cartItem.style.transition = 'opacity 0.3s ease';
                    cartItem.style.opacity = '0';
                    setTimeout(() => {
                        cartItem.remove();
                        // Check if cart is empty and reload page if needed
                        const remainingItems = document.querySelectorAll('.cart-item, .item-row');
                        if (remainingItems.length === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }
                // Update cart total
                if (data.cart_total !== undefined) {
                    this.updateCartTotal(data.cart_total);
                }
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            console.error('Remove from cart error:', error);
            this.showNotification('Failed to remove item from cart. Please try again.', 'error');
        }
    },

    updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        });
    },

    updateCartTotals(itemTotal, cartTotal) {
        // Update item total if element exists
        const itemTotalElement = document.querySelector('.item-total');
        if (itemTotalElement && itemTotal !== undefined) {
            itemTotalElement.textContent = this.formatCurrency(itemTotal);
        }

        // Update cart total
        this.updateCartTotal(cartTotal);
    },

    updateCartTotal(total) {
        const cartTotalElements = document.querySelectorAll('.cart-total');
        cartTotalElements.forEach(element => {
            element.textContent = this.formatCurrency(total);
        });
    }
};


App.init();

// Global functions for inline event handlers
window.addToCart = function (productId, quantity = 1) {
    App.addToCart(productId, quantity);
};

window.quickView = function (productId) {
    // Implement quick view functionality
    console.log('Quick view for product:', productId);
    // You can implement a modal or redirect to product page
};

window.toggleWishlist = function (productId) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update wishlist button state
                const wishlistBtns = document.querySelectorAll(`[data-product-id="${productId}"] .wishlist-btn, .wishlist-btn[data-product-id="${productId}"]`);
                wishlistBtns.forEach(btn => {
                    const icon = btn.querySelector('i');
                    if (data.is_in_wishlist) {
                        btn.classList.add('active');
                        if (icon) icon.className = 'fas fa-heart';
                        btn.title = 'Remove from Wishlist';
                    } else {
                        btn.classList.remove('active');
                        if (icon) icon.className = 'far fa-heart';
                        btn.title = 'Add to Wishlist';
                    }
                });

                // Update wishlist count if element exists
                const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                wishlistCountElements.forEach(element => {
                    element.textContent = data.wishlist_count;
                });

                // Show notification
                if (window.App && window.App.showNotification) {
                    window.App.showNotification(data.message, 'success');
                }
            } else {
                if (data.message.includes('login')) {
                    // Redirect to login if not authenticated
                    window.location.href = '/login';
                } else {
                    alert(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Wishlist toggle error:', error);
            alert('Failed to update wishlist. Please try again.');
        });
};

window.removeFromCart = function (productId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        App.removeFromCart(productId);
    }
};

window.clearCart = function () {
    if (confirm('Are you sure you want to clear your entire cart?')) {
        // Implement clear cart functionality
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to clear cart. Please try again.');
                }
            })
            .catch(error => {
                console.error('Clear cart error:', error);
                alert('Failed to clear cart. Please try again.');
            });
    }
};
