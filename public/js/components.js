
const Cart = {
    init() {
        this.bindEvents();
        this.updateCartDisplay();
    },

    bindEvents() {

        document.addEventListener('click', (e) => {
            if (e.target.matches('.add-to-cart, .add-to-cart *')) {
                e.preventDefault();
                const button = e.target.closest('.add-to-cart');
                this.addToCart(button);
            }
        });


        document.addEventListener('click', (e) => {
            if (e.target.matches('.qty-btn')) {
                e.preventDefault();
                this.updateQuantity(e.target);
            }
        });
        document.addEventListener('click', (e) => {
            if (e.target.matches('.remove-item, .remove-item *')) {
                e.preventDefault();
                const button = e.target.closest('.remove-item');
                this.removeItem(button);
            }
        });
    },

    async addToCart(button) {
        const productId = button.dataset.productId;
        const quantity = button.dataset.quantity || 1;

        if (!productId) return;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        button.disabled = true;

        try {
            const response = await App.makeRequest('/cart/add', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            });

            if (response.success) {
                App.showNotification(response.message, 'success');
                this.updateCartCount(response.cart_count);
                const cartIcon = document.querySelector('.cart-link');
                if (cartIcon) {
                    cartIcon.classList.add('animate-bounce');
                    setTimeout(() => {
                        cartIcon.classList.remove('animate-bounce');
                    }, 1000);
                }
            } else {
                App.showNotification(response.message, 'error');
            }
        } catch (error) {
            App.showNotification('Failed to add item to cart', 'error');
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    },

    async updateQuantity(button) {
        const productId = button.dataset.productId;
        const action = button.dataset.action;
        const quantityInput = button.parentElement.querySelector('.qty-input');

        if (!productId || !quantityInput) return;

        let newQuantity = parseInt(quantityInput.value);

        if (action === 'increase') {
            newQuantity++;
        } else if (action === 'decrease') {
            newQuantity = Math.max(1, newQuantity - 1);
        }

        quantityInput.value = newQuantity;

        try {
            const response = await App.makeRequest('/cart/update', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                })
            });

            if (response.success) {
                this.updateCartCount(response.cart_count);
                this.updateItemTotal(productId, response.item_total);
                this.updateCartTotal(response.cart_total);
            } else {
                App.showNotification(response.message, 'error');
                quantityInput.value = action === 'increase' ? newQuantity - 1 : newQuantity + 1;
            }
        } catch (error) {
            App.showNotification('Failed to update quantity', 'error');
        }
    },

    async removeItem(button) {
        const productId = button.dataset.productId;

        if (!productId) return;

        if (!confirm('Are you sure you want to remove this item?')) {
            return;
        }

        try {
            const response = await App.makeRequest('/cart/remove', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId
                })
            });

            if (response.success) {
                App.showNotification(response.message, 'success');
                this.updateCartCount(response.cart_count);
                this.updateCartTotal(response.cart_total);
                const cartItem = button.closest('.cart-item');
                if (cartItem) {
                    cartItem.style.opacity = '0';
                    cartItem.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        cartItem.remove();
                    }, 300);
                }
            } else {
                App.showNotification(response.message, 'error');
            }
        } catch (error) {
            App.showNotification('Failed to remove item', 'error');
        }
    },

    updateCartCount(count) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;

            if (count > 0) {
                cartCountElement.style.display = 'block';
            } else {
                cartCountElement.style.display = 'none';
            }
        }
    },

    updateItemTotal(productId, total) {
        const itemTotalElement = document.querySelector(`[data-item-total="${productId}"]`);
        if (itemTotalElement) {
            itemTotalElement.textContent = App.formatCurrency(total);
        }
    },

    updateCartTotal(total) {
        const cartTotalElement = document.querySelector('.cart-total');
        if (cartTotalElement) {
            cartTotalElement.textContent = App.formatCurrency(total);
        }
    },

    updateCartDisplay() {
        const cartCount = document.getElementById('cart-count');
        if (cartCount && parseInt(cartCount.textContent) === 0) {
            cartCount.style.display = 'none';
        }
    }
};
const Wishlist = {
    init() {
        this.bindEvents();
    },

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.wishlist-btn, .wishlist-btn *')) {
                e.preventDefault();
                const button = e.target.closest('.wishlist-btn');
                this.toggleWishlist(button);
            }
        });
    },

    async toggleWishlist(button) {
        const productId = button.dataset.productId;

        if (!productId) return;

        const icon = button.querySelector('i');
        const isInWishlist = icon.classList.contains('fas');

        try {
            const response = await App.makeRequest('/api/wishlist/toggle', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId
                })
            });

            if (response.success) {
                if (isInWishlist) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    App.showNotification('Removed from wishlist', 'success');
                } else {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    App.showNotification('Added to wishlist', 'success');
                }

                button.classList.add('animate-pulse');
                setTimeout(() => {
                    button.classList.remove('animate-pulse');
                }, 600);
            } else {
                App.showNotification(response.message, 'error');
            }
        } catch (error) {
            App.showNotification('Please login to use wishlist', 'error');
        }
    }
};

const ProductGallery = {
    init() {
        this.bindEvents();
        this.initMainImage();
    },

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.gallery-thumbnail')) {
                e.preventDefault();
                this.changeMainImage(e.target);
            }
        });
        const mainImage = document.querySelector('.main-product-image');
        if (mainImage) {
            mainImage.addEventListener('mousemove', this.handleImageZoom.bind(this));
            mainImage.addEventListener('mouseleave', this.resetImageZoom.bind(this));
        }
    },

    changeMainImage(thumbnail) {
        const mainImage = document.querySelector('.main-product-image img');
        const newSrc = thumbnail.dataset.fullImage || thumbnail.src;

        if (mainImage && newSrc) {
            mainImage.style.opacity = '0';

            setTimeout(() => {
                mainImage.src = newSrc;
                mainImage.style.opacity = '1';
            }, 150);
            document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    },

    handleImageZoom(e) {
        const image = e.target;
        const rect = image.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        image.style.transformOrigin = `${x}% ${y}%`;
        image.style.transform = 'scale(2)';
    },

    resetImageZoom(e) {
        const image = e.target;
        image.style.transform = 'scale(1)';
        image.style.transformOrigin = 'center';
    },

    initMainImage() {

        const thumbnails = document.querySelectorAll('.gallery-thumbnail');
        const activeThumbnail = document.querySelector('.gallery-thumbnail.active');

        if (thumbnails.length > 0 && !activeThumbnail) {
            thumbnails[0].classList.add('active');
        }
    }
};

const ProductFilter = {
    init() {
        this.bindEvents();
        this.initPriceRange();
    },

    bindEvents() {

        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', this.handleFilterSubmit.bind(this));
        }

        const clearFilters = document.getElementById('clear-filters');
        if (clearFilters) {
            clearFilters.addEventListener('click', this.clearFilters.bind(this));
        }

        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', this.handleSortChange.bind(this));
        }
    },

    handleFilterSubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.location.href = newUrl;
    },

    clearFilters() {
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.reset();
            window.location.href = window.location.pathname;
        }
    },

    handleSortChange(e) {
        const sortValue = e.target.value;
        const url = new URL(window.location);

        if (sortValue) {
            url.searchParams.set('sort', sortValue);
        } else {
            url.searchParams.delete('sort');
        }

        window.location.href = url.toString();
    },

    initPriceRange() {
        const minPrice = document.getElementById('min-price');
        const maxPrice = document.getElementById('max-price');

        if (minPrice && maxPrice) {
            const updatePriceDisplay = App.debounce(() => {
                const minVal = parseInt(minPrice.value) || 0;
                const maxVal = parseInt(maxPrice.value) || 1000;

                document.getElementById('price-range-display').textContent =
                    `${App.formatCurrency(minVal)} - ${App.formatCurrency(maxVal)}`;
            }, 300);

            minPrice.addEventListener('input', updatePriceDisplay);
            maxPrice.addEventListener('input', updatePriceDisplay);
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Cart.init();
    Wishlist.init();
    ProductGallery.init();
    ProductFilter.init();
});
