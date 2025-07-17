export const CalendarUtils = {
    getCardsForDate(cards, date) {
        return cards.filter(card =>
            card.deadline_date && this.isSameDay(card.deadline_date, date)
        );
    },

    getCardsForDayAndHour(cards, date, hour) {
        const dateCards = this.getCardsForDate(cards, date);
        return dateCards.filter(card => {
            if (!card.deadline_date) return false;
            const cardHour = card.deadline_date.getHours();
            return cardHour === hour;
        });
    },

    getAllDayCards(cards, date) {
        return this.getCardsForDate(cards, date).filter(card => {
            if (!card.deadline_date) return false;
            const cardHour = card.deadline_date.getHours();
            return cardHour === 0;
        });
    },

    isSameDay(date1, date2) {
        return date1.toDateString() === date2.toDateString();
    },

    formatHour(hour) {
        if (hour === 0) return '12:00 AM';
        if (hour < 12) return `${hour}:00 AM`;
        if (hour === 12) return '12:00 PM';
        return `${hour - 12}:00 PM`;
    },

    openCardModal(card) {
        window.dispatchEvent(new CustomEvent('open-card-modal', {
            detail: { cardId: card.id }
        }));
    }
};
