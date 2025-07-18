import toast from "../toast.js";

window.addEventListener('card-completed', async (event) => {
    const cardId = event.detail.cardId;
    if (!cardId) return;

    let already = markCardAsCompleted(cardId);
    markModalAsCompleted(cardId);

    if (!already) {
        toast.addToast('success', 'Card marked as completed');
    }
});

function markCardAsCompleted(cardId) {
    const cardElement = document.getElementById(`kanboard-card-${cardId}`);
    if (!cardElement) return;

    const existingCompletedSpan = cardElement.querySelector('.completed-badge');
    if (existingCompletedSpan) return true;

    const completedSpan = document.createElement('span');
    completedSpan.className = 'completed-badge text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full';
    completedSpan.textContent = 'Completed';

    const markIncompleteButton = document.getElementById(`mark-as-incomplete-button-${cardId}`);
    markIncompleteButton?.classList.remove('hidden');

    const flexContainer = cardElement.querySelector(`#kanboard-card-data-${cardId}`);

    flexContainer.appendChild(completedSpan);
}

function markModalAsCompleted(cardId) {
    const modalDataElement = document.getElementById(`kanboard-card-modal-data-${cardId}`);
    if (!modalDataElement) return;

    const existingCompletedEntry = modalDataElement.querySelector('.completed-entry');
    if (existingCompletedEntry) return;

    const completedEntry = document.createElement('div');
    completedEntry.className = 'completed-entry flex justify-between items-center';

    const dtElement = document.createElement('dt');
    dtElement.className = 'text-gray-500 dark:text-gray-400';
    dtElement.textContent = 'Completed';

    const ddElement = document.createElement('dd');
    ddElement.className = 'font-semibold px-2 py-1 rounded text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';

    const now = new Date();
    const formattedDate = now.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
    ddElement.textContent = formattedDate;

    completedEntry.appendChild(dtElement);
    completedEntry.appendChild(ddElement);

    modalDataElement.appendChild(completedEntry);
}
