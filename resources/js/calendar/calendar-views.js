import { MonthView } from './views/month-view.js';
import { WeekView } from './views/week-view.js';
import { ThreeDayView } from './views/three-day-view.js';
import { DayView } from './views/day-view.js';

export const CalendarViews = {
    getMonthDays(component) {
        return MonthView.getMonthDays(component);
    },

    getWeekDays(component) {
        return WeekView.getWeekDays(component);
    },

    getThreeDays(component) {
        return ThreeDayView.getThreeDays(component);
    },

    getCurrentDay(component) {
        return DayView.getCurrentDay(component);
    }
};
