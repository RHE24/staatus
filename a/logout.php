<?php
ob_start();
session_start();
require_once('config.php');
if($_SESSION['logged'] == 1 || isset($_SESSION['uid'])) {
	$_SESSION['logged'] = 0;
	unset($_SESSION['logged']);
	$_SESSION['uid'] = 0;
	unset($_SESSION['uid']);
	header("Location: login.php");
} else {
	header("Location: login.php");
}
?>