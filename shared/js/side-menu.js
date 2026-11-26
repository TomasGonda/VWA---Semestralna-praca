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

const sideMenu = new SideMenu();