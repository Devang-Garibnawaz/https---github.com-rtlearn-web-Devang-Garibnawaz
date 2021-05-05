<?
if (isset($_POST["type"])) {
    $oauth_token = $_COOKIE['oauth_token'];
    $oauth_token_secret = $_COOKIE['oauth_token_secret'];
    $type = $_POST["type"];
    $email = $_POST["email"];
    $screen_name = $_POST["screen_name"];

    switch ($type) {
        case 1:
            $result = shell_exec('php fetchFollowers.php ' . $oauth_token . ',' . $oauth_token_secret . ',' . $email . ',' . $screen_name . '  2>&1');
            echo json_encode($result);
            break;
        case 2:
            $result = shell_exec('php fetchtweets.php ' . $oauth_token . ',' . $oauth_token_secret . ',' . $email . ',' . $screen_name . '  2>&1');
            echo json_encode($result);
            break;
    }
}
