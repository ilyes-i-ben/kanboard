@props(['board'])

<div
    x-data="calendarComponent({{ $board->id }})"
    x-init="initCalendar()"
    class="calendar-container h-full bg-white/5 backdrop-blur-lg rounded-2xl p-6 shadow-2xl border border-white/20"
>
    <!-- calendar header -->
    <x-calendar.header />

    <!-- calendar grid -->
    <div class="calendar-grid flex-1 overflow-hidden">
        <!-- day view -->
        <template x-if="currentView === 'day'">
            <x-calendar.day-view :board="$board" />
        </template>

        <!-- 3-day view -->
        <template x-if="currentView === 'three-day'">
            <x-calendar.three-day-view :board="$board" />
        </template>

        <!-- week view -->
        <template x-if="currentView === 'week'">
            <x-calendar.week-view :board="$board" />
        </template>

        <!-- month view -->
        <template x-if="currentView === 'month'">
            <x-calendar.month-view :board="$board" />
        </template>
    </div>
</div>
