<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="hero-content">
                <h1>About <?= APP_NAME ?></h1>
                <p class="hero-subtitle">Your trusted partner in modern e-commerce excellence</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>10K+</h3>
                        <p>Happy Customers</p>
                    </div>
                    <div class="stat-item">
                        <h3>5+</h3>
                        <p>Years Experience</p>
                    </div>
                    <div class="stat-item">
                        <h3>1000+</h3>
                        <p>Products</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="container">
            <div class="section-header">
                <h2>Our Story</h2>
                <p>Building the future of online shopping</p>
            </div>
            <div class="story-content">
                <div class="story-text">
                    <h3>Founded on Innovation</h3>
                    <p>
                        <?= APP_NAME ?> was born from a simple idea: to create an online shopping experience 
                        that combines cutting-edge technology with exceptional customer service. Since our 
                        founding, we've been committed to providing our customers with the best products, 
                        competitive prices, and unmatched convenience.
                    </p>
                    <p>
                        Our journey began with a small team of passionate individuals who believed that 
                        e-commerce could be better. Today, we've grown into a trusted platform serving 
                        thousands of customers worldwide, but our core values remain the same: quality, 
                        integrity, and customer satisfaction.
                    </p>
                    <div class="story-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-rocket"></i>
                            <h4>Innovation First</h4>
                            <p>We constantly evolve our platform to provide the best shopping experience.</p>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-heart"></i>
                            <h4>Customer Focused</h4>
                            <p>Every decision we make is centered around our customers' needs and satisfaction.</p>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Trust & Security</h4>
                            <p>Your data and transactions are protected with industry-leading security measures.</p>
                        </div>
                    </div>
                </div>
                <div class="story-image">
                    <img src="<?= $this->asset('images/about-story.jpg') ?>" alt="Our Story" class="story-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission-vision">
        <div class="container">
            <div class="mv-grid">
                <div class="mission-card">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        To democratize access to quality products by providing an intuitive, secure, 
                        and enjoyable online shopping platform that connects customers with the best 
                        brands and merchants worldwide.
                    </p>
                </div>
                <div class="vision-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        To become the world's most trusted e-commerce platform, where every customer 
                        feels valued, every transaction is seamless, and every product meets the 
                        highest standards of quality and value.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Values</h2>
                <p>The principles that guide everything we do</p>
            </div>
            <div class="values-grid">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Excellence</h4>
                    <p>We strive for excellence in every aspect of our business, from product quality to customer service.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Integrity</h4>
                    <p>We conduct business with honesty, transparency, and ethical practices in all our interactions.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Community</h4>
                    <p>We believe in building strong relationships with our customers, partners, and team members.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>We embrace new technologies and ideas to continuously improve our platform and services.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4>Sustainability</h4>
                    <p>We're committed to environmentally responsible practices and supporting sustainable commerce.</p>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h4>Global Reach</h4>
                    <p>We connect customers worldwide with quality products and exceptional shopping experiences.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Team</h2>
                <p>The passionate people behind <?= APP_NAME ?></p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-photo">
                        <img src="<?= $this->asset('images/team/ceo.jpg') ?>" alt="CEO">
                    </div>
                    <div class="member-info">
                        <h4>Sarah Johnson</h4>
                        <p class="member-role">Chief Executive Officer</p>
                        <p class="member-bio">Leading our vision with 15+ years of e-commerce expertise.</p>
                        <div class="member-social">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-photo">
                        <img src="<?= $this->asset('images/team/cto.jpg') ?>" alt="CTO">
                    </div>
                    <div class="member-info">
                        <h4>Michael Chen</h4>
                        <p class="member-role">Chief Technology Officer</p>
                        <p class="member-bio">Driving innovation with cutting-edge technology solutions.</p>
                        <div class="member-social">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-photo">
                        <img src="<?= $this->asset('images/team/cmo.jpg') ?>" alt="CMO">
                    </div>
                    <div class="member-info">
                        <h4>Emily Rodriguez</h4>
                        <p class="member-role">Chief Marketing Officer</p>
                        <p class="member-bio">Connecting with customers through creative marketing strategies.</p>
                        <div class="member-social">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose <?= APP_NAME ?>?</h2>
                <p>Experience the difference that sets us apart</p>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4>Fast & Free Shipping</h4>
                    <p>Free shipping on orders over $50 with express delivery options available.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h4>Easy Returns</h4>
                    <p>30-day hassle-free returns with free return shipping on all orders.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Round-the-clock customer support via chat, email, and phone.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4>Secure Shopping</h4>
                    <p>SSL encryption and secure payment processing for your peace of mind.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h4>Quality Guarantee</h4>
                    <p>Every product is carefully selected and quality-tested before shipping.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h4>Best Prices</h4>
                    <p>Competitive pricing with regular sales and exclusive member discounts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Start Shopping?</h2>
                <p>Join thousands of satisfied customers and discover amazing products at unbeatable prices.</p>
                <div class="cta-buttons">
                    <a href="<?= $this->url('/products') ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag"></i>
                        Shop Now
                    </a>
                    <a href="<?= $this->url('/contact') ?>" class="btn btn-outline btn-lg">
                        <i class="fas fa-envelope"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.about-page {
    padding-top: 0;
}

/* Hero Section */
.about-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 6rem 0 4rem;
    text-align: center;
}

.hero-content h1 {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: var(--font-heading);
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 3rem;
    opacity: 0.9;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    max-width: 600px;
    margin: 0 auto;
}

.stat-item h3 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-item p {
    opacity: 0.9;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Our Story */
.our-story {
    padding: 6rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.section-header p {
    font-size: 1.125rem;
    color: var(--text-secondary);
}

.story-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.story-text h3 {
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.story-text p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

.story-highlights {
    display: grid;
    gap: 1.5rem;
    margin-top: 2rem;
}

.highlight-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.highlight-item i {
    color: var(--primary-color);
    font-size: 1.25rem;
    margin-top: 0.25rem;
}

.highlight-item h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.highlight-item p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.story-img {
    width: 100%;
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
}

/* Mission & Vision */
.mission-vision {
    padding: 6rem 0;
    background: var(--bg-secondary);
}

.mv-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

.mission-card,
.vision-card {
    background: white;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    text-align: center;
}

.card-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 2rem;
}

.mission-card h3,
.vision-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

/* Values Section */
.values-section {
    padding: 6rem 0;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.value-item {
    text-align: center;
    padding: 2rem;
}

.value-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: var(--primary-color);
    font-size: 1.5rem;
}

.value-item h4 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

/* Team Section */
.team-section {
    padding: 6rem 0;
    background: var(--bg-secondary);
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
}

.team-member {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    box-shadow: var(--shadow-md);
    transition: transform var(--transition);
}

.team-member:hover {
    transform: translateY(-5px);
}

.member-photo {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    overflow: hidden;
}

.member-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.member-info h4 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.member-role {
    color: var(--primary-color);
    font-weight: 500;
    margin-bottom: 1rem;
}

.member-bio {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.member-social {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.member-social a {
    width: 40px;
    height: 40px;
    background: var(--bg-secondary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    transition: all var(--transition);
}

.member-social a:hover {
    background: var(--primary-color);
    color: white;
}

/* Why Choose Us */
.why-choose-us {
    padding: 6rem 0;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-item {
    text-align: center;
    padding: 2rem;
    border-radius: 12px;
    transition: all var(--transition);
}

.feature-item:hover {
    background: var(--bg-secondary);
    transform: translateY(-3px);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.75rem;
}

.feature-item h4 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

/* CTA Section */
.about-cta {
    padding: 6rem 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline:hover {
    background: white;
    color: var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .story-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .mv-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>
