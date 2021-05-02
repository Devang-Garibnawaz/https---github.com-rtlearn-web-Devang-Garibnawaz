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
    if (isset($_GET['screen_name']) && isset($_GET['status'])) {
        $status = $_GET['status'];
        $screen_name = $_GET['screen_name'];
        switch ($status) {
            case "1":
                $count = 10;
                $user_timeline = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => $count]);
                echo json_encode($user_timeline);
                break;
            case "2":
                $user_timeline = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name]);
                echo json_encode($user_timeline);
                break;
            default:
                break;
        }
    } else if (isset($_GET['status'])) {
        if ($_GET['status'] == "2") {
            $myFollowers = $connection->get("followers/list");
            echo json_encode($myFollowers);
        }
    } else {
        $home_timeline = $connection->get("statuses/home_timeline", ["count" => 10]);
        echo json_encode($home_timeline);
    }
}
