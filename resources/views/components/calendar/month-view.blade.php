@props(['board'])

<div class="month-view h-full">
    <div class="grid grid-cols-7 gap-px mb-2">
        <div class="text-center py-2 text-white/80 font-medium text-sm">Sun</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Mon</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Tue</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Wed</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Thu</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Fri</div>
        <div class="text-center py-2 text-white/80 font-medium text-sm">Sat</div>
    </div>

    <div class="grid grid-cols-7 gap-px h-full bg-white/10 rounded-lg overflow-hidden">
        <template x-if="!monthDays || monthDays.length === 0">
            <div class="col-span-7 flex items-center justify-center h-96">
                <div class="text-white/60 text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto mb-2"></div>
                    <div class="text-sm">Loading calendar...</div>
                </div>
            </div>
        </template>

        <template x-if="monthDays && monthDays.length > 0">
            <template x-for="day in monthDays" :key="day.dateKey">
                <div
                    class="calendar-day bg-white/5 backdrop-blur-sm border border-white/10 p-2 min-h-[120px] flex flex-col"
                    :class="{
                        'bg-white/10': day.isToday,
                        'text-white/50': day.isOtherMonth,
                        'text-white': !day.isOtherMonth
                    }"
                >
                    <div class="flex justify-between items-center mb-2">
                        <span
                            class="text-sm font-medium"
                            :class="{
                                'bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center': day.isToday
                            }"
                            x-text="day.dayNumber"
                        ></span>
                    </div>

                    <div class="flex-1 space-y-1 overflow-y-auto">
                        <template x-for="card in (day.cards || [])" :key="`${day.dateKey}-card-${card.id}`">
                            <x-calendar.card x-bind:card="card" />
                        </template>
                    </div>
                </div>
            </template>
        </template>
    </div>
</div>
