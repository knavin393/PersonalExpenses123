


<!DOCTYPE html>
<html lang="en">
<?php
   session_start();
  
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/icon?
family=Material+Icons+Outlined" rel="stylesheet">

  <title>Login Form</title>
</head>
<body>
  <div class="login-wrapper">


    <?php
  if(isset($_SESSION['userId'])) {
    echo '<form action="includes/logout.inc.php" method="post">
      <button type="submit" name="logout-submit">logout</button>
    </form>';

  }
  else{
    echo '<form action="includes/login.inc.php" class="form" method="post">
      <img src="img/avatar.png" alt="">
      <h2>Login</h2>

      <div class="input-group">
        <input type="text" name="mailuid" id="loginUser" required>
        <label for="loginUser">User Name</label>

      </div>
      <div class="input-group">
        <input type="password" name="pwd" id="loginPassword" required>
        <label for="loginPassword">Password</label>
        <span id="togglePassword" 
          class="material-icons-outlined">
           visibility</span>
      </div>
      <input type="submit" name="login-submit" value="Login" class="submit-btn"><br><br>
      <a href="#forgot-pw" class="forgot-pw">Forgotten Password</a> or 
      <a href="sign-up.php" class="forgot-pw">Sign Up</a>
    </form>';
    
  }
  ?>

    <?php
      if(isset($_GET["reset"])) {
        if($_GET["reset"] == "success") {
          echo '<p class="signupsuccess">Check your e-mail!</p>';
        }
      }
      ?>

 <?php

    if(isset($_GET["newpwd"])) {
      if($_GET["newpwd"] == "passwordupdated") {
        echo '<p class="signupsuccess">Your password has been reset!</p>';
      }
    }
    ?>
  
   <style>
.signupsuccess{

             position: absolute;
            text-align: center;
           margin-bottom: 11rem;
            color:yellow;
             font-weight:300;
            


          }
  </style>
 

<script>

const loginPassword = document.querySelector('#loginPassword')
        const btn = document.querySelector('#togglePassword')

        btn.addEventListener('click', () => {
            if (loginPassword.type === "text") {
               loginPassword.type = "password";
                btn.innerHTML = "visibility";
            } else {
                loginPassword.type = "text";
                btn.innerHTML = "visibility_off";

            }
        })

        </script>
  <style>

.material-icons-outlined{

 position: absolute;
  color: grey;
  cursor: pointer;
  margin: 0 -20px;

}


  </style>


    <div id="forgot-pw">

      <form action="includes/reset-request.inc.php" method="post" class="form">
        <a href="#" class="close">&times;</a>

        <h2>Reset Password</h2>

      

        <div class="input-group">
          <input type="email" name="email" id="email" required>
          <label for="email">Email</label>
        </div>
        <input type="submit" class="submit-btn" value="Submit" name="reset-request-submit"> 
        
      </form>


      




    </div>
  </div>
 
</body>
</html>