<div class="contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Get in Touch</h1>
                <p class="hero-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <div class="form-header">
                        <h2>Send us a Message</h2>
                        <p>Fill out the form below and we'll get back to you within 24 hours.</p>
                    </div>
                    
                    <?php if ($success ?? false): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?= $this->escape($success) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error ?? false): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $this->escape($error) ?>
                        </div>
                    <?php endif; ?>

                    <form class="contact-form" method="POST" action="<?= $this->url('/contact') ?>">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name *</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" class="form-control" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Customer Support</option>
                                <option value="orders">Order Issues</option>
                                <option value="returns">Returns & Refunds</option>
                                <option value="partnership">Partnership Opportunities</option>
                                <option value="feedback">Feedback & Suggestions</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" class="form-control" rows="6" 
                                      placeholder="Please provide details about your inquiry..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="newsletter" value="1">
                                <span class="checkmark"></span>
                                Subscribe to our newsletter for updates and special offers
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="contact-info-section">
                    <div class="contact-info">
                        <h3>Contact Information</h3>
                        <p>Get in touch with us through any of these channels.</p>
                        
                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Visit Our Store</h4>
                                    <p>123 Commerce Street<br>Business District<br>New York, NY 10001</p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Call Us</h4>
                                    <p>
                                        <a href="tel:+1234567890">+1 (234) 567-8900</a><br>
                                        <small>Mon-Fri: 9AM-6PM EST</small>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Email Us</h4>
                                    <p>
                                        <a href="mailto:support@modernshop.com">support@modernshop.com</a><br>
                                        <small>We respond within 24 hours</small>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Live Chat</h4>
                                    <p>
                                        Available 24/7<br>
                                        <small>Click the chat icon in the bottom right</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-links">
                            <h4>Follow Us</h4>
                            <div class="social-icons">
                                <a href="#" class="social-icon facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-icon twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-icon instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-icon linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="social-icon youtube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <p>Quick answers to common questions</p>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>What are your shipping options?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We offer free standard shipping on orders over $50. Express shipping options are available for faster delivery. International shipping is available to most countries.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>What is your return policy?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We offer a 30-day return policy for most items. Items must be in original condition with tags attached. Return shipping is free for defective items.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>How can I track my order?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Once your order ships, you'll receive a tracking number via email. You can also track your order by logging into your account and viewing your order history.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>Do you offer customer support?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! We offer 24/7 customer support via live chat, email, and phone. Our support team is always ready to help with any questions or concerns.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>What payment methods do you accept?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple Pay, Google Pay, and bank transfers for larger orders.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h4>Is my personal information secure?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely. We use industry-standard SSL encryption to protect your personal and payment information. We never share your data with third parties without your consent.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-header">
                <h2>Find Our Store</h2>
                <p>Visit us in person for a personalized shopping experience</p>
            </div>
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Interactive Map</h3>
                    <p>123 Commerce Street, Business District<br>New York, NY 10001</p>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i>
                        Get Directions
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.contact-page {
    padding-top: 0;
}

/* Hero Section */
.contact-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.hero-content h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: var(--font-heading);
}

.hero-subtitle {
    font-size: 1.125rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

/* Contact Content */
.contact-content {
    padding: 6rem 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
}

/* Contact Form */
.form-header {
    margin-bottom: 2rem;
}

.form-header h2 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.form-header p {
    color: var(--text-secondary);
}

.contact-form {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color var(--transition);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.checkbox-label input[type="checkbox"] {
    margin: 0;
}

/* Contact Info */
.contact-info {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    height: fit-content;
}

.contact-info h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.contact-info > p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.contact-methods {
    margin-bottom: 2rem;
}

.contact-method {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    align-items: flex-start;
}

.method-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.method-info h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.method-info p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.5;
}

.method-info a {
    color: var(--primary-color);
    text-decoration: none;
}

.method-info a:hover {
    text-decoration: underline;
}

.method-info small {
    color: var(--text-light);
}

/* Social Links */
.social-links h4 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.social-icons {
    display: flex;
    gap: 0.75rem;
}

.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: transform var(--transition);
}

.social-icon:hover {
    transform: translateY(-2px);
}

.social-icon.facebook { background: #1877f2; }
.social-icon.twitter { background: #1da1f2; }
.social-icon.instagram { background: #e4405f; }
.social-icon.linkedin { background: #0077b5; }
.social-icon.youtube { background: #ff0000; }

/* FAQ Section */
.faq-section {
    padding: 6rem 0;
    background: var(--bg-secondary);
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.section-header p {
    color: var(--text-secondary);
    font-size: 1.125rem;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1rem;
}

.faq-item {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.faq-question {
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background var(--transition);
}

.faq-question:hover {
    background: var(--bg-secondary);
}

.faq-question h4 {
    margin: 0;
    color: var(--text-primary);
}

.faq-question i {
    color: var(--primary-color);
    transition: transform var(--transition);
}

.faq-item.active .faq-question i {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: all var(--transition);
}

.faq-item.active .faq-answer {
    padding: 0 1.5rem 1.5rem;
    max-height: 200px;
}

.faq-answer p {
    margin: 0;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Map Section */
.map-section {
    padding: 6rem 0;
}

.map-container {
    margin-top: 2rem;
}

.map-placeholder {
    background: var(--bg-secondary);
    padding: 4rem 2rem;
    border-radius: 12px;
    text-align: center;
    color: var(--text-secondary);
}

.map-placeholder i {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.map-placeholder h3 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.map-placeholder p {
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 6px;
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

/* Responsive */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .contact-form {
        padding: 1.5rem;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
    
    .social-icons {
        justify-content: center;
    }
}
</style>

<script>
function toggleFaq(element) {
    const faqItem = element.parentElement;
    const isActive = faqItem.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}
</script>
