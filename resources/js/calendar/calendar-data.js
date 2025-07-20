export const CalendarData = {
    async loadCards(component) {
        component.isLoading = true;
        try {
            const response = await fetch(window.boardCalendarData.apiEndpoint, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                window.showErrorToast(`error htttp status: ${response.status}`)
                return;
            }

            const data = await response.json();
            if (data.success && Array.isArray(data.cards)) {
                component.cards = this.processCards(data.cards);
            } else {
                window.showErrorToast('Calendar data invalid')
                component.cards = [];
            }
        } catch (error) {
            window.showErrorToast('Failed to load calendar data');
            component.cards = [];
        } finally {
            component.isLoading = false;
        }
    },

    processCards(rawCards) {
        return rawCards.map(card => ({
            ...card,
            deadline_date: card.deadline ? new Date(card.deadline) : null,
            list_title: card.list?.title || 'No List'
        })).filter(card => card.deadline_date);
    }
};
