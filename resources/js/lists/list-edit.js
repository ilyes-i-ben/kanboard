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
            <div class="empty-list text-center text-gray-800 dark:text-gray-400 py-8 text-sm flex items-center">
                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"w-10 h-10 mb-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728\" /></svg>
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
