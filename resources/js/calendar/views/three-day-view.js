import { CalendarUtils } from '../calendar-utils.js';

export const ThreeDayView = {
    getThreeDays(component) {
        const days = [];
        const today = new Date();
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for (let i = 0; i < 3; i++) {
            const date = new Date(component.currentDate);
            date.setDate(component.currentDate.getDate() + i);
            days.push({
                date,
                dayNumber: date.getDate(),
                dayName: dayNames[date.getDay()],
                monthName: months[date.getMonth()],
                dateKey: `three-day-${date.toISOString().split('T')[0]}`,
                isToday: CalendarUtils.isSameDay(date, today)
            });
        }

        return days;
    }
};
