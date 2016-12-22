<?php 
$db 	 		= "rfomca";
$password		= "Mkk@070189!";
$hostname		= "localhost"; 
$username 		= "rfomca";
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//die('aaaa');
$SITE_URL = 'http://139.162.22.238/html/sassuapi/';
define('SITE_URL',$SITE_URL);

$SITE_URL_ADMIN = 'http://139.162.22.238/html/sassuapi/admin/';
define('SITE_URL_ADMIN',$SITE_URL_ADMIN);


$conn = new mysqli($hostname, $username, $password);

if ($conn->connect_error) {
	echo "hello";
    die("Connection failed: " . $conn->connect_error);
} 
else
{
	//echo "success";
}
mysqli_select_db($conn,$db);
?>