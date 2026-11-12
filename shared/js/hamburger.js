const hamburger = document.getElementById('hamburger');
const navBar = document.getElementById('nav-bar');

hamburger.addEventListener('click', function() {
    navBar.classList.toggle('active');

    const isOpen = navBar.classList.contains('active');

    hamburger.setAttribute('aria-expanded', isOpen);

    hamburger.setAttribute ('aria-label', isOpen ? 'Zatvoriť navigáciu' : 'Otvoriť navigáciu');
});