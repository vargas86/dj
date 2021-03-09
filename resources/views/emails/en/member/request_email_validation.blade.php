Hello {{ $user->firstname }},<br><br>

To confirm your e-mail address and activate your account, simply click on the following link: <a href="{{ $validation_url }}">Confirm your e-mail address</a><br><br>

This e-mail activation link will expire in {{ setting('site.token_validation_email_timeout') ?? '60' }} minutes.<br><br>

Regards,<br>
TheDojo.

