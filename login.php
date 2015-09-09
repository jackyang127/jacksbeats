<html>
<head>
    <title>User Login Form</title>
</head>
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

<link rel="stylesheet" href="/bootstrap.min.css">
<link rel="stylesheet" href="/style.css">
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap-transition.js"></script>
<script src="../assets/js/bootstrap-alert.js"></script>
<script src="../assets/js/bootstrap-modal.js"></script>
<script src="../assets/js/bootstrap-dropdown.js"></script>
<script src="../assets/js/bootstrap-scrollspy.js"></script>
<script src="../assets/js/bootstrap-tab.js"></script>
<script src="../assets/js/bootstrap-tooltip.js"></script>
<script src="../assets/js/bootstrap-popover.js"></script>
<script src="../assets/js/bootstrap-button.js"></script>
<script src="../assets/js/bootstrap-collapse.js"></script>
<script src="../assets/js/bootstrap-carousel.js"></script>
<script src="../assets/js/bootstrap-typeahead.js"></script>
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
</style>

<body>

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
      <ul class="nav navbar-nav loginstuff">
        <li>
          <a href="/register.php">Register</a>
        </li>
        </li>
        <li>
          <a href="/login.php">Login</a>
        </li>

      </ul>
    </nav>
  </div>
</header>



<div class="row buffer"> </div>


<?php
if (!isset($_POST['submit'])){
?>
<form class="form-horizontal form-signin" action="<?=$_SERVER['PHP_SELF']?>" method="post">
  <div class="control-group">

    <label class="control-label username-login" for="inputEmail">Username</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="username" name="username">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label password-login" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password" name="password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn" name="submit" value="Login">Sign in</button>
      <a class="btn" name="back" value="back" href="http://jacksbeats.com">
            Back
        </a>

    </div>

    </div>
</form>


<?php
} else {
    require_once('db_constant.php');
  $con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
  if (!$con) {
      die("could not connect: " . mysql_error());
  }

  $db_selected = mysql_select_db( "video", $con);
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

 
    $sql = "SELECT * from users WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
    $result = mysql_query($sql, $con);
    if (mysql_num_rows($result) != 1) {
        echo "<p>Invalid username/password combination</p>";
    } else {
        ##$sql2 = "SELECT id from users WHERE username = $username AND password = $password";
        $row3 = mysql_fetch_array($result);
        $userid = $row3['id'];


        header("Location: community.php");
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        

        $_SESSION['id'] = $userid;
        
        // do stuffs
    }
}
?>        
</body>