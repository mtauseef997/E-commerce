<div class="profile-container">
    <div class="container">
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-details">
                    <h1><?= $this->escape($user['first_name'] . ' ' . $user['last_name']) ?></h1>
                    <p class="profile-email"><?= $this->escape($user['email']) ?></p>
                    <p class="profile-member-since">Member since <?= $this->date($user['created_at'], 'F Y') ?></p>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn btn-primary" onclick="toggleEditMode()">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
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

        <div class="profile-content">
            <div class="profile-tabs">
                <button class="tab-btn active" data-tab="personal">
                    <i class="fas fa-user"></i>
                    Personal Info
                </button>
                <button class="tab-btn" data-tab="addresses">
                    <i class="fas fa-map-marker-alt"></i>
                    Addresses
                </button>
                <button class="tab-btn" data-tab="orders">
                    <i class="fas fa-shopping-bag"></i>
                    Order History
                </button>
                <button class="tab-btn" data-tab="security">
                    <i class="fas fa-shield-alt"></i>
                    Security
                </button>
            </div>

            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal-tab">
                <div class="profile-section">
                    <h2>Personal Information</h2>
                    <form action="<?= $this->url('/profile') ?>" method="POST" class="profile-form" id="profile-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="<?= $this->escape($user['first_name']) ?>" 
                                       class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="<?= $this->escape($user['last_name']) ?>" 
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" 
                                   value="<?= $this->escape($user['email']) ?>" 
                                   class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?= $this->escape($user['phone'] ?? '') ?>" 
                                   class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" 
                                   value="<?= $this->escape($user['username']) ?>" 
                                   class="form-control" readonly>
                        </div>

                        <div class="form-actions" id="form-actions" style="display: none;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                <i class="fas fa-times"></i>
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Stats -->
                <div class="profile-section">
                    <h2>Account Statistics</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?= $stats['total_orders'] ?? 0 ?></h3>
                                <p>Total Orders</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?= $this->currency($stats['total_spent'] ?? 0) ?></h3>
                                <p>Total Spent</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?= $stats['wishlist_items'] ?? 0 ?></h3>
                                <p>Wishlist Items</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?= $stats['reviews_count'] ?? 0 ?></h3>
                                <p>Reviews Written</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses Tab -->
            <div class="tab-content" id="addresses-tab">
                <div class="profile-section">
                    <div class="section-header">
                        <h2>Saved Addresses</h2>
                        <button class="btn btn-primary" onclick="showAddAddressModal()">
                            <i class="fas fa-plus"></i>
                            Add New Address
                        </button>
                    </div>
                    
                    <?php if (!empty($addresses)): ?>
                        <div class="addresses-grid">
                            <?php foreach ($addresses as $address): ?>
                                <div class="address-card">
                                    <div class="address-header">
                                        <h3><?= ucfirst($address['type']) ?> Address</h3>
                                        <?php if ($address['is_default']): ?>
                                            <span class="badge badge-primary">Default</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="address-details">
                                        <p><strong><?= $this->escape($address['first_name'] . ' ' . $address['last_name']) ?></strong></p>
                                        <?php if ($address['company']): ?>
                                            <p><?= $this->escape($address['company']) ?></p>
                                        <?php endif; ?>
                                        <p><?= $this->escape($address['address_line_1']) ?></p>
                                        <?php if ($address['address_line_2']): ?>
                                            <p><?= $this->escape($address['address_line_2']) ?></p>
                                        <?php endif; ?>
                                        <p><?= $this->escape($address['city'] . ', ' . $address['state'] . ' ' . $address['postal_code']) ?></p>
                                        <p><?= $this->escape($address['country']) ?></p>
                                        <?php if ($address['phone']): ?>
                                            <p><i class="fas fa-phone"></i> <?= $this->escape($address['phone']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="address-actions">
                                        <button class="btn btn-sm btn-outline">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <?php if (!$address['is_default']): ?>
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3>No addresses saved</h3>
                            <p>Add your first address to make checkout faster.</p>
                            <button class="btn btn-primary" onclick="showAddAddressModal()">
                                <i class="fas fa-plus"></i>
                                Add Address
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Orders Tab -->
            <div class="tab-content" id="orders-tab">
                <div class="profile-section">
                    <h2>Order History</h2>
                    <div class="orders-list">
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>No orders yet</h3>
                            <p>Start shopping to see your orders here.</p>
                            <a href="<?= $this->url('/products') ?>" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i>
                                Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div class="tab-content" id="security-tab">
                <div class="profile-section">
                    <h2>Security Settings</h2>
                    <form action="<?= $this->url('/profile/password') ?>" method="POST" class="security-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                   class="form-control" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-container {
    padding: 2rem 0;
    min-height: 80vh;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.profile-avatar {
    font-size: 4rem;
    color: var(--primary-color);
}

.profile-details h1 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
}

.profile-email {
    color: var(--text-secondary);
    margin: 0 0 0.25rem 0;
}

.profile-member-since {
    color: var(--text-light);
    font-size: 0.875rem;
    margin: 0;
}

.profile-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.tab-btn {
    padding: 1rem 1.5rem;
    border: none;
    background: none;
    color: var(--text-secondary);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.tab-btn:hover,
.tab-btn.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.profile-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 8px;
}

.stat-icon {
    font-size: 2rem;
    color: var(--primary-color);
}

.stat-info h3 {
    margin: 0 0 0.25rem 0;
    font-size: 1.5rem;
    color: var(--text-primary);
}

.stat-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.addresses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.address-card {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
}

.address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.address-header h3 {
    margin: 0;
    color: var(--text-primary);
}

.address-details p {
    margin: 0.25rem 0;
    color: var(--text-secondary);
}

.address-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: var(--text-light);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
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

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .profile-tabs {
        flex-wrap: wrap;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .addresses-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function toggleEditMode() {
    const form = document.getElementById('profile-form');
    const inputs = form.querySelectorAll('input[readonly]');
    const actions = document.getElementById('form-actions');
    
    inputs.forEach(input => {
        if (input.name !== 'email') { // Keep email readonly
            input.removeAttribute('readonly');
            input.classList.add('editable');
        }
    });
    
    actions.style.display = 'block';
}

function cancelEdit() {
    location.reload();
}

// Tab functionality
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.dataset.tab;
        
        // Remove active class from all tabs and contents
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        
        // Add active class to clicked tab and corresponding content
        btn.classList.add('active');
        document.getElementById(tabId + '-tab').classList.add('active');
    });
});
</script>
