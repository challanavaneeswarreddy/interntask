<?php
$conn = mysqli_connect("localhost", "root","","interntask");
if($conn){
    echo "Database connected";
}else{
    echo "Database connection failed";
}

traverse_tree(0);

function traverse_tree($id)
{
    global $conn;
 
    $sql = "select * from tree where parent_id ='".$id."'";
    $result = $conn->query($sql);


    while($row= mysqli_fetch_assoc($result))
    {
        $i=0;
        if($i==0) echo '<ul>';
        echo '<li>'.$row['title']; 
            traverse_tree($row['sno']);
        echo '</li>';
        $i=$i+1;
        if($i > 0) echo '</ul>';


    }


}

mysqli_close($conn);

?>

<title>Task-B</title>