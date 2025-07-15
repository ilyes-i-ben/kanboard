import tinymce from "tinymce";
import { updateCardUI } from "./card-ui.js";

async function sendUpdateCard(url, formData) {
    try {
        console.log(formData.get('_token'))
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData,
        });
        const data = await response.json();
        if (data.success && data.card) {
            window.showSuccessToast(data.message || 'Card updated successfully!');
            return data.card;
        } else {
            window.showErrorToast(data.message || 'Error updating card');
            return null;
        }
    } catch (error) {
        console.error('Error updating card:', error);
        window.showErrorToast('Error occurred on card update');
        return null;
    }
}

async function renderCard(cardId) {
    try {
        const renderUrl = `/api/cards/${cardId}/render`;
        const renderResponse = await fetch(renderUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });
        const renderData = await renderResponse.json();
        if (renderData.success && renderData.html) {
            return renderData.html;
        }
        return null;
    } catch (error) {
        console.error('Error rendering card:', error);
        return null;
    }
}

async function handleCardUpdate(modalForm) {
    tinymce.activeEditor.save();
    const formData = new FormData(modalForm);
    const url = modalForm.action;
    const submitBtn = modalForm.querySelector('[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    try {
        const card = await sendUpdateCard(url, formData);
        if (card) {
            const cardHtml = await renderCard(card.id);
            if (cardHtml) {
                updateCardUI(card.id, cardHtml);
                window.dispatchEvent(new CustomEvent('close-edit-card-modal'));
                window.dispatchEvent(new CustomEvent('card-updated', { detail: { card } }));
            }
        }
    } finally {
        if (submitBtn) submitBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modalForms = document.querySelectorAll('.edit-card-modal-class');
    if (!modalForms) return;
    modalForms.forEach(modalForm => {
        modalForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            await handleCardUpdate(modalForm);
        });
    });
});
