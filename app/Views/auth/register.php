<div class="auth-container">
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-card animate-scale-in">
                <div class="auth-header">
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Join us and start your shopping journey</p>
                </div>
                <form action="<?= $this->url('/register') ?>" method="POST" class="auth-form" id="register-form">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" 
                                   id="first_name" 
                                   name="first_name" 
                                   class="form-input" 
                                   placeholder="Enter your first name"
                                   value="<?= $this->escape($_POST['first_name'] ?? '') ?>"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" 
                                   id="last_name" 
                                   name="last_name" 
                                   class="form-input" 
                                   placeholder="Enter your last name"
                                   value="<?= $this->escape($_POST['last_name'] ?? '') ?>"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="form-input" 
                               placeholder="Choose a username"
                               value="<?= $this->escape($_POST['username'] ?? '') ?>"
                               required>
                        <div class="form-help">Username must be at least 3 characters long</div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               placeholder="Enter your email"
                               value="<?= $this->escape($_POST['email'] ?? '') ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number (Optional)</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-input" 
                               placeholder="Enter your phone number"
                               value="<?= $this->escape($_POST['phone'] ?? '') ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-input-group">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-input" 
                                       placeholder="Create a password"
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength" id="password-strength"></div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="password-input-group">
                                <input type="password" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       class="form-input" 
                                       placeholder="Confirm your password"
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" value="1" class="checkbox-input" required>
                            <span class="checkbox-custom"></span>
                            I agree to the <a href="#" class="auth-link">Terms of Service</a> and 
                            <a href="#" class="auth-link">Privacy Policy</a>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="newsletter" value="1" class="checkbox-input">
                            <span class="checkbox-custom"></span>
                            Subscribe to our newsletter for updates and exclusive offers
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full btn-lg">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </button>
                </form>
                <div class="auth-divider">
                    <span>or</span>
                </div>
                <div class="social-login">
                    <button class="btn btn-ghost btn-full social-btn">
                        <i class="fab fa-google"></i>
                        Sign up with Google
                    </button>
                    <button class="btn btn-ghost btn-full social-btn">
                        <i class="fab fa-facebook"></i>
                        Sign up with Facebook
                    </button>
                </div>
                <div class="auth-footer">
                    <p>Already have an account? 
                        <a href="<?= $this->url('/login') ?>" class="auth-link">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
            <div class="auth-image animate-fade-in-left">
                <img src="<?= $this->asset('images/auth-register.svg') ?>" alt="Register Illustration">
                <div class="auth-image-overlay">
                    <h3>Start Your Journey</h3>
                    <p>Create your account today and unlock access to exclusive products, personalized recommendations, and member-only benefits.</p>
                    <div class="auth-features">
                        <div class="auth-feature">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-undo"></i>
                            <span>Easy Returns</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-headset"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.form-row .form-group {
    margin-bottom: 1.5rem;
}
.password-strength {
    margin-top: 0.5rem;
    font-size: 0.875rem;
}
.password-strength.weak {
    color: var(--error-color);
}
.password-strength.medium {
    color: var(--warning-color);
}
.password-strength.strong {
    color: var(--success-color);
}
.auth-features {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}
.auth-feature {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: white;
    opacity: 0.9;
}
.auth-feature i {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}
.auth-feature span {
    font-size: 0.875rem;
    text-align: center;
}
@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    .auth-features {
        gap: 1rem;
    }
    .auth-feature {
        flex-direction: row;
        gap: 0.5rem;
    }
    .auth-feature i {
        font-size: 1.25rem;
        margin-bottom: 0;
    }
}
</style>
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.nextElementSibling;
    const icon = toggle.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strengthElement = document.getElementById('password-strength');
    let strength = 0;
    let feedback = '';
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    if (password.length === 0) {
        strengthElement.textContent = '';
        strengthElement.className = 'password-strength';
    } else if (strength < 3) {
        feedback = 'Weak password';
        strengthElement.className = 'password-strength weak';
    } else if (strength < 4) {
        feedback = 'Medium password';
        strengthElement.className = 'password-strength medium';
    } else {
        feedback = 'Strong password';
        strengthElement.className = 'password-strength strong';
    }
    strengthElement.textContent = feedback;
});
document.getElementById('register-form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const terms = document.querySelector('input[name="terms"]').checked;
    if (password !== confirmPassword) {
        e.preventDefault();
        App.showNotification('Passwords do not match', 'error');
        return;
    }
    if (password.length < 6) {
        e.preventDefault();
        App.showNotification('Password must be at least 6 characters long', 'error');
        return;
    }
    if (!terms) {
        e.preventDefault();
        App.showNotification('Please accept the Terms of Service', 'error');
        return;
    }
});
document.getElementById('confirm_password').addEventListener('input', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = e.target.value;
    if (confirmPassword && password !== confirmPassword) {
        e.target.style.borderColor = 'var(--error-color)';
    } else {
        e.target.style.borderColor = 'var(--border-color)';
    }
});
</script>