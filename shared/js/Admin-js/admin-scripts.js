
/*NOT CONNECTED YET - WILL MERGE ALL ADMIN SCRIPTS FILES*/
class AdminTranslationsAjax {
    
    constructor() {

    }

    init() {

    }

    getMessages() {
        const messages = {
            missing: 'Formuláru chýba URL, tlačidlo alebo message element.',
            ajaxError: 'Ajax: Nepodarilo sa spracovať požiadavku.'
        };

        return messages;
    }

    showMessage(message, type) {
        this.contactMessage.hidden = false;
        this.contactMessage.textContent = message;
        this.contactMessage.className = 'form-message ' + type;
    }

    validateLanguage() {

    }

    createLanguage() {

    }
}

class AdminUploadFile {
    
    constructor() {
        const dropZone = document.getElementById('document-drop-zone');
        const fileInput = document.getElementById('document-input');
        const documentName = document.getElementById('document-name');

        this.init();
    }

    init() {
        document.addEventListener('dragover', e => {
            e.preventDefault();
        });

        document.addEventListener('drop', e => {
            e.preventDefault();
        });

        this.dropzone.addEventListener('dragover', e => {
            e.preventDefault();
        });

        this.dropzone.addEventListener('drop', e => {
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

        this.documentName.textContent = 'Vybraný súbor: ' +  this.file.name;
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

document.addEventListener('DOMContentLoaded', () => {
    new TranslationSearch();
    //new AdminTranslationsAjax();
    //new AdminUploadFile();
});
