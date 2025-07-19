@extends('layouts.email')

@section('content')
    <h1>Email Test ✅</h1>

    <p>Hello there!</p>

    <p>Your email system is working perfectly!</p>

    <div class="card">
        <h3>Status Check</h3>
        <ul>
            <li>SMTP Connection: Active</li>
            <li>Templates: Loaded</li>
            <li>Delivery: Success</li>
        </ul>
    </div>

    <div style="text-align: center; margin: 32px 0;">
        <span class="badge badge-success">All Systems Go</span>
    </div>

    <p style="margin-top: 24px;">Ready to rock!<br><strong>Dev Team</strong></p>
@endsection
