import { CalendarUtils } from '../calendar-utils.js';
import { CalendarNavigation } from '../calendar-navigation.js';

export const WeekView = {
    getWeekDays(component) {
        const weekStart = CalendarNavigation.getWeekStart(component.currentDate);
        const days = [];
        const today = new Date();
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        for (let i = 0; i < 7; i++) {
            const date = new Date(weekStart);
            date.setDate(weekStart.getDate() + i);
            days.push({
                date,
                dayNumber: date.getDate(),
                dayName: dayNames[date.getDay()],
                dateKey: `week-${date.toISOString().split('T')[0]}`,
                isToday: CalendarUtils.isSameDay(date, today)
            });
        }

        return days;
    }
};
