class ConfirmationModalManager {
    constructor() {
        this.modal = null;
        this.backdrop = null;
        this.onConfirm = null;
        this.onCancel = null;
        this.init();
    }

    init() {
        // Create backdrop
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
                    <button id="confirmation-modal-confirm" type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Confirm</button>
                    <button id="confirmation-modal-cancel" type="button" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md">Cancel</button>
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

const confirmationModalManager = new ConfirmationModalManager();

window.showConfirmationModalAsync = function({ title, message }) {
    return confirmationModalManager.showAsync({ title, message });
};

window.showConfirmationModal = function({ title, message, onConfirm }) {
    confirmationModalManager.show({ title, message, onConfirm });
};

export default confirmationModalManager;
