@props(['card', 'showCardDetails' => false, 'onClose'])

<div
    id="kanboard-card-modal-{{ $card->id }}"
    x-data="{
        showEditCardModal: false
    }"
    x-show="showCardDetails"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center"
    @keydown.escape.window="showCardDetails = false; if (typeof onClose === 'function') onClose()"
>
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-200 dark:border-gray-700 animate-fadeIn"
        @click.stop
        @click.away="showCardDetails = false; if (typeof onClose === 'function') onClose()"
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <div class="flex items-center gap-3">
                <x-heroicon-o-clipboard-document-list class="w-7 h-7 text-blue-500 dark:text-blue-400" />
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $card->title }} ({{ $card->id }})</h2>
            </div>
            <div class="flex items-center gap-2">
            @can('delete', $card)
                <button
                    class="rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition"
                    title="Delete"
                    @click="window.dispatchEvent(new CustomEvent('delete-card', { detail: { cardId: {{ $card->id }} } }))"
                >
                    <x-heroicon-o-trash class="w-6 h-6" />
                </button>
            @endcan
            @if ($card->finished_at !== null)
                <button
                    class="rounded-full p-2 text-yellow-400 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 transition"
                    title="Mark as Incomplete"
                    @click="window.dispatchEvent(new CustomEvent('mark-as-incomplete', { detail: { cardId: {{ $card->id }} } }))"
                >
                    <x-heroicon-o-exclamation-circle class="w-6 h-6" />
                </button>
            @endif
            <button
                @click="showEditCardModal = true"
                class="rounded-full p-2 text-blue-400 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition"
                title="Edit"
            >
                <x-heroicon-o-pencil-square class="w-6 h-6" />
            </button>
            <button @click="showCardDetails = false; if (typeof onClose === 'function') onClose()" class="rounded-full p-2 text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>
            </div>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
                <x-heroicon-o-rectangle-group class="w-5 h-5 text-blue-400" />
                <span class="font-medium">In list:</span> <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $card->list->title }}</span>
            </div>
            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 shadow-sm mb-2">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 mr-2">Created by</span>
                <x-user.avatar :user="$card->user" />
                <span class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $card->user->name }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">on {{ $card->created_at->format('M d, Y H:i') }}</span>
            </div>

            @if($card->description)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 mb-2 border border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                        <x-heroicon-o-document-text class="w-5 h-5 text-blue-400" />
                        Description
                    </h3>
                    <div class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                        {!! $card->description !!}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                        <x-heroicon-o-users class="w-5 h-5 text-blue-400" />
                        Members
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @forelse($card->members as $member)
                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 shadow-sm">
                                <x-user.avatar :user="$member" />
                                <span class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $member->name }}</span>
                            </div>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No members assigned</span>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-400" />
                        Details
                    </h3>
                    <dl
                        id="kanboard-card-modal-data-{{ $card->id }}"
                        class="space-y-3"
                    >
                        <div class="flex justify-between items-center">
                            <dt class="text-gray-500 dark:text-gray-400">Priority</dt>
                            <dd class="font-semibold rounded px-2 py-1 text-xs
                                {{ $card->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' :
                                   ($card->priority === 'medium' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300') }}">
                                {{ ucfirst($card->priority) }}
                            </dd>
                        </div>

                        @if($card->deadline)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500 dark:text-gray-400">Deadline</dt>
                                <dd class="font-semibold px-2 py-1 rounded text-xs {{ Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ Carbon\Carbon::parse($card->deadline)->format('M d, Y') }}
                                </dd>
                            </div>
                        @endif

                        @if($card->finished_at)
                            <div class="completed-entry flex justify-between items-center">
                                <dt class="text-gray-500 dark:text-gray-400">Completed</dt>
                                <dd class="font-semibold px-2 py-1 rounded text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                                    {{ Carbon\Carbon::parse($card->finished_at)->format('M d, Y') }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
        <div
            x-show="showEditCardModal"
            x-cloak
            x-transition
            class="fixed inset-0 z-60 overflow-auto bg-black bg-opacity-50 flex items-center justify-center"
        >
            <div
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl mx-4 overflow-hidden border border-gray-200 dark:border-gray-700 animate-fadeIn"
            >
                <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <div class="flex items-center gap-3">
                        <x-heroicon-o-pencil-square class="w-7 h-7 text-blue-500 dark:text-blue-400"/>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Card</h2>
                    </div>
                    <button
                        type="button"
                        class="rounded-full p-2 text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition"
                        @click="showEditCardModal = false"
                    >
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>
                <form
                    id="edit-card-modal-{{ $card->id }}"
                    action="{{ route('cards.update.post', $card) }}"
                    method="POST"
                    class="edit-card-modal-class p-6 space-y-4"
                >
                    @csrf
                    <input type="hidden" name="board_id" value="{{ $card->list->board->id }}">
                    <section>
                        <label for="edit-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                        <input type="text" name="title" id="edit-title" value="{{ $card->title }}" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Card title">
                    </section>
                    <section>
                        <label for="edit-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea name="description" id="edit-description" rows="3" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Card description">{{ $card->description }}</textarea>
                    </section>
                    <section>
                        <label for="edit-deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                        <input type="date" name="deadline" id="edit-deadline" value="{{ \Carbon\Carbon::parse($card->deadline)->format('Y-m-d') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500" placeholder="Select date...">
                    </section>
                    <section>
                        <label for="edit-priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                        <select name="priority" id="edit-priority" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none pr-10">
                            <option value="low" @if($card->priority=='low') selected @endif>Low</option>
                            <option value="medium" @if($card->priority=='medium') selected @endif>Medium</option>
                            <option value="high" @if($card->priority=='high') selected @endif>High</option>
                        </select>
                    </section>
                    <section>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assignees</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($card->list->board?->members as $member)
                                <label class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 shadow-sm cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                                    <input
                                        type="checkbox"
                                        name="assignees[]"
                                        value="{{ $member->id }}"
                                        @if($card->members->contains($member->id)) checked @endif
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    />
                                    <x-user.avatar :user="$member" />
                                    <span class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $member->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </section>
                    <section class="flex justify-end gap-3">
                        <button type="button" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition" onclick="this.closest('.fixed').style.display='none'">Cancel</button>
                        <x-primary-button type="submit" class="flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="mr-2 h-5 w-5" />
                            {{ __('Update Card') }}
                        </x-primary-button>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
