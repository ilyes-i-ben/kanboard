@props(['board'])

<div class="week-view h-full flex flex-col">
    <div class="flex border-b border-white/20 mb-4">
        <div class="w-16 flex-shrink-0"></div>

        <div class="flex-1 grid grid-cols-7 gap-px">
            <template x-for="day in weekDays" :key="day.dateKey">
                <div class="text-center py-3 border-r border-white/10 last:border-r-0">
                    <div class="text-white/80 text-xs font-medium" x-text="day.dayName"></div>
                    <div
                        class="text-white font-semibold mt-1"
                        :class="{
                            'bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center mx-auto': day.isToday
                        }"
                        x-text="day.dayNumber"
                    ></div>
                </div>
            </template>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto">
        <div class="flex">
            <div class="w-16 flex-shrink-0">
                <template x-for="hour in hours" :key="`week-hour-${hour}`">
                    <div class="h-16 flex items-start justify-end pr-2 border-b border-white/10">
                        <span class="text-xs text-white/60" x-text="hour + ':00'"></span>
                    </div>
                </template>
            </div>

            <div class="flex-1 grid grid-cols-7 gap-px">
                <template x-for="day in weekDays" :key="`week-day-${day.dateKey}`">
                    <div class="border-r border-white/10 last:border-r-0">
                        <template x-for="hour in hours" :key="`week-${day.dateKey}-hour-${hour}`">
                            <div class="h-16 border-b border-white/10 p-1 relative">
                                <!-- Cards for this hour -->
                                <template x-for="card in getCardsForDayAndHour(day.date, hour)" :key="`week-card-${card.id}-${day.dateKey}-${hour}`">
                                    <x-calendar.card x-bind:card="card" size="small" />
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
