<html>
<head>
    <title>User registration form</title>
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

<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<link rel="stylesheet" href="/static/css/style.css">
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
<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
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
require_once("db_const.php");
if (!isset($_POST['submit'])) {
?>    <!-- The HTML registration form -->
<form class="form-horizontal form-signin" action="<?=$_SERVER['PHP_SELF']?>" method="post">
  <label class="login-title">User Registration Form</label>
  <div class="control-group">

    <label class="control-label" for="inputEmail">Username</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="username" name="username">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password" name="password">
    </div>
  </div>
  <div class="control-group">

    <label class="control-label" for="inputEmail">First Name</label>
    <div class="controls">
      <input type="text" id="inputFirstName" placeholder="First Name" name="first_name">
    </div>
    <div class="control-group">

    <label class="control-label" for="inputEmail">Last Name</label>
    <div class="controls">
      <input type="text" id="inputLastName" placeholder="Last Name" name="last_name">
    </div>
    <div class="control-group">

    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="type" id="inputEmail" placeholder="Email" name="email">
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
## connect mysql server
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    # check connection
    if ($mysqli->connect_errno) {
        echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
        exit();
    }
## query database
    # prepare data for insertion
    $username    = $_POST['username'];
    $password    = sha1($_POST['password']);
    $first_name    = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $email        = $_POST['email'];
    $profilepic  = "defaultprofile.jpg";
    # check if username and email exist else insert
    $exists = 0;
    $result = $mysqli->query("SELECT username from users WHERE username = '{$username}' LIMIT 1");
    if ($result->num_rows == 1) {
        $exists = 1;
        $result = $mysqli->query("SELECT email from users WHERE email = '{$email}' LIMIT 1");
        if ($result->num_rows == 1) $exists = 2;    
    } else {
        $result = $mysqli->query("SELECT email from users WHERE email = '{$email}' LIMIT 1");
        if ($result->num_rows == 1) $exists = 3;
    }
 
    if ($exists == 1) echo "<p>Username already exists!</p>";
    else if ($exists == 2) echo "<p>Username and Email already exists!</p>";
    else if ($exists == 3) echo "<p>Email already exists!</p>";
    else {
        # insert data into mysql database
        $sql = "INSERT  INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `profilepic`) 
                VALUES (NULL, '{$username}', '{$password}', '{$first_name}', '{$last_name}', '{$email}', '{$profilepic}')";
 
        if ($mysqli->query($sql)) {
            //echo "New Record has id ".$mysqli->insert_id;
            echo "<p>Registred successfully!</p>";
            header("Location: index.php");
        } else {
            echo "<p>MySQL error no {$mysqli->errno} : {$mysqli->error}</p>";
            exit();
        }
    }
}
?>        
</div>
</body>


</html>