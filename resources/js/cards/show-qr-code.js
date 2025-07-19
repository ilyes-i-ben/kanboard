import {appendQRCode} from "../qrcodeUtil.js";

document.addEventListener('DOMContentLoaded', function() {
    const qrcodeContainer = document.getElementById('card-qrcode');
    if (qrcodeContainer) {
        const shareUrl = qrcodeContainer.getAttribute('data-card-url') || "";
        appendQRCode(qrcodeContainer, shareUrl );
    }
});
