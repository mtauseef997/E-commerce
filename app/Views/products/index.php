<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <span class="breadcrumb-item"><a href="<?= $this->url('/') ?>">Home</a></span>
        <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
        <span class="breadcrumb-item">Products</span>
    </nav>
</div>
<!-- Products Header -->
<section class="products-header">
    <div class="container">
        <div class="products-header-content">
            <div class="products-title">
                <h1>All Products</h1>
                <p>Discover our amazing collection of products</p>
            </div>
            <div class="products-count">
                <span><?= number_format($total_products) ?> products found</span>
            </div>
        </div>
    </div>
</section>
<!-- Products Content -->
<section class="products-content">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar Filters -->
            <aside class="products-sidebar">
                <div class="filter-section">
                    <h3 class="filter-title">Filters</h3>
                    <form id="filter-form" method="GET" action="<?= $this->url('/products') ?>">
                        <!-- Search Filter -->
                        <div class="filter-group">
                            <label class="filter-label">Search</label>
                            <input type="text"
                                name="search"
                                class="form-input"
                                placeholder="Search products..."
                                value="<?= $this->escape($filters['search'] ?? '') ?>">
                        </div>
                        <!-- Category Filter -->
                        <?php if (!empty($categories)): ?>
                            <div class="filter-group">
                                <label class="filter-label">Categories</label>
                                <div class="filter-options">
                                    <?php foreach ($categories as $category): ?>
                                        <label class="filter-option">
                                            <input type="radio"
                                                name="category"
                                                value="<?= $category['id'] ?>"
                                                <?= ($filters['category_id'] ?? '') == $category['id'] ? 'checked' : '' ?>>
                                            <span class="filter-option-text">
                                                <?= $this->escape($category['name']) ?>
                                                <span class="filter-count">(<?= $category['product_count'] ?>)</span>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!-- Price Filter -->
                        <div class="filter-group">
                            <label class="filter-label">Price Range</label>
                            <div class="price-range">
                                <input type="number"
                                    name="min_price"
                                    class="form-input"
                                    placeholder="Min"
                                    value="<?= $this->escape($filters['min_price'] ?? '') ?>">
                                <span>to</span>
                                <input type="number"
                                    name="max_price"
                                    class="form-input"
                                    placeholder="Max"
                                    value="<?= $this->escape($filters['max_price'] ?? '') ?>">
                            </div>
                        </div>
                        <!-- Filter Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary btn-full">
                                <i class="fas fa-filter"></i>
                                Apply Filters
                            </button>
                            <button type="button" class="btn btn-ghost btn-full" id="clear-filters">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </button>
                        </div>
                    </form>
                </div>
            </aside>
            <!-- Products Grid -->
            <main class="products-main">
                <!-- Sort and View Options -->
                <div class="products-toolbar">
                    <div class="sort-options">
                        <label for="sort-select">Sort by:</label>
                        <select id="sort-select" class="form-select">
                            <option value="">Default</option>
                            <option value="name" <?= ($filters['sort'] ?? '') === 'name' ? 'selected' : '' ?>>Name</option>
                            <option value="price_low" <?= ($filters['sort'] ?? '') === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high" <?= ($filters['sort'] ?? '') === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="rating" <?= ($filters['sort'] ?? '') === 'rating' ? 'selected' : '' ?>>Rating</option>
                        </select>
                    </div>
                    <div class="view-options">
                        <button class="view-btn active" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                <!-- Products Grid -->
                <?php if (!empty($products)): ?>
                    <div class="products-grid grid grid-3" id="products-grid">
                        <?php foreach ($products as $product): ?>
                            <div class="product-card hover-lift scroll-reveal">
                                <div class="product-image">
                                    <img src="<?= $this->asset('images/products/' . ($product['primary_image'] ?: 'placeholder.jpg')) ?>"
                                        alt="<?= $this->escape($product['name']) ?>"
                                        loading="lazy">
                                    <?php if ($product['sale_price']): ?>
                                        <div class="product-badge sale">Sale</div>
                                    <?php endif; ?>
                                    <div class="product-actions">
                                        <button class="product-action wishlist-btn"
                                            data-product-id="<?= $product['id'] ?>"
                                            title="Add to Wishlist"
                                            onclick="toggleWishlist(<?= $product['id'] ?>)">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="product-action add-to-cart"
                                            data-product-id="<?= $product['id'] ?>"
                                            title="Add to Cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <a href="<?= $this->url('/product/' . $product['slug']) ?>"
                                            class="product-action"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-category">
                                        <?= $this->escape($product['category_name'] ?? 'Uncategorized') ?>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="<?= $this->url('/product/' . $product['slug']) ?>">
                                            <?= $this->escape($product['name']) ?>
                                        </a>
                                    </h3>
                                    <?php if ($product['avg_rating']): ?>
                                        <div class="product-rating">
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star star <?= $i <= round($product['avg_rating']) ? '' : 'empty' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="rating-count">(<?= $product['review_count'] ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="product-price">
                                        <?php if ($product['sale_price']): ?>
                                            <span class="price-current"><?= $this->currency($product['sale_price']) ?></span>
                                            <span class="price-original"><?= $this->currency($product['price']) ?></span>
                                            <span class="price-discount">
                                                <?= round((($product['price'] - $product['sale_price']) / $product['price']) * 100) ?>% OFF
                                            </span>
                                        <?php else: ?>
                                            <span class="price-current"><?= $this->currency($product['price']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <div class="pagination">
                            <?php if ($current_page > 1): ?>
                                <a href="?page=<?= $current_page - 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>"
                                    class="pagination-item">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                                <a href="?page=<?= $i ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>"
                                    class="pagination-item <?= $i === $current_page ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            <?php if ($current_page < $total_pages): ?>
                                <a href="?page=<?= $current_page + 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>"
                                    class="pagination-item">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- No Products Found -->
                    <div class="no-products">
                        <div class="no-products-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or search terms</p>
                        <a href="<?= $this->url('/products') ?>" class="btn btn-primary">
                            <i class="fas fa-refresh"></i>
                            View All Products
                        </a>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</section>
<style>
    .products-header {
        background: var(--bg-secondary);
        padding: 2rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .products-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .products-title h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .products-title p {
        color: var(--text-secondary);
        margin: 0;
    }

    .products-count {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .products-content {
        padding: 2rem 0;
    }

    .products-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
    }

    .products-sidebar {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .filter-title {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .filter-group {
        margin-bottom: 2rem;
    }

    .filter-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        transition: background var(--transition-fast);
    }

    .filter-option:hover {
        background: var(--bg-secondary);
    }

    .filter-option input[type="radio"] {
        margin: 0;
    }

    .filter-option-text {
        display: flex;
        justify-content: space-between;
        width: 100%;
        font-size: 0.875rem;
    }

    .filter-count {
        color: var(--text-light);
    }

    .price-range {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .price-range input {
        flex: 1;
    }

    .filter-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .products-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
    }

    .sort-options {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sort-options label {
        font-weight: 500;
        color: var(--text-primary);
    }

    .view-options {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        width: 2.5rem;
        height: 2.5rem;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .view-btn:hover,
    .view-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .no-products {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .no-products-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .no-products h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .products-layout {
            grid-template-columns: 1fr;
        }

        .products-sidebar {
            position: static;
            order: 2;
        }

        .products-toolbar {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .sort-options,
        .view-options {
            justify-content: center;
        }

        .products-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }
</style>
<script>
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const view = btn.dataset.view;
            const grid = document.getElementById('products-grid');
            if (view === 'list') {
                grid.classList.remove('grid-3');
                grid.classList.add('products-list');
            } else {
                grid.classList.remove('products-list');
                grid.classList.add('grid-3');
            }
        });
    });
</script>