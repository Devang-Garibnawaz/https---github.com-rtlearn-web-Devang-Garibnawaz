<!DOCTYPE html>
<?php
session_start();
include_once("config.php");
include_once("twitteroauth.php");

if (!isset($_SESSION['logged_in'])) header('Location: index.php');
if (empty($_SESSION['logged_in'])) header('Location: index.php');
if ($_SESSION['logged_in'] != 1) header('Location: index.php');

?>
<?php


if (isset($_POST['btnGeneratePDF'])) {
    echo "hello";
    header("location:generatepdf.php");
}

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
    $user = $connection->get("account/verify_credentials");
    $home_timeline = $connection->get("statuses/home_timeline", ["count" => 10]);
    $myFollowers = $connection->get("followers/list", ["count" => 10]);

    $myFollowersArray = (array)$myFollowers;

    if (isset($myFollowersArray["errors"])) {

        $code = $myFollowersArray["errors"][0]->code;
        echo $code;
        if ($code == 88) {
            header("Location:limitexceeded.php");
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/caraousel.css" />
</head>
<body">
    <div class="container">
        <div class="topnav">
            <div class="left-nav">
                <?
                if (isset($user->profile_image_url)) {
                    $img = $user->profile_image_url;
                } else {
                    $img = "assets/images/defaultuser.png";
                }
                ?>
                <img class="profile-image" src="<? echo $img ?>" alt="">
                <h3 class="user-name">Hello <? echo $user->name ?></h3>
            </div>
            <div class="right-nav">

                <input type="button" class="btn btn-tweets" value=" My Tweets" />
                <input type="button" class="btn btn-logout" value="Logout" />
            </div>

        </div>
    </div>

    <div class="container col-11">
        <div class="card-header">TimeLines</div>
        <div class="carousel">
            <?
            for ($i = 0; $i < sizeof($home_timeline); $i++) {
                $i == 0 ? $visibleitem = 'carousel__item--visible' : $visibleitem = '';

            ?>
                <div class="carousel__item <? echo $visibleitem ?>">
                    <div class="card">
                        <img src="<? echo $home_timeline[$i]->user->profile_banner_url ?>" class="post" alt="Avatar" style="width:100%">
                        <div class="card-body">
                            <h4 class="mr"><b><? echo $home_timeline[$i]->user->name ?></b></h4>
                            <?
                            if (strpos($home_timeline[$i]->text, "http") !== false) {
                                $text = substr($home_timeline[$i]->text, 0, strpos($home_timeline[$i]->text, "http"));
                                $link = substr($home_timeline[$i]->text, strpos($home_timeline[$i]->text, "http"), strlen($home_timeline[$i]->text));
                            } else {
                                $text = $home_timeline[$i]->text;
                                $link = '';
                            }
                            ?>
                            <p class="mt"><? echo $text ?></p>
                            <p>Created At: <b><? echo date("d-m-Y h:i:s", strtotime($home_timeline[$i]->created_at)) ?></b></p>
                            <? if (isset($link)) { ?><a target="_blankl" class="btn btn-link" href="<? echo $link ?>">Read more</a><? } ?>

                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="carousel__actions">
                <button id="carousel__button--prev" aria-label="Previous slide"><i class="arrow left"></i></button>
                <button id="carousel__button--next" aria-label="Next slide"><i class="arrow right"></i></button>
            </div>
        </div>
    </div>

    <div class="container col-11">
        <div class="card-header">TimeLines</div>
        <div class="carousel" id="divFolloweTimelineNew"></div>
    </div>

    <div class="container col-9">
        <div class="row">
            <div class="card-header">Operations</div>
            <div class="user-card-body d-flex">
                <div class="col=3">
                    <input type="text" list="followers_name_list" placeholder="Search Follower" id="txtfollower_name" name="followers_name" class="form-control">
                    <datalist id="followers_name_list">
                        <?php foreach ($myFollowers->users as $Followers) { ?>
                            <option value="<?php echo $Followers->screen_name; ?>"><?php echo $Followers->name; ?></option>

                        <?php } ?>
                    </datalist>
                </div>
                <div class="col-9 d-flex ml">
                    <input type="button" id="" name="search_follower" onclick="getUserTweetBySearch()" class="btn btn-primary" value="Show Tweets" />
                    <button class="btn btn-success" onclick="fnGeneratePDF()">In PDF</button>
                    <button class="btn btn-secondary">In XML</button>
                    <button class="btn btn-info">In Google Spread Sheet</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-9">
        <div class="row">
            <div class="card-header">My Followers</div>
            <?php foreach ($myFollowers->users as $Followers) { ?>
                <div class="user-card-body">
                    <div class="user-item">
                        <div>
                            <img class="user-image" src="<?php echo $Followers->profile_image_url; ?>" alt="..." class="img-fluid rounded-circle">
                        </div>
                        <div class="text">
                            <a style="color:white;text-decoration:none;" href="javascript:void(0)" id="<?php echo $Followers->screen_name; ?>" onclick="fnGetUserTweets(this)">
                                <h3 class="h5"><?php echo $Followers->name; ?></h3>
                            </a>
                            </a>
                            <p><?php echo $Followers->description; ?></p>
                        </div>
                    </div>
                </div>
            <? } ?>

        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <? $now = new DateTime(); ?>
            © <? echo $now->format('Y'); ?> Copyright:
            <a target="_blank" style="color:white;" href="https://devang-garibnawaz.web.app/"> Devang Garibnawaz</a>
        </div>
    </footer>
    <script src="functionalJs/app.js"></script>
    <script src="functionalJs/functional.js"></script>
    </body>

</html>