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
        $cursor = -1;
        $myFollowers = [];
        $i = 0;
        do {
            $result = $connection->get("followers/list", ["screen_name" => $screen_name, "cursor" => $cursor]);
            $resultArray = (array)$result;
            if (isset($resultArray["errors"])) {
                sleep(900);
            } else {
                $myFollowers[$i] = $result;
                $cursor = $result->next_cursor;
                $i++;
            }
        } while ($cursor != 0);
        //$_SESSION["followers"] = $myFollowers;
        //$myFollowers = $_SESSION["followers"];
        generateCSV($screen_name, $myFollowers, $email);
    }
}

function generateCSV($screen_name, $myFollowers, $email)
{
    $file = $screen_name . '_followers.csv';
    $list = array(
        ['username', 'screen_name', 'description', 'profile_image_url', 'created_at']
    );
    for ($i = 0; $i < count($myFollowers); $i++) {
        for ($j = 0; $j < count($myFollowers[$i]->users); $j++) {
            array_push($list, [
                $myFollowers[$i]->users[$j]->name,
                $myFollowers[$i]->users[$j]->screen_name,
                $myFollowers[$i]->users[$j]->description,
                $myFollowers[$i]->users[$j]->profile_image_url,
                date("d-m-Y h:i:s", strtotime($myFollowers[$i]->users[$j]->created_at))
            ]);
        }
    }
    $fp = fopen($file, "w");
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

    $mail = new PHPMailer;


    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "devangjariwala25@gmail.com";
    $mail->Password = "Devang@4128";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->setFrom('devangjariwala25@gmail.com', 'Devang Garibnawaz');
    $mail->addAddress($email);

    //Provide file path and name of the attachments
    $file = $screen_name . "_followers.csv";
    $mail->addAttachment($file, $file);

    $mail->isHTML(true);
    $mail->Subject = "Followers list of " . $screen_name;
    $mail->Body = "<i>Check following attachment of follower list</i>";
    $mail->AltBody = "This is the plain text version of the email content";

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
