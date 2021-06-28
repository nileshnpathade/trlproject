<?php
require_once('header/dbconnection.php');
$email = $_POST['email'] ? $_POST['email'] : '';
$password = $_POST['password'] ? $_POST['password'] : '';
if(!empty($email) && !empty($password)){
	$password = MD5($password);
	$loginSql = "select * from tlr_client where email = ? and password = ? and isDeleted= ?";
	$resultRow = pdoQuery($loginSql,array($email,$password,'N'));
	if(count($resultRow) < 0){
		$loginSql = "select * from tlr_sourcingteam where email = ? and password = ? and isDeleted= ?";
		$resultRow = pdoQuery($loginSql,array($email,$password,'N'));
	}
	if(count($resultRow) > 0){
		header('location:clientgridregistration.php');
		die;
	}else{
		$message = MD5('error');
		header('location:login.php?message='.$message);
		die;
	}
}else{
	$message = MD5('error');
	header('location:login.php?message='.$message);
	die;
}

?>
