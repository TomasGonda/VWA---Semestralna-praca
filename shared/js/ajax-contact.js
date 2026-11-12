//console.log('AJAX contact JS sa načítal');

const contactForm = document.getElementById('contact-form');
const contactMessage = document.getElementById('contact-message');

contactForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(contactForm);

    try {
        const response = await fetch(contactForm.action, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        contactMessage.hidden = false;
        contactMessage.textContent = result.message;
        contactMessage.className = 'form-message ' + (result.success ? 'success' : 'error');

        if (result.success) {
            contactForm.reset();
        }
    } catch (error) {
        contactMessage.hidden = false;
        contactMessage.textContent = 'Nastala chyba pri komunikácii so serverom';
        contactMessage.className = 'form-message error';
    }
    
});