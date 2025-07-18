<div class="wishlist-page">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= $this->url('/') ?>">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">My Wishlist</li>
            </ol>
        </div>
    </nav>

    <!-- Wishlist Header -->
    <section class="wishlist-header">
        <div class="container">
            <div class="wishlist-title">
                <h1>
                    <i class="fas fa-heart"></i>
                    My Wishlist
                </h1>
                <p class="wishlist-subtitle">
                    <?php if ($total_items > 0): ?>
                        You have <?= $total_items ?> <?= $total_items === 1 ? 'item' : 'items' ?> in your wishlist
                    <?php else: ?>
                        Your wishlist is empty
                    <?php endif; ?>
                </p>
            </div>
            
            <?php if ($total_items > 0): ?>
                <div class="wishlist-actions">
                    <button class="btn btn-outline" onclick="clearWishlist()">
                        <i class="fas fa-trash"></i>
                        Clear Wishlist
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Wishlist Content -->
    <section class="wishlist-content">
        <div class="container">
            <?php if (!empty($wishlist_items)): ?>
                <div class="wishlist-grid">
                    <?php foreach ($wishlist_items as $item): ?>
                        <div class="wishlist-item" data-product-id="<?= $item['product_id'] ?>">
                            <div class="item-image">
                                <a href="<?= $this->url('/product/' . $item['product_id']) ?>">
                                    <?php if ($item['product_image']): ?>
                                        <img src="<?= $this->asset('images/products/' . $item['product_image']) ?>" 
                                             alt="<?= $this->escape($item['product_name']) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="product-placeholder">
                                            <i class="fas fa-image"></i>
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                
                                <div class="item-actions">
                                    <button class="action-btn remove-btn" 
                                            onclick="removeFromWishlist(<?= $item['product_id'] ?>)"
                                            title="Remove from Wishlist">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <?php if ($item['stock_status'] === 'out_of_stock'): ?>
                                    <span class="stock-badge out-of-stock">Out of Stock</span>
                                <?php elseif ($item['stock_quantity'] <= 5 && $item['stock_quantity'] > 0): ?>
                                    <span class="stock-badge low-stock">Only <?= $item['stock_quantity'] ?> left</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-details">
                                <div class="item-category">
                                    <?php if ($item['category_name']): ?>
                                        <a href="<?= $this->url('/category/' . $item['category_slug']) ?>" class="category-link">
                                            <?= $this->escape($item['category_name']) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="item-name">
                                    <a href="<?= $this->url('/product/' . $item['product_id']) ?>">
                                        <?= $this->escape($item['product_name']) ?>
                                    </a>
                                </h3>
                                
                                <?php if ($item['product_short_description']): ?>
                                    <p class="item-description">
                                        <?= $this->escape(substr($item['product_short_description'], 0, 100)) ?>
                                        <?= strlen($item['product_short_description']) > 100 ? '...' : '' ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="item-price">
                                    <?php if ($item['product_sale_price'] && $item['product_sale_price'] < $item['product_price']): ?>
                                        <span class="sale-price">$<?= number_format($item['product_sale_price'], 2) ?></span>
                                        <span class="original-price">$<?= number_format($item['product_price'], 2) ?></span>
                                        <span class="discount-badge">
                                            <?= round((($item['product_price'] - $item['product_sale_price']) / $item['product_price']) * 100) ?>% OFF
                                        </span>
                                    <?php else: ?>
                                        <span class="current-price">$<?= number_format($item['product_price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="item-meta">
                                    <span class="added-date">
                                        <i class="fas fa-calendar"></i>
                                        Added <?= date('M j, Y', strtotime($item['created_at'])) ?>
                                    </span>
                                </div>
                                
                                <div class="item-footer">
                                    <?php if ($item['stock_status'] === 'in_stock'): ?>
                                        <button class="btn btn-primary add-to-cart-btn" 
                                                data-product-id="<?= $item['product_id'] ?>"
                                                onclick="addToCartFromWishlist(<?= $item['product_id'] ?>)">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>
                                            <i class="fas fa-times"></i>
                                            Out of Stock
                                        </button>
                                    <?php endif; ?>
                                    
                                    <a href="<?= $this->url('/product/' . $item['product_id']) ?>" class="btn btn-outline">
                                        <i class="fas fa-eye"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Wishlist Summary -->
                <div class="wishlist-summary">
                    <div class="summary-card">
                        <h3>Wishlist Summary</h3>
                        <div class="summary-stats">
                            <div class="stat-item">
                                <span class="stat-label">Total Items:</span>
                                <span class="stat-value"><?= $total_items ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">In Stock:</span>
                                <span class="stat-value">
                                    <?= count(array_filter($wishlist_items, function($item) { return $item['stock_status'] === 'in_stock'; })) ?>
                                </span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Total Value:</span>
                                <span class="stat-value">
                                    $<?= number_format(array_sum(array_map(function($item) { 
                                        return $item['product_sale_price'] ?: $item['product_price']; 
                                    }, $wishlist_items)), 2) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="summary-actions">
                            <button class="btn btn-primary" onclick="addAllToCart()">
                                <i class="fas fa-shopping-cart"></i>
                                Add All to Cart
                            </button>
                            <button class="btn btn-secondary" onclick="shareWishlist()">
                                <i class="fas fa-share"></i>
                                Share Wishlist
                            </button>
                        </div>
                    </div>
                </div>
                
            <?php else: ?>
                <!-- Empty Wishlist -->
                <div class="empty-wishlist">
                    <div class="empty-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3>Your wishlist is empty</h3>
                    <p>Start adding products you love to your wishlist!</p>
                    <div class="empty-actions">
                        <a href="<?= $this->url('/products') ?>" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Browse Products
                        </a>
                        <a href="<?= $this->url('/') ?>" class="btn btn-outline">
                            <i class="fas fa-home"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
/* Wishlist Page Styles */
.wishlist-page {
    padding-top: 0;
}

.wishlist-header {
    padding: 3rem 0;
    background: var(--bg-primary);
    border-bottom: 1px solid var(--border-color);
}

.wishlist-title {
    text-align: center;
    margin-bottom: 2rem;
}

.wishlist-title h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.wishlist-title h1 i {
    color: var(--error-color);
}

.wishlist-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin: 0;
}

.wishlist-actions {
    text-align: center;
}

.wishlist-content {
    padding: 3rem 0;
}

.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.wishlist-item {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-normal);
}

.wishlist-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.item-image {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.wishlist-item:hover .item-image img {
    transform: scale(1.05);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    background: var(--bg-secondary);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
}

.product-placeholder i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.item-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity var(--transition-fast);
}

.wishlist-item:hover .item-actions {
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-primary);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: var(--error-color);
    color: white;
    transform: scale(1.1);
}

.stock-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.stock-badge.low-stock {
    background: var(--warning-color);
    color: white;
}

.stock-badge.out-of-stock {
    background: var(--error-color);
    color: white;
}

.item-details {
    padding: 1.5rem;
}

.item-category {
    margin-bottom: 0.5rem;
}

.category-link {
    font-size: 0.875rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.category-link:hover {
    text-decoration: underline;
}

.item-name {
    margin-bottom: 0.75rem;
}

.item-name a {
    color: var(--text-primary);
    text-decoration: none;
    font-size: 1.125rem;
    font-weight: 600;
    transition: color var(--transition-fast);
}

.item-name a:hover {
    color: var(--primary-color);
}

.item-description {
    color: var(--text-secondary);
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.item-price {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.current-price,
.sale-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

.original-price {
    font-size: 1rem;
    color: var(--text-secondary);
    text-decoration: line-through;
}

.discount-badge {
    background: var(--error-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.item-meta {
    margin-bottom: 1.5rem;
}

.added-date {
    font-size: 0.875rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.item-footer {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.item-footer .btn {
    flex: 1;
    min-width: 120px;
    justify-content: center;
}

/* Wishlist Summary */
.wishlist-summary {
    margin-top: 3rem;
}

.summary-card {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    max-width: 500px;
    margin: 0 auto;
}

.summary-card h3 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.summary-stats {
    display: grid;
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-light);
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    color: var(--text-secondary);
}

.stat-value {
    font-weight: 600;
    color: var(--text-primary);
}

.summary-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.summary-actions .btn {
    flex: 1;
    justify-content: center;
}

/* Empty Wishlist */
.empty-wishlist {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 5rem;
    color: var(--text-light);
    margin-bottom: 2rem;
}

.empty-wishlist h3 {
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-size: 1.5rem;
}

.empty-wishlist p {
    margin-bottom: 2rem;
    font-size: 1.125rem;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Responsive */
@media (max-width: 768px) {
    .wishlist-title h1 {
        font-size: 2rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .wishlist-grid {
        grid-template-columns: 1fr;
    }
    
    .item-footer {
        flex-direction: column;
    }
    
    .item-footer .btn {
        min-width: auto;
    }
    
    .summary-actions {
        flex-direction: column;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .empty-actions .btn {
        width: 100%;
        max-width: 300px;
    }
}
</style>

<script>
// Wishlist functionality
function removeFromWishlist(productId) {
    if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
        return;
    }
    
    fetch('/wishlist/remove', {
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
            // Remove item from DOM with animation
            const item = document.querySelector(`[data-product-id="${productId}"]`);
            if (item) {
                item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    item.remove();
                    // Reload page if no items left
                    const remainingItems = document.querySelectorAll('.wishlist-item');
                    if (remainingItems.length === 0) {
                        window.location.reload();
                    }
                }, 300);
            }
            
            // Show success message
            if (window.App && window.App.showNotification) {
                window.App.showNotification(data.message, 'success');
            } else {
                alert(data.message);
            }
        } else {
            alert(data.message || 'Failed to remove item from wishlist');
        }
    })
    .catch(error => {
        console.error('Remove from wishlist error:', error);
        alert('Failed to remove item from wishlist');
    });
}

function addToCartFromWishlist(productId) {
    if (window.addToCart) {
        window.addToCart(productId);
    } else {
        alert('Cart functionality not available');
    }
}

function clearWishlist() {
    if (!confirm('Are you sure you want to clear your entire wishlist?')) {
        return;
    }
    
    fetch('/wishlist/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Failed to clear wishlist');
        }
    })
    .catch(error => {
        console.error('Clear wishlist error:', error);
        alert('Failed to clear wishlist');
    });
}

function addAllToCart() {
    const items = document.querySelectorAll('.wishlist-item[data-product-id]');
    let addedCount = 0;
    let totalItems = items.length;
    
    if (totalItems === 0) {
        alert('No items to add to cart');
        return;
    }
    
    items.forEach(item => {
        const productId = item.dataset.productId;
        const stockStatus = item.querySelector('.stock-badge.out-of-stock');
        
        if (!stockStatus && window.addToCart) {
            setTimeout(() => {
                window.addToCart(productId);
                addedCount++;
                
                if (addedCount === totalItems) {
                    setTimeout(() => {
                        alert(`Added ${addedCount} items to cart!`);
                    }, 500);
                }
            }, addedCount * 200); // Stagger the requests
        }
    });
}

function shareWishlist() {
    if (navigator.share) {
        navigator.share({
            title: 'My Wishlist',
            text: 'Check out my wishlist!',
            url: window.location.href
        });
    } else {
        // Fallback - copy URL to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Wishlist URL copied to clipboard!');
        }).catch(() => {
            alert('Unable to share wishlist');
        });
    }
}
</script>
