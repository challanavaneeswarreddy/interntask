<?php 

// if(isset($_SESSION['loggedIn'])? $_SESSION['loggedIn']:false)
// {
//   header('location: taskview.php');
// }

if(!$sta=isset($_SESSION['loggedIn'])?$_SESSION['loggedIn']:false){ //if loggedIn session is not set
    header("Location: http://localhost/interntask/");
}

$user=isset($_SESSION['username'])?$_SESSION['username']:null;
$userid=isset($_SESSION['user_id'])?$_SESSION['user_id']:null;


?>

<!DOCTYPE html>
<html lang="en">
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
            
        }
 
    </style>

</head>
<br><br>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header row">
                        <div class="col-md-3">
                        <a href="index.php?op=logut" class="btn btn-info pull-right">logout</a>
                        </div>
                        <div class="col-md-5">
                            <h2 class="pull-left">Task Details</h2>
                        </div>
                        <div class="col-md-4">
                            <a href="view/create.php" class="btn btn-success pull-right">Add New Task</a>
                        </div>
                    </div>
                    <hr>
                </div>
                
                    <?php
                        if($result->num_rows > 0){
                            echo "<table class='table table-bordered table-striped' style='width:1000px;'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";                                        
                                        echo "<th>Userid</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Task Status</th>";
                                        echo "<th>Picture</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    $status = "<alert class='alert alert-warning'>pending</alert>";
                                    if($row['status']){
                                        $status = "<alert class='alert alert-info'>completed</alert>";
                                    }
                                    $task_id=$row['task_id'];  
                                    echo "<tr>";
                                        echo "<td>" . $row['task_id'] . "</td>"; 
                                        echo "<td>" . $userid . "</td>";                                         
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>". $status."</td>";
                                        echo "<td>
                                        <form action='../index.php?op=addImage' method='post'>
                                            
                                            <a href='view/upload.php?id=$task_id' class='btn btn-secondary'>Add a Picture</a>
                                         </form></td>";
                            
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>