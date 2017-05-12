<?php

  include("sqlcookiessessions.php");

  if(array_key_exists("user_email", $_COOKIE) || array_key_exists("email", $_SESSION)) {
      header("Location: login.php");
      exit();

  } else if(!array_key_exists("user_email", $_COOKIE)) {
  if($_POST) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $checkQuery = "SELECT * FROM `users` WHERE `email` = (?) LIMIT 1";
    $checkStmt = $link->prepare($checkQuery);
    $checkStmt->bind_param("s",$email);
    $checkStmt->execute();

    $checkStmt->store_result();
    $checkStmt->bind_result($userId,$userEmail,$userPassword,$userDiary);

      if($checkStmt->fetch()) {
        $hashUserId = hash("md5", $userId, false);
        $hashCompare = hash("md5", $hashUserId.$password, false);
        if($hashCompare != $userPassword) {
          header("Location: registered.php?pass=true");
        } else {
             $_SESSION["email"] = $email;
            if(isset($_POST["check"])) {
             setcookie("user_email",$email,time() + 60*60); 
             header("Location: login.php");
             exit();
            }
           else {
             header("Location: login.php");
             exit();
         }
       }
      } else {
        $query = "INSERT INTO users (email,password) VALUES (?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute();

        $query2 = "SELECT `id` FROM `users` WHERE `email` = (?) LIMIT 1";
        $stmt2 = $link->prepare($query2);
        $stmt2->bind_param("s",$email);
        $stmt2->execute();

        $stmt2->store_result();
        $stmt2->bind_result($userId);

        while($stmt2->fetch()) {
          $hashId = hash("md5", $userId, false);
          $hashSaltedPassword = hash("md5", $hashId.$password, false);
          $hashQuery = "UPDATE `users` SET `password` = (?) WHERE `id` = (?) LIMIT 1";
          $hashStmt = $link->prepare($hashQuery);
          $hashStmt->bind_param("si",$hashSaltedPassword,$userId);
          $hashStmt->execute();

          header("Location: registered.php");
        }   
        
      }
  } else {
  }

  

  }

  include("header.php");

?>

  <body>

    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <div id="center-square">        
        <h1 class="display-3">TextShare</h1>
        <p class="lead">Sign up, log in and start sharing text.</p>
          <form method="POST">
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div id="warning-section"></div>
            <div class="form-check wrapper">
              <label class="form-check-label">
                <input type="checkbox" id="save" name="check" class="form-check-input">
                Stay logged in
              </label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-success wrapper-btn">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <?php 

     include("footer.php");

    ?>

    <script>

    function validEmail(email) {
      var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

      return regex.test(email);
    }

    function cleanWarnings() {
      $("#center-square").height(420);
      $("#warning-section").attr("class","");
      $("#warning-section").attr("role","");
      $("#warning-section").html("");
    }

    function errorMessage(error,errorCount) {
      $("#warning-section").attr("class","alert alert-danger");
      $("#warning-section").attr("role","alert");
      $("#warning-section").html(error);
      $("#center-square").height($("#center-square").height()+50+(20*errorCount));
    }

    $("form").submit(function(e) {

      cleanWarnings();

      var error = "";
      var errorCount = 0;

      if(!validEmail($("#email").val())) {
        error += "E-mail is not valid.<br>"; 
        errorCount++;
      }

      if($("#email").val() == "") {
        error += "Fill the following field: E-mail<br>";
        errorCount++;
      }

      if($("#password").val() == "") {
        error += "Fill the following field: Password<br>";
        errorCount++;
      }

      if(error != "") {
        e.preventDefault();
        errorMessage(error,errorCount);
        errorCount = 0;
      }
    });


    </script>



  </body>
</html>