


<?php
if (isset($_POST['signup-submit'])) {

	
	//Get Heroku ClearDB connection information
	$cleardb_url = parse_url(getenv("https://www.cleardb.com/service/1.0/api"));
	$cleardb_server = $cleardb_url["us-cdbr-east-06.cleardb.net"];
	$cleardb_username = $cleardb_url["bf71fc7d365bc5"];
	$cleardb_password = $cleardb_url["bcf9e4f3"];
	$cleardb_db = substr($cleardb_url["path"],1);
	$active_group = 'default';
	$query_builder = TRUE;
	// Connect to DB
	$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
	

$username = $_POST['uid'];
$email = $_POST['mail'];
$password = $_POST['pwd'];
$passwordRepeat = $_POST['pwd-repeat'];

if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){

	header("Location: ../sign-up.php?error = emptyfields&uid=".$username."&mail=".$email);
	exit();
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
	header("Location: ../sign-up.php?error=invalidmailuid");
	exit();

}

else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	header("Location: ../sign-up.php?error=invalidmail&uid=".$username);
	exit();

}
else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
	header("Location: ../sign-up.php?error=invaliduid&mail=".$email);
	exit();

}
else if($password !== $passwordRepeat) {
	header("Location: ../sign-up.php?error=passwordcheck&uid=".$username."&mail=".$email);
	exit();

}

else{
	$sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../sign-up.php?error=sqlerror");
	exit();

	}
	else {
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt);
		if ($resultCheck > 0) {
			header("Location: ../sign-up.php?error=usertaken&mail=".$email);
			exit();

		}


		else{
			$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?,?,?)";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../sign-up.php?error=sqlerror");
		exit();
		}

		
		else{
			$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

		mysqli_stmt_bind_param($stmt, "sss", $username, $email,  $hashedPwd);
		mysqli_stmt_execute($stmt);
		header("Location: ../sign-up.php?signup=success");
		
		exit();
		
		}
	}
}
}









	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../sign-up.php");
		exit();
		
}
?>