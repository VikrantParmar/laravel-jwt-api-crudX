<?php

#PROJECT-WISE
if (!defined('MAIL_TEST_MODE')) define('MAIL_TEST_MODE', 'Test');
if (!defined('MAIL_TEST_EMAIL')) define('MAIL_TEST_EMAIL', 'vikrant.parmar91@gmail.com');
if (!defined('MAIL_TEST_MODE_TEST')) define('MAIL_TEST_MODE_TEST', 'Test');
if (!defined('DEV_HOST_NAME')) define('DEV_HOST_NAME', @$_SERVER['HTTP_HOST'] );
if (!defined('DEFAULT_PHOTO_PROFILE')) define('DEFAULT_PHOTO_PROFILE', '100_no_img.jpg' );

return [
    //DEFAULT
    'main_admin_id' => [1],
    'mail' => [
        'developer' => ['developmentsmtp127@gmail.com'],
        'support' => 'vikrant.parmar91@gmail.com'
    ],
];
?>

