@props(['card'])

<div
    class="card-list-item bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 mb-3 cursor-pointer hover:shadow-xl transition border-l-8 flex flex-col gap-2"
    :class="{
        'border-red-500': '{{ $card->priority }}' === 'high',
        'border-yellow-500': '{{ $card->priority }}' === 'medium',
        'border-blue-500': '{{ $card->priority }}' === 'low'
    }"
    @click="showCardDetails = true"
    x-data="{ showCardDetails: false }"
    data-title="{{ strtolower($card->title) }}"
    data-description="{{ strtolower(strip_tags($card->description ?? '')) }}"
    data-deadline="{{ $card->deadline }}"
    data-finished="{{ $card->finished_at ? '1' : '0' }}"
    data-priority="{{ $card->priority }}"
    data-list-title="{{ strtolower($card->list->title) }}"
>
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $card->title }}</h3>
            @if($card->description)
                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ Str::limit(strip_tags($card->description), 60) }}</p>
            @endif
        </div>
        <div class="flex flex-col items-end gap-2">
            @if($card->deadline)
                <span class="text-xs px-2 py-1 rounded-full font-semibold {{ Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                    {{ Carbon\Carbon::parse($card->deadline)->format('M d') }}
                </span>
            @endif
            @if($card->finished_at)
                <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full font-semibold">
                    Completed
                </span>
            @endif
        </div>
    </div>
    <div class="flex items-center mt-2 gap-2">
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
    </div>
    <div class="flex justify-between items-center text-xs text-gray-400 dark:text-gray-500 mt-2">
        <span>List: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $card->list->title }}</span></span>
        <span>Priority: <span class="font-medium {{
            $card->priority === 'high' ? 'text-red-600 dark:text-red-400' :
            ($card->priority === 'medium' ? 'text-yellow-600 dark:text-yellow-400' : 'text-blue-600 dark:text-blue-400')
        }}">{{ ucfirst($card->priority) }}</span></span>
    </div>
    <x-card.card-modal :card="$card" show-card-details="showCardDetails" />
</div>
