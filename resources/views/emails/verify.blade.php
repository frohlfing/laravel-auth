<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{__('auth.emails.register.heading')}}</h2>
        <div>
            <p>
                {{__('auth.emails.register.text', ['app' => config('app.name')])}}
            </p>
            <p>
                <a href="{{route('auth.verification.confirm', [
                    'confirmationToken' => $user->confirmation_token,
                    'email' => $user->email
                    ])}}">
                    {{__('auth.emails.register.button')}}
                </a>
            </p>
        </div>
        <hr/>
        <div>
            <i>
                {{__('auth.emails.register.contact')}}
                <a href="mailto:{{config('mail.from.address')}}">
                    {{config('mail.from.address')}}
                </a>.
            </i>
        </div>
    </body>
</html>