import { CalendarUtils } from '../calendar-utils.js';

export const MonthView = {
    getMonthDays(component) {
        const year = component.currentDate.getFullYear();
        const month = component.currentDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();

        const days = [];
        const today = new Date();

        const prevMonth = new Date(year, month - 1, 0);
        for (let i = startingDayOfWeek - 1; i >= 0; i--) {
            const date = new Date(year, month - 1, prevMonth.getDate() - i);
            days.push({
                date,
                dayNumber: date.getDate(),
                dateKey: `month-prev-${year}-${month - 1}-${date.getDate()}-${date.getTime()}`,
                isToday: CalendarUtils.isSameDay(date, today),
                isOtherMonth: true,
                cards: CalendarUtils.getCardsForDate(component.cards, date)
            });
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            days.push({
                date,
                dayNumber: day,
                dateKey: `month-curr-${year}-${month}-${day}-${date.getTime()}`,
                isToday: CalendarUtils.isSameDay(date, today),
                isOtherMonth: false,
                cards: CalendarUtils.getCardsForDate(component.cards, date)
            });
        }

        const remainingDays = 42 - days.length;
        for (let day = 1; day <= remainingDays; day++) {
            const date = new Date(year, month + 1, day);
            days.push({
                date,
                dayNumber: day,
                dateKey: `month-next-${year}-${month + 1}-${day}-${date.getTime()}`,
                isToday: CalendarUtils.isSameDay(date, today),
                isOtherMonth: true,
                cards: CalendarUtils.getCardsForDate(component.cards, date)
            });
        }

        return days;
    }
};
