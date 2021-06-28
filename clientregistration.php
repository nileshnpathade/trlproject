<?php 
require_once('header/dbconnection.php');
require_once('header/header.php');
require_once('header/registrationHeader.php');
error_reporting(0);
if($_GET['message']==md5('success')){
  $message = '<div class="alert alert-success" role="alert">You have successfully registered.</div>';
}else if($_GET['message']==md5('error')){
  $message = '<div class="alert alert-danger" role="alert">Something went wrong please try again!</div>';
}
$contrySql = "select * from tlr_countries where isDeleted= ?";
$totalResult = pdoQuery($contrySql,array('N'));
 ?>
    <div class="col-md-12">
			<?php if(!empty($message)) echo $message;   ?>
            <form action="clientregistrationsubmit.php" method="post" id="fileForm" role="form" enctype="multipart/form-data">
            <h2>Client Registration</h2>
            <fieldset><legend class="mandateinfo">Valid information is required to register. <span class="req"><small> required *</small></span></legend>

             <div class="form-group col-md-6">   
                <label for="clientname"><span class="req">* </span> Client name: </label>
                    <input class="form-control" type="text" name="clientname" id = "txt" onkeyup = "Validate(this)" required placeholder="Client name" /> 
                        <div id="errClient"></div>    
            </div>

            <div class="form-group col-md-6">
                <label for="email"><span class="req">* </span> Email Address: </label> 
                    <input class="form-control" required type="text" name="email" id = "email"  onchange="email_validate(this.value);" placeholder="Enter valid email address" />   
                        <div class="status" id="status"></div>
            </div>

            <div class="form-group col-md-6">
                <label for="password"><span class="req">* </span> Password: </label>
                    <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16"  id="pass1" placeholder="Password" />
            </div>
             <div class="form-group col-md-6">

                <label for="confirmpassword"><span class="req">* </span> Password Confirm: </label>
                    <input required name="confirmpassword" type="password" class="form-control inputpass" minlength="4" maxlength="16" placeholder="Enter again to validate"  id="pass2" onkeyup="checkPass(); return false;" />
                        <span id="confirmMessage" class="confirmMessage"></span>
            </div>

            <div class="form-group col-md-6">
            <label for="phonenumber"><span class="req">* </span> Mobile Number: </label>
                    <input required type="text" name="phonenumber" id="phone" class="form-control phone" maxlength="10" onkeyup="validatephone(this);" placeholder="enter mobile number ex 1234567890"/> 
            </div>

           
            <div class=" form-group md-form amber-textarea active-amber-textarea col-md-6">
               <label for="address"><span class="textaddress">* </span>Address: </label> 
              <textarea id="form19" class="md-textarea form-control" name="address" rows="3" placeholder="Enter your address"></textarea>
            </div>

            <div class="form-group col-md-6">
            <label for="country"><span class="req">* </span> Country: </label>
                    <select class="form-control getstatelistclass" name="country" id="country" required>
                      <option selected>select country</option>
                      <?php foreach ($totalResult as $name) { ?>
                       <option value="<?php echo $name['id']; ?>"><?php echo $name['countryName']; ?></option>
                      <?php }  ?>
                    </select>
            </div>

            <div class="form-group col-md-6">
            <label for="state"><span class="req">* </span> State: </label>
                    <select class="form-control getCitylistclass" name="states" id="states" required>
                    <option selected>select state</option>
                    </select>
            </div>

            <div class="form-group col-md-6">
            <label for="city"><span class="req">* </span> City: </label>
                   <select class="form-control" name="city" id="city" required>
                      <option selected>select city</option>
                    </select>
            </div>

              <div class=" form-group md-form amber-textarea active-amber-textarea col-md-6">
               <label for="description"><span class="textdescription">* </span>Description: </label> 
              <textarea id="form19" class="md-textarea form-control" name="description" rows="3" placeholder="Enter your description"></textarea>
            </div>

            <div class="form-group col-md-6">
            <label for="spoccontact"><span class="req">* </span> SPOC Contact: </label>
                    <input required type="text" name="spoccontact" id="spoccontact" class="form-control" maxlength="28" onkeyup="validate(this);" placeholder="not used for marketing"/> 
            </div>

            <div class="form-group col-md-6">
            <label for="websiteurl"><span class="req">* </span> Website url: </label>
                    <input required type="text" name="websiteurl" id="websiteurl" class="form-control" placeholder="enter client websitre url example google.com"/> 
            </div>

              <div class="form-group col-md-6">
                <label for="clientspoc"><span class="req">* </span> Client SPOC: </label> 
                    <input class="form-control" type="text" name="clientspoc" id = "clientspoc" onkeyup = "Validate(this)" placeholder="Client SPOC" required />  
                        <div id="errclientspoc"></div>
            </div>

          

            <div class="form-group col-md-6">   
                <label for="iprimedspocClient"><span class="req">* </span> IPRIMED SPOC for client(Lead): </label>
                    <input class="form-control" type="text" name="iprimedspocClient" id = "txt" onkeyup = "Validate(this)" required placeholder="IPRIMED SPOC for client(Lead)" /> 
                        <div id="erriprimedspocClient"></div>    
            </div>

            <div class="form-group col-md-6">   
                <label for="companyname"><span class="req">* </span> Company Name: </label>
                    <input class="form-control" type="text" name="companyname" id = "txt" onkeyup = "Validate(this)" required placeholder="Company name" /> 
                <div id="errCompanyname"></div>  
                
            </div>

            <div class="form-group col-md-6">
            <label for="uploadContract">Upload Contract/SOW: </label>
                   <input type="file" class="form-control"  name="uploadContract" required />
                    <div id="erruploadContract"></div>
            </div>

           <div class="form-group col-md-6"> 
                <input type="checkbox" required name="terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" id="field_terms">   <label for="terms">I agree with the <a href="terms.php" title="You may read our terms and conditions by clicking on this link">terms and conditions</a> for Registration.</label><span class="req">* </span>
                <?php $regs = md5("tlraddsubmit"); ?>
                <input type="hidden" name="registration" value="<?php echo $regs; ?>" />  
            </div>
           
            <div class="form-group btnleft">
                <input class="btn btn-primary" type="submit" name="submit_reg" value="Register">
            </div>
            </fieldset>
            </form><!-- ends register form -->

<script type="text/javascript">
  document.getElementById("field_terms").setCustomValidity("Please indicate that you accept the Terms and Conditions");
</script>
        </div><!-- ends col-6 -->
<script type="text/javascript" src="js/registration.js?v=3"></script>