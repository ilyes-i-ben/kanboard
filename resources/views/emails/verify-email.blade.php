@extends('layouts.email')

@section('content')
    <h1>Verify Your Email 📧</h1>

    <p>Hi {{ $name }},</p>

    <p>Click the button below to verify your email and activate your account.</p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ $url }}" class="btn">Verify Email</a>
    </div>

    <div class="card">
        <h3>⚡ Quick & Secure</h3>
        <p style="margin: 0;">This link expires in 60 minutes for your security.</p>
    </div>

    <hr>

    <p style="font-size: 13px; text-align: center;">
        Button not working? Copy this link: <a href="{{ $url }}">{{ $url }}</a>
    </p>

    <p style="margin-top: 24px;">See you soon!<br><strong>The Kanboard Team</strong></p>
@endsection
