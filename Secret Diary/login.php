<?php

  include("sqlcookiessessions.php");

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
	    	$diaryContent = $userDiary;
	    }
	} else {
		echo "You are not logged in.";
		header("Location: index.php");
		exit();
	}


	include("header.php");

?>


 <body>

 	<div class="jumbotron jumbotron-fluid">
      <div class="container">
        <div id="center-square"> 
        	<h3 style="margin-top: -10px; margin-bottom: 13px; color: white; text-align: center;">Hello, <? if($_SESSION["email"]) echo $_SESSION["email"]; ?>!</h3>
        	<form>
        	<textarea type="textarea" id="textareaid" name="textareaidname"><? if($diaryContent) echo $diaryContent; ?></textarea>
        	</form> 
        	<form method="POST">  
        	<input type="hidden" name="logout" value="log">
        	<button type="submit" style="margin-left: 174px; margin-top: 20px;" id="btnlogout" class="btn btn-success">Log out</button>
        	</form>
        </div>
      </div>
 	</div>

 	<?php 

   	 include("footer.php");

    ?>

    <script>

    	$("#textareaid").bind("input propertychange", function() {
    		$.ajax({
    			type: "POST",
    			url: "updatedb.php",
    			data: { content: $("#textareaid").val() }
    		});
    	});

    </script>

 </body>
 </html>