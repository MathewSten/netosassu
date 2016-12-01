<?php
include_once('../common/config.php');
session_unset($_SESSION['user_name']);
session_destroy();
header("Location:".SITE_URL_ADMIN.'login.php');
 ?>