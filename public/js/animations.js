
const AnimationController = {
    init() {
        this.setupScrollAnimations();
        this.setupHoverAnimations();
        this.setupLoadAnimations();
        this.setupParallaxEffects();
    },

    setupScrollAnimations() {

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');


                    const children = entry.target.querySelectorAll('.stagger-child');
                    children.forEach((child, index) => {
                        child.style.animationDelay = `${index * 0.1}s`;
                        child.classList.add('animate-fade-in-up');
                    });
                }
            });
        }, observerOptions);


        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });


        document.querySelectorAll('.product-card').forEach(el => {
            observer.observe(el);
        });
    },

    setupHoverAnimations() {

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

        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                btn.style.transform = 'translateY(-2px)';
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translateY(0)';
            });
        });

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

        window.addEventListener('load', () => {

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


            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate-fade-in-down');
                }, index * 100);
            });
            const gridItems = document.querySelectorAll('.grid > *');
            gridItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate-fade-in-up');
                }, index * 100);
            });
        });
    },

    setupParallaxEffects() {
        const heroBackground = document.querySelector('.hero-background');

        if (heroBackground) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                heroBackground.style.transform = `translateY(${rate}px)`;
            });
        }


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

    animateAddToCart(productElement, cartElement) {
        const productRect = productElement.getBoundingClientRect();
        const cartRect = cartElement.getBoundingClientRect();

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

        setTimeout(() => {
            flyingElement.style.top = cartRect.top + cartRect.height / 2 + 'px';
            flyingElement.style.left = cartRect.left + cartRect.width / 2 + 'px';
            flyingElement.style.opacity = '0';
            flyingElement.style.transform = 'scale(0.5)';
        }, 50);


        setTimeout(() => {
            flyingElement.remove();
            this.bounceIn(cartElement);
        }, 850);
    },

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

document.addEventListener('DOMContentLoaded', () => {
    AnimationController.init();
});
window.AnimationController = AnimationController;
