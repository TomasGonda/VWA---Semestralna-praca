
const carouselImage = document.getElementById('carousel-img');
const previousButton = document.getElementById('prev-image');
const nextButton = document.getElementById('next-image');

const images = [
    {
        src: '../../shared/imgs/hokejbal-170T-1-700x400.jpg',
        alt: 'Hokejbal'
    },
    {
        src: '../../shared/imgs/o2arena1-700x400.jpg',
        alt: 'O2 Arena'
    },
    {
        src: '../../shared/imgs/sparta-kralovka-700x400.jpg',
        alt: 'Športová hala Královka'
    }, 
    {
        src: '../../shared/imgs/kokej220-Pezinok-700x400.jpg',
        alt: 'Hokej Pezinok'
    },
    {
        src: '../../shared/imgs/Hokejbal-Malacky-700x400.jpg',
        alt: 'Športová hala Královka'
    }
];

let currentImage = 0;

function showImage(index) {
    carouselImage.src = images[index].src;
    carouselImage.alt = images[index].alt;
}

nextButton.addEventListener('click', function () {
    currentImage++;

    if (currentImage >= images.length) {
        currentImage = 0;
    }

    showImage(currentImage);
});

previousButton.addEventListener('click', function () {
    currentImage--;

    if (currentImage < 0) {
        currentImage = images.length - 1;
    }

    showImage(currentImage);
});