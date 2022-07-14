<?php
   session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/icon?
family=Material+Icons+Outlined" rel="stylesheet">
 
  <title>Sign-up Form</title>
</head>
<body>
  <div class="login-wrapper">


    <form action="includes/signup.inc.php" class="form" method="POST">
      <img src="img/avatar.png" alt="">
      <h2>Sign-Up</h2>



      <?php
      $signupMessage = isset($_GET['signup']) ? $_GET['signup'] : null;
     

    if (isset($_GET['error'])) {
      if ($_GET['error'] == "emptyfields") {

        echo'<p class="signuperror">Fill in all fields !</p>';      
      }
      else if($_GET["error"] == "invaliduidmail") {
        echo'<p class="signuperror">Invalid username and e-mail !</p>'; 

      }
       else if($_GET["error"] == "invaliduid") {
        echo'<p class="signuperror">Invalid username !</p>'; 

      }
       else if($_GET["error"] == "invalidmail") {
        echo'<p class="signuperror">Invalid e-mail !</p>'; 

      }
       else if($_GET["error"] == "passwordcheck") {
        echo'<p class="signuperror">Your password do not match !</p>'; 

      }
       else if($_GET["error"] == "usertaken") {
        echo'<p class="signuperror">Username is already taken !</p>'; 

      }
    }
   
  else if($signupMessage == "success"){
    echo '<p class="signupsuccess" >signup successful !</p>';
  }

  ?>

  <style>
          .signuperror{

            position: relative;
            text-align: center;
            margin: 20px;
            color:yellow;
             font-weight:300;


          }
          .signupsuccess{

             position: relative;
            text-align: center;
            margin: 20px;
            color:yellow;
             font-weight:500;

          }



  </style>


      <div class="input-group">
        <input type="text" name="uid" id="loginUser" required="">
        <label for="loginUser">User Name</label>
      </div>
      <div class="input-group">
        <input type="Email" name="mail" id="Enter email id" required="">
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <input type="password" name="pwd" id="password" required="">
        <label for="loginPassword">Password</label>
         <span id="togglePassword" 
          class="material-icons-outlined">
           visibility</span>
           <div class="pw-strength">
      <span>Weak</span>
      <span></span>
    </div><br>




<style>

.input-group .pw-strength {
  position:relative;
  border-radius: 0 0 5px 5px;
  height:5px;
  margin-top:-30px;
  text-align:center;
  background:#7d7d7d;
  display:none;
}


.input-group .pw-strength span:nth-child(1) {
  position:relative;
  font-size:12px;
  color:#fff;
  top:3px;
  font-weight:600;

}

.input-group .pw-strength span:nth-child(2) {
  position:absolute;
  top:0px;
  left:0px;
  width:0%;
  height:100%;
  border-radius: 0 0 5px 5px;
  z-index:1;
  transition:all 300ms ease-in-out;
}


  </style>



       <div class="input-group">

        <input type="password" name="pwd-repeat" id="Re-EnterPassword" required="">

        <label for="loginPassword">Re-Enter Password</label>

      </div>
    </div>
         
         <input type="submit" name="signup-submit" value="Signup" class="submit-btn"><br><br>
         <a href="index.php" class="forgot-pw">Already have an account ?</a> 
    </form>

</div>

  <style>

.material-icons-outlined{

 position: absolute;
  color: grey;
  cursor: pointer;
  margin: 0 -20px;

}


  </style>

<script src="js/togglejs.js"></script>
</body>
</html>