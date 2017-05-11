<?php

  $dburl = "param";
  $dbname = "param";
  $dbpassword = "param";
  $dbuser = "param";

  $link = mysqli_connect($dburl, $dbname, $dbpassword, $dbuser);

  if (mysqli_connect_error()) {
    die("There was an error connecting to the database.");
  }

  session_start();

	if(array_key_exists("user_email", $_COOKIE) || array_key_exists("email", $_SESSION)) {

		if($_POST) {
			if($_POST["logout"] == "log") {
				unset($_SESSION["email"]);
				setcookie("user_email","",time() - 60*60);
				header("Location: index.php");
				exit();
			}
		}

		$email = $_SESSION["email"];
		$checkQuery = "SELECT `email`,`diary` FROM `users` WHERE `email` = (?) LIMIT 1";
	    $checkStmt = $link->prepare($checkQuery);
	    $checkStmt->bind_param("s",$email);
	    $checkStmt->execute();

	    $checkStmt->store_result();
	    $checkStmt->bind_result($userEmail,$userDiary);

	    while($checkStmt->fetch()) {
	    	echo $userDiary;
	    }
	} else {
		echo "You are not logged in.";
		header("Location: index.php");
	}


?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

 </head>

 <body>


 	<form method="POST">
 		<input type="hidden" name="logout" value="log">
 		<button type="submit">Log out
 	</form>





 	 <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>






 </body>
 </html>