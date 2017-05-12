<?php

	if($_GET) {
		echo 'You submitted a wrong password, try again.';
	} else {
		echo '<p>No register was found using that e-mail, we have just created one for you ;)!</p>';
	}


?>

<html>

<head>
</head>




<body>

	
	<form action="index.php">
		<input type="submit">Click</input> here to go back to login page.
	</form>

</body>



</html>