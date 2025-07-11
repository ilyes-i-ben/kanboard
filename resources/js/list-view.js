document.addEventListener('DOMContentLoaded', function () {
    const cardListContainer = document.getElementById('list-view-card-list');
    const noCardsMessage = document.getElementById('no-cards-message');
    const nameInput = document.getElementById('filter-card-name');
    const descInput = document.getElementById('filter-card-description');
    const prioritySelect = document.getElementById('filter-priority');

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
            const nameMatch = !name || cardTitle.includes(name);
            const descMatch = !desc || cardDesc.includes(desc);
            const priorityMatch = !priority || cardPriority === priority;
            if (nameMatch && descMatch && priorityMatch) {
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
    filterCards();
});
