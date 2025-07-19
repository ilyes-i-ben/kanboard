@props(['card'])
<div
    id="kanboard-card-{{ $card->id }}"
    x-sort:item="{{ $card->id }}"
    x-data="{ showCardDetails: false }"
    class="card bg-white dark:bg-gray-700 rounded-md shadow-md p-3 mb-2 cursor-pointer w-72"
    :class="{
        'border-l-4 border-red-500': '{{ $card->priority }}' === 'high',
        'border-l-4 border-yellow-500': '{{ $card->priority }}' === 'medium',
        'border-l-4 border-blue-500': '{{ $card->priority }}' === 'low'
    }"
    @click="showCardDetails = true"
>
    <div class="flex justify-between items-start">
        <h3 class="font-medium text-gray-900 dark:text-gray-100 break-words">{{ $card->title }}</h3>
        @if($card->deadline)
            <div class="text-xs px-2 py-1 rounded-full {{ Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                {{ Carbon\Carbon::parse($card->deadline)->format('M d') }}
            </div>
        @endif
    </div>

    @if($card->description)
        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
            {{ Str::limit(strip_tags($card->description), 100) }}
        </p>
    @endif

    @if($card->category)
        <div class="mt-2">
            <span class="font-semibold rounded px-2 py-1 text-xs bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                {{ $card->category->name }}
            </span>
        </div>
    @endif

    <div
        id="kanboard-card-data-{{ $card->id }}"
        class="flex justify-between items-center mt-3"
    >
        @if($card->members->count() > 0)
            <div class="flex -space-x-2 overflow-hidden p-1">
                @foreach($card->members->take(3) as $member)
                    <x-user.avatar :user="$member"/>
                @endforeach
                @if($card->members->count() > 3)
                    <span class="flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 text-xs font-medium text-gray-800 dark:text-gray-300">
                        +{{ $card->members->count() - 3 }}
                    </span>
                @endif
            </div>
        @endif

        @if($card->finished_at)
            <span
                class="completed-badge text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full"
            >
                Completed
            </span>
        @endif
    </div>

    <x-card.card-modal :card="$card" show-card-details="showCardDetails" />
</div>
