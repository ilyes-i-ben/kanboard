@extends('layouts.email')

@section('content')
    <h1>🎉 You're Invited to Join a Board!</h1>

    <p>
        You've been invited to collaborate on <strong>{{ $board->title }}</strong> -
        an exciting project on Kanboard where great ideas come to life.
    </p>

    <div class="card">
        <h3>📋 Board Details</h3>
        <ul>
            <li><strong>Board Name:</strong> {{ $board->title }}</li>
            <li><strong>Description:</strong> {{ $board->description ?? 'No description provided' }}</li>
            <li><strong>Invited by:</strong> {{ $inviterName }}</li>
            <li><strong>Invitation expires:</strong> {{ $invitation->expires_at->format('F j, Y \a\t g:i A') }}</li>
        </ul>
    </div>

    @if($isAnonymous)
        <h2>🚀 Get Started in 2 Easy Steps!</h2>
        <p>
            Since you don't have a Kanboard account yet, here's how to join the board:
        </p>

        <div class="card">
            <h3>📝 How to Accept Your Invitation</h3>
            <ul>
                <li><strong>Step 1:</strong> Create your free Kanboard account using this email address</li>
                <li><strong>Step 2:</strong> Once logged in, you'll find this invitation waiting in your notifications</li>
            </ul>
        </div>

        <a href="{{ route('register') }}" class="btn">
            Create Your Account
        </a>

        <p style="font-size: 14px; color: #64748b; margin-top: 16px;">
            Already have an account?
            <a href="{{ route('login') }}" style="color: #60a5fa;">Sign in</a>
            to see your pending invitations.
        </p>
    @else
        <h2>🎯 Your Invitation is Ready!</h2>
        <p>
            Great news! Since you already have a Kanboard account, your invitation
            is waiting for you in your notifications. Simply log in to accept it
            and start collaborating on {{ $board->title }}.
        </p>

        <a href="{{ route('login') }}" class="btn">
            Sign In & View Invitation
        </a>

        <p style="font-size: 14px; color: #64748b; margin-top: 16px;">
            Look for the notification bell icon in your dashboard to find this invitation.
        </p>
    @endif

    <div class="card">
        <h3>✨ What You Can Do</h3>
        <ul>
            <li>Create and organize cards in lists</li>
            <li>Collaborate with team members in real-time</li>
            <li>Track progress and manage deadlines</li>
            <li>Add comments and attachments to cards</li>
            <li>Get notifications on important updates</li>
        </ul>
    </div>

    <hr>

    <h3>🤔 Need Help?</h3>
    <p>
        If you have any questions about this invitation or need help getting started,
        feel free to reach out to us. We're here to help make your project management
        experience amazing!
    </p>

    <p style="font-size: 14px; color: #64748b; margin-top: 24px;">
        <strong>Important:</strong> Make sure to create your account with this email address
        (<strong>{{ $invitation->email }}</strong>) to receive your invitation.
        The invitation will expire on {{ $invitation->expires_at->format('F j, Y') }}.
    </p>

    <p style="font-size: 12px; color: #64748b; margin-top: 16px;">
        If you didn't expect this invitation, you can safely ignore this email.
        The invitation will expire automatically.
    </p>
@endsection
