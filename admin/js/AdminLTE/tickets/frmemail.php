<?php
session_start();
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$username = $_REQUEST['username'];
$captchachode = $_REQUEST['captchachode'];


if(isset($_SESSION['captcha']) && ($_SESSION['captcha']['code']==$captchachode)){
	
	// multiple recipients
	$to = 'gary.ong@clickpro.com.my';
	
	// subject
	$subject = 'Moxian Registration';
	
	// message
	$message = '
	<html>
	<head>
	  <title>Moxian</title>
	</head>
	<body>
	  <p>Some is signup from Moxian.Please check the below details:-</p>
	  <table>
		<tr>
		  <th>Email:</th><th>'.$email.'</th>
		</tr>
		<tr>
		  <th>Password:</th><th>'.$password.'</th>
		</tr>
		<tr>
		  <th>Username:</th><th>'.$username.'</th>
		</tr>
		
	  </table>
	</body>
	</html>
	';
	
	//echo $message;
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: Mary <gary.ong@clickpro.com.my>' . "\r\n";
	$headers .= 'From: Moxian Registration <'.$email.'>' . "\r\n";
	
	// Mail it
	mail($to, $subject, $message, $headers);
	
	echo '1';	
	
}else{
	echo '0';
}
?>

