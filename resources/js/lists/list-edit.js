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

window.addEventListener('list-emptied', ({ detail: { listId } }) => {
    addEmptied(listId);
});

window.addEventListener('list-was-empty', ({ detail: { listId } }) => {
    removeEmpty(listId);
});

// helpers
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

function addEmptied(listId) {
    const container = document.getElementById(`list-cards-container-${listId}`);
    if (container) {
        container.innerHTML = `
            <div class="empty-list flex flex-col items-center justify-center text-gray-800 dark:text-gray-400 py-8 text-sm">
                <svg class="w-10 h-10 mb-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd"></path>
                </svg>
                <span>No cards in this list.</span>
            </div>
        `;
    }
}

function removeEmpty(listId) {
    const container = document.getElementById(`list-cards-container-${listId}`);
    if (container) {
        const emptyListElements = container.querySelectorAll('.empty-list');
        emptyListElements.forEach(el => el.remove());
    }
}

export { updateTerminal };
