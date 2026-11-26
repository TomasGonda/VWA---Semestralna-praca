
console.log('AJAX admin JS sa načítal');

document.querySelectorAll('.admin-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        /*console.log('Zachytený submit:', form.className);
        console.log('URL:', form.dataset.url);
        console.log('Action:', new FormData(form).get('action'));
        console.log('ID SK:', new FormData(form).get('id_sk'));
        console.log('ID EN:', new FormData(form).get('id_en'));*/

        const message = form.querySelector('.form-message');
        const button = form.querySelector('button[type="submit"]');

        const supportedForms = [
            'create-translation',
            'edit-translation',
            'delete-translation',
            'edit-document',
            'upload-document'
        ];

        const isSupported = supportedForms.some(className =>
            form.classList.contains(className)
        );

        if (!isSupported) {
            return;
        }

        const url = form.dataset.url;

        if (!url || !button || !message) {
            console.error('Formuláru chýba URL, tlačidlo alebo message element.');
            return;
        }

        button.disabled = true;
        message.hidden = false;
        message.textContent = 'Spracovávanie...';
        message.className = 'form-message';

        try {
            const formData = new FormData(form);

            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const responseText = await response.text();

            console.log('URL:', url);
            console.log('HTTP status:', response.status);
            console.log('Server response:', responseText);

            const result = JSON.parse(responseText);

            message.textContent = result.message;
            message.classList.add(result.success ? 'success' : 'error');

            if (!response.ok || !result.success) {
                return;
            }

            if (form.classList.contains('create-translation')) {
                form.reset();
            }

            if (form.classList.contains('delete-translation')) {
                const translationCard = form.closest('.translation-card');

                if (translationCard) {
                    translationCard.remove();
                }
            }

        } catch (error) {
            console.error('Ajax error:', error);
            message.textContent = 'Ajax: Nepodarilo sa spracovať požiadavku.';
            message.classList.add('error');

        } finally {
            button.disabled = false;
        }
    });
});
