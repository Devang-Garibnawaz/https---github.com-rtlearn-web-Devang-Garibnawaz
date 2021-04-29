<?php
// Include config file and twitter PHP Library
include_once("config.php");
include_once("twitteroauth.php");
session_start();
if(isset($_GET['request']))
{
    //Fresh authentication
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

    //Received token info from twitter
    $_SESSION['token'] = $request_token['oauth_token'];
    $_SESSION['token_secret'] = $request_token['oauth_token_secret'];

    //Any value other than 200 is failure, so continue only if http code is 200
    if($connection->http_code == '200')
    {
        //redirect user to twitter
        $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']); 
        header('Location: ' . $twitter_url);
    }
    else
    {
        die("error connecting to twitter! try again later!");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login with Twitter</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body style="background:cadetblue">
<div class="container">
    <div class="container my-4">

        <div class="p-5 mb-4">
            <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                <div class="p-2 bd-highlight col-example"><h1>Twitter Challenge</h1></div>
            </div> 
            
            <div class="d-flex align-items-center justify-content-center">
                <div class="p-2 bd-highlight col-example"><a href="index.php?request=twitter"><img src="twitter.png" /></a></div>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                <div class="p-2 bd-highlight col-example"><h3>By, Devang Garibnawaz</h3></div>
            </div> 
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>   
</body>
</html>