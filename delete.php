<?php

include("includes/db.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting task";
    }

}

?>