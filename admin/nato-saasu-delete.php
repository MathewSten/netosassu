<?php
include_once('../common/config.php');
include_once('header.php');
$uid = $_GET['id'];
$chkSql = "DELETE FROM `nato_saasu` WHERE id = '".$uid."'";
if($conn->query($chkSql)){
	$msgBox = alertBox("Account successfully deleted", "<i class='fa fa-ban'></i>", "success");
	$_SESSION['msg'] = $msgBox;
}
header("Location:".SITE_URL_ADMIN.'nato-saasu.php');
?>