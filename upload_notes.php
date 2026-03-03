<?php
session_start();
include "db.php";
include "includes/header.php";


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4">Upload Notes</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Select File</label>
                <input type="file" name="file" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fa fa-upload"></i> Upload
            </button>
        </form>
    </div>
</div>

<br>

<?php include("includes/footer.php"); ?>
</body>
</html>
