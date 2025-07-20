window.addEventListener('card-share-requested', async (event) => {
    const cardId = event.detail.cardId;
    if (!cardId) return;

    const confirm = await window.showConfirmationModalAsync({
        title: 'Share card?',
        message: 'Are you sure you want to generate and copy the public share link for this card ?'
    });

    if (!confirm) {
        return;
    }

    try {
        const response = await fetch(`/api/cards/${cardId}/share`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            const {full_shared_url} = await response.json();
            if (full_shared_url) {
                window.showShareLinkModal({ link: full_shared_url });
                window.showSuccessToast('Card shared !')
            } else {
                window.showErrorToast('Failed to get share link.');
            }
        } else {
            const error = await response.json();
            window.showErrorToast(error.message || 'Failed to share card.');
        }
    } catch (err) {
        window.showErrorToast('Network error. Could not share card.');
    }
});
