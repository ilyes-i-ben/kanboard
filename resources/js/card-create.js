import tinymce from "tinymce";
import { addCard } from "./card-ui";

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

async function createCard(url, formData) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData,
        });
        const data = await response.json();

        if (data.success && data.card) {
            showSuccessToast(data.message || 'Card created successfully!');
            return data.card;
        } else {
            showErrorToast(data.message || 'Error creating card');
            return null;
        }
    } catch (error) {
        console.error('Error creating card:', error);
        showErrorToast('Unexpected error occurred while creating card');
        return null;
    }
}

async function handleCardCreation(modalForm) {
    tinymce.activeEditor.save();
    const formData = new FormData(modalForm);
    const url = modalForm.action;
    const submitBtn = modalForm.querySelector('[type="submit"]');

    if (submitBtn) submitBtn.disabled = true;

    try {
        const card = await createCard(url, formData);

        if (card) {
            const cardHtml = await renderCard(card.id);

            if (cardHtml) {
                addCard(card, cardHtml);
                window.dispatchEvent(new CustomEvent('close-create-card-modal'));
            }
        }
    } finally {
        if (submitBtn) submitBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modalForms = document.querySelectorAll('.card-create-modal-form');
    if (!modalForms) return;

    modalForms.forEach(modalForm => {
        modalForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            await handleCardCreation(modalForm);
        });
    });
});
