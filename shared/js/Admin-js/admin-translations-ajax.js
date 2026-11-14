console.log('AJAX admin JS sa načítal');

document.querySelectorAll('.admin-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const message = form.querySelector('.form-message');
        const button = form.querySelector('button[type="submit"]');

        let url;

        if (form.classList.contains('create-translation')) {
            url = '../Dev-tools/Dev-scripts/create-language.php';
        } else if (form.classList.contains('edit-translation')) {
            url = 'Admin-scripts/updateLanguage.php';
        } else if (form.classList.contains('edit-document')){
            url = 'Admin-scripts/edit-document.php';
        } else if (form.classList.contains('upload-document')) {
            url = 'Admin-scripts/upload-document.php';
        }
        
        else    {
            return;
        }

        button.disabled = true;
        message.hidden = false;
        message.textContent = 'Ukladanie';
        message.className = 'form-message';

        try {
            const formData = new FormData(form);

            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
            const response = await fetch(url, {
                method: 'POST',
                body: new FormData(form)
            });

            const responseText = await response.text();

            console.log('URL:', url);
            console.log('HTTP status:', response.status);
            console.log('Server response:', responseText);

            const result = JSON.parse(responseText);

            message.textContent = result.message;
            message.classList.add(result.success ? 'success' : 'error');
        } catch (error) {
            console.log('Ajax error: ', error);
            message.textContent = 'Ajax: Nepodarilo sa spojiť so serverom';
            message.classList.add('error');
        } finally {
            button.disabled = false;
        }
    });
});
