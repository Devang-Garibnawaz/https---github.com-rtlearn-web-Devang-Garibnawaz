<?php 
	
	session_start();

    include_once('config.php');
	include_once("twitteroauth.php");
    function verify_vars()
    {
        foreach (func_get_args() as $arg) {
            if (isset($arg) && !empty($arg)) continue;
            else return false;
        }
        return true;
    }
    if (verify_vars($_SESSION['oauth_token'], $_SESSION['oauth_token_secret'])) {
      $oauth_token = $_SESSION['oauth_token'];
      $oauth_token_secret = $_SESSION['oauth_token_secret'];
    
      $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
      $screen_name = $_POST['screen_name'];
      if(isset($_POST['fetch_tweets'])){
				
            $screen_name = $_POST['screen_name'];
            $myTweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => 10));
            echo json_encode($myTweets);
      }else if(isset($_POST['fetch_users'])){
				
				$q = $_POST['q'];
				$myTweets = $connection->get('users/search', array('q' => $q, 'count' => 10));		
				echo json_encode($myTweets);
        }
			
    }
		


?>