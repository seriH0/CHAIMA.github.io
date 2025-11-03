// Initialize the current slide index
let current_slide = 0;

// Show the first slide immediately
showSlide(current_slide);

// a function to display a specific slide
function showSlide(n) {
    const slides = document.getElementsByClassName("slideshow_img");
    
    if (n >= slides.length) current_slide = 0;
    if (n < 0) current_slide = slides.length - 1;

    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Shows the current slide
    slides[current_slide].style.display = "block";
}

// Function to go to the next slide
function next() {
    current_slide++;
    showSlide(current_slide);
}

// Function to go to the previous slide
function previous() {
    current_slide--;
    showSlide(current_slide);
}
