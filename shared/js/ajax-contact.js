console.log('AJAX contact JS sa načítal');

const contactForm = document.getElementById('contact-form');
const contactMessage = document.getElementById('contact-message');

console.log('Form:', contactForm);
console.log('Message:', contactMessage);

contactForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(contactForm);

    const language = formData.get('language') || 'sk';

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

    const text = messages[language] || messages.sk;

    const firstName = formData.get('first_name').trim();
    const lastName = formData.get('last_name').trim();
    const email = formData.get('email').trim();
    const phone = formData.get('phone').trim();
    const note = formData.get('note').trim();
    const gdpr = formData.get('gdpr');

    if (!firstName || !lastName || !email || !phone || !note) {
        contactMessage.hidden = false;
        contactMessage.textContent = text.required;
        contactMessage.className = 'form-message error';
        return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        contactMessage.hidden = false;
        contactMessage.textContent = text.invalidEmail;
        contactMessage.className = 'form-message error';
        return;
    }

    if (!gdpr) {
        contactMessage.hidden = false;
        contactMessage.textContent = text.gdpr;
        contactMessage.className = 'form-message error';
        return;
    }

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
        console.error('AJAX chyba:', error);

        contactMessage.hidden = false;
        contactMessage.textContent = 'Nastala chyba pri komunikácii so serverom';
        contactMessage.className = 'form-message error';
    }

});