<div class="admin-header">
    <div class="admin-header-content">
        <div class="admin-title">
            <h1><i class="fas fa-box"></i> Manage Products</h1>
            <p>Add, edit, and manage your product catalog</p>
        </div>
        <div class="admin-actions">
            <a href="<?= $this->url('/admin/product/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Product
            </a>
        </div>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= $this->escape($success) ?>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <?= $this->escape($error) ?>
</div>
<?php endif; ?>

<div class="admin-filters">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <label for="search">Search Products</label>
            <input type="text" id="search" name="search" value="<?= $this->escape($filters['search'] ?? '') ?>"
                placeholder="Search by name, SKU, or description..." class="form-control">
        </div>

        <div class="filter-group">
            <label for="category">Category</label>
            <select id="category" name="category" class="form-control">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?= ($filters['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                    <?= $this->escape($category['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">All Status</option>
                <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive
                </option>
                <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Filter
            </button>
            <a href="<?= $this->url('/admin/products') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<div class="admin-table-container">
    <?php if (!empty($products)): ?>
    <div class="table-header">
        <div class="table-info">
            <span class="results-count">
                Showing <?= count($products) ?> of <?= $total_products ?> products
            </span>
        </div>
        <div class="table-actions">
            <button class="btn btn-outline btn-sm" onclick="selectAll()">
                <i class="fas fa-check-square"></i>
                Select All
            </button>
            <button class="btn btn-outline btn-sm" onclick="bulkDelete()">
                <i class="fas fa-trash"></i>
                Delete Selected
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="product-checkbox" value="<?= $product['id'] ?>">
                    </td>
                    <td>
                        <div class="product-image">
                            <?php if ($product['primary_image']): ?>
                            <img src="<?= $this->asset($product['primary_image']) ?>"
                                alt="<?= $this->escape($product['name']) ?>">
                            <?php else: ?>
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class="product-info">
                            <h4><?= $this->escape($product['name']) ?></h4>
                            <?php if ($product['featured']): ?>
                            <span class="badge badge-featured">Featured</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <code><?= $this->escape($product['sku']) ?></code>
                    </td>
                    <td>
                        <?= $this->escape($product['category_name'] ?? 'N/A') ?>
                    </td>
                    <td>
                        <div class="price-info">
                            <?php if ($product['sale_price']): ?>
                            <span class="sale-price"><?= $this->currency($product['sale_price']) ?></span>
                            <span class="original-price"><?= $this->currency($product['price']) ?></span>
                            <?php else: ?>
                            <span class="price"><?= $this->currency($product['price']) ?></span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class="stock-info">
                            <span class="stock-quantity"><?= $product['stock_quantity'] ?></span>
                            <span class="stock-status stock-<?= $product['stock_status'] ?>">
                                <?= ucfirst(str_replace('_', ' ', $product['stock_status'])) ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $product['status'] ?>">
                            <?= ucfirst($product['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= $this->url('/product/' . $product['slug']) ?>" class="btn btn-sm btn-outline"
                                target="_blank" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= $this->url('/admin/product/' . $product['id'] . '/edit') ?>"
                                class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteProduct(<?= $product['id'] ?>)" class="btn btn-sm btn-danger"
                                title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <?php if ($total_pages > 1): ?>
    <div class="admin-pagination">
        <div class="pagination-info">
            Page <?= $current_page ?> of <?= $total_pages ?>
        </div>
        <div class="pagination-controls">
            <?php if ($current_page > 1): ?>
            <a href="<?= $this->url('/admin/products?page=' . ($current_page - 1) . '&' . http_build_query($filters)) ?>"
                class="btn btn-outline">
                <i class="fas fa-chevron-left"></i>
                Previous
            </a>
            <?php endif; ?>

            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <?php if ($i == $current_page): ?>
            <span class="btn btn-primary"><?= $i ?></span>
            <?php else: ?>
            <a href="<?= $this->url('/admin/products?page=' . $i . '&' . http_build_query($filters)) ?>"
                class="btn btn-outline"><?= $i ?></a>
            <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
            <a href="<?= $this->url('/admin/products?page=' . ($current_page + 1) . '&' . http_build_query($filters)) ?>"
                class="btn btn-outline">
                Next
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-box-open"></i>
        </div>
        <h3>No products found</h3>
        <p>No products match your current filters. Try adjusting your search criteria or add your first product.</p>
        <a href="<?= $this->url('/admin/product/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add First Product
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/product/${productId}/delete`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = 'csrf_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.product-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function bulkDelete() {
    const selectedProducts = document.querySelectorAll('.product-checkbox:checked');

    if (selectedProducts.length === 0) {
        alert('Please select products to delete.');
        return;
    }

    if (confirm(
            `Are you sure you want to delete ${selectedProducts.length} selected products? This action cannot be undone.`
            )) {

        console.log('Bulk delete:', Array.from(selectedProducts).map(cb => cb.value));
    }
}

document.querySelectorAll('.filters-form select').forEach(select => {
    select.addEventListener('change', () => {
        document.querySelector('.filters-form').submit();
    });
});
</script>