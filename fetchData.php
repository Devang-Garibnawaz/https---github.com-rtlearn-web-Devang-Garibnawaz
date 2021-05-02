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

// print_r($_SESSION);


if (verify_vars($_SESSION['oauth_token'], $_SESSION['oauth_token_secret'])) {


    $oauth_token = $_SESSION['oauth_token'];
    $oauth_token_secret = $_SESSION['oauth_token_secret'];

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    if (isset($_POST['screen_name']) && isset($_POST['count'])) {
        $count = $_POST['count'];
        $screen_name = $_POST['screen_name'];
        $user_timeline = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => $count]);
        echo json_encode($user_timeline);
    } else if (isset($_POST['status'])) {
        if ($_POST['status'] == "2") {
            $myFollowers = $connection->get("followers/list");
            echo json_encode($myFollowers);
        }
    } else {
        $home_timeline = $connection->get("statuses/home_timeline", ["count" => 10]);
        echo json_encode($home_timeline);
    }
}
