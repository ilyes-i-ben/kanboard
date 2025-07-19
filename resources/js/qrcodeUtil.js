import QRCode from 'qrcode';

export function appendQRCode(container, value, options = {}) {
    if (!container || typeof value !== 'string') return;
    container.innerHTML = '';
    try {
        const canvas = document.createElement('canvas');
        container.appendChild(canvas);
        QRCode.toCanvas(canvas, value, {
            width: 160,
            margin: 1,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            },
            ...options
        }, (error) => {
            if (error) {
                console.error('error generating QR code:', error);
                container.innerHTML = '<p class="text-red-500">Could not generate QR code</p>';
            }
        });
    } catch (error) {
        console.error('error setting up QR code:', error);
        container.innerHTML = '<p class="text-red-500">Could not generate QR code</p>';
    }
}

