<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $note_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Insert into downloads table
    mysqli_query($conn, "
        INSERT INTO downloads (user_id, note_id, download_date)
        VALUES ('$user_id', '$note_id', NOW())
    ");

    // Get file name
    $result = mysqli_query($conn, "
        SELECT file_name FROM notes WHERE id='$note_id'
    ");

    $note = mysqli_fetch_assoc($result);

    if ($note) {
        $file_path = "uploads/" . $note['file_name'];

        if (file_exists($file_path)) {
            header("Location: " . $file_path);
            exit();
        } else {
            echo "File not found!";
        }
    }
}
?>