<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EUVerify</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: var(--surface-low);">

    <div class="card" style="width: 100%; max-width: 440px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 2rem; font-weight: 700; color: var(--primary); letter-spacing: -0.03em;">EUVerify</div>
            <div class="text-muted mt-4">The Digital Notary platform.</div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="label-sm">Email Address</label>
                <input type="email" name="email" class="input-field" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="label-sm">Password</label>
                <input type="password" name="password" class="input-field" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; font-size: 16px;">
                Secure Sign In
            </button>
        </form>
    </div>

</body>
</html>
