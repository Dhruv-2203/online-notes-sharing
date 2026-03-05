<?php
include "db.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // get file information
    $query = "SELECT * FROM notes WHERE id='$id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);

    $file = "uploads/".$row['file_name'];

    if(file_exists($file)){

        // increase download count
        mysqli_query($conn,"UPDATE notes SET downloads = downloads + 1 WHERE id='$id'");

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        readfile($file);
        exit();

    }else{
        echo "File not found.";
    }
}
?>