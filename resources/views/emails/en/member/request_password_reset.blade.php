Hello {{ $user->firstname }},<br><br>

You are receiving this email because we received a password reset request for your account.<br><br>

{{ $token }}<br><br>

<a href="#">Reset Password</a><br><br>

This password reset link will expire in {{ setting('site.token_reset_password_timeout') ?? '60' }} minutes.<br><br>

If you did not request a password reset, no further action is required.<br><br>

Regards,<br>
TheDojo.
