<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{__('auth::emails.verify.heading')}}</h2>
        <div>
            <p>
                {{__('auth::emails.verify.text', ['app' => config('app.name')])}}
            </p>
            <p>
                <a href="{{ Illuminate\Support\Facades\URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $user->id]) }}">
                    {{__('auth::emails.verify.button')}}
                </a>
            </p>
        </div>
        <hr/>
        <div>
            <i>
                {{__('auth::emails.verify.contact')}}
                <a href="mailto:{{config('mail.from.address')}}">
                    {{config('mail.from.address')}}
                </a>.
            </i>
        </div>
    </body>
</html>