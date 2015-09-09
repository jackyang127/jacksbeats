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

   // Configuration - Your Options
      $allowed_filetypes = array('.jpg','.gif','.bmp','.png','.PNG', '.JPG', '.GIF'); // These will be the types of file that will pass the validation.
      $max_filesize = 5242880; // Maximum filesize in BYTES (currently 05MB).
      $upload_path = 'images/'; // The place the files will be uploaded to (currently a 'files' directory).
 
   $filename = $_FILES['filename']['name']; // Get the name of the file (including file extension).
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die('The file you attempted to upload is not allowed.');
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['filename']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['filename']['tmp_name'],$upload_path . $filename))
         echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
      else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
 

  require_once('db_const.php');
 $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  #$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME_URL);

  $sql = "UPDATE users SET profilepic = '$filename' WHERE id = '$userid'";
  $mysqli->query($sql);
  if (!result) die ("Database access failed: " . mysql_error());
?>