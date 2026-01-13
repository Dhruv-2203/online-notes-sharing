<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['upload'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $file = $_FILES['note_file'];
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

if ($fileType != "pdf") {
    echo "Only PDF files are allowed!";
    exit();
}
$maxSize = 5 * 1024 * 1024; // 5 MB

if ($file['size'] > $maxSize) {
    echo "File size must be less than 5MB!";
    exit();
}

    $fileName = time() . "_" . $file['name'];
    $targetPath = "uploads/" . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {

        $userId = $_SESSION['user_id'];

        $query = "INSERT INTO notes (title, file_name, uploaded_by)
                  VALUES ('$title', '$fileName', '$userId')";

        if (mysqli_query($conn, $query)) {
            echo "Note uploaded successfully!";
        } else {
            echo "Database error!";
        }

    } else {
        echo "File upload failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Notes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Upload Notes</h2>

<div class="nav">
    <strong>Online Notes Sharing</strong>
    <span style="float:right;">
        <a href="dashboard.php">Dashboard</a>
        <a href="notes.php">View Notes</a>
        <a href="logout.php">Logout</a>
    </span>
</div>

<div class="container" style="margin-top:40px;">
    <h2>Upload Notes</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Note Title" required>
        <input type="file" name="note_file" required>
        <button type="submit" name="upload">Upload</button>
    </form>
</div>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
