<?php 
require_once('header/dbconnection.php');
$countryId = !empty($_POST['countryId']) ? $_POST['countryId'] : '';
if(!empty($countryId)){

	$stateSql = "select * from tlr_states where isDeleted= ? and countryId = ?";
	$totalResult = pdoQuery($stateSql,array('N',$countryId));
	$data = array(); $states = '<option selected>select state</option>';
	foreach ($totalResult as $name) { 
       $states .= '<option value="'.$name['id'].'">'.$name['stateName'].'</option>';
    }
    $data['states'] = $states;
    //header('HTTP/1.1 Success'); 
}else{

}
echo json_encode($data);
die;
?>