<?php require_once('header/loginHeader.php');
error_reporting(0); 
$message =  $_GET['message'] ? $_GET['message'] : ''; 
if($message == md5('error')){
  $message = "Invalid username or password";
}
?>
  <body>
    <div class="container login-container">
      <div>
        <h1 class="text-center">Welcome to TLR Portal</h1>
        <h3 class="text-center mt-5 mb-5">Login</h3>
        <?php if(!empty($message)) echo '<div class="alert alert-danger" role="alert">'.$message.'</div>'; ?>
        <form class="regform" action="loginsubmit.php" method="POST">
          <div class="mb-3">
            <label class="form-label" for="email">Email:</label>
            <input
              class="form-control"  type="email"  name="email" id="email" required />
          </div>
          <div class="mb-3">
            <label class="form-label" for="password">Password:</label>
            <input
              class="form-control" type="password" name="password" id="password" required />
          </div>
          <button class="btn btn-primary mt-3" type="submit">Login</button>
        </form>
      </div>
    </div>
  </body>
</html>