<?php
require_once('header/dbconnection.php');
$registration = $_POST['registration'] ? $_POST['registration'] : '';
if($registration == md5("tlraddsubmit")){
	$clientname = $_POST['clientname'] ? $_POST['clientname'] : '';
	$email = $_POST['email'] ? $_POST['email'] : '';
	$password = $_POST['password'] ? $_POST['password'] : '';
	$confirmpassword = $_POST['confirmpassword'] ? $_POST['confirmpassword'] : '';
	$phonenumber = $_POST['phonenumber'] ? $_POST['phonenumber'] : '';
	$address = $_POST['address'] ? $_POST['address'] : '';
	$countryId = $_POST['country'] ? $_POST['country'] : '101';
	$stateId = $_POST['state'] ? $_POST['state'] : '';
	$cityId = $_POST['city'] ? $_POST['city'] : '';
	$description = $_POST['description'] ? $_POST['description'] : '';
	$spoccontact = $_POST['spoccontact'] ? $_POST['spoccontact'] : '';
	$websiteurl = $_POST['websiteurl'] ? $_POST['websiteurl'] : '';
	$clientspoc = $_POST['clientspoc'] ? $_POST['clientspoc'] : '';
	$iprimedspocClient = $_POST['iprimedspocClient'] ? $_POST['iprimedspocClient'] : '';
	$companyname = $_POST['companyname'] ? $_POST['companyname'] : '';
	$masterPassword = MD5("admin99@");
	$password = MD5($password);
	if (move_uploaded_file($_FILES["uploadContract"]["tmp_name"],
	      "uploadsow/" . $_FILES["uploadContract"]["name"])){
		  $uploadContract = "uploadsow/" . $_FILES["uploadContract"]["name"];
	}else{
		$uploadContract = '';
	}
	$insertSql = "insert into tlr_client (`clientName`, `email`, `password`, `address`, `countryId`, `stateId`, `cityId`, `description`, `spocContact`, `mobile`, `clientWebsite`, `clientSpoc`, `iprimedspocClient`, `uploadContract`,`companyName`, `masterPassword`,`isDeleted`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$resultRow = pdoQuery($insertSql,array($clientname,$email,$password,$address,$countryId,$stateId,$cityId,$description,$spoccontact,$phonenumber,$websiteurl,$clientspoc,$iprimedspocClient,$uploadContract,$companyname,$masterPassword,'N'));
	if($resultRow){
		$message = "success";
		}else{
			$message = "error";
		}
	header('location:clientregistration.php?message='.md5($message));

}else if($registration == md5("tlreditsubmit")){

	$clientId = $_POST['clientId'] ? $_POST['clientId'] : '';
	$clientname = $_POST['clientname'] ? $_POST['clientname'] : '';
	$email = $_POST['email'] ? $_POST['email'] : '';
	$phonenumber = $_POST['phonenumber'] ? $_POST['phonenumber'] : '';
	$address = $_POST['address'] ? $_POST['address'] : '';
	$countryId = $_POST['country'] ? $_POST['country'] : '101';
	$stateId = $_POST['state'] ? $_POST['state'] : '';
	$cityId = $_POST['city'] ? $_POST['city'] : '';
	$description = $_POST['description'] ? $_POST['description'] : '';
	$spoccontact = $_POST['spoccontact'] ? $_POST['spoccontact'] : '';
	$websiteurl = $_POST['websiteurl'] ? $_POST['websiteurl'] : '';
	$clientspoc = $_POST['clientspoc'] ? $_POST['clientspoc'] : '';
	$iprimedspocClient = $_POST['iprimedspocClient'] ? $_POST['iprimedspocClient'] : '';
	$companyname = $_POST['companyname'] ? $_POST['companyname'] : '';
	$uploadContractexist = $_POST['uploadContractexist'] ? $_POST['uploadContractexist'] : '';
	if(empty($uploadContractexist)){

		if (move_uploaded_file($_FILES["uploadContract"]["tmp_name"],
		      "uploadsow/" . $_FILES["uploadContract"]["name"])){
			$uploadContract = "uploadsow/" . $_FILES["uploadContract"]["name"];
		}else{
			$uploadContract = '';
		}
	}else{
		$uploadContract = $uploadContractexist;
	}
	$editquery = "UPDATE tlr_client SET clientName = ?,`email` = ?,`address` = ?,`countryId` = ?,`stateId` = ?,`cityId` = ?,`description` = ?,`spocContact` = ?,`mobile` = ?,`clientWebsite` = ?,`clientSpoc` = ?,`iprimedspocClient` = ?,uploadContract = ?, companyName =?  WHERE `id` = ? and `isDeleted` = ?";
	$resultRow = pdoQuery($editquery,array($clientname,$email,$address,$countryId,$stateId,$cityId,$description,$spoccontact,$phonenumber,$websiteurl,$clientspoc,$iprimedspocClient,$uploadContract,$companyname,$clientId,'N'));
	if($resultRow){
		$message = "success";
		}else{
			$message = "error";
		}
	header('location:clientgridregistration.php?message='.md5($message));
}else{
	if(!empty($_GET['did'])){
		$id =encrypt_decrypt('decrypt',$_GET['did']);
		$clientdelquery = "UPDATE tlr_client SET isDeleted = ? WHERE `id` = ? and `isDeleted` = ? limit 1";
		$resultRow = pdoQuery($clientdelquery,array('Y',$id,'N'));
		if($resultRow){
			$message = "dsuccess";
		}else{
			$message = "error";
		}
		header('location:clientgridregistration.php?message='.md5($message));
	}else{

	}
	
}
?>