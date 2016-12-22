<?php
include_once('../common/config.php');
include_once('header.php');
$uid = $_GET['id'];
$sql = "SELECT * FROM `nato_saasu` WHERE id = '".$uid."'";
$data = $conn->query($sql); 
$accountData = $data->fetch_assoc();
$chkSql = "DELETE FROM `nato_saasu` WHERE id = '".$uid."'";
if($conn->query($chkSql)){
	$sassufileid = $accountData['saasufile'];
	$sql = "DELETE FROM `sassu_items` WHERE `sassu_file` = '".$sassufileid."'";
	$conn->query($sql);
	$sql = "DELETE FROM `sassu_contacts` WHERE `sassu_file` = '".$sassufileid."'";
	$conn->query($sql);
	$msgBox = alertBox("Account successfully deleted", "<i class='fa fa-ban'></i>", "success");
	$_SESSION['msg'] = $msgBox;
}
header("Location:".SITE_URL_ADMIN.'nato-saasu.php');
?>