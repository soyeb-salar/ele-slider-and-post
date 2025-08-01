jQuery(document).ready(function($) {
   
// Function to initialize slider functionality for a specific slider container
function initializeSlider(sliderContainer) {
    // Select the next and previous buttons within the specific slider container
    let next = sliderContainer.querySelector('.next');
    let prev = sliderContainer.querySelector('.prev');

    // Event listener for the next button
    next.addEventListener('click', function() {
        let items = sliderContainer.querySelectorAll('.ele-item');
        // Move the first item to the end of the slider container
        sliderContainer.querySelector('.ele-slide').appendChild(items[0]);
    });

    // Event listener for the previous button
    prev.addEventListener('click', function() {
        let items = sliderContainer.querySelectorAll('.ele-item');
        // Move the last item to the beginning of the slider container
        sliderContainer.querySelector('.ele-slide').prepend(items[items.length - 1]);
    });
}

// Initialize each slider individually
document.querySelectorAll('.ele-container').forEach(slider => initializeSlider(slider));



// Function to initialize slider functionality for a specific slider container
function initializePostSlider(sliderContainer) {
    // Select the next and previous buttons within the specific slider container
    let nextpost = sliderContainer.querySelector('.nextpost');
    let prevpost = sliderContainer.querySelector('.prevpost');

    // Event listener for the next button
    nextpost.addEventListener('click', function() {
        let items = sliderContainer.querySelectorAll('.ele-item-post');
        // Move the first item to the end of the slider container
        sliderContainer.querySelector('.ele-slide-post').appendChild(items[0]);
    });

    // Event listener for the previous button
    prevpost.addEventListener('click', function() {
        let items = sliderContainer.querySelectorAll('.ele-item-post');
        // Move the last item to the beginning of the slider container
        sliderContainer.querySelector('.ele-slide-post').prepend(items[items.length - 1]);
    });
}

// Initialize the sliders
document.querySelectorAll('.ele-container-post').forEach(slider => initializePostSlider(slider));
});
