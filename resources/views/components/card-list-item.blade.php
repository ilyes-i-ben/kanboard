@props(['card'])

<div
    class="card-list-item bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 mb-3 cursor-pointer hover:shadow-xl transition border-l-8 flex flex-col gap-2"
    data-card-id="{{ $card->id }}"
    :class="{
        'border-red-500': '{{ $card->priority }}' === 'high',
        'border-yellow-500': '{{ $card->priority }}' === 'medium',
        'border-blue-500': '{{ $card->priority }}' === 'low'
    }"
    data-title="{{ strtolower($card->title) }}"
    data-description="{{ strtolower(strip_tags($card->description ?? '')) }}"
    data-created-at="{{ $card->created_at ? Carbon\Carbon::parse($card->created_at)->toDateString() : '' }}"
    data-deadline="{{ $card->deadline ? Carbon\Carbon::parse($card->deadline)->toDateString() : '' }}"
    data-finished="{{ $card->finished_at ? '1' : '0' }}"
    data-late="{{ $card->deadline && Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? '1' : '0' }}"
    data-priority="{{ $card->priority }}"
    data-list-title="{{ strtolower($card->list->title) }}"
    data-category="{{ $card->category ? strtolower($card->category->name) : 'uncategorized' }}"
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
        @if($card->category)
            <span class="ml-2 font-semibold rounded px-2 py-1 text-xs bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300 flex items-center gap-1">
                <x-heroicon-o-tag class="w-4 h-4 text-purple-400" />
                {{ $card->category->name }}
            </span>
        @else
            <span class="ml-2 font-semibold rounded px-2 py-1 text-xs bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 flex items-center gap-1">
                <x-heroicon-o-tag class="w-4 h-4 text-gray-400" />
                No category
            </span>
        @endif
    </div>
    <div class="flex justify-between items-center text-xs text-gray-400 dark:text-gray-500 mt-2">
        <span>List: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $card->list->title }}</span></span>
        <span>Priority: <span class="font-medium {{
            $card->priority === 'high' ? 'text-red-600 dark:text-red-400' :
            ($card->priority === 'medium' ? 'text-yellow-600 dark:text-yellow-400' : 'text-blue-600 dark:text-blue-400')
        }}">{{ ucfirst($card->priority) }}</span></span>
    </div>
</div>
