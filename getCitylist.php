<?php 
require_once('header/dbconnection.php');
$stateId = !empty($_POST['stateId']) ? $_POST['stateId'] : '';
if(!empty($stateId)){

	$citySql = "select * from tlr_cities where isDeleted= ? and stateId = ?";
	$totalResult = pdoQuery($citySql,array('N',$stateId));
	$data = array(); $cities = '<option selected>select city</option>';
	foreach ($totalResult as $name) { 
       $cities .= '<option value="'.$name['id'].'">'.$name['cityName'].'</option>';
    }
    $data['cities'] = $cities;
    //header('HTTP/1.1 Success'); 
}else{

}
echo json_encode($data);
die;
?>