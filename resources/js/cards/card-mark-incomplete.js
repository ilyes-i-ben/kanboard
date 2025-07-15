window.addEventListener('mark-as-incomplete', async ({ detail: { cardId } }) => {
    if (!cardId) return;

    const confirm = await window.showConfirmationModalAsync({
        title: "Mark incomplete ?",
        message: 'Are you sure about that?',
    });

    if (!confirm) {
        window.showErrorToast('Cancelled.');
        return;
    }

    try {
        const response = await fetch(`/api/cards/${cardId}/mark-incomplete`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            const resData = await response.json();
            window.showSuccessToast(resData.message);
            markCardAsIncomplete(cardId);
            markModalAsIncomplete(cardId);
        } else {
            const error = await response.json();
            window.showErrorToast(error.message || 'Failed to mark incomplete.');
        }
    } catch (err) {
        window.showErrorToast('Network error. Could not update card.');
    }

});

function markCardAsIncomplete(cardId) {
    const cardElement = document.getElementById(`kanboard-card-${cardId}`);
    if (!cardElement) return;
    const completedSpan = cardElement.querySelector('.completed-badge');
    if (completedSpan) completedSpan.remove();
}

function markModalAsIncomplete(cardId) {
    const modalDataElement = document.getElementById(`kanboard-card-modal-data-${cardId}`);
    if (!modalDataElement) return;
    const completedEntry = modalDataElement.querySelector('.completed-entry');
    if (completedEntry) completedEntry.remove();
}
