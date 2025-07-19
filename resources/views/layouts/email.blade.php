<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .email-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            padding: 40px 40px;
            text-align: center;
            border-bottom: 1px solid #475569;
        }

        .brand-name {
            color: #f1f5f9;
            font-size: 28px;
            font-weight: 800;
            margin: 0 auto;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .brand-tagline {
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            margin-top: 8px;
            text-align: center;
        }

        .email-content {
            padding: 50px 40px;
            background: #1e293b;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .email-footer {
            background: #0f172a;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #334155;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 24px 0;
            box-shadow: 0 4px 16px 0 rgba(59, 130, 246, 0.3);
            transition: all 0.2s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(59, 130, 246, 0.4);
        }

        .card {
            background: #334155;
            border: 1px solid #475569;
            border-radius: 8px;
            padding: 20px;
            margin: 24px auto;
            max-width: 400px;
            text-align: left;
        }

        .card h3 {
            color: #f1f5f9;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            text-align: center;
        }

        .card ul {
            list-style: none;
            padding: 0;
        }

        .card li {
            padding: 8px 0;
            padding-left: 24px;
            position: relative;
            color: #cbd5e1;
            font-size: 15px;
        }

        .card li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #3b82f6;
            font-weight: bold;
            font-size: 18px;
        }

        .card p {
            text-align: center;
            margin: 0;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: #166534;
            color: #bbf7d0;
        }

        h1 {
            color: #f1f5f9;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 24px;
            line-height: 1.2;
            text-align: center;
        }

        h2 {
            color: #e2e8f0;
            font-size: 20px;
            font-weight: 600;
            margin: 24px 0 12px;
        }

        h3 {
            color: #cbd5e1;
            font-size: 16px;
            font-weight: 600;
            margin: 16px 0 8px;
        }

        p {
            color: #94a3b8;
            font-size: 15px;
            margin: 16px 0;
            line-height: 1.5;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        a {
            color: #60a5fa;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer-text {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            margin: 8px 0;
            text-align: center;
        }

        hr {
            margin: 32px auto;
            border: none;
            height: 1px;
            background: #475569;
            max-width: 300px;
        }

        @media (max-width: 768px) {
            .email-header {
                padding: 30px 20px;
            }

            .email-content {
                padding: 30px 20px;
            }

            .email-footer {
                padding: 24px 20px;
            }

            .brand-name {
                font-size: 24px;
            }

            h1 {
                font-size: 22px;
            }

            .card {
                margin: 20px auto;
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-header">
        <h1 class="brand-name">Kanboard</h1>
        <p class="brand-tagline">Organize your projects beautifully</p>
    </div>

    <div class="email-content">
        @yield('content')
    </div>

    <div class="email-footer">
        <p class="footer-text">
            © {{ date('Y') }} Kanboard. All rights reserved.
        </p>
        <p class="footer-text">
            Questions? <a href="mailto:support@kanboard.com">Contact us</a>
        </p>
    </div>
</body>
</html>
