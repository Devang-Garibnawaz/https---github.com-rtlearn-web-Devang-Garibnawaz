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

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Home</title>
  <style>
    .profile-image {
      display: inline-block;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-repeat: no-repeat;
      background-position: center center;
      background-size: cover;
      padding: 20px;
    }

    .post-img {
      max-width: 100% !important;
      height: 240px !important;
      overflow: hidden !important;
      object-fit: contain !important;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="assets/userlist.css" />
</head>

<body>
  <div class="d-flex flex-column flex-md-row align-items-center px-md-4 mb-5 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">Hello, Welcome <? echo $user->name ?></h5>
    <a class="btn btn-outline-danger" href="logout.php">Log out</a>
    <button class="btn btn-outline-primary ml-2" onclick="fnShowMyTweets()">Show My Tweets</button>
    <img class="profile-image" src="<? echo $user->profile_image_url ?>" alt="">

  </div>

  <div class="container">

    <section class="pt-5 pb-5" id="divDefaultTimeLine">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <h3 class="mb-3">Top 10 posts</h3>
          </div>
          <div class="col-6 text-right">
            <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
              <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-primary mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
              <i class="fa fa-arrow-right"></i>
            </a>
          </div>
          <div class="col-12">
            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="row">
                    <?
                    for ($i = 0; $i < sizeof($home_timeline); $i++) {
                    ?>
                      <div class="col-md-4 mb-3">
                        <div class="card">
                          <img class="img-fluid" alt="100%x280" src="<? echo $home_timeline[$i]->user->profile_banner_url ?>">
                          <div class="card-body" style="min-height:250px ;">
                            <h4 class="card-title"><? echo $home_timeline[$i]->user->name ?></h4>
                            <?
                            if (strpos($home_timeline[$i]->text, "http") !== false) {
                              $text = substr($home_timeline[$i]->text, 0, strpos($home_timeline[$i]->text, "http"));
                              $link = substr($home_timeline[$i]->text, strpos($home_timeline[$i]->text, "http"), strlen($home_timeline[$i]->text));
                            } else {
                              $text = $home_timeline[$i]->text;
                              $link = '';
                            }
                            ?>
                            <p class="card-text"><? echo $text ?></p>
                            <?  ?>
                            <p style="display:inline">read more...</p><a target="_blankl" href="<? echo $link ?>"><? echo $link ?></a>
                          </div>

                        </div>
                      </div>
                      <?
                      if (($i + 1) % 3 == 0) {
                      ?>
                  </div>
                </div>
                <div class="carousel-item ">
                  <div class="row">
                  <?
                      }
                  ?>
                <?
                    }
                ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="pt-5 pb-5" id="divFollowerTimeLine" style="display: none;"></section>

    <div class="col-lg-12">
      <div class="row">
        <div class="form-group">
          <span id="search_followers_loader" style="display:none;">
            <image src="assets/images/ajax-loader.gif">
          </span><input type="text" list="followers_name_list" placeholder="Search Follower" id="txtfollower_name" name="followers_name" class="form-control">
          <datalist id="followers_name_list">
            <?php foreach ($myFollowers->users as $Followers) { ?>
              <option value="<?php echo $Followers->screen_name; ?>"><?php echo $Followers->name; ?></option>

            <?php } ?>
          </datalist>
        </div>
        <div class="form-group">
          <input type="button" id="" name="search_follower" onclick="getUserTweetBySearch()" class="btn btn-primary ml-2" value="Show Tweets" />
          <button class="btn btn-success" onclick="fnGeneratePDF()">In PDF</button>
          <button class="btn btn-secondary">In XML</button>
          <button class="btn btn-info">In Google Spread Sheet</button>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="articles card">
          <div class="card-header d-flex align-items-center">
            <h2 class="h3">Followers</h2>
            <div class="badge badge-rounded bg-green"></div>
          </div>
          <div class="card-body no-padding">
            <?php foreach ($myFollowers->users as $Followers) { ?>
              <div class="item d-flex align-items-center">
                <div class="image"><img src="<?php echo $Followers->profile_image_url; ?>" alt="..." class="img-fluid rounded-circle"></div>
                <div class="text">
                  <a href="javascript:void(0)" id="<?php echo $Followers->screen_name; ?>" onclick="getUserTweet(this)">
                    <h3 class="h5"><?php echo $Followers->screen_name; ?></h3>
                  </a>
                  </a><small><?php echo "@" . $Followers->screen_name; ?></small>
                </div>
              </div>
            <? } ?>
          </div>
        </div>
      </div>
      <footer class="page-footer font-small blue">

        <!-- Copyright -->
        <? $now = new DateTime(); ?>
        <div class="footer-copyright text-center py-3">© <? echo $now->format('Y'); ?> Copyright:
          <a target="_blank" href="https://devang-garibnawaz.web.app/"> Devang Garibnawaz</a>
        </div>
        <!-- Copyright -->

      </footer>
    </div>
  </div>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="functionalJs/functional.js"></script>
</body>

</html>