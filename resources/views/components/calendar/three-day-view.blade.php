@props(['board'])

<div class="three-day-view h-full flex flex-col">
    <!-- Time Column Header + Days Header -->
    <div class="flex border-b border-white/20 mb-4">
        <!-- Empty space for time column -->
        <div class="w-16 flex-shrink-0"></div>

        <!-- Days Header -->
        <div class="flex-1 grid grid-cols-3 gap-px">
            <template x-for="day in threeDays" :key="day.dateKey">
                <div class="text-center py-3 border-r border-white/10 last:border-r-0">
                    <div class="text-white/80 text-sm font-medium" x-text="day.dayName"></div>
                    <div
                        class="text-white font-bold text-lg mt-1"
                        :class="{
                            'bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center mx-auto': day.isToday
                        }"
                        x-text="day.dayNumber"
                    ></div>
                    <div class="text-white/60 text-xs mt-1" x-text="day.monthName"></div>
                </div>
            </template>
        </div>
    </div>

    <!-- Time Grid -->
    <div class="flex-1 overflow-y-auto">
        <div class="flex">
            <!-- Time Column -->
            <div class="w-16 flex-shrink-0">
                <template x-for="hour in hours" :key="`three-day-hour-${hour}`">
                    <div class="h-20 flex items-start justify-end pr-2 border-b border-white/10">
                        <span class="text-sm text-white/60" x-text="hour + ':00'"></span>
                    </div>
                </template>
            </div>

            <!-- Days Grid -->
            <div class="flex-1 grid grid-cols-3 gap-px">
                <template x-for="day in threeDays" :key="`three-day-${day.dateKey}`">
                    <div class="border-r border-white/10 last:border-r-0">
                        <template x-for="hour in hours" :key="`three-day-${day.dateKey}-hour-${hour}`">
                            <div class="h-20 border-b border-white/10 p-2 relative">
                                <!-- Cards for this hour -->
                                <template x-for="card in getCardsForDayAndHour(day.date, hour)" :key="`three-day-card-${card.id}-${day.dateKey}-${hour}`">
                                    <x-calendar.card x-bind:card="card" size="medium" />
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
