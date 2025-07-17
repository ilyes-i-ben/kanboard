@props(['board'])

<div
    x-data="calendarComponent()"
    x-init="initCalendar()"
    class="calendar-container h-full bg-white/5 backdrop-blur-lg rounded-2xl p-6 shadow-2xl border border-white/20"
>
    <!-- Calendar Header -->
    <x-calendar.header />

    <!-- Calendar Grid -->
    <div class="calendar-grid flex-1 overflow-hidden">
        <!-- Day View -->
        <template x-if="currentView === 'day'">
            <x-calendar.day-view :board="$board" />
        </template>

        <!-- 3-Day View -->
        <template x-if="currentView === 'three-day'">
            <x-calendar.three-day-view :board="$board" />
        </template>

        <!-- Week View -->
        <template x-if="currentView === 'week'">
            <x-calendar.week-view :board="$board" />
        </template>

        <!-- Month View -->
        <template x-if="currentView === 'month'">
            <x-calendar.month-view :board="$board" />
        </template>
    </div>
</div>
