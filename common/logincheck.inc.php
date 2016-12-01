<?php 	
	// check if a valid user is set in session 
	if(empty($_SESSION["customer_user_id"])){
		header('Location:login2.php');
	}
?>	