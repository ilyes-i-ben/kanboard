class ToastManager {
    // TODO: idea: make blade components, generate the toasts from the backend when possible (online)
    // if not, generate them at JS level, like now..

    constructor() {
        this.toasts = [];
        this.container = null;
        this.init();
    }

    init() {
        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        this.container.className = 'fixed bottom-4 right-4 z-50 space-y-2';
        document.body.appendChild(this.container);
    }

    addToast(type, message, duration = 4000) {
        const toast = this.createToast(type, message, duration);
        this.container.appendChild(toast);

        // Auto-remove toast after duration
        setTimeout(() => {
            this.removeToast(toast);
        }, duration);
    }

    createToast(type, message, duration) {
        const toastId = 'toast-' + Date.now();

        // Get type-specific styles
        const styles = this.getToastStyles(type);

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.setAttribute('x-data', '{ show: true }');
        toast.setAttribute('x-init', `setTimeout(() => show = false, ${duration})`);
        toast.setAttribute('x-show', 'show');
        toast.setAttribute('x-transition:enter', 'transition ease-out duration-300');
        toast.setAttribute('x-transition:enter-start', 'opacity-0 translate-y-2');
        toast.setAttribute('x-transition:enter-end', 'opacity-100 translate-y-0');
        toast.setAttribute('x-transition:leave', 'transition ease-in duration-300');
        toast.setAttribute('x-transition:leave-start', 'opacity-100 translate-y-0');
        toast.setAttribute('x-transition:leave-end', 'opacity-0 translate-y-2');
        toast.className = `flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 ${styles.bgColor} ${styles.borderColor} rounded-lg shadow-lg ${styles.darkTextColor} ${styles.darkBgColor} ${styles.darkBorderColor}`;
        toast.setAttribute('role', 'alert');

        toast.innerHTML = `
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${styles.iconColor} ${styles.iconBgColor} rounded-lg ${styles.darkIconBgColor} ${styles.darkIconColor}">
                ${this.getIcon(type)}
            </div>

            <div class="ms-3 text-sm font-normal">${message}</div>

            <button @click="show = false" type="button" class="ms-auto text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close</span>
            </button>
        `;

        return toast;
    }

    getToastStyles(type) {
        const styles = {
            success: {
                bgColor: 'bg-green-50',
                borderColor: 'border border-green-200',
                darkTextColor: 'dark:text-green-100',
                darkBgColor: 'dark:bg-green-900',
                darkBorderColor: 'dark:border-green-700',
                iconColor: 'text-green-500',
                iconBgColor: 'bg-green-100',
                darkIconBgColor: 'dark:bg-green-800',
                darkIconColor: 'dark:text-green-200'
            },
            error: {
                bgColor: 'bg-red-50',
                borderColor: 'border border-red-200',
                darkTextColor: 'dark:text-red-100',
                darkBgColor: 'dark:bg-red-900',
                darkBorderColor: 'dark:border-red-700',
                iconColor: 'text-red-500',
                iconBgColor: 'bg-red-100',
                darkIconBgColor: 'dark:bg-red-800',
                darkIconColor: 'dark:text-red-200'
            },
            warning: {
                bgColor: 'bg-yellow-50',
                borderColor: 'border border-yellow-200',
                darkTextColor: 'dark:text-yellow-100',
                darkBgColor: 'dark:bg-yellow-900',
                darkBorderColor: 'dark:border-yellow-700',
                iconColor: 'text-yellow-500',
                iconBgColor: 'bg-yellow-100',
                darkIconBgColor: 'dark:bg-yellow-800',
                darkIconColor: 'dark:text-yellow-200'
            },
            info: {
                bgColor: 'bg-blue-50',
                borderColor: 'border border-blue-200',
                darkTextColor: 'dark:text-blue-100',
                darkBgColor: 'dark:bg-blue-900',
                darkBorderColor: 'dark:border-blue-700',
                iconColor: 'text-blue-500',
                iconBgColor: 'bg-blue-100',
                darkIconBgColor: 'dark:bg-blue-800',
                darkIconColor: 'dark:text-blue-200'
            }
        };

        return styles[type] || styles.info;
    }

    getIcon(type) {
        const icons = {
            success: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>`,
            error: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>`,
            warning: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 0 1-1-1V6a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1Z"/>
            </svg>`,
            info: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>`
        };

        return icons[type] || icons.info;
    }

    removeToast(toast) {
        if (toast && toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }
}

const toastManager = new ToastManager();

// Global functions
window.addToast = function(type, message, duration = 4000) {
    toastManager.addToast(type, message, duration);
};

// Convenience methods
window.showSuccessToast = function(message, duration = 4000) {
    toastManager.addToast('success', message, duration);
};

window.showErrorToast = function(message, duration = 4000) {
    toastManager.addToast('error', message, duration);
};

window.showWarningToast = function(message, duration = 4000) {
    toastManager.addToast('warning', message, duration);
};

window.showInfoToast = function(message, duration = 4000) {
    toastManager.addToast('info', message, duration);
};

export default toastManager;
