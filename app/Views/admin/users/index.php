<div class="admin-header">
    <div class="admin-header-content">
        <div class="admin-title">
            <h1><i class="fas fa-users"></i> Manage Users</h1>
            <p>Manage customer accounts and administrators</p>
        </div>
        <div class="admin-actions">
            <button class="btn btn-outline" onclick="exportUsers()">
                <i class="fas fa-download"></i>
                Export Users
            </button>
            <button class="btn btn-primary" onclick="showAddUserModal()">
                <i class="fas fa-plus"></i>
                Add New User
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

<div class="user-stats">
    <div class="stat-card">
        <div class="stat-icon total">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_users ?></h3>
            <p>Total Users</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon customers">
            <i class="fas fa-user"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_users - 1 ?></h3>
            <p>Customers</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon admins">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-info">
            <h3>1</h3>
            <p>Administrators</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon active">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_users ?></h3>
            <p>Active Users</p>
        </div>
    </div>
</div>

<div class="admin-filters">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <label for="role">User Role</label>
            <select id="role" name="role" class="form-control">
                <option value="">All Roles</option>
                <option value="customer">Customers</option>
                <option value="admin">Administrators</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="status">Account Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="search">Search Users</label>
            <input type="text" id="search" name="search" placeholder="Name, email, username..." class="form-control">
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Filter
            </button>
            <a href="<?= $this->url('/admin/users') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<div class="admin-table-container">
    <?php if (!empty($users)): ?>
    <div class="table-header">
        <div class="table-info">
            <span class="results-count">
                Showing <?= count($users) ?> of <?= $total_users ?> users
            </span>
        </div>
        <div class="table-actions">
            <button class="btn btn-outline btn-sm" onclick="selectAll()">
                <i class="fas fa-check-square"></i>
                Select All
            </button>
            <button class="btn btn-outline btn-sm" onclick="bulkAction()">
                <i class="fas fa-cog"></i>
                Bulk Actions
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>User</th>
                    <th>Contact</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="user-checkbox" value="<?= $user['id'] ?>">
                    </td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php if ($user['avatar'] ?? false): ?>
                                <img src="<?= $this->asset('images/avatars/' . $user['avatar']) ?>"
                                    alt="<?= $this->escape($user['first_name'] . ' ' . $user['last_name']) ?>">
                                <?php else: ?>
                                <div class="avatar-placeholder">
                                    <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="user-details">
                                <div class="user-name">
                                    <?= $this->escape($user['first_name'] . ' ' . $user['last_name']) ?>
                                </div>
                                <div class="username">
                                    @<?= $this->escape($user['username']) ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <div class="email">
                                <i class="fas fa-envelope"></i>
                                <?= $this->escape($user['email']) ?>
                            </div>
                            <?php if ($user['phone'] ?? false): ?>
                            <div class="phone">
                                <i class="fas fa-phone"></i>
                                <?= $this->escape($user['phone']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-<?= $user['role'] ?>">
                            <?php if ($user['role'] === 'admin'): ?>
                            <i class="fas fa-shield-alt"></i>
                            Administrator
                            <?php else: ?>
                            <i class="fas fa-user"></i>
                            Customer
                            <?php endif; ?>
                        </span>
                    </td>
                    <td>
                        <div class="date-info">
                            <div class="date"><?= $this->date($user['created_at'], 'M j, Y') ?></div>
                            <div class="time"><?= $this->date($user['created_at'], 'g:i A') ?></div>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <?php if ($user['last_login'] ?? false): ?>
                            <div class="date"><?= $this->date($user['last_login'], 'M j, Y') ?></div>
                            <div class="time"><?= $this->date($user['last_login'], 'g:i A') ?></div>
                            <?php else: ?>
                            <span class="text-muted">Never</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $user['status'] ?? 'active' ?>">
                            <?= ucfirst($user['status'] ?? 'active') ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="viewUser(<?= $user['id'] ?>)" class="btn btn-sm btn-outline"
                                title="View Profile">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="editUser(<?= $user['id'] ?>)" class="btn btn-sm btn-primary"
                                title="Edit User">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if ($user['role'] !== 'admin'): ?>
                            <button onclick="toggleUserStatus(<?= $user['id'] ?>)" class="btn btn-sm btn-secondary"
                                title="Toggle Status">
                                <i class="fas fa-toggle-on"></i>
                            </button>
                            <button onclick="deleteUser(<?= $user['id'] ?>)" class="btn btn-sm btn-danger"
                                title="Delete User">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-danger" disabled title="Cannot delete admin">
                                <i class="fas fa-lock"></i>
                            </button>
                            <?php endif; ?>
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
            <a href="<?= $this->url('/admin/users?page=' . ($current_page - 1)) ?>" class="btn btn-outline">
                <i class="fas fa-chevron-left"></i>
                Previous
            </a>
            <?php endif; ?>

            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <?php if ($i == $current_page): ?>
            <span class="btn btn-primary"><?= $i ?></span>
            <?php else: ?>
            <a href="<?= $this->url('/admin/users?page=' . $i) ?>" class="btn btn-outline"><?= $i ?></a>
            <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
            <a href="<?= $this->url('/admin/users?page=' . ($current_page + 1)) ?>" class="btn btn-outline">
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
            <i class="fas fa-users"></i>
        </div>
        <h3>No users found</h3>
        <p>No users match your current filters or no users have registered yet.</p>
        <button class="btn btn-primary" onclick="showAddUserModal()">
            <i class="fas fa-plus"></i>
            Add First User
        </button>
    </div>
    <?php endif; ?>
</div>

<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="userModalTitle">Add New User</h2>
            <button class="modal-close" onclick="closeUserModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="userForm" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="user_id" id="userId">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name *</label>
                        <input type="text" id="firstName" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="last_name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="userEmail">Email Address *</label>
                    <input type="email" id="userEmail" name="email" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="userUsername">Username *</label>
                        <input type="text" id="userUsername" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="userPhone">Phone Number</label>
                        <input type="tel" id="userPhone" name="phone" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="userRole">Role *</label>
                        <select id="userRole" name="role" class="form-control" required>
                            <option value="customer">Customer</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userStatus">Status</label>
                        <select id="userStatus" name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="userPassword">Password *</label>
                    <input type="password" id="userPassword" name="password" class="form-control" required>
                    <small class="form-help">Minimum 8 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password *</label>
                    <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeUserModal()">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save User
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.user-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-icon.total {
    background: #6366f1;
}

.stat-icon.customers {
    background: #10b981;
}

.stat-icon.admins {
    background: #f59e0b;
}

.stat-icon.active {
    background: #059669;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
}

.user-name {
    font-weight: 500;
    color: var(--text-primary);
}

.username {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.contact-info {
    min-width: 200px;
}

.contact-info .email,
.contact-info .phone {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.contact-info i {
    width: 12px;
    color: var(--text-light);
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.role-admin {
    background: #fef3c7;
    color: #92400e;
}

.role-customer {
    background: #dbeafe;
    color: #1e40af;
}

.date-info .date {
    font-weight: 500;
    color: var(--text-primary);
}

.date-info .time {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-inactive {
    background: #f3f4f6;
    color: #6b7280;
}

.status-suspended {
    background: #fee2e2;
    color: #991b1b;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 768px) {
    .user-stats {
        grid-template-columns: 1fr;
    }

    .user-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .contact-info {
        min-width: auto;
    }

    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function showAddUserModal() {
    document.getElementById('userModalTitle').textContent = 'Add New User';
    document.getElementById('userForm').action = '/admin/users/create';
    document.getElementById('userId').value = '';
    document.getElementById('userForm').reset();
    document.getElementById('userModal').classList.add('active');
}

function editUser(userId) {
    document.getElementById('userModalTitle').textContent = 'Edit User';
    document.getElementById('userForm').action = `/admin/users/${userId}/edit`;
    document.getElementById('userId').value = userId;
    document.getElementById('userModal').classList.add('active');


    console.log('Edit user:', userId);
}

function viewUser(userId) {

    window.open(`/admin/users/${userId}`, '_blank');
}

function toggleUserStatus(userId) {
    if (confirm('Are you sure you want to toggle this user\'s status?')) {

        console.log('Toggle status for user:', userId);
    }
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}/delete`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = 'csrf_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function closeUserModal() {
    document.getElementById('userModal').classList.remove('active');
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.user-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function bulkAction() {
    const selectedUsers = document.querySelectorAll('.user-checkbox:checked');

    if (selectedUsers.length === 0) {
        alert('Please select users to perform bulk actions.');
        return;
    }

    const action = prompt('Enter action (activate, deactivate, suspend, delete):');
    if (action && confirm(`Perform "${action}" on ${selectedUsers.length} selected users?`)) {
        console.log('Bulk action:', action, 'on users:', Array.from(selectedUsers).map(cb => cb.value));
    }
}

function exportUsers() {
    window.location.href = '/admin/users/export';
}


document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUserModal();
    }
});


document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('userPassword').value;
    const confirmPassword = this.value;

    if (password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>