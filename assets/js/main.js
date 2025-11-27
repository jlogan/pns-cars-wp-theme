document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth Scrolling for Anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                // Account for fixed header
                const headerOffset = 80; 
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        });
    });

    // Header Scroll Effect
    const header = document.querySelector('.site-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Animated Counter for Earnings
    const animateCounters = () => {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds
            const start = 0;
            const startTime = performance.now();

            const updateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (easeOutQuart)
                const ease = 1 - Math.pow(1 - progress, 4);
                
                const current = start + (target - start) * ease;
                counter.innerText = current.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            };

            requestAnimationFrame(updateCounter);
        });
    };

    // Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Trigger counter if inside
                if(entry.target.querySelector('.counter')) {
                    animateCounters();
                }

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all others
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('active');
                const otherAnswer = otherItem.querySelector('.faq-answer');
                if(otherAnswer) {
                    otherAnswer.style.maxHeight = null;
                }
            });

            // Toggle current
            if (!isActive) {
                item.classList.add('active');
                const answer = item.querySelector('.faq-answer');
                if(answer) {
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            } else {
                // If closing the active one
                const answer = item.querySelector('.faq-answer');
                if(answer) {
                    answer.style.maxHeight = null;
                }
            }
        });
    });

    // Mobile Menu Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const mainNav = document.querySelector('.main-nav');
    const headerActions = document.querySelector('.header-actions');
    
    if (mobileToggle && mainNav) {
        mobileToggle.addEventListener('click', function() {
            const isOpen = mainNav.classList.contains('mobile-open');
            
            if (isOpen) {
                mainNav.classList.remove('mobile-open');
                if (headerActions) {
                    headerActions.classList.remove('mobile-open');
                }
                mobileToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            } else {
                mainNav.classList.add('mobile-open');
                if (headerActions) {
                    headerActions.classList.add('mobile-open');
                    // Position header actions below the nav
                    const navHeight = mainNav.scrollHeight;
                    headerActions.style.top = (70 + navHeight) + 'px';
                }
                mobileToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }
        });
        
        // Close mobile menu when clicking on a link
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mainNav.classList.remove('mobile-open');
                if (headerActions) {
                    headerActions.classList.remove('mobile-open');
                }
                mobileToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mainNav.classList.contains('mobile-open')) {
                if (!mainNav.contains(e.target) && 
                    !headerActions.contains(e.target) && 
                    !mobileToggle.contains(e.target)) {
                    mainNav.classList.remove('mobile-open');
                    if (headerActions) {
                        headerActions.classList.remove('mobile-open');
                    }
                    mobileToggle.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                }
            }
        });
    }

    // Vehicle Slider Drag (Desktop)
    const slider = document.querySelector('.vehicle-slider-container');
    let isDown = false;
    let startX;
    let scrollLeft;

    if(slider) {
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    }

});
