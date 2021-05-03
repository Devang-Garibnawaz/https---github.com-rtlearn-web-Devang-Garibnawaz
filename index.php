<?php
// Include config file and twitter PHP Library
include_once("config.php");
include_once("twitteroauth.php");
session_start();
if (isset($_GET['request'])) {
    //Fresh authentication
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

    //Received token info from twitter
    $_SESSION['token'] = $request_token['oauth_token'];
    $_SESSION['token_secret'] = $request_token['oauth_token_secret'];

    //Any value other than 200 is failure, so continue only if http code is 200
    if ($connection->http_code == '200') {
        //redirect user to twitter
        $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
        header('Location: ' . $twitter_url);
    } else {
        die("error connecting to twitter! try again later!");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login with Twitter</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="index-heading">
            <h2>Twitter Challenge</h2>
        </div>
        <div class="btn-login">
            <a href="index.php?request=twitter"><img src="twitter.png" /></a>
        </div>
        <div class="index-heading">
            <h5>By, Devang Garibnawaz</h5>
        </div>
    </div>
</body>

</html>