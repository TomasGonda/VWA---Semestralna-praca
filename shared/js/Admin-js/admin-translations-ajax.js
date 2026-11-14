console.log('AJAX admin JS sa načítal');

document.querySelectorAll('.admin-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const message = form.querySelector('.form-message');
        const button = form.querySelector('button[type="submit"]');

        button.disabled = true;
        message.hidden = false;
        message.textContent = 'Ukladanie';
        message.className = 'form-message';

        try {
            const response = await fetch('Admin-scripts/updateLanguage.php', {
                method: 'POST',
                body: new FormData(form)
            });

            const result = await response.json();

            message.textContent = result.message;
            message.classList.add(result.success ? 'success' : 'error');
        } catch (error) {
            message.textContent = 'Nepodarilo sa spojiť so serverom';
            message.classList.add('error');
        } finally {
            button.disabled = false;
        }
    });
});
