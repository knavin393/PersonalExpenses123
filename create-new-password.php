
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

 <title>Reset Password</title>
</head>
<body>

<main>
	<div class="login-wrapper">
		<Section class="form">


			<?php
			$selector =$_GET["selector"];
			$validator =$_GET["validator"];

			if (empty($selector) || empty($validator)) {
				echo "could not validate your request!";
			} 
			else {
				if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {


				?>
				 <img src="img/avatar.png" alt="">
      <h2>Reset Password</h2>

				<form action="includes/reset-password.inc.php" method="post">

					<div class="input-group">

					<input type="hidden" name="selector" value="<?php echo $selector ?>">
					<input type="hidden" name="validator" value="<?php echo $validator ?>">
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
					<label for="loginPassword">Re-Enter Password</label></div></div>

				
				<input type="submit" name="reset-password-submit" value="Reset" class="submit-btn"><br><br>
				</form>

				


  <style>

.material-icons-outlined{

 position: absolute;
  color: grey;
  cursor: pointer;
  margin: 0 -20px;

}


  </style>

				<?php


				}
			}

			?>
			
			

		</Section>
	</div>
</main>

<script src="togglejs.js"></script>
</body>
</html>
