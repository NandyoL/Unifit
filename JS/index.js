let index = 0;
const slides = document.querySelectorAll('.slide');

function showSlide() {
  slides.forEach((slide, i) => {
    slide.classList.remove('active');
    if (i === index) {
      slide.classList.add('active');
    }
  });
  index = (index + 1) % slides.length; // Loop
}

setInterval(showSlide, 3000); // Muda o slide a cada 3 segundos

const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener('click', () => {
        card.classList.toggle('is-flipped'); // Adiciona ou remove a classe para girar
    });
});
