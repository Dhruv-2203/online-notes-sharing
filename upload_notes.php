<?php
session_start();
include("db.php");
include("includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $user_id = $_SESSION['user_id'];
    $uploaded_by = $_SESSION['name'];

    $file = $_FILES['file']['name'];
    $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if($file_type != "pdf"){
    echo "<script>
            alert('Only PDF files allowed');
            window.location.href='upload_notes.php';
          </script>";
    return;
    }
    $temp_name = $_FILES['file']['tmp_name'];

    $new_file_name = time() . "_" . $file;

    $upload_path = "uploads/" . $new_file_name;

    if (move_uploaded_file($temp_name, $upload_path)) {

        $query = "INSERT INTO notes (user_id, title, subject, file_name, uploaded_by, uploaded_at, downloads)
        VALUES ('$user_id', '$title', '$subject', '$new_file_name', '$uploaded_by', NOW(), 0)";

        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Note uploaded successfully!');
            window.location.href='notes.php';
            </script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
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
                <select name="subject" class="form-control mt-2" required>
                <option value="">Select Subject</option>
                <option value="Maths">Maths</option>
                <option value="Physics">Physics</option>
                <option value="Computer">Computer</option>
                <option value="Chemistry">Chemistry</option>
                <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select File</label>
                <input type="file" name="file" class="form-control" accept=".pdf" required>
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
