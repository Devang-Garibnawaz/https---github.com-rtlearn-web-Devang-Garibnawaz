<?php
session_start();
set_time_limit(0);
include_once('config.php');
include_once("twitteroauth.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function verify_vars()
{
    foreach (func_get_args() as $arg) {
        if (isset($arg) && !empty($arg)) continue;
        else return false;
    }
    return true;
}

// print_r($_SESSION);

$arg_arr = explode(",", $argv[1]);
if (verify_vars($arg_arr[0], $arg_arr[1])) {


    $oauth_token = $arg_arr[0];
    $oauth_token_secret = $arg_arr[1];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    if (isset($arg_arr[2]) && isset($arg_arr[3])) {
        $email = $arg_arr[2];
        $screen_name = $arg_arr[3];
        $users_tweets = [];
        $i = 0;
        $id = 0;
        do {
            if ($id == 0) {
                $result = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => 200]);
            } else {
                $result = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name, "count" => 200, 'since_id' => $id]);
            }
            $index = sizeof($result) - 1;
            $users_tweets[$i] = $result;
            $id = $result[$index]->id;
        } while (sizeof($result) <= 0);

        generateCSV($screen_name, $users_tweets, $email);
    }
}

function generateCSV($screen_name, $users_tweets, $email)
{
    $file = $screen_name . '_tweets.csv';
    $list = array(
        ['tweet_id', 'name', 'text', 'favorite_count', 'retweet_count', 'created_at']
    );
    for ($i = 0; $i < count($users_tweets); $i++) {
        for ($j = 0; $j < count($users_tweets[$i]); $j++) {
            array_push($list, [
                $users_tweets[$i][$j]->id_str,
                $users_tweets[$i][$j]->user->name,
                $users_tweets[$i][$j]->text,
                $users_tweets[$i][$j]->favorite_count,
                $users_tweets[$i][$j]->retweet_count,
                date("d-m-Y h:i:s", strtotime($users_tweets[$i][$j]->created_at))
            ]);
        }
    }
    $fp = fopen($file, "a+");
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
    sendMailToUser($screen_name, $email);
}

function sendMailToUser($screen_name, $email)
{

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $fromEmail = "trackerincco@gmail.com";
    $fromName = "Devang Garibnawaz";

    $mail = new PHPMailer;


    $mail->isSMTP();
    // $mail->Host = "smtp.gmail.com";
    $mail->CharSet = 'UTF-8';
    $mail->Host = 'email-smtp.us-east-1.amazonaws.com'; //Sets the SMTP hosts of your Email hosting, this for AWS
    $mail->Port = '587'; //Sets the default SMTP server port
    $mail->SMTPAuth = true; //Sets SMTP authentication. Utilizes the Username and Password variables
    // $mail->Username = "devangjariwala25@gmail.com";
    // $mail->Password = "Devang@4128";
    $mail->Username = 'AKIA347SSPVUQUP2NZX2'; //Sets SMTP username
    $mail->Password = 'BBFaKRlHifYVUDtPoF8HfeWPAUea0Q75LzdlaF4F4Pjc'; //Sets SMTP password
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($email);

    //Provide file path and name of the attachments
    $file = $screen_name . "_tweets.csv";
    $mail->addAttachment($file, $file);

    $mail->isHTML(true);
    $mail->Subject = "Tweets of " . $screen_name;
    $mail->Body = "<i>Check following attachment of follower tweets</i>";


    try {
        if (!$mail->send()) {
            $status = "failed";
            $response = "Error" . $mail->ErrorInfo;
        } else {
            $status = "success";
            $response = "Email Sent";
        }
    } catch (Exception $e) {
        $status = "failed";
        $response = "Error! " . $mail->ErrorInfo;
    }

    unlink($file);
    echo json_encode(array("status" => $status, "response" => $response));
}
