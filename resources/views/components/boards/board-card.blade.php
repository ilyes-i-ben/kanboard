@props(['board', 'type' => 'owned'])

@php
    $bgColors = [
        'owned' => 'style="background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%), linear-gradient(135deg, ' . $board->background_color . ' 0%, ' . $board->background_color . 'E6 50%, ' . $board->background_color . 'CC 100%); backdrop-filter: blur(10px);"',
        'collaborative' => 'style="background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.10) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.08) 0%, transparent 50%), linear-gradient(135deg, #34d399 0%, #10b981 100%); backdrop-filter: blur(10px);"'
    ];

    $iconColors = [
        'owned' => 'bg-white/20',
        'collaborative' => 'bg-green-400/30'
    ];

    $statusColors = [
        'owned' => 'bg-green-400',
        'collaborative' => 'bg-green-400'
    ];

    $statusText = [
        'owned' => 'Active',
        'collaborative' => 'Member'
    ];

    $icons = [
        'owned' => 'heroicon-o-rectangle-group',
        'collaborative' => 'heroicon-o-user-group'
    ];

    $animationColors = [
        'owned' => 'bg-white/10',
        'collaborative' => 'bg-green-400/20'
    ];
@endphp

<div
    class="group board-card relative overflow-hidden rounded-2xl shadow-2xl border border-gray-300/50 dark:border-white/20 hover:shadow-3xl transition-all duration-500 cursor-pointer"
    {!! $bgColors['owned'] !!}
    onclick="window.location.href = '{{ route('boards.show', $board->id) }}'"
>
    <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity duration-300">
        <div class="absolute top-4 right-4 w-16 h-16 rounded-full {{ $animationColors[$type] }} blur-xl animate-pulse"></div>
        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full {{ $animationColors[$type] }} blur-lg animate-pulse delay-1000"></div>
    </div>

    <div class="relative mb-4 p-6 h-48 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl {{ $iconColors[$type] }} backdrop-blur-sm flex items-center justify-center shadow-lg">
                    @if($type === 'owned')
                        <x-heroicon-o-rectangle-group class="w-6 h-6 text-white" />
                    @else
                        <x-heroicon-o-user-group class="w-6 h-6 text-white" />
                    @endif
                </div>
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 rounded-full {{ $statusColors[$type] }} animate-pulse"></div>
                    <span class="text-xs text-white/80">{{ $statusText[$type] }}</span>
                </div>
            </div>
            <h3 id="board-title-{{ $board->id }}" class="text-xl font-bold text-white drop-shadow-lg mb-2 line-clamp-2 group-hover:text-white/90 transition-colors">
                {{ $board->title }}
            </h3>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between text-white/80 text-sm">
                <div class="flex items-center space-x-2">
                    <x-heroicon-o-rectangle-group class="w-4 h-4" />
                    <span>{{ $board->lists->count() ?? 0 }} lists</span>
                </div>
                <div class="flex items-center space-x-2">
                    <x-heroicon-o-users class="w-4 h-4" />
                    <span>{{ $board->members->count() ?? 0 }} members</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs text-white/70">{{ $board->created_at->diffForHumans() }}</span>
                @if($type === 'owned')
                    <div class="flex -space-x-2">
                        @foreach($board->members->take(3) as $member)
                            <div class="ring-2 ring-white/30 rounded-full transition-transform group-hover:scale-110">
                                <x-user.avatar :user="$member" class="w-6 h-6" />
                            </div>
                        @endforeach
                        @if($board->members->count() > 3)
                            <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-xs font-bold text-white ring-2 ring-white/30">
                                +{{ $board->members->count() - 3 }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex items-center space-x-1">
                        <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                        <span class="text-xs text-white/70">Shared</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Hover overlay -->
    <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
</div>
