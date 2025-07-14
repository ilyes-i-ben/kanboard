document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form.list-edit-modal-form').forEach(function(form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const url = form.action;
            const formData = new FormData(form);
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                if (response.ok) {
                    window.dispatchEvent(new CustomEvent('close-edit-list-modal'));
                    const data = await response.json();
                    updateListTitle(data.listId, data.title);
                    if (data.terminal) {
                        updateTerminal(data.listId);
                    }
                    window.showSuccessToast(data.message);
                } else {
                    const data = await response.json();
                    window.showErrorToast('Error updating list');
                }
            } catch (err) {
                window.showErrorToast('Error updating list');
            }
        });
    });
});


function updateListTitle(listId, title) {
    const titleElement = document.getElementById(`title-list-${listId}`);
    if (titleElement) {
        titleElement.innerHTML = title;
    }
}

function updateTerminal(listId) {
    document.querySelectorAll('.terminal-badge').forEach(function (e) { e.classList.add('hidden'); });
    document.querySelector(`#terminal-badge-${listId}`).classList.remove('hidden');
}
