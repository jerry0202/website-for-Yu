/**
 * Mediascope Theme JavaScript
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Initialize all functions
        initSmoothScroll();
        initAnimations();
        initFormValidation();
        initLazyLoad();
    });

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        $('a[href*="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                var headerHeight = $('.site-header').outerHeight();
                var targetPosition = target.offset().top - headerHeight;
                
                $('html, body').animate({
                    scrollTop: targetPosition
                }, 800, 'swing');
            }
        });
    }

    /**
     * Scroll animations
     */
    function initAnimations() {
        // Intersection Observer for fade-in animations
        var observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements
        var animatedElements = document.querySelectorAll('.section-header, .case-study-card, .service-card, .team-card, .insight-card');
        animatedElements.forEach(function(el) {
            el.style.opacity = '0';
            observer.observe(el);
        });
    }

    /**
     * Form validation
     */
    function initFormValidation() {
        var $contactForm = $('.contact-form');
        
        if ($contactForm.length) {
            $contactForm.on('submit', function(e) {
                var isValid = true;
                var $requiredFields = $(this).find('[required]');
                
                $requiredFields.each(function() {
                    if (!$(this).val().trim()) {
                        isValid = false;
                        $(this).addClass('error');
                    } else {
                        $(this).removeClass('error');
                    }
                });
                
                // Email validation
                var $emailField = $(this).find('input[type="email"]');
                if ($emailField.length) {
                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test($emailField.val())) {
                        isValid = false;
                        $emailField.addClass('error');
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields correctly.');
                }
            });
            
            // Remove error class on input
            $contactForm.find('input, select, textarea').on('input change', function() {
                $(this).removeClass('error');
            });
        }
    }

    /**
     * Lazy load images
     */
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                            img.removeAttribute('data-srcset');
                        }
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            var lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Parallax effect for hero section
     */
    $(window).on('scroll', function() {
        var scrolled = $(window).scrollTop();
        var $hero = $('.hero-background');
        
        if ($hero.length && scrolled < $hero.outerHeight()) {
            $hero.css('transform', 'translateY(' + (scrolled * 0.5) + 'px)');
        }
    });

    /**
     * Mobile menu close on link click
     */
    $('.nav-menu a').on('click', function() {
        if ($(window).width() < 768) {
            $('#main-navigation').removeClass('active');
            $('#menu-toggle').attr('aria-expanded', 'false');
        }
    });

    /**
     * Sticky header
     */
    var lastScrollTop = 0;
    $(window).on('scroll', function() {
        var scrollTop = $(window).scrollTop();
        var $header = $('.site-header');
        
        if (scrollTop > 100) {
            $header.addClass('sticky');
            
            // Hide header on scroll down, show on scroll up
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                $header.addClass('hidden');
            } else {
                $header.removeClass('hidden');
            }
        } else {
            $header.removeClass('sticky');
            $header.removeClass('hidden');
        }
        
        lastScrollTop = scrollTop;
    });

})(jQuery);
