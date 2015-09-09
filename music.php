<?php
  session_start();
  $con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
  if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];
  }
  if (isset($_SESSION['password']))
  {
  	$password = $_SESSION['password'];
  }
  if (isset($_SESSION['id']))
  {
  	$userid = $_SESSION['id'];
  }
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
<link rel="stylesheet"  type="text/css" href="/style.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<style></style>
</head>

<?php
//login info
require_once('db_constant.php');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
$db_selected = mysql_select_db( "video", $con);
require_once("db_const.php");
$videotime = $_SERVER['REQUEST_TIME'];
$videourl = $_SERVER['REQUEST_URI'];
//logging in
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$newId = str_replace('/music.php?search=', '', $videourl);

$test = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $newId . '&key=AIzaSyC5k1c_K_Oa6wkKI7Lm5yR8kYnuxVebk88';

//we are going to get the youtube data for this video

//make changes here
$videodata = json_decode(file_get_contents($test));

## query database
    # prepare data for insertion
    $videourl    = $_GET['search'];
 	{
        # insert data into mysql database
        $preview = $videodata->items[0]->snippet->thumbnails->default->url;
        $description = $videodata->items[0]->snippet->description;
        $title = addslashes($videodata->items[0]->snippet->title);

	        $sql = "INSERT  INTO `videourl` (`id`, `videourls`, `userid`, `videotime`, `title`) 
	                VALUES (NULL, '{$videourl}', '{$userid}', '{$videotime}', '{$title}')";


    }
    $mysqli->query($sql);
    # insert data into "mostviewed" table and increase count if there are dublicates



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
	<div class="container">
		<div class="col-md-12">
			<form class="search">
				<input type="text" style="font-size:20px" class="form-control col-md-4 searchbar" placeholder="search some music!" name="query" action="music.php">
			</form>
		</div>
		<div class="col-md-12 player"></div>
	</div>	
</div>
<div class="row buffer2"> </div>
<div class="row">
	<div class="container">
		<div class="col-md-7 videoinfo"> 
			<div class="col-md-6 picture">
				<img src="<?php echo $preview ?>" height="180" width="240">
			</div>
			<div class="col-md-6 title">
				<?php echo nl2br("$title  \n  $description")?>
				
			</div>
		</div>
		
		<?php if (isset($_GET['start']))
			  {
			  } else {
		?>
			<div class="col-md-3 col-md-offset-1 snippetbox">
				<div class="row">
					<h3> Create your own Clip!</h3>
				</div>
				<br> <div class="row">
					<div class="col-md-6">
						<button type="button" onclick = "startClip()" class="btn btn-primary btn-lg button">Start Clip</button>
					</div>
					<div class="col-md-6">
						<button type="button" onclick = "stopClip()" class="btn btn-primary btn-lg button">Stop clip</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						 <br> <button type="button" onclick = "createSnippet()" class="btn btn-primary btn-lg btn-block button">Create Snippet!</button>
					</div>
				</div>
			</div>
			<?php } ?>

	</div>
</div>
<?php
if (isset($_GET['start']))
  {
    $start = $_GET['start'];
    $starttime = round($start);
  } else {
  	$starttime = 0;
  }
if (isset($_GET['end']))
  {
    $endtime = $_GET['end'];
    $start = $_GET['start'];
    $end = $endtime - $start;
    $end = 1000 * $end;
    $end = round($end);

  } else {
  	$end = 99999999;
  }
 $videoid = $_GET['search'];
?>
<script type="text/javascript">
	var before = document.URL;
	var after = before.replace("http://jacksbeats.com/music.php?search=", "");
	var start = <?php echo $starttime ?>;
	var finalurl = "<iframe id='player' width='650' height='400' seamless src='http://www.youtube.com/embed/" + "<?php echo $videoid ?>" + "?rel=0&start=" + start + "&autoplay=1&version=3&enablejsapi=1&loop=1'>";
	$('.player').html(finalurl);
	//player.getDuration()


</script>



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
			var videourl = data.items[0].id.videoId;
			var video = "<iframe width='0' height='0' src='http://www.youtube.com/embed/" + data.items[0].id.videoId +"?autoplay=1'></iframe>";
			location.href="music.php?search=" + videourl;
		});
}
//Load YouTube Player API

var tag = document.createElement('script');
tag.src = "https://youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		endSeconds: 20,
		events: {
			'onStateChange': onPlayerStateChange
		}
	});
}

var done = false;
function onPlayerStateChange(event) {
	if(event.data == YT.PlayerState.PLAYING && !done) {
		setTimeout(stopVideo, <?php echo $end ?>);
		done = true;
	}
}

function stopVideo() {
	player.stopVideo();
}
function startClip() {
	starttime = player.getCurrentTime();
}
function stopClip() {
	stoptime = player.getCurrentTime();
}
function createSnippet(){
	var before = document.URL;
	var after = before.replace("http://jacksbeats.com/music.php?search=", "");
	location.href="music.php?search=" + after + "&start=" + starttime + "&end=" + stoptime;
}
$(document).ready(function(){
    $('.button').click(function(){
        $(this).toggleClass('active');
    });
});
</script>

</html>