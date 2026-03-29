<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Identity Setup | EUVerify')</title>
    <link rel="stylesheet" href="/css/app.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body.setup-mode {
            background-color: #F8FAFC;
            font-family: 'Inter', -apple-system, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Top Navigation for Setup */
        .setup-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            background-color: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
        }

        .setup-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .setup-brand-logo {
            font-weight: 800;
            font-size: 20px;
            color: #0F172A;
            letter-spacing: -0.02em;
        }

        .setup-brand-badge {
            background: #E0E7FF;
            color: #3730A3;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .setup-actions {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .help-icon {
            color: #64748B;
            cursor: pointer;
            transition: color 0.2s;
        }

        .help-icon:hover {
            color: #0F172A;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #64748B;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s;
        }

        .logout-btn:hover {
            color: #0F172A;
        }

        /* Main Content wrapper */
        .setup-main {
            flex: 1;
            padding: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Footer */
        .setup-footer {
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #E2E8F0;
            background: #FFFFFF;
        }

        .footer-secure-badges {
            display: flex;
            gap: 24px;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .secure-badge svg {
            width: 14px;
            height: 14px;
            color: #10B981;
        }

        .footer-links {
            display: flex;
            gap: 24px;
            font-size: 13px;
            color: #475569;
            font-weight: 500;
        }

        .footer-note {
            font-size: 11px;
            color: #94A3B8;
            font-style: italic;
        }

    </style>
</head>
<body class="setup-mode">

    <header class="setup-nav">
        <div class="setup-brand">
            <span class="setup-brand-logo">EUVerify</span>
            <span class="setup-brand-badge">Manufacturer Portal</span>
        </div>
        <div class="setup-actions">
            <i data-lucide="help-circle" class="help-icon"></i>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>

    <main class="setup-main">
        @yield('content')
    </main>

    <footer class="setup-footer">
        <div class="footer-secure-badges">
            <div class="secure-badge">
                <i data-lucide="shield-check"></i>
                SECURE TLS 1.3
            </div>
            <div class="secure-badge">
                <i data-lucide="shield-check"></i>
                GDPR COMPLIANT
            </div>
        </div>
        <div class="footer-note">
            EUVerify Regulatory Data Node: #4401-BX
        </div>
    </footer>
    
    <div style="text-align: center; padding: 16px; font-size: 12px; color: #64748B;">
        <div class="footer-links" style="justify-content: center; margin-bottom: 8px;">
            <span>Privacy Policy</span>
            <span>Terms of Service</span>
            <span>Compliance Hub</span>
        </div>
        © {{ date('Y') }} EUVerify Systems. All rights reserved.
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
