<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines for Authentication
    |--------------------------------------------------------------------------
    |
    | Les lignes de langue suivantes sont utilisées pendant l'authentification pour divers
    | messages que nous devons afficher à l'utilisateur. Vous êtes libre de modifier
    | ces lignes de langue en fonction des exigences de votre application.
    |
    */

    'failed' => 'Ces identifiants ne correspondent pas à nos dossiers.',
    'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
    'login_title' => 'Se connecter à votre compte',
    'form' => [
        'lbl_email' => 'Adresse email',
        'lbl_password' => 'Mot de passe',

        'ph_email' => 'Entrez l\'adresse email',
        'ph_password' => 'Entrez le mot de passe',

        'lbl_current_password' => 'Mot de passe actuel',
        'lbl_new_password' => 'Nouveau mot de passe',
        'lbl_confirm_new_password' => 'Confirmer le nouveau mot de passe',
    ],
    'forgot_password_question' => 'Mot de passe oublié ?',

    'reset' => 'Votre mot de passe a été réinitialisé !',
    'sent' => 'Nous avons envoyé votre lien de réinitialisation par email !',
    'throttled' => 'Veuillez attendre avant de réessayer.',
    'token' => 'Ce token de réinitialisation de mot de passe est invalide.',
    'user' => "Nous ne trouvons pas un utilisateur avec cette adresse email.",
    'msg' => [
        'login_success' => 'Connexion réussie',
        'register_success' => 'Merci pour votre inscription ! Vous pouvez maintenant vous connecter à votre compte.',
        'too_many_attempts' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
        'invalid_credentials' => 'Identifiants invalides',
        'account_not_active' => 'Votre compte n\'est pas actif. Veuillez nous contacter.',
        'fp_send_reset_link_error' => 'Échec de l\'envoi du lien de réinitialisation',
        'fp_send_reset_link_success' => 'Un lien de réinitialisation de mot de passe a été envoyé avec succès à votre adresse email enregistrée. Veuillez vérifier votre boîte de réception et suivre les instructions pour réinitialiser votre mot de passe. Si vous ne recevez pas l\'email dans quelques minutes, vérifiez votre dossier spam ou courrier indésirable. Si vous rencontrez des problèmes, n\'hésitez pas à contacter notre équipe de support pour toute assistance supplémentaire.',
        'password_reset_success' => 'Votre mot de passe a été réinitialisé avec succès.',
        'password_reset_error' => 'Le token de réinitialisation est invalide ou expiré.',
        'token_refreshed_successfully' => 'Le token a été rafraîchi avec succès.',
        'token_refresh_error' => 'Impossible de rafraîchir le token. Veuillez réessayer.',
    ]
];
