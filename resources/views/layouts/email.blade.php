<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        /* Base styles */
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: #1F2937;
            background-color: #F3F4F6;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            max-height: 60px;
            width: auto;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            color: #6B7280;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3B82F6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 10px 0;
        }
        .card {
            background-color: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-red {
            background-color: #FEE2E2;
            color: #B91C1C;
        }
        .badge-yellow {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .badge-blue {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        .badge-green {
            background-color: #D1FAE5;
            color: #065F46;
        }
        h1, h2, h3 {
            color: #111827;
            margin-top: 0;
        }
        p {
            margin: 16px 0;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <!-- Logo placeholder -->
        <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Kanboard" class="logo">
    </div>

    <div class="container">
        @yield('content')
    </div>

    <div class="footer">
        <p>
            © {{ date('Y') }} Kanboard. Tous droits réservés.
        </p>
        <p>
            Si vous avez des questions, contactez-nous à <a href="mailto:support@kanboard.com">support@kanboard.com</a>
        </p>
    </div>
</div>
</body>
</html>
