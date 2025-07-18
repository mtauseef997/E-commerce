<div class="admin-header">
    <div class="admin-header-content">
        <div class="admin-title">
            <h1><i class="fas fa-plus"></i> Add New Product</h1>
            <p>Create a new product for your store</p>
        </div>
        <div class="admin-actions">
            <a href="<?= $this->url('/admin/products') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= $this->escape($error) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?= $this->escape($success) ?>
    </div>
<?php endif; ?>

<div class="admin-content">
    <form class="product-form" method="POST" action="<?= $this->url('/admin/products/store') ?>" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        
        <div class="form-layout">
            <!-- Main Product Information -->
            <div class="form-main">
                <div class="form-card">
                    <h2>
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h2>
                    
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required
                               placeholder="Enter product name">
                    </div>
                    
                    <div class="form-group">
                        <label for="slug">Product Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control"
                               placeholder="product-slug (auto-generated if empty)">
                        <small class="form-help">URL-friendly version of the name. Leave empty to auto-generate.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="6"
                                  placeholder="Enter product description..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description" class="form-control" rows="3"
                                  placeholder="Brief product summary..."></textarea>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="form-card">
                    <h2>
                        <i class="fas fa-dollar-sign"></i>
                        Pricing
                    </h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Regular Price *</label>
                            <div class="input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="price" name="price" class="form-control" 
                                       step="0.01" min="0" required placeholder="0.00">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="sale_price">Sale Price</label>
                            <div class="input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="sale_price" name="sale_price" class="form-control" 
                                       step="0.01" min="0" placeholder="0.00">
                            </div>
                            <small class="form-help">Leave empty if not on sale</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="sku">SKU (Stock Keeping Unit)</label>
                        <input type="text" id="sku" name="sku" class="form-control"
                               placeholder="Enter unique SKU">
                    </div>
                </div>

                <!-- Inventory -->
                <div class="form-card">
                    <h2>
                        <i class="fas fa-boxes"></i>
                        Inventory
                    </h2>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="manage_stock" name="manage_stock" value="1" checked>
                            <span class="checkmark"></span>
                            Manage stock quantity
                        </label>
                    </div>
                    
                    <div id="stock_fields" class="stock-fields">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="stock_quantity">Stock Quantity</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" 
                                       class="form-control" min="0" value="0">
                            </div>
                            
                            <div class="form-group">
                                <label for="low_stock_threshold">Low Stock Alert</label>
                                <input type="number" id="low_stock_threshold" name="low_stock_threshold" 
                                       class="form-control" min="0" value="5">
                                <small class="form-help">Alert when stock falls below this number</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock_status">Stock Status</label>
                        <select id="stock_status" name="stock_status" class="form-control">
                            <option value="in_stock">In Stock</option>
                            <option value="out_of_stock">Out of Stock</option>
                            <option value="on_backorder">On Backorder</option>
                        </select>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="form-card">
                    <h2>
                        <i class="fas fa-images"></i>
                        Product Images
                    </h2>
                    
                    <div class="form-group">
                        <label for="image">Main Product Image</label>
                        <div class="file-upload-area">
                            <input type="file" id="image" name="image" class="file-input" 
                                   accept="image/*" onchange="previewImage(this, 'main-preview')">
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload or drag and drop</p>
                                <small>PNG, JPG, GIF up to 10MB</small>
                            </div>
                        </div>
                        <div id="main-preview" class="image-preview"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="gallery">Additional Images</label>
                        <div class="file-upload-area">
                            <input type="file" id="gallery" name="gallery[]" class="file-input" 
                                   accept="image/*" multiple onchange="previewGallery(this)">
                            <div class="file-upload-content">
                                <i class="fas fa-images"></i>
                                <p>Upload multiple images</p>
                                <small>Hold Ctrl/Cmd to select multiple files</small>
                            </div>
                        </div>
                        <div id="gallery-preview" class="gallery-preview"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="form-sidebar">
                <!-- Publish Settings -->
                <div class="form-card">
                    <h3>
                        <i class="fas fa-cog"></i>
                        Publish Settings
                    </h3>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active">Published</option>
                            <option value="draft">Draft</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="featured">Featured Product</label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="featured" name="featured" value="1">
                            <span class="checkmark"></span>
                            Mark as featured
                        </label>
                    </div>
                </div>

                <!-- Category -->
                <div class="form-card">
                    <h3>
                        <i class="fas fa-folder"></i>
                        Category
                    </h3>
                    
                    <div class="form-group">
                        <label for="category_id">Product Category *</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>">
                                    <?= $this->escape($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Product Attributes -->
                <div class="form-card">
                    <h3>
                        <i class="fas fa-tags"></i>
                        Attributes
                    </h3>
                    
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" class="form-control" 
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    
                    <div class="form-group">
                        <label>Dimensions (cm)</label>
                        <div class="dimensions-group">
                            <input type="number" name="length" class="form-control" 
                                   placeholder="Length" step="0.01" min="0">
                            <span>×</span>
                            <input type="number" name="width" class="form-control" 
                                   placeholder="Width" step="0.01" min="0">
                            <span>×</span>
                            <input type="number" name="height" class="form-control" 
                                   placeholder="Height" step="0.01" min="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" id="tags" name="tags" class="form-control"
                               placeholder="Enter tags separated by commas">
                        <small class="form-help">e.g., electronics, smartphone, android</small>
                    </div>
                </div>

                <!-- SEO -->
                <div class="form-card">
                    <h3>
                        <i class="fas fa-search"></i>
                        SEO Settings
                    </h3>
                    
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" class="form-control"
                               placeholder="SEO title for search engines">
                        <small class="form-help">Recommended: 50-60 characters</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" class="form-control" rows="3"
                                  placeholder="SEO description for search engines"></textarea>
                        <small class="form-help">Recommended: 150-160 characters</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" name="action" value="save" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save Product
            </button>
            <button type="submit" name="action" value="save_and_continue" class="btn btn-secondary">
                <i class="fas fa-plus"></i>
                Save & Add Another
            </button>
            <a href="<?= $this->url('/admin/products') ?>" class="btn btn-outline">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
/* Product Form Styles */
.product-form {
    max-width: none;
}

.form-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.form-main {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.form-card h2,
.form-card h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    font-size: 1.25rem;
}

.form-card h2 {
    font-size: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    left: 1rem;
    color: var(--text-secondary);
    font-weight: 500;
    z-index: 2;
}

.input-group .form-control {
    padding-left: 2.5rem;
}

.stock-fields {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

/* File Upload */
.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-fast);
    position: relative;
}

.file-upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-content i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.file-upload-content p {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 500;
}

.file-upload-content small {
    color: var(--text-secondary);
}

.image-preview,
.gallery-preview {
    margin-top: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.preview-item {
    position: relative;
    width: 100px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-remove {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    width: 24px;
    height: 24px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.dimensions-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dimensions-group input {
    flex: 1;
}

.dimensions-group span {
    color: var(--text-secondary);
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    margin-top: 2rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .form-layout {
        grid-template-columns: 1fr;
    }
    
    .form-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .dimensions-group {
        flex-direction: column;
    }
    
    .dimensions-group span {
        display: none;
    }
}
</style>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.value) {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugField.value = slug;
    }
});

// Toggle stock fields
document.getElementById('manage_stock').addEventListener('change', function() {
    const stockFields = document.getElementById('stock_fields');
    const stockInputs = stockFields.querySelectorAll('input');
    
    if (this.checked) {
        stockFields.style.display = 'block';
        stockInputs.forEach(input => input.removeAttribute('disabled'));
    } else {
        stockFields.style.display = 'none';
        stockInputs.forEach(input => input.setAttribute('disabled', 'disabled'));
    }
});

// Image preview functions
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="preview-remove" onclick="removePreview('${previewId}', '${input.id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewGallery(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Gallery ${index + 1}">
                    <button type="button" class="preview-remove" onclick="removeGalleryItem(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

function removePreview(previewId, inputId) {
    document.getElementById(previewId).innerHTML = '';
    document.getElementById(inputId).value = '';
}

function removeGalleryItem(index) {
    // This would need more complex logic to remove specific files
    // For now, just clear the preview
    const preview = document.getElementById('gallery-preview');
    const items = preview.querySelectorAll('.preview-item');
    if (items[index]) {
        items[index].remove();
    }
}

// Form validation
document.querySelector('.product-form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});
</script>
