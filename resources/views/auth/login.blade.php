<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — {{ $siteSettings->brandName() ?? 'CNCI' }}</title>
  <link rel="icon" href="{{ isset($siteSettings) ? $siteSettings->faviconUrl() : asset('assets/img/favicon/favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --red: #c41e2a;
      --blue: #024886;
      --ink: #1e1e2a;
      --muted: #6b7280;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', system-ui, sans-serif;
      min-height: 100vh;
      background: #f0f2f5;
      overflow-x: hidden;
    }

    .auth-page {
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 24px 16px;
      background:
        radial-gradient(ellipse 80% 60% at 10% 20%, rgba(196, 30, 42, 0.12), transparent 50%),
        radial-gradient(ellipse 70% 50% at 90% 80%, rgba(2, 72, 134, 0.14), transparent 55%),
        #eef1f6;
    }

    .auth-shell {
      position: relative;
      width: min(980px, 100%);
      min-height: 560px;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 30px 80px rgba(15, 23, 42, 0.16);
      overflow: hidden;
    }

    .forms-wrap {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
    }

    .signin-signup {
      position: absolute;
      top: 50%;
      left: 75%;
      width: 50%;
      transform: translate(-50%, -50%);
      display: grid;
      transition: 0.9s ease-in-out;
      z-index: 5;
    }

    .auth-shell.sign-up-mode .signin-signup {
      left: 25%;
    }

    form,
    .sign-up-form {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0 2.5rem;
      grid-area: 1 / 1;
      transition: 0.2s 0.6s ease-in-out;
      overflow: hidden;
    }

    .sign-in-form {
      z-index: 2;
      opacity: 1;
    }

    .sign-up-form {
      z-index: 1;
      opacity: 0;
      pointer-events: none;
    }

    .auth-shell.sign-up-mode .sign-in-form {
      z-index: 1;
      opacity: 0;
      pointer-events: none;
    }

    .auth-shell.sign-up-mode .sign-up-form {
      z-index: 2;
      opacity: 1;
      pointer-events: auto;
    }

    .brand-mini {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 18px;
      text-decoration: none;
      color: var(--ink);
    }

    .brand-mini img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
    }

    .brand-mini strong {
      font-size: 1.05rem;
    }

    .brand-mini span {
      color: var(--red);
    }

    .title {
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--ink);
      margin-bottom: 8px;
      letter-spacing: -0.02em;
    }

    .subtitle {
      color: var(--muted);
      font-size: 0.92rem;
      margin-bottom: 22px;
      text-align: center;
      max-width: 320px;
      line-height: 1.5;
    }

    .input-field {
      max-width: 340px;
      width: 100%;
      height: 48px;
      background: #f4f6f9;
      margin: 8px 0;
      border-radius: 999px;
      display: grid;
      grid-template-columns: 48px 1fr 44px;
      align-items: center;
      padding-right: 6px;
      border: 1px solid transparent;
      transition: border-color .15s ease, background .15s ease;
    }

    .input-field:focus-within {
      border-color: rgba(2, 72, 134, 0.35);
      background: #fff;
    }

    .input-field i {
      text-align: center;
      color: #9aa3b2;
      font-size: 0.95rem;
    }

    .input-field input {
      background: none;
      border: none;
      outline: none;
      font: inherit;
      font-weight: 500;
      font-size: 0.92rem;
      color: var(--ink);
      width: 100%;
      height: 100%;
    }

    .toggle-pass {
      border: 0;
      background: transparent;
      color: #9aa3b2;
      cursor: pointer;
      height: 36px;
      width: 36px;
      border-radius: 50%;
    }

    .toggle-pass:hover { color: var(--blue); }

    .alert {
      max-width: 340px;
      width: 100%;
      padding: 10px 14px;
      border-radius: 12px;
      font-size: 0.85rem;
      margin-bottom: 8px;
    }

    .alert-danger {
      background: #fdecea;
      color: #b71c1c;
    }

    .row-between {
      max-width: 340px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 10px 0 16px;
      font-size: 0.82rem;
      color: var(--muted);
    }

    .row-between label {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
    }

    .row-between a {
      color: var(--blue);
      text-decoration: none;
      font-weight: 600;
    }

    .btn {
      width: 160px;
      height: 46px;
      border: none;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--red), var(--blue));
      color: #fff;
      font-weight: 700;
      font-size: 0.9rem;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      cursor: pointer;
      margin-top: 8px;
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 12px 28px rgba(2, 72, 134, 0.28);
    }

    .btn.outline {
      background: transparent;
      border: 2px solid #fff;
      width: auto;
      padding: 0 28px;
      margin-top: 16px;
    }

    .btn.ghost {
      background: #fff;
      color: var(--blue);
      margin-top: 14px;
      text-decoration: none;
      display: inline-grid;
      place-items: center;
    }

    .panels {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      pointer-events: none;
      z-index: 6;
    }

    .panel {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      padding: 2.5rem;
      transition: 0.9s ease-in-out;
    }

    .left-panel { pointer-events: all; }
    .right-panel {
      pointer-events: none;
      transform: translateX(0);
    }

    .panel .content {
      max-width: 320px;
      transition: transform 0.9s ease-in-out;
      z-index: 2;
    }

    .left-panel .content { transform: translateX(0); }
    .right-panel .content { transform: translateX(220%); }

    .auth-shell.sign-up-mode .left-panel { pointer-events: none; }
    .auth-shell.sign-up-mode .right-panel { pointer-events: all; }
    .auth-shell.sign-up-mode .left-panel .content { transform: translateX(-220%); }
    .auth-shell.sign-up-mode .right-panel .content { transform: translateX(0); }

    .panel h3 {
      font-size: 1.7rem;
      font-weight: 800;
      margin-bottom: 10px;
      letter-spacing: -0.02em;
    }

    .panel p {
      font-size: 0.92rem;
      line-height: 1.55;
      color: rgba(255,255,255,0.9);
    }

    .overlay-wrap {
      position: absolute;
      top: 0;
      left: 50%;
      width: 100%;
      height: 100%;
      overflow: hidden;
      transform: translateX(-100%);
      transition: transform 0.9s ease-in-out;
      z-index: 1;
    }

    .auth-shell.sign-up-mode .overlay-wrap {
      transform: translateX(0);
    }

    .overlay {
      position: absolute;
      inset: 0;
      left: -50%;
      width: 200%;
      background:
        linear-gradient(135deg, rgba(196,30,42,0.92), rgba(2,72,134,0.94)),
        url('https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&w=1600&q=80') center/cover;
      transform: translateX(0);
      transition: transform 0.9s ease-in-out;
    }

    .auth-shell.sign-up-mode .overlay {
      transform: translateX(50%);
    }

    .back-home {
      position: absolute;
      top: 18px;
      left: 18px;
      z-index: 10;
      color: var(--muted);
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,255,255,0.9);
      padding: 8px 12px;
      border-radius: 999px;
    }

    .back-home:hover { color: var(--blue); }

    @media (max-width: 870px) {
      .auth-shell {
        min-height: 780px;
        width: min(420px, 100%);
      }

      .signin-signup {
        width: 100%;
        left: 50%;
        top: 72%;
      }

      .auth-shell.sign-up-mode .signin-signup {
        left: 50%;
        top: 28%;
      }

      form,
      .sign-up-form { padding: 0 1.4rem; }

      .panels {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 1fr;
      }

      .overlay-wrap {
        width: 100%;
        height: 40%;
        top: 0;
        left: 0;
        transform: translateY(0);
      }

      .auth-shell.sign-up-mode .overlay-wrap {
        transform: translateY(150%);
      }

      .overlay {
        left: 0;
        width: 100%;
        height: 200%;
        top: -100%;
        transform: translateY(0);
        background:
          linear-gradient(180deg, rgba(196,30,42,0.92), rgba(2,72,134,0.94)),
          url('https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&w=1200&q=80') center/cover;
      }

      .auth-shell.sign-up-mode .overlay {
        transform: translateY(50%);
      }

      .left-panel { transform: translateY(0); }
      .right-panel { transform: translateY(0); }

      .left-panel .content { transform: translateY(0); }
      .right-panel .content { transform: translateY(280px); }

      .auth-shell.sign-up-mode .left-panel .content { transform: translateY(-280px); }
      .auth-shell.sign-up-mode .right-panel .content { transform: translateY(0); }

      .panel { padding: 1.4rem; }
      .panel h3 { font-size: 1.35rem; }
      .title { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
  <div class="auth-page">
    <a class="back-home" href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> Back to website</a>

    <div class="auth-shell" id="authShell">
      <div class="forms-wrap">
        <div class="signin-signup">
          {{-- Sign In --}}
          <form class="sign-in-form" action="{{ route('login.submit') }}" method="POST" autocomplete="on">
            @csrf
            <a href="{{ url('/') }}" class="brand-mini">
              <img src="{{ isset($siteSettings) ? $siteSettings->logoUrl() : asset('assets/img/avatars/1.png') }}" alt="Logo">
              <strong>{{ isset($siteSettings) ? $siteSettings->brandName() : 'CNCI' }} <span>Admin</span></strong>
            </a>
            <h2 class="title">Sign in</h2>
            <p class="subtitle">Access your dashboard to manage your church branch.</p>

            @if(session('error'))
              <div class="alert alert-danger" style="display:none">{{ session('error') }}</div>
            @endif
            @error('email')
              <div class="alert alert-danger" style="display:none">{{ $message }}</div>
            @enderror
            @error('password')
              <div class="alert alert-danger" style="display:none">{{ $message }}</div>
            @enderror

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="loginPassword" placeholder="Password" required>
              <button type="button" class="toggle-pass" data-target="loginPassword" aria-label="Show password">
                <i class="fas fa-eye"></i>
              </button>
            </div>

            <div class="row-between">
              <label>
                <input type="checkbox" name="remember" value="1">
                Remember me
              </label>
              <a href="{{ url('/') }}">Need help?</a>
            </div>

            <button type="submit" class="btn">Login</button>
          </form>

          {{-- Request access (branch accounts are invite-only) --}}
          <div class="sign-up-form" role="region" aria-label="Request access">
            <a href="{{ url('/') }}" class="brand-mini">
              <img src="{{ isset($siteSettings) ? $siteSettings->logoUrl() : asset('assets/img/avatars/1.png') }}" alt="Logo">
              <strong>{{ isset($siteSettings) ? $siteSettings->brandName() : 'CNCI' }} <span>Branch</span></strong>
            </a>
            <h2 class="title">Request access</h2>
            <p class="subtitle">
              Branch accounts are created by headquarters and emailed with a temporary password.
              If you need a login for your church branch, contact CNCI admin.
            </p>
            <a href="{{ url('/#contact') }}" class="btn ghost">Contact HQ</a>
            <a href="{{ route('findus') }}" class="row-between" style="justify-content:center;margin-top:16px;text-decoration:none;color:var(--blue);font-weight:600;">
              Find a church near you →
            </a>
          </div>
        </div>
      </div>

      <div class="panels">
        <div class="panel left-panel">
          <div class="content">
            <h3>New branch?</h3>
            <p>HQ creates your account and sends login credentials to your Gmail. You can then manage your pastor gallery and branch details.</p>
            <button type="button" class="btn outline" id="signUpBtn">Request access</button>
          </div>
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Welcome back</h3>
            <p>Already have a CNCI admin or branch account? Sign in to continue managing your dashboard.</p>
            <button type="button" class="btn outline" id="signInBtn">Sign in</button>
          </div>
        </div>
      </div>

      <div class="overlay-wrap">
        <div class="overlay"></div>
      </div>
    </div>
  </div>

  @include('layouts.partials.cnci-ui')
  <script>
    const shell = document.getElementById('authShell');
    document.getElementById('signUpBtn').addEventListener('click', () => {
      shell.classList.add('sign-up-mode');
    });
    document.getElementById('signInBtn').addEventListener('click', () => {
      shell.classList.remove('sign-up-mode');
    });

    document.querySelectorAll('.toggle-pass').forEach((btn) => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        if (!input) return;
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.innerHTML = show ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
      });
    });
  </script>
</body>
</html>
