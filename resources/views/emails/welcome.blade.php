@extends('layouts.email')

@section('content')
    <h1>Welcome to Kanboard! 🎉</h1>

    <p>Hey {{ $name }},</p>

    <p>Your Kanboard workspace is ready! Time to turn your ideas into organized action.</p>

    @if($pendingInvitations?->count() > 0)
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; margin: 24px auto; max-width: 600px; width: 100%;">
            <h3 style="color: white; margin-bottom: 16px;">🎯 You have {{ $pendingInvitations->count() }} pending invitation{{ $pendingInvitations->count() > 1 ? 's' : '' }}!</h3>

            @foreach($pendingInvitations as $invitation)
                <div style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 16px; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <strong style="font-size: 16px;">{{ $invitation->board->title }}</strong>
                            <br>
                            <span style="opacity: 0.9; font-size: 14px;">from {{ $invitation->inviter->name }}</span>
                            @if($invitation->board->description)
                                <br>
                                <span style="opacity: 0.8; font-size: 13px; font-style: italic;">{{ Str::limit(strip_tags($invitation->board->description), 60) }}</span>
                            @endif
                        </div>
                        <div style="text-align: right; opacity: 0.8; font-size: 12px;">
                            Expires {{ $invitation->expires_at->format('M j') }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ url('/boards') }}" style="background: white; color: #667eea; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block;">
                    View Invitations
                </a>
            </div>
        </div>
    @endif

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ url('/boards') }}" class="btn">
            {{ $pendingInvitations->count() > 0 ? 'Explore Your Workspace' : 'Create Your First Board' }}
        </a>
    </div>

    <div class="card">
        <h3>✨ What's Next:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 16px;">
            @if($pendingInvitations->count() > 0)
                <div style="text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 8px;">🤝</div>
                    <strong>Join Teams</strong>
                    <div style="font-size: 14px; opacity: 0.7;">Accept invitations & collaborate</div>
                </div>
            @endif
            <div style="text-align: center;">
                <div style="font-size: 24px; margin-bottom: 8px;">📋</div>
                <strong>Create Boards</strong>
                <div style="font-size: 14px; opacity: 0.7;">Organize your projects</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 24px; margin-bottom: 8px;">🎯</div>
                <strong>Add Tasks</strong>
                <div style="font-size: 14px; opacity: 0.7;">Break down your work</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 24px; margin-bottom: 8px;">👥</div>
                <strong>Invite Others</strong>
                <div style="font-size: 14px; opacity: 0.7;">Share the productivity</div>
            </div>
        </div>
    </div>

    <p style="margin-top: 32px; text-align: center;">
        Ready to get organized?<br>
        <strong style="color: #667eea;">The Kanboard Team</strong> 🚀
    </p>
@endsection
