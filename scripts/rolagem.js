//Script pra fazer a galeria ir para a esquerda ou direita com a seta
let slideIndex = 0;

function moveSlide(step) {
    let slides = document.querySelectorAll('.gallery-item');
    slideIndex += step;

    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    }
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }

    const newTransform = `translateX(-${slideIndex * 100}%)`;
    document.querySelector('.gallery').style.transform = newTransform;
}
