@props(['card', 'showCardDetails', 'onClose'])

<div
    x-show="showCardDetails"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center"
    @click.away="showCardDetails = false; if (typeof onClose === 'function') onClose()"
    @keydown.escape.window="showCardDetails = false; if (typeof onClose === 'function') onClose()"
>
    <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-2xl mx-4 overflow-hidden" @click.stop>
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $card->title }}</h2>
            <button @click="showCardDetails = false; if (typeof onClose === 'function') onClose()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <!-- Card content here -->
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                <span class="font-medium">In list:</span> {{ $card->list->title }}
            </div>

            @if($card->description)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Description</h3>
                    <div class="text-gray-700 dark:text-gray-300 text-sm">
                        {!! $card->description !!}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Members</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($card->members as $member)
                            <div class="flex items-center space-x-2">
                                <x-user.avatar :user="$member"/>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $member->name }}</span>
                            </div>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No members assigned</span>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Details</h3>
                    <dl class="text-sm">
                        <div class="flex justify-between py-1">
                            <dt class="text-gray-500 dark:text-gray-400">Priority</dt>
                            <dd class="font-medium {{
                                $card->priority === 'high' ? 'text-red-600 dark:text-red-400' :
                                ($card->priority === 'medium' ? 'text-yellow-600 dark:text-yellow-400' : 'text-blue-600 dark:text-blue-400')
                            }}">{{ ucfirst($card->priority) }}</dd>
                        </div>

                        @if($card->deadline)
                            <div class="flex justify-between py-1">
                                <dt class="text-gray-500 dark:text-gray-400">Deadline</dt>
                                <dd class="font-medium {{ Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ Carbon\Carbon::parse($card->deadline)->format('M d, Y') }}
                                </dd>
                            </div>
                        @endif

                        @if($card->finished_at)
                            <div class="flex justify-between py-1">
                                <dt class="text-gray-500 dark:text-gray-400">Completed</dt>
                                <dd class="font-medium text-green-600 dark:text-green-400">
                                    {{ Carbon\Carbon::parse($card->finished_at)->format('M d, Y') }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

