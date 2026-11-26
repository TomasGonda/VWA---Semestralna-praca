class Carousel {
    constructor() {
        this.carouselImage = document.getElementById('carousel-img');
        this.previousButton = document.getElementById('prev-image');
        this.nextButton = document.getElementById('next-image');

        this.images = [
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
                alt: 'Hokejbal Malacky'
            }
        ];

        this.currentImage = 0;

        this.init();
    }

    init() {
        if (!this.carouselImage) {
            return;
        }

        if (this.nextButton) {
            this.nextButton.addEventListener('click', () => {
                this.nextImage();
            });
        }

        if (this.previousButton) {
            this.previousButton.addEventListener('click', () => {
                this.previousImage();
            });
        }
    }

    showImage(index) {
        this.carouselImage.src = this.images[index].src;
        this.carouselImage.alt = this.images[index].alt;
    }

    nextImage() {
        this.currentImage++;

        if (this.currentImage >= this.images.length) {
            this.currentImage = 0;
        }

        this.showImage(this.currentImage);
    }
}