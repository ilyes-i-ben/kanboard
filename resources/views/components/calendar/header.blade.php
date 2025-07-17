<div class="calendar-header flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2 bg-white/15 backdrop-blur-lg rounded-xl p-2 shadow-lg border border-white/20">
            <button
                @click="navigatePrevious()"
                class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105"
                title="Previous"
            >
                <x-heroicon-o-chevron-left class="w-5 h-5 text-white" />
            </button>

            <div class="px-4 py-2 text-white font-semibold min-w-[200px] text-center">
                <span x-text="getCurrentPeriodLabel()"></span>
            </div>

            <button
                @click="navigateNext()"
                class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105"
                title="Next"
            >
                <x-heroicon-o-chevron-right class="w-5 h-5 text-white" />
            </button>
        </div>

        <button
            @click="goToToday()"
            class="px-4 py-2 bg-white/15 backdrop-blur-lg rounded-xl hover:bg-white/25 transition-all duration-300 shadow-lg border border-white/20 text-white font-medium"
        >
            Today
        </button>
    </div>

    <div class="flex items-center space-x-1 bg-white/15 backdrop-blur-lg rounded-xl p-1.5 shadow-lg border border-white/20">
        <button
            @click="setView('day')"
            :class="currentView === 'day' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
            class="px-3 py-2 rounded-lg transition-all duration-300 text-white text-sm font-medium"
        >
            Day
        </button>
        <button
            @click="setView('three-day')"
            :class="currentView === 'three-day' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
            class="px-3 py-2 rounded-lg transition-all duration-300 text-white text-sm font-medium"
        >
            3 Days
        </button>
        <button
            @click="setView('week')"
            :class="currentView === 'week' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
            class="px-3 py-2 rounded-lg transition-all duration-300 text-white text-sm font-medium"
        >
            Week
        </button>
        <button
            @click="setView('month')"
            :class="currentView === 'month' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
            class="px-3 py-2 rounded-lg transition-all duration-300 text-white text-sm font-medium"
        >
            Month
        </button>
    </div>
</div>

