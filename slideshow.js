let current_slide = 0;
showSlide(current_slide); // startinig off with the first slide
function showSlide(n) {
    const slides = document.getElementsByClassName("slideshow_img");
    if (n >= slides.length) current_slide = 0;
    if (n < 0) current_slide = slides.length - 1;

    // this is ot hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[current_slide].style.display = "block"; //so we show the current slide were on
}

// a function to go to the next slide
function next() {
    current_slide++;
    showSlide(current_slide);
}

// function to go to the previous slide
function previous() {
    current_slide--;
    showSlide(current_slide);
}
