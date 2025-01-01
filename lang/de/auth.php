<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentifizierungs-Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen werden während der Authentifizierung für verschiedene
    | Nachrichten verwendet, die wir dem Benutzer anzeigen müssen. Sie können diese
    | Sprachzeilen nach den Anforderungen Ihrer Anwendung anpassen.
    |
    */

    'failed' => 'Diese Anmeldedaten stimmen nicht mit unseren Aufzeichnungen überein.',
    'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
    'login_title' => 'Zum Konto anmelden',
    'form' => [
        'lbl_email' => 'E-Mail-Adresse',
        'lbl_password' => 'Passwort',

        'ph_email' => 'E-Mail-Adresse eingeben',
        'ph_password' => 'Passwort eingeben',

        'lbl_current_password' => 'Aktuelles Passwort',
        'lbl_new_password' => 'Neues Passwort',
        'lbl_confirm_new_password' => 'Neues Passwort bestätigen',
    ],
    'forgot_password_question' => 'Passwort vergessen?',

    'reset' => 'Ihr Passwort wurde zurückgesetzt!',
    'sent' => 'Wir haben Ihnen einen Link zum Zurücksetzen des Passworts per E-Mail gesendet!',
    'throttled' => 'Bitte warten Sie, bevor Sie es erneut versuchen.',
    'token' => 'Dieser Passwort-Zurücksetzungs-Token ist ungültig.',
    'user' => "Wir können keinen Benutzer mit dieser E-Mail-Adresse finden.",
    'msg' => [
        'login_success' => 'Erfolgreich angemeldet',
        'register_success' => 'Danke für die Registrierung! Sie können sich jetzt in Ihr Konto einloggen.',
        'too_many_attempts' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
        'invalid_credentials' => 'Ungültige Anmeldedaten',
        'account_not_active' => 'Ihr Konto ist nicht aktiv. Bitte kontaktieren Sie uns.',
        'fp_send_reset_link_error' => 'Fehler beim Senden des Zurücksetzungslinks',
        'fp_send_reset_link_success' => 'Ein Passwort-Zurücksetzungslink wurde erfolgreich an Ihre registrierte E-Mail-Adresse gesendet. Bitte überprüfen Sie Ihr Postfach und folgen Sie den Anweisungen, um Ihr Passwort zurückzusetzen. Wenn Sie die E-Mail nicht innerhalb weniger Minuten erhalten, überprüfen Sie bitte Ihren Spam- oder Junk-Ordner. Bei Problemen wenden Sie sich bitte an unser Support-Team für weitere Unterstützung.',
        'password_reset_success' => 'Ihr Passwort wurde erfolgreich zurückgesetzt.',
        'password_reset_error' => 'Der Zurücksetzungs-Token ist ungültig oder abgelaufen.',
        'token_refreshed_successfully' => 'Der Token wurde erfolgreich aktualisiert.',
        'token_refresh_error' => 'Der Token konnte nicht aktualisiert werden. Bitte versuchen Sie es erneut.',
    ]
];
