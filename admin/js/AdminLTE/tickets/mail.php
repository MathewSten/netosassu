<?php

// multiple recipients
	$to = 'mr.bhupi@gmail.com';
	
	// subject
	$subject = 'Moxian Signup Details';
	
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
		  <th>Email:</th><th>test</th>
		</tr>
		<tr>
		  <th>Password:</th><th>test</th>
		</tr>
		<tr>
		  <th>Username:</th><th>test</th>
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
	$headers .= 'To: Mary <mr.bhupi@gmail.com>' . "\r\n";
	$headers .= 'From: Moxian Signup <phpstn@gmail.com>' . "\r\n";
	
	// Mail it
	mail($to, $subject, $message, $headers);
	echo "sent";
?>
