export const CalendarNavigation = {
    navigatePrevious(component) {
        switch (component.currentView) {
            case 'day':
                component.currentDate.setDate(component.currentDate.getDate() - 1);
                break;
            case 'three-day':
                component.currentDate.setDate(component.currentDate.getDate() - 3);
                break;
            case 'week':
                component.currentDate.setDate(component.currentDate.getDate() - 7);
                break;
            case 'month':
                component.currentDate.setMonth(component.currentDate.getMonth() - 1);
                break;
        }
        component.currentDate = new Date(component.currentDate);
    },

    navigateNext(component) {
        switch (component.currentView) {
            case 'day':
                component.currentDate.setDate(component.currentDate.getDate() + 1);
                break;
            case 'three-day':
                component.currentDate.setDate(component.currentDate.getDate() + 3);
                break;
            case 'week':
                component.currentDate.setDate(component.currentDate.getDate() + 7);
                break;
            case 'month':
                component.currentDate.setMonth(component.currentDate.getMonth() + 1);
                break;
        }
        component.currentDate = new Date(component.currentDate);
    },

    goToToday(component) {
        component.currentDate = new Date();
    },

    getCurrentPeriodLabel(component) {
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        switch (component.currentView) {
            case 'day':
                return component.currentDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            case 'three-day':
                const endDate = new Date(component.currentDate);
                endDate.setDate(endDate.getDate() + 2);
                return `${component.currentDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
            case 'week':
                const weekStart = this.getWeekStart(component.currentDate);
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekEnd.getDate() + 6);
                return `${weekStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${weekEnd.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
            case 'month':
                return `${months[component.currentDate.getMonth()]} ${component.currentDate.getFullYear()}`;
            default:
                return '';
        }
    },

    getWeekStart(date) {
        const start = new Date(date);
        const day = start.getDay();
        const diff = start.getDate() - day;
        return new Date(start.setDate(diff));
    }
};
