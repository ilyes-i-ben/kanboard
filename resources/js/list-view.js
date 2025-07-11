document.addEventListener('DOMContentLoaded', function () {
    const cardListContainer = document.getElementById('list-view-card-list');
    const noCardsMessage = document.getElementById('no-cards-message');
    const nameInput = document.getElementById('filter-card-name');
    const descInput = document.getElementById('filter-card-description');
    const prioritySelect = document.getElementById('filter-priority');
    let completedFilter = 'all';

    function filterCards() {
        const name = nameInput.value.trim().toLowerCase();
        const desc = descInput.value.trim().toLowerCase();
        const priority = prioritySelect.value;

        let anyVisible = false;
        const cards = cardListContainer.querySelectorAll('.card-list-item');
        cards.forEach(card => {
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-description') || '';
            const cardPriority = (card.getAttribute('data-priority') || '').toLowerCase();
            const cardFinished = card.getAttribute('data-finished') === '1';
            const nameMatch = !name || cardTitle.includes(name);
            const descMatch = !desc || cardDesc.includes(desc);
            const priorityMatch = !priority || cardPriority === priority;
            const completedMatch = checkCompletedMatch(completedFilter, cardFinished);
            if (nameMatch && descMatch && priorityMatch && completedMatch) {
                card.style.display = '';
                anyVisible = true;
            } else {
                card.style.display = 'none';
            }
        });
        if (!anyVisible) {
            noCardsMessage.classList.remove('hidden');
        } else {
            noCardsMessage.classList.add('hidden');
        }
    }

    nameInput.addEventListener('input', filterCards);
    descInput.addEventListener('input', filterCards);
    prioritySelect.addEventListener('change', filterCards);
    document.addEventListener('completed-filter', function(e) {
        completedFilter = e.detail.value;
        filterCards();
    });
    filterCards();
});

// little helpers...:
function checkCompletedMatch(filter, finished) {
    if (filter === 'not') return !finished;
    if (filter === 'yes') return finished;
    return true;
}
