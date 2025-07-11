document.addEventListener('DOMContentLoaded', function () {
    const cardListContainer = document.getElementById('list-view-card-list');
    const noCardsMessage = document.getElementById('no-cards-message');
    const nameInput = document.getElementById('filter-card-name');
    const descInput = document.getElementById('filter-card-description');

    function filterCards() {
        const name = nameInput.value.trim().toLowerCase();
        const desc = descInput.value.trim().toLowerCase();

        let anyVisible = false;
        const cards = cardListContainer.querySelectorAll('.card-list-item');
        cards.forEach(card => {
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-description') || '';
            const nameMatch = !name || cardTitle.includes(name);
            const descMatch = !desc || cardDesc.includes(desc);
            if (nameMatch && descMatch) {
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
    filterCards();
});
