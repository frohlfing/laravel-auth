<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>{{__('auth.emails.reset.heading')}}</h2>
<div>
    <p>
        {{__('auth.emails.reset.text', ['app' => config('app.name')])}}
    </p>
    <p>
        <a href="{{route('password.reset', [
                    'token' => $token,
                    'email' => $user->email
                    ])}}">
            {{__('auth.emails.reset.button')}}
        </a>
    </p>
</div>
<hr/>
<div>
    <i>
        {{__('auth.emails.reset.contact')}}
        <a href="mailto:{{config('mail.from.address')}}">
            {{config('mail.from.address')}}
        </a>.
    </i>
</div>
</body>
</html>
