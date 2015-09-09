<?php
  session_start();
  if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];
  }

?>

<html>
<title>Jack's Website</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="icon" 
      type="image/png" 
      href="https://www.ad2myaccount.com/img/play_button.png">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
      href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" 
      href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet"  
      type="text/css" 
      href="/style.css">

<style></style>
</head>

<?php
require_once('db_constant.php');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
$db_selected = mysql_select_db( "video", $con);
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
  $sql = "SELECT * FROM `users` ORDER BY id";
  $result = mysql_query($sql, $con);
  $num_rows = mysql_num_rows($result);
  if (!result) die ("Database access failed: " . mysql_error());
?>

<div class="container">
	<div class="row-fluid profile-content">
		<div class="col-md-12 comm">
			<b class="comm"> Community </b>
		</div>
	<?php 
	for($i=0; $i<$num_rows; $i++) {
    $row = mysql_fetch_array($result);
		?>    
	<div class="userbox col-md-4"> 
      <img src ="/images/<?php
        echo $row['profilepic'];
      ?>"



       class="thumbnail" height="60" width="60">
      <h3> <?php echo '<a href="/profile.php?profileid='. $row['id'] .'">' ?>

        <?php echo $row['username'] ?> </a> </h3>
  </div>
<?php } ?>

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
    </script>
  </div>
</div>