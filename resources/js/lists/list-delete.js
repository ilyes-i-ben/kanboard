import {removeList} from "./list-ui.js";
import {updateTerminal} from "./list-edit.js";

window.addEventListener('delete-list', async ({detail: {listId}}) => {
    if (!listId) return;

    const confirm = await window.showConfirmationModalAsync({
        title: "Are you sure of deleting the list ?",
        message: '⚠️ Deleting the list deletes all the cards !',
    });

    if (!confirm) {
        return;
    }

    try {
        const response = await fetch(`/api/lists/${listId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            window.showSuccessToast('List deleted successfully');
            removeList(listId);
            const responseData = await response.json();
            if (responseData.wasTerminal && responseData.newTerminalId) {
                try {
                    updateTerminal(responseData.newTerminalId)
                    window.showSuccessToast("The list 'Done' is now terminal.", 6000);
                } catch (e) {
                }
            }
            document.querySelector('#board-list-count').innerHTML = responseData.listsCount;
        } else {
            const error = await response.json();
            window.showErrorToast(error.message || 'Failed to delete list.');
        }
    } catch (err) {
        window.showErrorToast('Network error. Could not delete list.');
    }
})
