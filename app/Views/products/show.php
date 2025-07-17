<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <span class="breadcrumb-item"><a href="<?= $this->url('/') ?>">Home</a></span>
        <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
        <span class="breadcrumb-item"><a href="<?= $this->url('/products') ?>">Products</a></span>
        <?php if (!empty($breadcrumb)): ?>
            <?php foreach ($breadcrumb as $category): ?>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item">
                    <a href="<?= $this->url('/category/' . $category['slug']) ?>">
                        <?= $this->escape($category['name']) ?>
                    </a>
                </span>
            <?php endforeach; ?>
        <?php endif; ?>
        <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
        <span class="breadcrumb-item"><?= $this->escape($product['name']) ?></span>
    </nav>
</div>
<!-- Product Details -->
<section class="product-details">
    <div class="container">
        <div class="product-layout">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="main-image">
                    <img src="<?= $this->asset('images/products/' . (!empty($images) ? $images[0]['image_path'] : 'placeholder.jpg')) ?>" 
                         alt="<?= $this->escape($product['name']) ?>" 
                         class="main-product-image">
                    <?php if ($product['sale_price']): ?>
                        <div class="product-badge sale">Sale</div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($images) && count($images) > 1): ?>
                <div class="thumbnail-gallery">
                    <?php foreach ($images as $index => $image): ?>
                        <img src="<?= $this->asset('images/products/' . $image['image_path']) ?>" 
                             alt="<?= $this->escape($image['alt_text'] ?: $product['name']) ?>" 
                             class="gallery-thumbnail <?= $index === 0 ? 'active' : '' ?>"
                             data-full-image="<?= $this->asset('images/products/' . $image['image_path']) ?>">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <!-- Product Info -->
            <div class="product-info">
                <div class="product-header">
                    <h1 class="product-title"><?= $this->escape($product['name']) ?></h1>
                    <div class="product-meta">
                        <span class="product-sku">SKU: <?= $this->escape($product['sku']) ?></span>
                        <?php if ($product['avg_rating']): ?>
                            <div class="product-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star star <?= $i <= round($product['avg_rating']) ? '' : 'empty' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-text"><?= number_format($product['avg_rating'], 1) ?> (<?= $product['review_count'] ?> reviews)</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="product-price">
                    <?php if ($product['sale_price']): ?>
                        <span class="price-current"><?= $this->currency($product['sale_price']) ?></span>
                        <span class="price-original"><?= $this->currency($product['price']) ?></span>
                        <span class="price-discount">
                            Save <?= $this->currency($product['price'] - $product['sale_price']) ?> 
                            (<?= round((($product['price'] - $product['sale_price']) / $product['price']) * 100) ?>% OFF)
                        </span>
                    <?php else: ?>
                        <span class="price-current"><?= $this->currency($product['price']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="product-description">
                    <p><?= nl2br($this->escape($product['short_description'])) ?></p>
                </div>
                <div class="product-stock">
                    <?php if ($product['stock_status'] === 'in_stock'): ?>
                        <div class="stock-status in-stock">
                            <i class="fas fa-check-circle"></i>
                            <span>In Stock (<?= $product['stock_quantity'] ?> available)</span>
                        </div>
                    <?php elseif ($product['stock_status'] === 'out_of_stock'): ?>
                        <div class="stock-status out-of-stock">
                            <i class="fas fa-times-circle"></i>
                            <span>Out of Stock</span>
                        </div>
                    <?php else: ?>
                        <div class="stock-status backorder">
                            <i class="fas fa-clock"></i>
                            <span>Available on Backorder</span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($product['stock_status'] === 'in_stock'): ?>
                <div class="product-actions">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn" onclick="changeQuantity(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="<?= $product['stock_quantity'] ?>" 
                                   class="qty-input">
                            <button type="button" class="qty-btn" onclick="changeQuantity(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-lg add-to-cart" 
                                data-product-id="<?= $product['id'] ?>" 
                                data-quantity="1">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                        <button class="btn btn-outline btn-lg wishlist-btn" 
                                data-product-id="<?= $product['id'] ?>">
                            <i class="far fa-heart"></i>
                            Add to Wishlist
                        </button>
                    </div>
                </div>
                <?php endif; ?>
                <div class="product-features">
                    <div class="feature-item">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Free shipping on orders over $100</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-undo"></i>
                        <span>30-day return policy</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>1-year warranty included</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Tabs -->
        <div class="product-tabs">
            <div class="tabs">
                <ul class="tab-list">
                    <li class="tab-item">
                        <a href="#description" class="tab-link active">Description</a>
                    </li>
                    <li class="tab-item">
                        <a href="#specifications" class="tab-link">Specifications</a>
                    </li>
                    <li class="tab-item">
                        <a href="#reviews" class="tab-link">Reviews (<?= $product['review_count'] ?>)</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content active" id="description">
                <div class="content-section">
                    <h3>Product Description</h3>
                    <div class="description-content">
                        <?= nl2br($this->escape($product['description'])) ?>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="specifications">
                <div class="content-section">
                    <h3>Specifications</h3>
                    <div class="specifications-table">
                        <div class="spec-row">
                            <span class="spec-label">SKU</span>
                            <span class="spec-value"><?= $this->escape($product['sku']) ?></span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label">Weight</span>
                            <span class="spec-value"><?= $product['weight'] ? $product['weight'] . ' lbs' : 'N/A' ?></span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label">Dimensions</span>
                            <span class="spec-value"><?= $this->escape($product['dimensions'] ?: 'N/A') ?></span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label">Category</span>
                            <span class="spec-value"><?= $this->escape($product['category_name']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="reviews">
                <div class="content-section">
                    <h3>Customer Reviews</h3>
                    <?php if (!empty($reviews)): ?>
                        <div class="reviews-list">
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <strong><?= $this->escape($review['first_name'] . ' ' . substr($review['last_name'], 0, 1) . '.') ?></strong>
                                            <div class="review-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star star <?= $i <= $review['rating'] ? '' : 'empty' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="review-date">
                                            <?= $this->date($review['created_at'], 'M j, Y') ?>
                                        </div>
                                    </div>
                                    <?php if ($review['title']): ?>
                                        <h4 class="review-title"><?= $this->escape($review['title']) ?></h4>
                                    <?php endif; ?>
                                    <p class="review-comment"><?= nl2br($this->escape($review['comment'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-reviews">
                            <p>No reviews yet. Be the first to review this product!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Related Products -->
        <?php if (!empty($related_products)): ?>
        <div class="related-products">
            <h2 class="section-title">Related Products</h2>
            <div class="grid grid-4">
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card hover-lift">
                        <div class="product-image">
                            <img src="<?= $this->asset('images/products/' . ($related['primary_image'] ?: 'placeholder.jpg')) ?>" 
                                 alt="<?= $this->escape($related['name']) ?>" 
                                 loading="lazy">
                            <div class="product-actions">
                                <button class="product-action wishlist-btn" data-product-id="<?= $related['id'] ?>">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="product-action add-to-cart" data-product-id="<?= $related['id'] ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <a href="<?= $this->url('/product/' . $related['slug']) ?>" class="product-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="<?= $this->url('/product/' . $related['slug']) ?>">
                                    <?= $this->escape($related['name']) ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <span class="price-current"><?= $this->currency($related['price']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<style>
.product-details {
    padding: 2rem 0;
}
.product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    margin-bottom: 4rem;
}
.product-gallery {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.main-image {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--bg-secondary);
}
.main-product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform var(--transition-slow);
    cursor: zoom-in;
}
.thumbnail-gallery {
    display: flex;
    gap: 0.75rem;
    overflow-x: auto;
    padding: 0.5rem 0;
}
.gallery-thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius-md);
    cursor: pointer;
    border: 2px solid transparent;
    transition: all var(--transition-fast);
    flex-shrink: 0;
}
.gallery-thumbnail:hover,
.gallery-thumbnail.active {
    border-color: var(--primary-color);
    transform: scale(1.05);
}
.product-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}
.product-header {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
}
.product-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}
.product-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}
.product-sku {
    color: var(--text-light);
    font-size: 0.875rem;
}
.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.rating-text {
    color: var(--text-secondary);
    font-size: 0.875rem;
}
.product-price {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.price-current {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}
.price-original {
    font-size: 1.5rem;
    color: var(--text-light);
    text-decoration: line-through;
}
.price-discount {
    background: var(--error-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 600;
}
.product-description {
    font-size: 1.125rem;
    line-height: 1.6;
    color: var(--text-secondary);
}
.stock-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}
.stock-status.in-stock {
    color: var(--success-color);
}
.stock-status.out-of-stock {
    color: var(--error-color);
}
.stock-status.backorder {
    color: var(--warning-color);
}
.product-actions {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.quantity-selector label {
    font-weight: 500;
    color: var(--text-primary);
}
.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.action-buttons .btn {
    flex: 1;
    min-width: 200px;
}
.product-features {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
}
.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}
.feature-item i {
    color: var(--success-color);
    width: 1.25rem;
}
.product-tabs {
    margin-top: 4rem;
}
.content-section {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.content-section h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}
.description-content {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-secondary);
}
.specifications-table {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.spec-row {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
}
.spec-label {
    font-weight: 500;
    color: var(--text-primary);
}
.spec-value {
    color: var(--text-secondary);
}
.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}
.review-item {
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}
.reviewer-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.review-rating {
    display: flex;
    gap: 0.125rem;
}
.review-date {
    color: var(--text-light);
    font-size: 0.875rem;
}
.review-title {
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}
.review-comment {
    color: var(--text-secondary);
    line-height: 1.6;
}
.no-reviews {
    text-align: center;
    padding: 2rem;
    color: var(--text-light);
}
.related-products {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}
.section-title {
    font-size: 1.75rem;
    margin-bottom: 2rem;
    text-align: center;
    color: var(--text-primary);
}
@media (max-width: 768px) {
    .product-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .product-title {
        font-size: 1.5rem;
    }
    .price-current {
        font-size: 1.5rem;
    }
    .action-buttons {
        flex-direction: column;
    }
    .action-buttons .btn {
        min-width: auto;
    }
    .quantity-selector {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .product-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .review-header {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
<script>
function changeQuantity(delta) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    const newValue = Math.max(1, Math.min(parseInt(input.max), currentValue + delta));
    input.value = newValue;
    const addToCartBtn = document.querySelector('.add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.dataset.quantity = newValue;
    }
}
document.getElementById('quantity').addEventListener('change', function() {
    const addToCartBtn = document.querySelector('.add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.dataset.quantity = this.value;
    }
});
</script>