<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>CNCI Branch Account</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f5f5f7;padding:24px;color:#1e1e2a;">
  <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;padding:28px;border:1px solid #e7e7e9;">
    <h2 style="margin:0 0 12px;color:#024886;">Welcome to CNCI Branch Admin</h2>
    <p style="margin:0 0 16px;line-height:1.6;">
      Hello <strong>{{ $user->name }}</strong>,
      your branch account has been created
      @if($user->pastor)
        for <strong>{{ $user->pastor->name }}{{ $user->pastor->church ? ' — '.$user->pastor->church : '' }}</strong>
      @endif.
    </p>
    <p style="margin:0 0 8px;">Use these login details:</p>
    <div style="background:#f8f9fc;border-radius:10px;padding:16px;margin:0 0 20px;">
      <p style="margin:0 0 8px;"><strong>Login URL:</strong><br><a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
      <p style="margin:0 0 8px;"><strong>Email:</strong> {{ $user->email }}</p>
      <p style="margin:0;"><strong>Temporary password:</strong> <code style="font-size:1.05rem;">{{ $plainPassword }}</code></p>
    </div>
    <p style="margin:0 0 16px;line-height:1.6;color:#555;">
      After signing in you can manage your assigned pastor gallery and branch details.
      Please change your password under Account Settings after first login.
    </p>
    <p style="margin:0;color:#888;font-size:0.85rem;">If you did not expect this email, contact CNCI headquarters.</p>
  </div>
</body>
</html>
