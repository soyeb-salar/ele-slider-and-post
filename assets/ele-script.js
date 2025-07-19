/**
 * Ele Slider JavaScript
 * Modern slider functionality with autoplay, navigation, and pagination
 */

(function($) {
    'use strict';

    class EleSlider {
        constructor(element) {
            this.element = element;
            this.wrapper = element.find('.ele-slider-wrapper');
            this.slides = element.find('.ele-slider-slide');
            this.prevBtn = element.find('.ele-slider-prev');
            this.nextBtn = element.find('.ele-slider-next');
            this.dots = element.find('.ele-slider-dot');
            
            this.currentSlide = 0;
            this.totalSlides = this.slides.length;
            this.autoplay = this.wrapper.data('autoplay') === 'true';
            this.autoplaySpeed = parseInt(this.wrapper.data('speed')) || 3000;
            this.autoplayInterval = null;
            
            if (this.totalSlides > 0) {
                this.init();
            }
        }

        init() {
            this.setupEventListeners();
            this.showSlide(0);
            
            if (this.autoplay) {
                this.startAutoplay();
            }
        }

        setupEventListeners() {
            // Navigation buttons
            this.prevBtn.on('click', () => this.prevSlide());
            this.nextBtn.on('click', () => this.nextSlide());
            
            // Pagination dots
            this.dots.on('click', (e) => {
                const slideIndex = parseInt($(e.currentTarget).data('slide'));
                this.goToSlide(slideIndex);
            });
            
            // Pause autoplay on hover
            if (this.autoplay) {
                this.element.on('mouseenter', () => this.stopAutoplay());
                this.element.on('mouseleave', () => this.startAutoplay());
            }
            
            // Keyboard navigation
            $(document).on('keydown', (e) => {
                if (this.element.is(':hover')) {
                    if (e.key === 'ArrowLeft') {
                        this.prevSlide();
                    } else if (e.key === 'ArrowRight') {
                        this.nextSlide();
                    }
                }
            });
        }

        showSlide(index) {
            // Remove active class from all slides and dots
            this.slides.removeClass('active');
            this.dots.removeClass('active');
            
            // Add active class to current slide and dot
            this.slides.eq(index).addClass('active');
            this.dots.eq(index).addClass('active');
            
            this.currentSlide = index;
        }

        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.totalSlides;
            this.goToSlide(nextIndex);
        }

        prevSlide() {
            const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.goToSlide(prevIndex);
        }

        goToSlide(index) {
            if (index !== this.currentSlide) {
                this.showSlide(index);
                
                // Reset autoplay timer
                if (this.autoplay) {
                    this.stopAutoplay();
                    this.startAutoplay();
                }
            }
        }

        startAutoplay() {
            if (this.autoplay && this.totalSlides > 1) {
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, this.autoplaySpeed);
            }
        }

        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        }
    }

    // Initialize sliders when DOM is ready
    $(document).ready(function() {
        $('.ele-slider-wrapper').each(function() {
            new EleSlider($(this));
        });
    });

    // Reinitialize sliders for Elementor editor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/ele-slider.default', function($scope) {
            new EleSlider($scope.find('.ele-slider-wrapper'));
        });
    });

})(jQuery);
