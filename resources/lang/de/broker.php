<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'password' => 'Passwörter müssen mindestens ' . config('auth.password_length') . ' Zeichen lang sein und korrekt bestätigt werden.',
    'reset'    => 'Das Passwort wurde zurückgesetzt!',
    'sent'     => 'Eine E-Mail zwecks Zurücksetzen des Kennworts wurde versendet!',
    'token'    => 'Der Passwort-Wiederherstellungs-Schlüssel ist ungültig oder abgelaufen.',
    'user'     => 'Es konnte leider kein Nutzer mit dieser E-Mail-Adresse gefunden werden.',

];
