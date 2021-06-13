<?php
session_start();
require '../model/tasks.php'; 
$tasktb=isset($_SESSION['tasktbl0'])?unserialize($_SESSION['tasktbl0']):new tasks();
// if(isset($_SESSION['loggedIn'])? $_SESSION['loggedIn']:false)
// {

//   header('location: taskview.php');
// }

?>


<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css " />
<style>
.help-block{
            color:red;
            font-size:12px;
        }
body{
  background: #99ccff;
}

.log{
  height:300px;
  width:400px;
  background: #66b3ff;
}


</style>
<title>Login</title>
</head>
 <body>
 <br>
 <br><br>
 <br><br>
 <br>
  <form method="post" action="../index.php?op=login">

  <div class="container log text-center border border-info">
  <br>
    <span class="help-block"><?php echo $tasktb->log_error_msg;?></span><br><br>
    <label for="uname"><b>Username</b></label>&nbsp
    <input type="text" placeholder="Enter Username" name="uname" required>
    
    <br>
    <br>
    <label for="psw"><b>Password</b></label>&nbsp
    <input type="password" placeholder="Enter Password" name="psw" required>

    <br>
    <br>
    <button  name='loginbtn' class="btn btn-success">Login</button>&nbsp&nbsp
    <a href="signup.php" class="btn btn-info">Signup</a>
  </div>
  </from>
 </body>

</html>