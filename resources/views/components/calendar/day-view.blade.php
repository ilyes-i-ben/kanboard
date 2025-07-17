@props(['board'])

<div class="day-view h-full flex flex-col">
    <!-- Day Header -->
    <div class="flex border-b border-white/20 mb-4">
        <!-- Empty space for time column -->
        <div class="w-20 flex-shrink-0"></div>

        <!-- Day Header -->
        <div class="flex-1 text-center py-4">
            <div class="text-white/80 text-sm font-medium" x-text="currentDay.dayName"></div>
            <div
                class="text-white font-bold text-2xl mt-2"
                :class="{
                    'bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto': currentDay.isToday
                }"
                x-text="currentDay.dayNumber"
            ></div>
            <div class="text-white/60 text-sm mt-1" x-text="currentDay.monthYear"></div>
        </div>
    </div>

    <!-- Time Grid -->
    <div class="flex-1 overflow-y-auto">
        <div class="flex">
            <!-- Time Column -->
            <div class="w-20 flex-shrink-0">
                <template x-for="hour in hours" :key="`day-hour-${hour}`">
                    <div class="h-24 flex items-start justify-end pr-3 border-b border-white/10">
                        <span class="text-sm text-white/60 font-medium" x-text="formatHour(hour)"></span>
                    </div>
                </template>
            </div>

            <!-- Day Content -->
            <div class="flex-1 border-l border-white/10">
                <template x-for="hour in hours" :key="`day-content-hour-${hour}`">
                    <div class="h-24 border-b border-white/10 p-3 relative">
                        <!-- Cards for this hour -->
                        <template x-for="card in getCardsForDayAndHour(currentDay.date, hour)" :key="`day-card-${card.id}-${hour}`">
                            <x-calendar.card x-bind:card="card" size="large" />
                        </template>

                        <!-- All-day cards for this day (if hour is 6 AM, show all-day cards) -->
                        <template x-if="hour === 6">
                            <template x-for="card in getAllDayCards(currentDay.date)" :key="`day-allday-${card.id}`">
                                <div
                                    @click="openCardModal(card)"
                                    class="calendar-card bg-gradient-to-r from-purple-500/30 to-pink-500/30 backdrop-blur-sm rounded-lg px-4 py-2 mb-2 cursor-pointer hover:from-purple-500/40 hover:to-pink-500/40 transition-all duration-300 border border-white/20"
                                >
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs bg-white/20 text-white px-2 py-1 rounded-full">All Day</span>
                                        <div class="text-white font-medium truncate flex-1" x-text="card.title"></div>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
