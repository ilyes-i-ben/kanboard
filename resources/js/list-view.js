document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const viewParam = urlParams.get('view');
    if (viewParam !== 'list') return;

    const cardListContainer = document.getElementById('list-view-card-list');
    const noCardsMessage = document.getElementById('no-cards-message');
    const nameInput = document.getElementById('filter-card-name');
    const descInput = document.getElementById('filter-card-description');
    const prioritySelect = document.getElementById('filter-priority');
    const listSelect = document.getElementById('filter-list-title');
    const categorySelect = document.getElementById('filter-category');

    const startDate = document.getElementById('filter-start-date');

    const deadlineStartDate = document.getElementById('datepicker-range-start');
    const deadlineEndDate = document.getElementById('datepicker-range-end');

    let completedFilter = 'all';

    function filterCards() {
        const name = nameInput.value.trim().toLowerCase();
        const desc = descInput.value.trim().toLowerCase();
        const priority = prioritySelect.value;
        const listTitle = listSelect.value;
        const category = categorySelect.value;

        const createdAtDate = startDate.value;
        const deadlineStart = deadlineStartDate.value;
        const deadlineEnd = deadlineEndDate.value;

        let anyVisible = false;
        const cards = cardListContainer.querySelectorAll('.card-list-item');
        cards.forEach(card => {
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-description') || '';
            const cardPriority = (card.getAttribute('data-priority') || '').toLowerCase();
            const cardListTitle = (card.getAttribute('data-list-title') || '').toLowerCase();
            const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
            const cardFinished = card.getAttribute('data-finished') === '1';

            const cardCreatedAtDate = (card.getAttribute('data-created-at') || '');
            const cardDeadline = (card.getAttribute('data-deadline') || '');
            const cardLate = card.getAttribute('data-late') === '1';

            const nameMatch = !name || cardTitle.includes(name);
            const descMatch = !desc || cardDesc.includes(desc);
            const priorityMatch = !priority || cardPriority === priority;
            const listMatch = !listTitle || cardListTitle === listTitle;
            const categoryMatch = !category || (category === 'uncategorized' ? cardCategory === '' || cardCategory === 'uncategorized' : cardCategory === category);

            let createdAtDateMatch = true;
            if (createdAtDate) {
                createdAtDateMatch = cardCreatedAtDate === createdAtDate;
            }
            let deadlineMatch = true;
            if (deadlineStart && deadlineEnd) {
                deadlineMatch = cardDeadline >= deadlineStart && cardDeadline <= deadlineEnd;
            } else if (deadlineStart) {
                deadlineMatch = cardDeadline >= deadlineStart;
            } else if (deadlineEnd) {
                deadlineMatch = cardDeadline <= deadlineEnd;
            }

            let completedMatch = checkCompletedMatch(completedFilter, cardFinished);
            if (completedFilter === 'late') {
                completedMatch = cardLate;
            }

            if (
                nameMatch &&
                descMatch &&
                priorityMatch &&
                listMatch &&
                categoryMatch &&
                completedMatch &&
                createdAtDateMatch &&
                deadlineMatch
            ) {
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
        updateTotalCardsCount();
    }

    function updateTotalCardsCount() {
        const cards = cardListContainer.querySelectorAll('.card-list-item');
        let visibleCount = 0;
        cards.forEach(card => {
            if (card.style.display !== 'none') visibleCount++;
        });
        document.getElementById('total-cards-count').textContent = visibleCount;
    }

    nameInput.addEventListener('input', filterCards);
    descInput.addEventListener('input', filterCards);
    prioritySelect.addEventListener('change', filterCards);
    listSelect.addEventListener('change', filterCards);
    categorySelect.addEventListener('change', filterCards);

    startDate.addEventListener('changeDate', filterCards);

    [
        startDate,
        deadlineStartDate,
        deadlineEndDate
    ].forEach(v => v.addEventListener('changeDate', filterCards));

    document.addEventListener('completed-filter', function(e) {
        completedFilter = e.detail.value;
        filterCards();
    });

    window.addEventListener('reset-filters', () => {
        nameInput.value = '';
        descInput.value = '';
        prioritySelect.value = '';
        listSelect.value = '';
        categorySelect.value = '';
        startDate.value = '';
        deadlineStartDate.value = '';
        deadlineEndDate.value = '';
        completedFilter = 'all';
        filterCards();
    });

    filterCards();
    updateTotalCardsCount();
});

// little helpers...:
function checkCompletedMatch(filter, finished) {
    if (filter === 'late') return 'late';
    if (filter === 'not') return !finished;
    if (filter === 'yes') return finished;
    return true;
}
