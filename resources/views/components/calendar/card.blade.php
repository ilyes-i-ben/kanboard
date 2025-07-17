@props(['card', 'size' => 'default'])

<div
    @click="openCardModal(card)"
    class="calendar-card bg-white/20 backdrop-blur-sm rounded cursor-pointer hover:bg-white/30 transition-colors"
    :class="{
        'border-l-2 border-red-400': card.priority === 'high',
        'border-l-2 border-yellow-400': card.priority === 'medium',
        'border-l-2 border-blue-400': card.priority === 'low'
    }"
    x-data="{
        getCardClasses() {
            const sizes = {
                small: 'px-1 py-0.5 mb-1 text-xs',
                medium: 'px-2 py-1 mb-1 text-sm',
                default: 'px-2 py-1 mb-1 text-xs',
                large: 'px-4 py-3 mb-2 text-sm shadow-lg hover:scale-105'
            };
            return sizes['{{ $size }}'] || sizes.default;
        }
    }"
    :class="getCardClasses()"
>
    <div class="text-white font-medium truncate" x-text="card.title"></div>

    @if($size === 'large')
        <div class="flex justify-between items-center mt-1">
            <div class="text-white/70 truncate" x-text="card.list_title"></div>
            <div x-show="card.finished_at" class="text-xs bg-green-400/30 text-green-200 px-2 py-1 rounded-full">✓ Done</div>
        </div>
        <div x-show="card.description" class="text-white/60 text-xs truncate mt-1" x-text="card.description"></div>

        <!-- Members for large cards -->
        <div x-show="card.members && card.members.length > 0" class="flex -space-x-1 mt-2">
            <template x-for="member in card.members.slice(0, 3)" :key="`member-${member.id}-${card.id}`">
                <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center text-xs text-white font-medium ring-2 ring-white/20">
                    <span x-text="member.name.charAt(0).toUpperCase()"></span>
                </div>
            </template>
            <div x-show="card.members.length > 3" class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs text-white font-medium ring-2 ring-white/20">
                <span x-text="'+' + (card.members.length - 3)"></span>
            </div>
        </div>
    @elseif($size === 'medium')
        <div class="flex items-center justify-between mt-1">
            <div class="text-white/70 text-xs truncate" x-text="card.list_title"></div>
            <div x-show="card.finished_at" class="text-xs bg-green-400/30 text-green-200 px-1 rounded">✓</div>
        </div>
    @else
        <div class="flex items-center justify-between mt-1">
            <div class="text-white/70 text-xs truncate" x-text="card.list_title"></div>
            <div x-show="card.finished_at" class="text-xs bg-green-400/30 text-green-200 px-1 rounded">✓</div>
        </div>
    @endif
</div>
