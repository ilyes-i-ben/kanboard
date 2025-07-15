function addList(list, html) {
    if (!list || !html) return;
    const boardContainer = document.querySelector('.lists-container');
    const addListSection = document.getElementById('add-list-section');
    if (addListSection) {
        addListSection.insertAdjacentHTML('beforebegin', html);
    } else if (boardContainer) {
        boardContainer.insertAdjacentHTML('beforeend', html);
    }
}

function removeList(listId) {
    if (!listId) return;
    const listEl = document.querySelector(`[x-sort\\:item="${listId}"]`);
    if (listEl) listEl.remove();
}

export { addList, removeList };

