<?php
define('CONSUMER_KEY', '61v2qOiJLLER0yOQZ2Zg1L5wP');
define('CONSUMER_SECRET', 'mDSNKHT3tU6THGi1oFiPnGxSPIl4LcIuCdtjhtTy2coaRmWjID');
//define('OAUTH_CALLBACK', 'http://localhost/twitterassignment/callback.php');
define('OAUTH_CALLBACK', 'https://www.directoapp.com/twitterassignment/callback.php');

if (array_key_exists('logout', $_GET)) {
    session_start();
    session_destroy();
    header("Location:index.php");
}
