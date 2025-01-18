document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    let currentIndex = 0;

    // Update slide position
    const updateSlidePosition = () => {
        const offset = -currentIndex * 100;
        slider.style.transform = `translateX(${offset}%)`;
    };

    // Auto-slide every 5 seconds
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlidePosition();
    }, 5000);

});
