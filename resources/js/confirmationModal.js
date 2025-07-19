import { appendQRCode } from './qrcodeUtil';

class ConfirmationModalManager {
    constructor() {
        this.modal = null;
        this.backdrop = null;
        this.onConfirm = null;
        this.onCancel = null;
        this.init();
    }

    init() {
        this.backdrop = document.createElement('div');
        this.backdrop.className = 'fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 z-50';
        this.backdrop.style.display = 'none';
        this.backdrop.addEventListener('click', () => this.hide());
        document.body.appendChild(this.backdrop);

        // Create modal
        this.modal = document.createElement('div');
        this.modal.className = 'fixed inset-0 flex items-center justify-center z-50';
        this.modal.style.display = 'none';
        this.modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 id="confirmation-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2"></h2>
                <p id="confirmation-modal-message" class="mb-4 text-gray-700 dark:text-gray-300"></p>
                <div class="flex justify-end gap-3">
                    <button id="confirmation-modal-confirm" type="button" class="inline-flex justify-center px-4 py-2 font-medium text-white bg-green-600 dark:bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">Confirm</button>
                    <button id="confirmation-modal-cancel" type="button" class="inline-flex justify-center px-4 py-2 font-medium text-gray-800 dark:text-gray-200 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md shadow-sm hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">Cancel</button>
                </div>
            </div>
        `;
        document.body.appendChild(this.modal);

        // Button listeners
        this.modal.querySelector('#confirmation-modal-confirm').addEventListener('click', () => {
            if (typeof this.onConfirm === 'function') {
                this.onConfirm();
            }
            this.hide();
        });
        this.modal.querySelector('#confirmation-modal-cancel').addEventListener('click', () => {
            if (typeof this.onCancel === 'function') {
                this.onCancel();
            }
            this.hide();
        });
    }

    show({ title = '', message = '', onConfirm = null }) {
        this.onConfirm = onConfirm;
        this.modal.querySelector('#confirmation-modal-title').textContent = title;
        this.modal.querySelector('#confirmation-modal-message').textContent = message;
        this.modal.style.display = 'flex';
        this.backdrop.style.display = 'block';
    }

    showAsync({ title = '', message = '' }) {
        return new Promise((resolve, reject) => {
            this.onConfirm = () => {
                resolve(true);
            };
            this.onCancel = () => {
                resolve(false);
            };
            this.modal.querySelector('#confirmation-modal-title').textContent = title;
            this.modal.querySelector('#confirmation-modal-message').textContent = message;
            this.modal.style.display = 'flex';
            this.backdrop.style.display = 'block';
        });
    }

    hide() {
        this.modal.style.display = 'none';
        this.backdrop.style.display = 'none';
        this.onConfirm = null;
        this.onCancel = null;
    }
}

class ShareLinkModalManager {
    constructor() {
        this.modal = null;
        this.backdrop = null;
        this.init();
    }

    init() {
        this.backdrop = document.createElement('div');
        this.backdrop.className = 'fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 z-50';
        this.backdrop.style.display = 'none';
        this.backdrop.addEventListener('click', () => this.hide());
        document.body.appendChild(this.backdrop);

        // modal
        this.modal = document.createElement('div');
        this.modal.className = 'fixed inset-0 flex items-center justify-center z-50';
        this.modal.style.display = 'none';
        this.modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Share Link</h2>
                <div class="mb-4">
                    <a id="share-link-modal-link" href="#" target="_blank" class="text-blue-600 underline break-all"></a>
                </div>
                <div class="flex justify-center mb-4">
                    <div id="share-link-qrcode" class="bg-white p-2 rounded"></div>
                </div>
                <div class="flex gap-3 justify-end">
                    <button id="share-link-modal-copy" type="button" class="inline-flex justify-center px-4 py-2 font-medium text-white bg-green-600 dark:bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">Copy</button>
                    <button id="share-link-modal-close" type="button" class="inline-flex justify-center px-4 py-2 font-medium text-gray-800 dark:text-gray-200 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md shadow-sm hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">Cancel</button>
                </div>
            </div>
        `;
        document.body.appendChild(this.modal);

        // Button listeners
        this.modal.querySelector('#share-link-modal-copy').addEventListener('click', () => this.copyLink());
        this.modal.querySelector('#share-link-modal-close').addEventListener('click', () => this.hide());
    }

    show(link) {
        this.link = link;
        const linkElem = this.modal.querySelector('#share-link-modal-link');
        linkElem.href = link;
        linkElem.textContent = link;

        const qrcodeContainer = this.modal.querySelector('#share-link-qrcode');
        appendQRCode(qrcodeContainer, link);

        this.modal.style.display = 'flex';
        this.backdrop.style.display = 'block';
    }

    async copyLink() {
        try {
            await navigator.clipboard.writeText(this.link);
            window.showSuccessToast('Link copied to clipboard!');
        } catch (e) {
            const tempInput = document.createElement('input');
            tempInput.value = this.link;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand('copy');
                window.showSuccessToast('Link copied to clipboard!');
            } catch (err) {
                window.showErrorToast('Could not copy link. Please copy manually.');
            }
            document.body.removeChild(tempInput);
        }
    }

    hide() {
        this.modal.style.display = 'none';
        this.backdrop.style.display = 'none';
    }
}

const confirmationModalManager = new ConfirmationModalManager();
const shareLinkModalManager = new ShareLinkModalManager();

window.showConfirmationModalAsync = function({ title, message }) {
    return confirmationModalManager.showAsync({ title, message });
};

window.showConfirmationModal = function({ title, message, onConfirm }) {
    confirmationModalManager.show({ title, message, onConfirm });
};

window.showShareLinkModal = function({ link }) {
    shareLinkModalManager.show(link);
};

// Add a style tag to ensure these buttons have higher specificity
document.head.insertAdjacentHTML('beforeend', `
    <style>
        #confirmation-modal-confirm, #share-link-modal-copy {
            background-color: rgb(22, 163, 74) !important; /* Green-600 */
            color: white !important;
        }

        #confirmation-modal-confirm:hover, #share-link-modal-copy:hover {
            background-color: rgb(21, 128, 61) !important; /* Green-700 */
        }
    </style>
`);

export default confirmationModalManager;
