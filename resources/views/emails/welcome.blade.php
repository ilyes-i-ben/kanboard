@extends('layouts.email')

@section('content')
    <h1>Welcome to Kanboard! 🎉</h1>

    <p>Hey {{ $name }},</p>

    <p>Your Kanboard workspace is ready. Let's get you started!</p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ url('/boards') }}" class="btn">Start Organizing</a>
    </div>

    <div class="card">
        <h3>Quick Start:</h3>
        <ul>
            <li>Create your first board</li>
            <li>Add lists and cards</li>
            <li>Invite your team</li>
        </ul>
    </div>

    <p style="margin-top: 32px;">Happy organizing!<br><strong>The Kanboard Team</strong></p>
@endsection
