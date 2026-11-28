class AdminTranslationAjax {
    constructor() {
        this.supportedForms = [
            'create-translation',
            'edit-translation',
            'delete-translation',
            'edit-document',
            'upload-document'
        ];

        this.init();
    }

    init() {
        console.log('AJAX admin JS sa načítal');

        document.querySelectorAll('.admin-form').forEach(form => {
            form.addEventListener('submit', (event) => {
                this.handleSubmit(event, form);
            });
        });
    }

    isSupportedForm(form) {
        return this.supportedForms.some(className =>
            form.classList.contains(className)
        );
    }

    async handleSubmit(event, form) {
        event.preventDefault();

        if (!this.isSupportedForm(form)) {
            return;
        }

        const message = form.querySelector('.form-message');
        const button = form.querySelector('button[type="submit"]');
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

            this.showMessage(message, result);

            if (!response.ok || !result.success) {
                return;
            }

            this.handleSuccess(form);

        } catch (error) {
            console.error('Ajax error:', error);

            message.textContent = 'Ajax: Nepodarilo sa spracovať požiadavku.';
            message.classList.add('error');

        } finally {
            button.disabled = false;
        }
    }

    showMessage(message, result) {
        message.textContent = result.message;
        message.classList.add(result.success ? 'success' : 'error');
    }

    handleSuccess(form) {
        if (form.classList.contains('create-translation')) {
            form.reset();
        }

        if (form.classList.contains('delete-translation')) {
            const translationCard = form.closest('.translation-card');

            if (translationCard) {
                translationCard.remove();
            }
        }
    }
}

class AdminUploadFile {

    constructor() {
        this.dropZone = document.getElementById('document-drop-zone');
        this.fileInput = document.getElementById('document-input');
        this.documentName = document.getElementById('document-name');

        this.init();
    }

    init() {
        console.log('Uloap admin JS sa načítal');

        console.log(this.dropZone);
        console.log(this.fileInput);
        console.log(this.documentName);
        if (!this.dropZone || !this.fileInput || !this.documentName) {
            console.warn('Elementy pre upload neboli nájdené.');
            return;
        }

        document.addEventListener('dragover', e => {
            e.preventDefault();
        });

        document.addEventListener('drop', e => {
            e.preventDefault();
        });

        this.dropZone.addEventListener('dragover', e => {
            e.preventDefault();
        });

        this.dropZone.addEventListener('drop', e => {
            e.preventDefault();
            this.handleDrop(e);
        });
    }

    handleDrop(e) {
        const files = e.dataTransfer.files;

        if (files.length !== 1) {
            this.documentName.textContent = 'Presuň iba jeden súbor';
            return;
        }

        const file = files[0];

        if (!file.name.toLowerCase().endsWith('.pdf')) {
            this.documentName.textContent = 'Povolené sú iba .pdf súbory';
            this.fileInput.value = '';
            return;
        }

        this.fileInput.files = files;

        this.documentName.textContent = 'Vybraný súbor: ' + this.file.name;
    }
}


class TranslationSearch {
    constructor() {
        this.searchForm = document.getElementById('translation-search');
        this.searchInput = document.getElementById('search-input');
        this.searchMessage = document.getElementById('search-message');

        this.init();
    }

    init() {
        console.log('Preklady admin JS sa načítal');
        if (!this.searchForm || !this.searchInput || !this.searchMessage) {
            return;
        }

        this.searchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            this.searchTranslation();
        });
    }

    searchTranslation() {
        const searchTag = this.searchInput.value.trim().toLowerCase();

        this.searchMessage.hidden = true;

        if (!searchTag) {
            this.showMessage('Zadajte tag prekladu.');
            return;
        }

        const translations = document.querySelectorAll('.translation-card');

        const translation = Array.from(translations).find(item => {
            return item.dataset.tag.toLowerCase() === searchTag;
        });

        if (translation) {
            translation.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        } else {
            this.showMessage('Preklad s týmto tagom sa nenašiel.');
        }
    }

    showMessage(message) {
        this.searchMessage.textContent = message;
        this.searchMessage.hidden = false;
    }
}

class AdminFormsResponds {
    constructor() {
        console.log('AdminFormsResponds sa spustil');

        this.formSelectors = [
            '.delete-message',
            '.update-message',
            '.delete-translation',
            '.edit-translation',
            '.create-translation',
            '.edit-document',
            '.delete-document'
        ];

        this.forms = document.querySelectorAll(
            this.formSelectors.join(', ')
        );

        this.message = document.getElementById('contact-message');

        console.log('Nájdené formuláre:', this.forms.length);

        this.init();
    }

    init() {
        console.log('Init AdminFormsResponds');

        if (this.forms.length === 0) {
            console.log('Neboli nájdené žiadne podporované formuláre.');
            return;
        }

        this.forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                this.handleSubmit(event, form);
            });
        });
    }

    async handleSubmit(event, form) {
        event.preventDefault();

        const action = form.querySelector('[name="action"]')?.value;
        const button = form.querySelector('button[type="submit"]');
        const url = form.dataset.url || form.action;

        if (!button || !url) {
            console.error('Chýba tlačidlo alebo URL.');
            return;
        }

        // Potvrdenie iba pri mazaní
        const deleteActions = [
            'delete-message',
            'delete-language',
            'delete-translation',
            'delete-document'
        ];

        if (deleteActions.includes(action)) {
            if (!confirm('Naozaj chcete vykonať túto operáciu?')) {
                return;
            }
        }

        button.disabled = true;

        this.showMessage('Spracovávanie požiadavky...', true, form);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: new FormData(form)
            });

            console.log('Akcia:', action);
            console.log('HTTP status:', response.status);
            console.log('Response URL:', response.url);
            console.log('Redirected:', response.redirected);

            const responseText = await response.text();
            console.log('PHP odpoveď:', responseText);

            const result = JSON.parse(responseText);

            this.showMessage(
                result.message,
                response.ok && result.success,
                form
            );

            if (!response.ok || !result.success) {
                return;
            }

            if (action === 'update-message') {
                const card = form.closest('.form-card');
                const status = card?.querySelector('.message-status span');
                const isResolved = form.querySelector('[name="is_resolved"]');

                if (status && isResolved) {
                    const resolved = isResolved.value === '1';

                    status.textContent = resolved ? 'Vybavené' : 'Nevybavené';
                    status.className = resolved ? 'resolved' : 'unresolved';

                    isResolved.value = resolved ? '0' : '1';

                    form.querySelector('button[type="submit"]').textContent =
                        resolved
                            ? 'Vrátiť medzi nevybavené'
                            : 'Označiť ako vybavené';
                }
            }
            if (action === 'create-language' ||
                action === 'create-translation') {
                form.reset();
            }
            if (deleteActions.includes(action)) {
                const card = form.closest(
                    '.form-card, .translation-card, .document-card'
                );

                if (card) {
                    card.remove();
                }
            }

        } catch (error) {
            console.error('AJAX error:', error);

            this.showMessage(
                'Nepodarilo sa spracovať požiadavku.',
                false,
                form
            );

        } finally {
            button.disabled = false;
        }
    }

    showMessage(message, success, form) {
        const messageElement =
            form.querySelector('.form-message') || this.message;

        if (!messageElement) {
            console.error('Element na vypísanie správy nebol nájdený.');
            return;
        }

        messageElement.hidden = false;
        messageElement.textContent = message;
        messageElement.className = 'form-message';

        messageElement.classList.add(
            success ? 'success' : 'error'
        );
    }
}


document.addEventListener('DOMContentLoaded', () => {
    new TranslationSearch();
    new AdminTranslationAjax();
    new AdminUploadFile();
    new AdminFormsResponds();
});
