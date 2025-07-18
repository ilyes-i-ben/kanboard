function addCard(card, html) {
    if (!card || !html) return;
    const listId = card.list_id;
    const container = document.querySelector(`[x-sort\\:item="${listId}"] .cards-container`);
    if (container) container.insertAdjacentHTML('beforeend', html);
}

function removeCard(cardId) {
    if (!cardId) return;
    const cardEl = document.querySelector(`[x-sort\\:item="${cardId}"]`);
    if (cardEl) cardEl.remove();
}

function updateCardUI(cardId, html) {
    if (!cardId || !html) return;
    const cardEl = document.getElementById(`kanboard-card-${cardId}`);
    if (cardEl) {
        cardEl.outerHTML = html;
    }
}

export { addCard, removeCard, updateCardUI };
