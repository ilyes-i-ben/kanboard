window.addEventListener('delete-board', async (event) => {
    console.log('aaoubeoubaougnaoeghae');
    const boardId = event.detail.boardId;
    if (!boardId) return;

    const confirm = await window.showConfirmationModalAsync({
        title: 'Delete board?',
        message: 'Are you sure about deleting the board? This action cannot be undone.'
    });

    if (!confirm) {
        window.showErrorToast('Board deletion canceled.');
        return;
    }

    try {
        const response = await fetch(`/boards/${boardId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            window.location.href = '/boards';
            window.showSuccessToast('Board deleted successfully!');
        } else {
            const error = await response.json();
            window.showErrorToast(error.message || 'Failed to delete board.');
        }
    } catch (err) {
        window.showErrorToast('Network error. Could not delete board.');
    }
});
