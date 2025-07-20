<x-app-layout>
    <div class="min-h-screen relative overflow-hidden">
        <!-- Dynamic animated background -->
        <x-boards.animated-background />

        <!-- Header -->
        <x-boards.page-header />

        <!-- Main Content -->
        <div class="relative z-10 pb-20">
            <!-- Alpine.js data -->
            <div
                x-data="boardsIndex()"
                x-init="() => {
                @if($errors->any())
                    $nextTick(() => {
                        showCreateModal = true;
                    });
                @endif
                }"
            >
                <!-- Invitations Section -->
                @if(isset($invitations) && $invitations->count())
                    <x-boards.section
                        title="{{ __('Board Invitations') }}"
                        :count="$invitations->count()"
                        icon="heroicon-o-envelope"
                        icon-color="text-blue-400"
                    >
                        @foreach($invitations as $invitation)
                            <x-boards.invitation-card :invitation="$invitation" />
                            <x-boards.invitation-modal :invitation="$invitation" />
                        @endforeach
                    </x-boards.section>
                @endif

                <!-- Owned Boards Section -->
                @if($createdBoards?->count())
                    <x-boards.section
                        title="{{ __('Owned Boards') }}"
                        :count="$createdBoards->count()"
                        icon="heroicon-o-star"
                        icon-color="text-yellow-400"
                        :show-create-button="true"
                    >
                        @foreach ($createdBoards as $board)
                            <x-boards.board-card :board="$board" type="owned" />
                        @endforeach

                        <!-- Create New Board Card -->
                        <x-boards.create-board-card />
                    </x-boards.section>
                @else
                    <!-- Empty State for Owned Boards -->
                    <x-boards.empty-state
                        title="{{ __('Create Your First Board') }}"
                        description="{{ __('Start organizing your projects with beautiful, powerful boards. Create your first board to get started.') }}"
                    />
                @endif



                <!-- Member Boards Section -->
                @if($boards?->count())
                    <x-boards.section
                        title="{{ __('Collaborative Boards') }}"
                        :count="$boards->count()"
                        icon="heroicon-o-user-group"
                        icon-color="text-green-400"
                    >
                        @foreach ($boards as $board)
                            <x-boards.board-card :board="$board" type="collaborative" />
                        @endforeach
                    </x-boards.section>
                @endif

                <!-- Create Board Modal -->
                <x-boards.create-board-modal />
            </div>
        </div>
    </div>

    <!-- Styles and Scripts -->
    <x-boards.styles />
    <x-boards.scripts />
</x-app-layout>
