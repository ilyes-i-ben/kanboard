import { removeCard } from './card-ui.js';



window.addEventListener('delete-card', async (event) => {
    const cardId = event.detail.cardId;
    if (!cardId) return;

    const confirm = await window.showConfirmationModalAsync({
        title: "Delete card ?",
        message: 'Are you sure about deleting the card',
    });

    if (!confirm) {
        window.showErrorToast('Deletion canceled.');
        return;
    }

    try {
        const response = await fetch(`/api/cards/${cardId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            window.showSuccessToast('Card deleted successfully!');
            removeCard(cardId);
        } else {
            const error = await response.json();
            window.showErrorToast(error.message || 'Failed to delete card.');
        }
    } catch (err) {
        window.showErrorToast('Network error. Could not delete card.');
    }
});
