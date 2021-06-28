<?php 
require_once('header/dbconnection.php');
error_reporting(0);
if($_GET['message']==md5('success')){
  $message = '<div class="alert alert-success" role="alert">You have successfully updated.</div>';
}else if($_GET['message']==md5('dsuccess')){
  $message = '<div class="alert alert-success" role="alert">You have successfully deleted.</div>';
}else if($_GET['message']==md5('error')){
  $message = '<div class="alert alert-danger" role="alert">Something went wrong please try again!</div>';
}
$pageno = !empty($_GET['pageno']) ?  $_GET['pageno'] : 1;
$fixlimit = !empty($_REQUEST['fixlimit']) ?  $_REQUEST['fixlimit'] : 1;
$limit = !empty($_REQUEST['fixlimit']) ?  $_REQUEST['fixlimit'] : 1;
$filterColumn = !empty($_REQUEST['filterColumn']) ?  $_REQUEST['filterColumn'] : '';
$filterValue = !empty($_REQUEST['filterValue']) ?  $_REQUEST['filterValue'] : '';
$condition = '';
if(!empty($filterColumn) && !empty($filterValue)){
   if($filterColumn == 'clientName' || $filterColumn == 'clientSpoc' || $filterColumn == 'iprimedspocClient'){
    $condition = "and $filterColumn like '%$filterValue%'";
  }else if($filterColumn == 'email'){
    $condition = "and $filterColumn ='$filterValue'";
  }
}
$totalSql = "select * from tlr_client where isDeleted= ? $condition";
$totalResult = pdoQuery($totalSql,array('N'));
$totalCount = count($totalResult);
$totalPages = ceil($totalCount/$limit);
if($pageno == 1){
  $pageno = 0;
}else{
  $pageno = ($pageno-1)*$limit;
  $limit = $pageno*$limit;
}
$regeditSql = "select * from tlr_client where isDeleted= ? $condition limit ".$pageno.','.$limit;
$resultRow = pdoQuery($regeditSql,array('N'));
require_once('header/header.php');
if(!empty($message)) echo $message; 
?>
 <div class="col-md-3"><a href="clientregistration.php" class="btn btn-primary">Add New registration</a></div>
<div class="row">
  <div class="col-md-1 cmtop">
    <form method="POST" id="limitform" name="limitform">
      <select name="fixlimit" id="fixlimit" class="form-control" onchange="limitChanged(this.value);"> 
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </form>
  </div>
   <div class="col-md-2 cmtop">
         <form method="POST" id="filterform" name="filterform">
        <select name="filterColumn" class="form-control" id="filterColumn"> 
           <option value="">---select---</option>
          <option value="clientName">Client Name</option>
          <option value="email">Email</option>
          <option value="clientSpoc">SPOC</option>
          <option value="iprimedspocClient">iprimed SPOC Client</option>
        </select>
      </div>
      <div class="col-md-2 cmtop">
        <input type="text" name="filterValue" class="form-control" id="filterValue" value="<?php echo $filterValue; ?>" />
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary cmtop">Search</button>
      </div>
    </form>
    </div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Client Name</th>
      <th scope="col">Email Address</th>
      <th scope="col">Mobile No.</th>
      <th scope="col">SPOC Contact</th>
      <th scope="col">IPRIMED SPOC for client(Lead)</th>
       <th scope="col">Actions</th>
    </tr>
  </thead>
   <tbody>
  <?php
   $k=1;
  if(count($resultRow) > 0 ){
  
    foreach ($resultRow as $rows) {
      $clientId = encrypt_decrypt('encrypt',$rows['id'])
      ?>
      <tr>
          <th scope="row"><?php echo $k; ?></th>
          <td><?php echo $rows['clientName']; ?></td>
          <td><?php echo $rows['email']; ?></td>
          <td><?php echo $rows['mobile']; ?></td>
          <td><?php echo $rows['spocContact']; ?></td>
          <td><?php echo $rows['iprimedspocClient']; ?></td>
          <td><a href="clienteditregistration.php?eid=<?php echo encrypt_decrypt('encrypt',$rows['id']); ?>" title="edit"><span class="material-icons-round">edit</span></a> | <a href="#" onClick="javascript:deleteconfirmation('<?php echo $clientId; ?>');" title="Delete"><span class="material-icons-round">delete</span></a>
          </td>
      </tr>
<?php $k++;
       }

     }
    ?>
 </div></div>
 <tr>
    <td colspan="7">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
    <?php if($totalPages > 0){ 
              if($pageno > 0){ ?>
                 <li class="page-item">
                <a href="clientgridregistration.php?pageno=1&fixlimit=<?php echo $fixlimit; ?>" class="page-link"> Previous </a></li>
           <?php   }
          for($i=0;$i<$totalPages;$i++){  ?>
               <li class="page-item"> <a href="clientgridregistration.php?pageno=<?php echo $i+1; ?>&fixlimit=<?php echo $fixlimit; ?>" class="page-link"><?php echo $i+1; ?></a></li>
            <?php } 
             if($totalPages > $pageno+1){ ?>
               <li class="page-item">  <a href="clientgridregistration.php?pageno=<?php echo $totalPages; ?>&fixlimit=<?php echo $fixlimit; ?>" class="page-link"> Next </a> </li>
           <?php   }
          } ?>
      </td>
    </tr>
 </tbody>
</table>
<script type="text/javascript">
  function limitChanged(limit){
     document.getElementById('limitform').submit();
  }
  
</script>
<script type="text/javascript" src="js/registration.js"></script>