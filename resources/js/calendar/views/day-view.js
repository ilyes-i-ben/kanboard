export const DayView = {
    getCurrentDay(component) {
        const today = new Date();
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return {
            date: component.currentDate,
            dayNumber: component.currentDate.getDate(),
            dayName: dayNames[component.currentDate.getDay()],
            monthYear: `${months[component.currentDate.getMonth()]} ${component.currentDate.getFullYear()}`,
            isToday: component.isSameDay(component.currentDate, today)
        };
    }
};
