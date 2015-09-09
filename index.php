<?php
  session_start();
  if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];
  }

?>
<!-- saved from url=(0029)file:///C:/Website/index.html -->
<html>
<title>Jack's Website</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="icon" type="image/png" href="https://www.ad2myaccount.com/img/play_button.png">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet"  type="text/css" href="/style.css">

<style>
.content {
  bottom: 50px;
}
</style>
</head>
<body>
 
<?php
  require_once('db_constant.php');
  $con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
  if (!$con) {
      die("could not connect: " . mysql_error());
    }
  $db_selected = mysql_select_db( "video", $con);

  ## select the last 5 videos searched
  $sql = "SELECT DISTINCT videourls, title FROM `videourl` ORDER BY id DESC LIMIT 5";
  $sql2 = "SELECT `videourls`, `title`, count(*) from `videourl` group by `videourls` order by count(*) desc limit 5";
  $result = mysql_query($sql, $con);
  $result2 = mysql_query($sql2, $con);
  if (!result) die ("Database access failed: " . mysql_error());
?>

<?php
  $sql5 = "SELECT * from users WHERE username LIKE '{$username}'LIMIT 1";
  $result5 = mysql_query($sql5, $con);
  $row5 = mysql_fetch_array($result5);
  $userid = $row5['id'];
?>

<div class="container">
<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="./" class="navbar-brand">Home</a>
    </div>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">

      <?php 
        if (isset($username)) {
      ?>
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
      <?php } else { ?>


      <ul class="nav navbar-nav loginstuff">
        <li>
          <a href="/register.php">Register</a>
        </li>
        </li>
        <li>
          <a href="/login.php">Login</a>
        </li>


      </ul>
      <?php } ?>
    </nav>
  </div>
</header>
</div>



<div class="jumbotron">
<!--  <blockquote>
    <p>Music can change the world because it can change people.</p>
    <footer>Bono</footer>
  </blockquote> -->
  <div class="container">
  <div class="col-md-12">
    <form class="search">
      <input type="text" style="font-size:20px" class="form-control col-md-4 searchbar" placeholder="search some music!" name="query">
    </form>
  </div>

</div>
</div>
<div class="row content">
  <div class="container">
    <div class="col-md-6 popular"> 
      <h1 class="subheading">Most Listened</h1>

        <?php 
          for($i=0; $i<5; $i++) {
            $row2 = mysql_fetch_array($result2);
            ?>    
          <div class="boxes"> 
              <a href="http://jacksbeats.com/music.php?search=<?php echo $row2['videourls'] ?>"><img src ="http://i1.ytimg.com/vi/<?php echo $row2['videourls'] ?>/default.jpg" class="thumbnail"></a>
              <h3> <a href="http://jacksbeats.com/music.php?search=<?php echo $row2['videourls'] ?>" > <?php echo $row2['title'] ?> </a> </h3>
            </div>
        <?php } ?>
    </div>
    <div class="col-md-6 recent"> 
      <h1 class="subheading">Most Recent</h1>
        <?php 
          for($i=0; $i<5; $i++) {
            $row = mysql_fetch_array($result);
            ?>    
          <div class="boxes"> 
              <img src ="http://i1.ytimg.com/vi/<?php echo $row['videourls'] ?>/default.jpg" class="thumbnail">
              <h3> <a href="http://jacksbeats.com/music.php?search=<?php echo $row['videourls'] ?>" > <?php echo $row['title'] ?> </a> </h3>
            </div>
        <?php } ?>
    </div>

  </div>
  <div class="row viewing"> 
    <div class="col-md-6 col-md-offset-3"> </div>
  </div>
  <script type="text/javascript">

    $(document).ready(
      $(".search").submit(function(event) {
        search($(".searchbar").val());

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
          var html = "<div id='boxes'>" + "<img src = '" + data.items[0].snippet.thumbnails.default.url + "' width = '150' height ='100' style='border:0;' align='left'>";
          html += "<a href='http://jacksbeats.com/music.php?search=" + data.items[0].id.videoId + "'>" + "<br>" + data.items[0].snippet.title + "</a>"+ data.items[0].snippet.description;
          html += "</div>";
          var url = data.items[0].id.videoId;
          var video = "<iframe width='0' height='0' src='http://www.youtube.com/embed/" + data.items[0].id.videoId +"?autoplay=1'></iframe>";
    //      $('.player').html(video);
          location.href="music.php?search=" + url;
        });
    }

  </script>
</div>
</body>
</html>
