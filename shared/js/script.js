
const carouselImage = document.getElementById('carousel-img');
const previousButton = document.getElementById('prev-image');
const nextButton = document.getElementById('next-image');

const images = [
    {
    src: BASE_URL + 'imgs/hokejbal-170T-1-700x400.jpg',
    alt: 'Hokejbal'
},
{
    src: BASE_URL + 'imgs/o2arena1-700x400.jpg',
    alt: 'O2 Arena'
},
{
    src: BASE_URL + 'imgs/sparta-kralovka-700x400.jpg',
    alt: 'Športová hala Královka'
},
{
    src: BASE_URL + 'imgs/kokej220-Pezinok-700x400.jpg',
    alt: 'Hokej Pezinok'
},
{
    src: BASE_URL + 'imgs/Hokejbal-Malacky-700x400.jpg',
    alt: 'Športová hala Královka'
}
];

let currentImage = 0;

function showImage(index) {
    carouselImage.src = images[index].src;
    carouselImage.alt = images[index].alt;
}

if (nextButton) {
    nextButton.addEventListener('click', function () {
    currentImage++;

    if (currentImage >= images.length) {
        currentImage = 0;
    }

    showImage(currentImage);
});
}

if (previousButton) {
    previousButton.addEventListener('click', function () {
    currentImage--;

    if (currentImage < 0) {
        currentImage = images.length - 1;
    }

    showImage(currentImage);
});
}