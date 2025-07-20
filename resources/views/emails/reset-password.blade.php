@extends('layouts.email')

@section('content')
    <h1>Reset Your Password 🔐</h1>

    <p>Hi {{ $name }},</p>

    <p>We received a request to reset your password for your Kanboard account. Click the button below to create a new password.</p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ $url }}" class="btn">Reset Password</a>
    </div>

    <div class="card">
        <h3>⏰ Time Sensitive</h3>
        <p style="margin: 0;">This link expires in 5 minutes for your security.</p>
    </div>

    <div class="card" style="background: #7c2d12; border-color: #dc2626;">
        <h3 style="color: #fecaca;">🔒 Security Notice</h3>
        <ul>
            <li style="color: #fed7d7;">If you didn't request this, you can safely ignore this email</li>
            <li style="color: #fed7d7;">Your password won't change until you click the link above</li>
            <li style="color: #fed7d7;">Never share this link with anyone</li>
        </ul>
    </div>

    <hr>

    <p style="font-size: 13px; text-align: center;">
        Button not working? Copy this link: <a href="{{ $url }}">{{ $url }}</a>
    </p>

    <p style="margin-top: 24px;">Stay secure!<br><strong>The Kanboard Team</strong></p>
@endsection
