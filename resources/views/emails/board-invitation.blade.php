@extends('layouts.email')

@section('content')
    <h1>🎉 You're Invited to Join a Board!</h1>

    <p>{{ $inviterName }} invited you to collaborate on <strong>{{ $board->title }}</strong>!</p>

    <div class="card">
        <ul>
            <li><strong>Board:</strong> {{ $board->title }}</li>
            @if($board->description)
            <li><strong>Description:</strong>{!! $board->description !!}</li>
            @endif
            <li><strong>Expires:</strong> {{ $invitation->expires_at->format('M j, Y') }}</li>
        </ul>
    </div>

    @if($isAnonymous)
        <h2>🚀 Quick Setup</h2>
        <p>Create your account, then find this invitation in your notifications!</p>

        <a href="{{ route('register') }}" class="btn">
            Create Account
        </a>

        <p style="font-size: 14px; color: #64748b; margin-top: 16px;">
            Already have an account? <a href="{{ route('login') }}" style="color: #60a5fa;">Sign in</a>
        </p>
    @else
        <h2>🎯 Ready to Go!</h2>
        <p>Your invitation is waiting in your notifications. Just log in to accept!</p>

        <a href="{{ route('login') }}" class="btn">
            Sign In
        </a>
    @endif

    <p style="font-size: 12px; color: #64748b; margin-top: 24px;">
        Use email <strong>{{ $invitation->email }}</strong> to receive your invitation.
        Didn't expect this? You can safely ignore this email.
    </p>
@endsection
