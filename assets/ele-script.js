/* Original Ele Slider JavaScript */
jQuery(document).ready(function($) {
    
    // Initialize all sliders
    $('.ele-slider-wrapper').each(function() {
        var slider = $(this);
        var slides = slider.find('.ele-slider-slide');
        var currentSlide = 0;
        var autoplay = slider.data('autoplay') === 'true' || slider.data('autoplay') === true;
        var speed = parseInt(slider.data('speed')) || 3000;
        var autoplayTimer;
        
        // Show first slide
        if (slides.length > 0) {
            slides.first().addClass('active');
        }
        
        // Update pagination
        function updatePagination() {
            slider.find('.ele-slider-dot').removeClass('active');
            slider.find('.ele-slider-dot').eq(currentSlide).addClass('active');
        }
        
        // Go to specific slide
        function goToSlide(index) {
            if (index >= slides.length) index = 0;
            if (index < 0) index = slides.length - 1;
            
            slides.removeClass('active');
            slides.eq(index).addClass('active');
            currentSlide = index;
            updatePagination();
        }
        
        // Next slide
        function nextSlide() {
            goToSlide(currentSlide + 1);
        }
        
        // Previous slide
        function prevSlide() {
            goToSlide(currentSlide - 1);
        }
        
        // Start autoplay
        function startAutoplay() {
            if (autoplay && slides.length > 1) {
                autoplayTimer = setInterval(nextSlide, speed);
            }
        }
        
        // Stop autoplay
        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
            }
        }
        
        // Navigation arrows
        slider.find('.ele-slider-prev').click(function() {
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
        
        slider.find('.ele-slider-next').click(function() {
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
        
        // Pagination dots
        slider.find('.ele-slider-dot').click(function() {
            var index = $(this).data('slide');
            stopAutoplay();
            goToSlide(index);
            startAutoplay();
        });
        
        // Pause on hover
        slider.hover(
            function() {
                stopAutoplay();
            },
            function() {
                startAutoplay();
            }
        );
        
        // Keyboard navigation
        $(document).keydown(function(e) {
            if (slider.is(':hover')) {
                if (e.keyCode === 37) { // Left arrow
                    stopAutoplay();
                    prevSlide();
                    startAutoplay();
                } else if (e.keyCode === 39) { // Right arrow
                    stopAutoplay();
                    nextSlide();
                    startAutoplay();
                }
            }
        });
        
        // Start autoplay
        startAutoplay();
        
        // Initial pagination update
        updatePagination();
    });
    
    // Elementor editor compatibility
    if (typeof elementor !== 'undefined') {
        elementor.hooks.addAction('panel/open_editor/widget/ele-slider', function(panel, model, view) {
            // Reinitialize sliders when widget is edited
            setTimeout(function() {
                $('.ele-slider-wrapper').each(function() {
                    // Simple reinitialization for editor
                    var slider = $(this);
                    var slides = slider.find('.ele-slider-slide');
                    slides.removeClass('active');
                    if (slides.length > 0) {
                        slides.first().addClass('active');
                    }
                });
            }, 100);
        });
    }
});
