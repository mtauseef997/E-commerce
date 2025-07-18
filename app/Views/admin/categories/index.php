<div class="admin-header">
    <div class="admin-header-content">
        <div class="admin-title">
            <h1><i class="fas fa-tags"></i> Manage Categories</h1>
            <p>Organize your products with categories and subcategories</p>
        </div>
        <div class="admin-actions">
            <button class="btn btn-primary" onclick="showAddCategoryModal()">
                <i class="fas fa-plus"></i>
                Add New Category
            </button>
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


<div class="admin-table-container">
    <?php if (!empty($categories)): ?>
    <div class="table-header">
        <div class="table-info">
            <span class="results-count">
                <?= count($categories) ?> categories found
            </span>
        </div>
        <div class="table-actions">
            <button class="btn btn-outline btn-sm" onclick="expandAll()">
                <i class="fas fa-expand-arrows-alt"></i>
                Expand All
            </button>
            <button class="btn btn-outline btn-sm" onclick="collapseAll()">
                <i class="fas fa-compress-arrows-alt"></i>
                Collapse All
            </button>
        </div>
    </div>

    <div class="categories-grid">
        <?php foreach ($categories as $category): ?>
        <div class="category-card" data-category-id="<?= $category['id'] ?>">
            <div class="category-header">
                <div class="category-info">
                    <div class="category-image">
                        <?php if ($category['image']): ?>
                        <img src="<?= $this->asset('images/categories/' . $category['image']) ?>"
                            alt="<?= $this->escape($category['name']) ?>">
                        <?php else: ?>
                        <div class="no-image">
                            <i class="fas fa-folder"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="category-details">
                        <h3><?= $this->escape($category['name']) ?></h3>
                        <p class="category-slug">
                            <i class="fas fa-link"></i>
                            <?= $this->escape($category['slug']) ?>
                        </p>
                        <?php if ($category['description']): ?>
                        <p class="category-description">
                            <?= $this->escape(substr($category['description'], 0, 100)) ?>
                            <?= strlen($category['description']) > 100 ? '...' : '' ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="category-stats">
                    <div class="stat-item">
                        <span class="stat-value"><?= $category['product_count'] ?></span>
                        <span class="stat-label">Products</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value"><?= $category['sort_order'] ?></span>
                        <span class="stat-label">Order</span>
                    </div>
                </div>
            </div>

            <div class="category-meta">
                <div class="category-status">
                    <span class="status-badge status-<?= $category['status'] ?>">
                        <?= ucfirst($category['status']) ?>
                    </span>
                    <?php if ($category['parent_id']): ?>
                    <span class="badge badge-secondary">
                        <i class="fas fa-level-up-alt"></i>
                        Subcategory
                    </span>
                    <?php else: ?>
                    <span class="badge badge-primary">
                        <i class="fas fa-folder"></i>
                        Main Category
                    </span>
                    <?php endif; ?>
                </div>
                <div class="category-dates">
                    <small class="text-muted">
                        Created: <?= $this->date($category['created_at'], 'M j, Y') ?>
                    </small>
                </div>
            </div>

            <div class="category-actions">
                <a href="<?= $this->url('/category/' . $category['slug']) ?>" class="btn btn-sm btn-outline"
                    target="_blank" title="View Category">
                    <i class="fas fa-eye"></i>
                    View
                </a>
                <button onclick="editCategory(<?= $category['id'] ?>)" class="btn btn-sm btn-primary"
                    title="Edit Category">
                    <i class="fas fa-edit"></i>
                    Edit
                </button>
                <button onclick="addSubcategory(<?= $category['id'] ?>)" class="btn btn-sm btn-secondary"
                    title="Add Subcategory">
                    <i class="fas fa-plus"></i>
                    Sub
                </button>
                <?php if ($category['product_count'] == 0): ?>
                <button onclick="deleteCategory(<?= $category['id'] ?>)" class="btn btn-sm btn-danger"
                    title="Delete Category">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
                <?php else: ?>
                <button class="btn btn-sm btn-danger" disabled title="Cannot delete category with products">
                    <i class="fas fa-lock"></i>
                    Locked
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h3>No categories found</h3>
        <p>Start organizing your products by creating your first category.</p>
        <button class="btn btn-primary" onclick="showAddCategoryModal()">
            <i class="fas fa-plus"></i>
            Create First Category
        </button>
    </div>
    <?php endif; ?>
</div>


<div class="modal" id="categoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Add New Category</h2>
            <button class="modal-close" onclick="closeCategoryModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="categoryForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="category_id" id="categoryId">

            <div class="modal-body">
                <div class="form-group">
                    <label for="categoryName">Category Name *</label>
                    <input type="text" id="categoryName" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="categorySlug">URL Slug</label>
                    <input type="text" id="categorySlug" name="slug" class="form-control">
                    <small class="form-help">Leave empty to auto-generate from name</small>
                </div>

                <div class="form-group">
                    <label for="categoryDescription">Description</label>
                    <textarea id="categoryDescription" name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="parentCategory">Parent Category</label>
                        <select id="parentCategory" name="parent_id" class="form-control">
                            <option value="">None (Main Category)</option>
                            <?php foreach ($categories as $cat): ?>
                            <?php if (!$cat['parent_id']): // Only show main categories 
                                ?>
                            <option value="<?= $cat['id'] ?>"><?= $this->escape($cat['name']) ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sortOrder">Sort Order</label>
                        <input type="number" id="sortOrder" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoryImage">Category Image</label>
                    <input type="file" id="categoryImage" name="image" class="form-control" accept="image/*">
                    <small class="form-help">Recommended size: 400x300px</small>
                </div>

                <div class="form-group">
                    <label for="categoryStatus">Status</label>
                    <select id="categoryStatus" name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeCategoryModal()">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.category-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: all 0.3s;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.category-header {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.category-info {
    display: flex;
    gap: 1rem;
    flex: 1;
}

.category-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
    font-size: 1.5rem;
}

.category-details h3 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
    font-size: 1.125rem;
}

.category-slug {
    margin: 0 0 0.5rem 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.category-description {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
    line-height: 1.4;
}

.category-stats {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-item {
    text-align: center;
    padding: 0.5rem;
    background: var(--bg-secondary);
    border-radius: 6px;
    min-width: 60px;
}

.stat-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-color);
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: uppercase;
}

.category-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light);
}

.category-status {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.category-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary {
    background: var(--primary-color);
    color: white;
}

.badge-secondary {
    background: var(--text-secondary);
    color: white;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.modal-header h2 {
    margin: 0;
    color: var(--text-primary);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }

    .category-header {
        flex-direction: column;
    }

    .category-stats {
        flex-direction: row;
        justify-content: space-around;
    }

    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function showAddCategoryModal() {
    document.getElementById('modalTitle').textContent = 'Add New Category';
    document.getElementById('categoryForm').action = '/admin/categories/create';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryModal').classList.add('active');
}

function editCategory(categoryId) {

    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('categoryForm').action = `/admin/categories/${categoryId}/edit`;
    document.getElementById('categoryId').value = categoryId;
    document.getElementById('categoryModal').classList.add('active');

    console.log('Edit category:', categoryId);
}

function addSubcategory(parentId) {
    document.getElementById('modalTitle').textContent = 'Add Subcategory';
    document.getElementById('categoryForm').action = '/admin/categories/create';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryForm').reset();
    document.getElementById('parentCategory').value = parentId;
    document.getElementById('categoryModal').classList.add('active');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('active');
}

function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/categories/${categoryId}/delete`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = 'csrf_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function expandAll() {

    console.log('Expand all categories');
}

function collapseAll() {

    console.log('Collapse all categories');
}

document.getElementById('categoryName').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('categorySlug').value = slug;
});

document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCategoryModal();
    }
});
</script>