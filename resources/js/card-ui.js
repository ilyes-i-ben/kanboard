function addCard(card, html) {
    if (!card || !html) return;
    const listId = card.list_id;
    const container = document.querySelector(`[x-sort\\:item="${listId}"] .cards-container`);
    if (container) container.insertAdjacentHTML('beforeend', html);
}

function resetForm(form) {
    if (form) form.reset();
}

function closeModal() {
    window.dispatchEvent(new CustomEvent('close-create-card-modal'));
}

function showError(msg) {
    alert(msg || 'Error');
}

export { addCard, resetForm, closeModal, showError };
