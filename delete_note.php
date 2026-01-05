<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $noteId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Get note info
    $query = "SELECT * FROM notes WHERE id = '$noteId' AND uploaded_by = '$userId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $note = mysqli_fetch_assoc($result);
        $filePath = "uploads/" . $note['file_name'];

        // Delete file from folder
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete record from DB
        $deleteQuery = "DELETE FROM notes WHERE id = '$noteId'";
        mysqli_query($conn, $deleteQuery);

        header("Location: notes.php");
        exit();

    } else {
        echo "You are not allowed to delete this note!";
    }
}
?>
