<?php
        require '../model/tasks.php'; 
        session_start();             
        $tasktb=isset($_SESSION['tasktbl0'])?unserialize($_SESSION['tasktbl0']):new tasks();
        if(!$sta=isset($_SESSION['loggedIn'])?$_SESSION['loggedIn']:false){ //if loggedIn session is not set
            header("Location: http://localhost/interntask/");
        }            
?>
<!DOCTYPE html>
<html lang="en">
<title>Create Task</title>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css " />
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
        .help-block{
            color:red;
            font-size:10px;
        }
    </style>

</head>
<br><br>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header row">
                        <div class="col-md-3">
                            <a href="../index.php?op=list" class="btn btn-primary pull-left">Home</a>
                        </div>
                        <div class="col-md-5">
                            <h2 class="pull-left">Task Details</h2>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                    <hr>
                    <br>
                    <form action="../index.php?op=add" method="post" enctype='multipart/form-data'>
                        <div class="form-group <?php echo (!empty($tasktb->taskname_msg)) ? 'has-error' : ''; ?>">
                            <label for="task"><b>Task Name</b></label>
                            <input type="text" placeholder="Enter Task Name" name="taskname" value="<?php echo $tasktb->taskname; ?>">
                            <span class="help-block"><?php echo $tasktb->taskname_msg;?></span>
                        </div>
                        <br>
                        <div class="form-group <?php echo (!empty($tasktb->description_msg)) ? 'has-error' : ''; ?>">
                            <label for="descr"><b>Description</b></label>
                            <textarea rows="4" cols="80" placeholder="Enter Task Description" name="description" ></textarea>
                            <span class="help-block"><?php echo $tasktb->description_msg;?></span>
                        </div>
                        
                        <br><br>
                        <button class="btn btn-success" name="submit" value="Submit">Submit</button>
                    </form>
                </div>

            
            </div>        
        </div>
    </div>
</body>
</html>