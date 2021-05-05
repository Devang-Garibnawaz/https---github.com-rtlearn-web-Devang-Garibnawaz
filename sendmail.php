<?

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$status = '';
$response = '';

$mail = new PHPMailer;

$arg_arr = explode(",", $argv[1]);
if (count($arg_arr) <= 0) {
    $status = "failed";
    $response = "Error! You have to pass email and screen name";
} else {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "devangjariwala25@gmail.com";
    $mail->Password = "Devang@4128";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->setFrom('devangjariwala25@gmail.com', 'Devang Garibnawaz');
    $mail->addAddress($arg_arr[0]);

    //Provide file path and name of the attachments
    //$file = $screen_name . "_followers.csv";
    //$mail->addAttachment($file, $file);

    $mail->isHTML(true);
    $mail->Subject = "Test Mail Using Background For" . $arg_arr[1];
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
}
echo json_encode(array("status" => $status, "response" => $response));
