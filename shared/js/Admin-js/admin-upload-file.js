console.log('admin-uploads sa nacital');

document.addEventListener('dragover', e => {
    e.preventDefault();
});

document.addEventListener('drop', e => {
    e.preventDefault();
});

const dropZone = document.getElementById('document-drop-zone');
const fileInput = document.getElementById('document-input');
const documentName = document.getElementById('document-name');

if (dropZone && fileInput) {
    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
    });


    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        const files = e.dataTransfer.files;

        if (files.length !== 1) {
            documentName.textContent = 'Presuň iba jeden súbor';
            return;
        }

        const file = files[0];

        if (!file.name.toLowerCase().endsWith('.pdf')) {
            documentName.textContent = 'Povolené sú iba .pdf súbory';
            fileInput.value = '';
            return;
        }

        fileInput.files = files;

        documentName.textContent = 'Vybraný súbor' + file.name;
    });
}