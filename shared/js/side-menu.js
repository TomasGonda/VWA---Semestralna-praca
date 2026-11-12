const sideButtons = document.querySelectorAll('.side-menu-button');
//const arrow = document.querySelectorAll('.arrow');

sideButtons.forEach(button => {
    button.addEventListener('click', function() {
        const sideMenuItem = button.closest('.side-menu-item');
        const arrow = button.querySelector('.arrow');

        sideMenuItem.classList.toggle('open');

        const isOpen = sideMenuItem.classList.contains('open');

        arrow.textContent = isOpen ? '▲' : '▼';
    
    });
});