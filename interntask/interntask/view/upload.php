<?php
        require '../model/tasks.php'; 
        session_start(); 
        if(!$sta=isset($_SESSION['loggedIn'])?$_SESSION['loggedIn']:false){ //if loggedIn session is not set
            header("Location: http://localhost/interntask/");
        }

        $tasktb=isset($_SESSION['tasktbl0'])?unserialize($_SESSION['tasktbl0']):new tasks();
        
        
        
        $task_id = isset($_GET['id']) ? $_GET['id'] : NULL;

        $_SESSION['taskid'] = $task_id;
?>
<head>
<title>Upload Image</title>
<style>
.log{
    background:#b3b3ff;
}
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css " />
</head>
<br><br><br><br><br>
<div class = "container log text-center border border-info">
    <form action="../index.php?op=addimage" method="post" enctype="multipart/form-data">
        <br><br>
        <div class="form-group <?php echo (!empty($tasktb->pic_msg)) ? 'has-error' : ''; ?>">
            <label for="descr"><b>Task Picture : </b></label>&nbsp&nbsp
            <input type="file"  name="image"/>
            <input type='text' name="taskid" value='$task_id' style='display:none;'>
            <span class="help-block"><?php echo $tasktb->pic_msg;?></span>    
        </div>

        <br><br>
        <button class="btn btn-success" name="addimage">Submit</button>&nbsp&nbsp
        <a href="../index.php?op=list" class="btn btn-primary pull-left">Home</a>
    </form>
</div>
