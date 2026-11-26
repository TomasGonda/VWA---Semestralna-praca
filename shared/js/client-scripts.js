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

//const arrow = document.querySelectorAll('.arrow');

class SideMenu {
    constructor() {
        this.sideButtons = document.querySelectorAll('.side-menu-button');

        this.init();
    }

    init() {
        this.sideButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.toggleMenu(button);
            });
        });
    }

    toggleMenu(button) {
        const sideMenuItem = button.closest('.side-menu-item');
        const arrow = button.querySelector('.arrow');

        if (!sideMenuItem || !arrow) {
            return;
        }

        sideMenuItem.classList.toggle('open');

        const isOpen = sideMenuItem.classList.contains('open');

        arrow.textContent = isOpen ? '▲' : '▼';
    }
}

class HamburgerMenu {
    constructor() {
        this.hamburger = document.getElementById('hamburger');
        this.navBar = document.getElementById('nav-bar');

        this.init();
    }

    init() {
        if (!this.hamburger || !this.navBar) return;

        this.hamburger.addEventListener('click', () => {
            this.toggleMenu();
        });
    }

    toggleMenu() {
        this.navBar.classList.toggle('active');

        const isOpen = this.navBar.classList.contains('active');

        this.hamburger.setAttribute('aria-expanded', isOpen);
        this.hamburger.setAttribute(
            'aria-label',
            isOpen ? 'Zatvoriť navigáciu' : 'Otvoriť navigáciu'
        );
    }
}

class ContactForm {
    constructor() {
        this.contactForm = document.getElementById('contact-form');
        this.contactMessage = document.getElementById('contact-message');

        this.init();
    }

    init() {
        if (!this.contactForm || !this.contactMessage) return;

        console.log('AJAX contact JS sa načítal');
        console.log('Form:', this.contactForm);
        console.log('Message:', this.contactMessage);

        this.contactForm.addEventListener('submit', (event) => {
            this.submitForm(event);
        });
    }

    getMessages(language) {
        const messages = {
            sk: {
                required: 'Vyplňte všetky povinné polia.',
                invalidEmail: 'Zadajte platnú e-mailovú adresu.',
                gdpr: 'Musíte súhlasiť so spracovaním osobných údajov.'
            },
            en: {
                required: 'Please fill in all required fields.',
                invalidEmail: 'Please enter a valid email address.',
                gdpr: 'You must agree to the processing of personal data.'
            }
        };

        return messages[language] || messages.sk;
    }

    showMessage(message, type) {
        this.contactMessage.hidden = false;
        this.contactMessage.textContent = message;
        this.contactMessage.className = 'form-message ' + type;
    }

    validateForm(formData, messages) {
        const firstName = formData.get('first_name').trim();
        const lastName = formData.get('last_name').trim();
        const email = formData.get('email').trim();
        const phone = formData.get('phone').trim();
        const note = formData.get('note').trim();
        const gdpr = formData.get('gdpr');

        if (!firstName || !lastName || !email || !phone || !note) {
            this.showMessage(messages.required, 'error');
            return false;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            this.showMessage(messages.invalidEmail, 'error');
            return false;
        }

        if (!gdpr) {
            this.showMessage(messages.gdpr, 'error');
            return false;
        }

        return true;
    }

    async submitForm(event) {
        event.preventDefault();

        const formData = new FormData(this.contactForm);
        const language = formData.get('language') || 'sk';
        const messages = this.getMessages(language);

        if (!this.validateForm(formData, messages)) return;

        try {
            const response = await fetch(this.contactForm.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            this.showMessage(
                result.message,
                result.success ? 'success' : 'error'
            );

            if (result.success) {
                this.contactForm.reset();
            }

        } catch (error) {
            console.error('AJAX chyba:', error);

            this.showMessage(
                'Nastala chyba pri komunikácii so serverom',
                'error'
            );
        }
    }
}

const contactForm = new ContactForm();


document.addEventListener('DOMContentLoaded', () => {
    new Carousel();
    new SideMenu();
    new HamburgerMenu();
    new ContactForm();
});