/**
 * Animation JavaScript
 * E-Commerce Application Animations
 */

// Animation Controller
const AnimationController = {
    init() {
        this.setupScrollAnimations();
        this.setupHoverAnimations();
        this.setupLoadAnimations();
        this.setupParallaxEffects();
    },

    setupScrollAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    
                    // Add stagger delay for child elements
                    const children = entry.target.querySelectorAll('.stagger-child');
                    children.forEach((child, index) => {
                        child.style.animationDelay = `${index * 0.1}s`;
                        child.classList.add('animate-fade-in-up');
                    });
                }
            });
        }, observerOptions);

        // Observe elements with scroll-reveal class
        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });

        // Observe product cards for stagger animation
        document.querySelectorAll('.product-card').forEach(el => {
            observer.observe(el);
        });
    },

    setupHoverAnimations() {
        // Product card hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            const image = card.querySelector('.product-image img');
            const actions = card.querySelector('.product-actions');
            
            card.addEventListener('mouseenter', () => {
                if (image) {
                    image.style.transform = 'scale(1.05)';
                }
                if (actions) {
                    actions.style.opacity = '1';
                    actions.style.transform = 'translateX(0)';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                if (image) {
                    image.style.transform = 'scale(1)';
                }
                if (actions) {
                    actions.style.opacity = '0';
                    actions.style.transform = 'translateX(20px)';
                }
            });
        });

        // Button hover effects
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                btn.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translateY(0)';
            });
        });

        // Card hover effects
        document.querySelectorAll('.card, .category-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = 'var(--shadow-xl)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'var(--shadow-sm)';
            });
        });
    },

    setupLoadAnimations() {
        // Page load animations
        window.addEventListener('load', () => {
            // Animate hero section
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle');
            const heroActions = document.querySelector('.hero-actions');
            
            if (heroTitle) {
                setTimeout(() => heroTitle.classList.add('animate-fade-in-up'), 200);
            }
            if (heroSubtitle) {
                setTimeout(() => heroSubtitle.classList.add('animate-fade-in-up'), 400);
            }
            if (heroActions) {
                setTimeout(() => heroActions.classList.add('animate-fade-in-up'), 600);
            }

            // Animate navigation
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate-fade-in-down');
                }, index * 100);
            });

            // Animate grid items with stagger
            const gridItems = document.querySelectorAll('.grid > *');
            gridItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate-fade-in-up');
                }, index * 100);
            });
        });
    },

    setupParallaxEffects() {
        // Simple parallax effect for hero background
        const heroBackground = document.querySelector('.hero-background');
        
        if (heroBackground) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                heroBackground.style.transform = `translateY(${rate}px)`;
            });
        }

        // Parallax for floating elements
        const floatingElements = document.querySelectorAll('.animate-float');
        
        floatingElements.forEach(element => {
            let offset = 0;
            
            const animate = () => {
                offset += 0.01;
                const y = Math.sin(offset) * 10;
                element.style.transform = `translateY(${y}px)`;
                requestAnimationFrame(animate);
            };
            
            animate();
        });
    },

    // Utility functions for custom animations
    fadeIn(element, duration = 300) {
        element.style.opacity = '0';
        element.style.display = 'block';
        
        let opacity = 0;
        const timer = setInterval(() => {
            opacity += 50 / duration;
            if (opacity >= 1) {
                clearInterval(timer);
                opacity = 1;
            }
            element.style.opacity = opacity;
        }, 50);
    },

    fadeOut(element, duration = 300) {
        let opacity = 1;
        const timer = setInterval(() => {
            opacity -= 50 / duration;
            if (opacity <= 0) {
                clearInterval(timer);
                opacity = 0;
                element.style.display = 'none';
            }
            element.style.opacity = opacity;
        }, 50);
    },

    slideDown(element, duration = 300) {
        element.style.height = '0';
        element.style.overflow = 'hidden';
        element.style.display = 'block';
        
        const targetHeight = element.scrollHeight;
        let height = 0;
        const increment = targetHeight / (duration / 16);
        
        const timer = setInterval(() => {
            height += increment;
            if (height >= targetHeight) {
                clearInterval(timer);
                element.style.height = 'auto';
            } else {
                element.style.height = height + 'px';
            }
        }, 16);
    },

    slideUp(element, duration = 300) {
        const targetHeight = element.scrollHeight;
        let height = targetHeight;
        const decrement = targetHeight / (duration / 16);
        
        const timer = setInterval(() => {
            height -= decrement;
            if (height <= 0) {
                clearInterval(timer);
                element.style.display = 'none';
                element.style.height = 'auto';
            } else {
                element.style.height = height + 'px';
            }
        }, 16);
    },

    bounceIn(element) {
        element.classList.add('animate-bounce');
        setTimeout(() => {
            element.classList.remove('animate-bounce');
        }, 1000);
    },

    shake(element) {
        element.classList.add('animate-shake');
        setTimeout(() => {
            element.classList.remove('animate-shake');
        }, 500);
    },

    pulse(element) {
        element.classList.add('animate-pulse');
        setTimeout(() => {
            element.classList.remove('animate-pulse');
        }, 2000);
    },

    // Shopping cart animation
    animateAddToCart(productElement, cartElement) {
        const productRect = productElement.getBoundingClientRect();
        const cartRect = cartElement.getBoundingClientRect();
        
        // Create flying element
        const flyingElement = document.createElement('div');
        flyingElement.innerHTML = '<i class="fas fa-shopping-cart"></i>';
        flyingElement.style.cssText = `
            position: fixed;
            top: ${productRect.top + productRect.height / 2}px;
            left: ${productRect.left + productRect.width / 2}px;
            z-index: 9999;
            color: var(--primary-color);
            font-size: 1.5rem;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        `;
        
        document.body.appendChild(flyingElement);
        
        // Animate to cart
        setTimeout(() => {
            flyingElement.style.top = cartRect.top + cartRect.height / 2 + 'px';
            flyingElement.style.left = cartRect.left + cartRect.width / 2 + 'px';
            flyingElement.style.opacity = '0';
            flyingElement.style.transform = 'scale(0.5)';
        }, 50);
        
        // Remove element and animate cart
        setTimeout(() => {
            flyingElement.remove();
            this.bounceIn(cartElement);
        }, 850);
    },

    // Loading animation
    showLoading(element, text = 'Loading...') {
        element.innerHTML = `
            <div class="loading-container">
                <div class="loading-spinner"></div>
                <span>${text}</span>
            </div>
        `;
        element.classList.add('loading');
    },

    hideLoading(element, originalContent) {
        element.innerHTML = originalContent;
        element.classList.remove('loading');
    }
};

// Initialize animations when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    AnimationController.init();
});

// Export for use in other scripts
window.AnimationController = AnimationController;
