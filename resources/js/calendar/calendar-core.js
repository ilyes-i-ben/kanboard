import { CalendarData } from './calendar-data.js';
import { CalendarNavigation } from './calendar-navigation.js';
import { CalendarViews } from './calendar-views.js';
import { CalendarUtils } from './calendar-utils.js';

window.calendarComponent = function() {
    return {
        currentView: 'month',
        currentDate: new Date(),
        cards: [],
        hours: Array.from({length: 24}, (_, i) => i),
        isLoading: false,

        async initCalendar() {
            await CalendarData.loadCards(this);

            const savedView = localStorage.getItem('calendar-view');
            if (savedView && ['day', 'three-day', 'week', 'month'].includes(savedView)) {
                this.currentView = savedView;
            }
        },

        setView(view) {
            this.currentView = view;
            localStorage.setItem('calendar-view', view);
        },

        navigatePrevious() {
            CalendarNavigation.navigatePrevious(this);
        },

        navigateNext() {
            CalendarNavigation.navigateNext(this);
        },

        goToToday() {
            CalendarNavigation.goToToday(this);
        },

        getCurrentPeriodLabel() {
            return CalendarNavigation.getCurrentPeriodLabel(this);
        },

        get monthDays() {
            return CalendarViews.getMonthDays(this);
        },

        get weekDays() {
            return CalendarViews.getWeekDays(this);
        },

        get threeDays() {
            return CalendarViews.getThreeDays(this);
        },

        get currentDay() {
            return CalendarViews.getCurrentDay(this);
        },

        getCardsForDate(date) {
            return CalendarUtils.getCardsForDate(this.cards, date);
        },

        getCardsForDayAndHour(date, hour) {
            return CalendarUtils.getCardsForDayAndHour(this.cards, date, hour);
        },

        getAllDayCards(date) {
            return CalendarUtils.getAllDayCards(this.cards, date);
        },

        isSameDay(date1, date2) {
            return CalendarUtils.isSameDay(date1, date2);
        },

        formatHour(hour) {
            return CalendarUtils.formatHour(hour);
        },

        openCardModal(card) {
            CalendarUtils.openCardModal(card);
        }
    };
};
