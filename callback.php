<?php

session_start();
include_once("config.php");
include_once("twitteroauth.php");


if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($connection->http_code == '200')
	{
		$user = $connection->get("account/verify_credentials");   
		$_SESSION['oauth_token'] = $access_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $access_token['oauth_token_secret'];
        $_SESSION['oauth_verifier'] =$_REQUEST['oauth_verifier'];
		$_SESSION['logged_in'] = 1;
		
		header('Location:home.php');
	}
	else
	{
		die("error, try again later!");
	}
}   

?>