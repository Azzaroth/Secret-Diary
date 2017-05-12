<?php 

	include("sqlcookiessessions.php");
	
	if (array_key_exists("content", $_POST)) {echo $_POST["content"];
		$checkQuery = "UPDATE `users` SET `diary` = (?) WHERE `email` = (?)";
	    $checkStmt = $link->prepare($checkQuery);
	    $checkStmt->bind_param("ss",$_POST["content"],$_SESSION["email"]);
	    $checkStmt->execute();
    }

    ?>