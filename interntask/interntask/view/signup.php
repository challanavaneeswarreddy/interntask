<?php
session_start();
require '../model/tasks.php'; 
$tasktb=isset($_SESSION['tasktbl0'])?unserialize($_SESSION['tasktbl0']):new tasks();
// if(isset($_SESSION['loggedIn'])? $_SESSION['loggedIn']:false)
// {

//   header('location: taskview.php');
// }

?>

<head>
<title>Signup</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css " />
<style>
.help-block{
            color:red;
            font-size:12px;
        }
.sign h1{
  color:blue;
}
.sign{
  background:#99ccff;
  padding-left:100px;
  padding-right:100px;
}
.log{
  width:480px;
}
</style>

</head>
<form action="../index.php?op=signup" method="post" style="border:1px solid #ccc">
  <br><br>
  <div class="container sign text-center border border-warning ">
  <br>
    <h1>SIGN UP </h1>
    <p class="alert alert-info">Please fill in this form to create an account.</p>
    <hr>
    <br>
    <div class="container log ">
        <span class="help-block"><?php echo $tasktb->sign_error_msg;?></span><br><br>
        <div class="row log">
          <div class="col-md-5 ">
            <label for="email"><b>Username :</b></label>
          </div>
          <div class="col-md-6 text-left">
            <input type="text" placeholder="Enter Username" name="username" required>
          </div>
        </div>
        <br><br>
        <div class=row>
          <div class="col-md-5 ">
            <label for="psw"><b>Password :</b></label>
          </div>
          <div class="col-md-6 text-left">
            <input type="password" placeholder="Enter Password" name="psw" required>
          </div>
        </div>
        <br><br>
        <div class=row>
        <div class="col-md-5"> 
          <label for="phone"><b>Phone :</b></label>
        </div>    
        <div class="col-md-6 text-left"> 
          <input type="number" placeholder="Enter number" name="phone" required>
        </div> 
        </div>
        <br><br>
      <div class="clearfix">
          <a href="http://localhost/interntask/" class="btn btn-info" >Login</a>&nbsp &nbsp
          <button class="btn btn-success" name="signupbtn">Sign Up</button>
        </div>
        <br>
    
    </div>
  
  </div>
</form> 