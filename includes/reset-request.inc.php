<?php
use PHPMailer\PHPMailer\PHPMailer;  
if(isset($_POST["reset-request-submit"])) {

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = "http://localhost/fyp/fyp/create-new-password.php?selector=" .$selector . "&validator=" . bin2hex($token);

$expires = date("U") + 1800;

require '../dbconfigs/dbh.inc.php';
$userEmail = $_POST["email"];

$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt,$sql)) {

	echo "There was an error!";
	exit();
} else{

	mysqli_stmt_bind_param($stmt, "s", $userEmail);
	mysqli_stmt_execute($stmt);


}

$sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt,$sql)) {

	echo "There was an error!";
	exit();
} else{

	$hashedToken = password_hash($token, PASSWORD_DEFAULT);
	mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
	mysqli_stmt_execute($stmt);


}

mysqli_stmt_close($stmt);
mysqli_close($conn);

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$mail = new PHPMailer();

//SMTP Settings
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = 
$mail->Password = 
$mail->Port = 465;
$mail->SMTPSecure = "ssl";

//Email Settings
$mail->isHTML(true);
$mail->setFrom("knavin393@gmail.com", "Navin Login");
$mail->addAddress($userEmail);
//$mail->AddAttachment($file_name);
$mail->Subject = ("Reset your password for localhost");
$mail->Body =   "We received a password reset request. The link to reset your password is below if you did not make this request, you can ignore this email $url" ;


					

					
if ($mail->send() ) {
	
	header("Location: ../index.php?reset=success");
	
} else {
	echo "Email failed";
}


} else{

	header("Location: ../index.php");
}
