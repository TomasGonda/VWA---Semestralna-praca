class TranslationSearch {
    constructor() {
        this.searchForm = document.getElementById('translation-search');
        this.searchInput = document.getElementById('search-input');
        this.searchMessage = document.getElementById('search-message');

        this.init();
    }

    init() {
        if (!this.searchForm || !this.searchInput) {
            return;
        }

        this.searchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            this.searchTranslation();
        });
    }

    searchTranslation() {
        const searchTag = this.searchInput.value.trim().toLowerCase();

        if (!searchTag) {
            return;
        }

        const translations = document.querySelectorAll('.translation-card');

        const translation = Array.from(translations).find(item => {
            return item.dataset.tag.toLowerCase() === searchTag;
        });

        if (translation) {
            translation.scrollIntoView ({
                behavior: 'smooth',
                block: 'center'
            });  
        } else {
            this.searchMessage.textContent = 'Preklad s týmto tagom sa nenašiel';
            this.searchMessage.hidden = false;
        }
    }
}

const translationSearch = new TranslationSearch();