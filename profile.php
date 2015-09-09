<?php
  session_start();
  if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];
  }
  if (isset($_SESSION['id']))
  {
    $userid = $_SESSION['id'];
  }
  if (isset($_SESSION['profilepic']))
  {
    $profilepic = $_SESSION['profilepic'];
  }
  $profileid =  $_GET['profileid'];
  require_once('db_constant.php');
  $con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
  $db_selected = mysql_select_db( "video");
  $sql6 =  "SELECT * from `users` WHERE id = $profileid";
  $result6 = mysql_query($sql6);
  $row6 = mysql_fetch_array($result6);
?>


<html>
<title>Jack's Website</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="icon" 
      type="image/png" 
      href="https://www.ad2myaccount.com/img/play_button.png">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<link rel="stylesheet"  type="text/css" href="/style.css">

<style></style>
</head>


<?php
$sql5 = "SELECT * from users WHERE username LIKE '{$username}'LIMIT 1";
$result5 = mysql_query($sql5, $con);
$row5 = mysql_fetch_array($result5);
$userid = $row5['id'];
?>

<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
      </button>
      <a href="./" class="navbar-brand">Home</a>
    </div>
    <form class="navbar-form navbar-left form-inline navbarsearch search" id="search" role="search">
      <div class="form-group-group">
          <div class="input-group" style="width: 600px;" font-size="20px">
              <input type="text" class="form-control searchbars " placeholder="search some music!" name="query">
          </div>
      </div> <!-- END form group div -->
    </form> <!-- END search bar form -->
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav community-button">
        <li>
          <a href="/community.php">Community</a>
        </li>
      </ul>
      <ul class="greeting">
        <ul class="nav navbar-nav community-button">
        <li>
          <?php echo '<a href="/profile.php?profileid=' . $userid . '">Hello' ?> <?php echo $username ?></a>
        </li>
        <li>
          <a href="/logout.php">Logout</a>
        </li>
      </ul>

      </ul>
    </nav>
  </div>
</div>
</header>
<body>
<?php
    $sql = "SELECT DISTINCT videourls, title FROM `videourl` ORDER BY id DESC LIMIT 10";
    $sql2 = "SELECT DISTINCT videourls, title from `videourl` WHERE userid = $profileid ORDER BY id DESC LIMIT 10";
    $sql3 =  "SELECT profilepic from `users` WHERE id = $profileid";
    $result = mysql_query($sql);
    $result2 = mysql_query($sql2); #responsible for the feed
    $result3 = mysql_query($sql3);
    $row3 = mysql_fetch_array($result3); #row3 responsible for profile pic
    if (!result) die ("Database access failed: " . mysql_error());

    $followingcount = "SELECT * from `friend` WHERE `userid` = $profileid";
    $followercount = "SELECT * from `friend` WHERE `friendid` = $profileid";
    $resultfollower = mysql_query($followercount);
    $resultfollowing = mysql_query($followingcount);
?>


<div class="container">
<div class="row-fluid profile-content">
  <div class="col-md-3 user">

    <img src ="/images/<?php 
    echo $row3['profilepic'] #retrieves the profile pic from the database here
    ?>" class="profilepic">

    <div class="col-md-10 col-md-offset-1 userinfo">
      <br> <br><!-- break -->
      <b class="username"> <?php echo $row6['username'] ?></b>
      <br> <br><!-- break -->
      <b class="friendcount"> Followers: <?php echo mysql_num_rows($resultfollower) ?></b>
      <b class="friendcount"> Following: <?php echo mysql_num_rows($resultfollowing) ?> </b>
      
      <br> <br><!-- break -->
      
      <?php if($_GET['profileid'] == $userid) { ?>
        <b> edit profile picture </b>
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
          <label for="file">Filename:</label>
          <input type="file" class="button" name="filename" id="filename"><br>
          <input type="submit" class="button" name="submit" value="Submit">
        </form>
      <?php } else {?>
        <form method="post">
        <input type="hidden" value="<?php echo $row6['userid']; ?>" name="friend_id">
        <input type="submit" class="button" name="add_friend" value="Follow!" /> 
      <?php 
        if(isset($_POST['add_friend'])) {
        $current_user = $_SESSION['id']; //This will fetch user id of the person who is logged in and for this you need to have a user id in your session for the user who logs in

        $followid = $_GET['profileid']; //This will assign friend id to variable $friendid
        $sql10 = "INSERT  INTO `friend` (`userid`, `friendid`) 
                  VALUES ('{$current_user}', '{$followid}')";
        //this code inserts the data collected into the server
        mysql_query($sql10);
  }
    } ?>

</form>
    </div>
  </div>
  <div class="col-md-5 user-music">
    <b class="music-heading"> Most Recently Viewed </b>
      <br> <br><!-- break -->
<?php 
  for($i=0; $i<mysql_num_rows($result2); $i++) {
    $row = mysql_fetch_array($result2);
    ?>    
  <div class="boxes"> 
      <img src ="http://i1.ytimg.com/vi/<?php echo $row['videourls'] ?>/default.jpg" class="thumbnail">
      <h3> <a href="http://jacksbeats.com/music.php?search=<?php echo $row['videourls'] ?>" > <?php echo $row['title'] ?> </a> </h3>
    </div>
  <?php } ?>
  </div>
  </div>
  <div class="col-md-4 friend-feed">
    <b class="friend-heading"> Friend Feed </b>
<?php
require_once('db_constant.php');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$con)
{
  die("could not connect: " . mysql_error());
}
$db_selected = mysql_select_db( "video");
#$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME_URL);

## select the last 5 videos searched
    $sql11 = "SELECT * FROM `friend` WHERE `userid`={$userid}";
    $result11 = mysql_query($sql11);
    
    $all = array();

    while(($row11 = mysql_fetch_array($result11))) {
      array_push($all, $row11['friendid']);
    }
    $friendfeedids = implode(",",$all);
    
    $sql = "SELECT DISTINCT videourls, title FROM `videourl` ORDER BY id DESC LIMIT 10";
    $sql2 = "SELECT DISTINCT videourls, title FROM `videourl` WHERE userid IN ({$friendfeedids}) ORDER BY id DESC LIMIT 10";
    $result = mysql_query($sql);
    $result2 = mysql_query($sql2);
    if (!result) die ("Database access failed: " . mysql_error());
?>
<?php 
  for($i=0; $i<mysql_num_rows($result2); $i++) {
    $row2 = mysql_fetch_array($result2);
    ?>    
  <div class="boxes"> 
      <img src ="http://i1.ytimg.com/vi/<?php echo $row2['videourls'] ?>/default.jpg" class="thumbnail">
      <h3> <a href="http://jacksbeats.com/music.php?search=<?php echo $row2['videourls'] ?>" > <?php echo $row2['title'] ?> </a> </h3>
    </div>
  <?php } ?>
  </div>
  </div>
</div>
</div>
</body>

<script type="text/javascript">

$(document).ready(
  $(".search").submit(function(event) {
    search($(".searchbars").val());

    return false;
  })
);


function search(query) {
  $.getJSON('https://www.googleapis.com/youtube/v3/search', 
    { 
      key: 'AIzaSyC5k1c_K_Oa6wkKI7Lm5yR8kYnuxVebk88', 
      part: 'snippet', 
      type: 'video',
      videoCategoryId: 10,
      q: query
    }, 
    function(data) { 
      var url = data.items[0].id.videoId;
      location.href="music.php?search=" + url;
    });
}
$(document).ready(function(){
    $('.button').click(function(){
        $(this).toggleClass('active');
    });
});
</script>