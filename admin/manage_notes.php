<?php
session_start();
include("../db.php");

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check admin
if ($_SESSION['role'] != 'admin') {
    echo "<h2>Access Denied!</h2>";
    exit();
}

// Delete note
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Get file name first
    $result = mysqli_query($conn, "SELECT file_name FROM notes WHERE id='$id'");
    $note = mysqli_fetch_assoc($result);

    if ($note) {
        $file_path = "../uploads/" . $note['file_name'];

        // Delete file from folder
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete from database
        mysqli_query($conn, "DELETE FROM notes WHERE id='$id'");
    }

    header("Location: manage_notes.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: Arial; background: #f4f6f9; margin: 0; }
        .container {
            width: 90%;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #2563eb;
            color: white;
        }
        a.delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Notes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>File</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php
        $query = "SELECT * FROM notes";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['file_name']; ?></td>
            <td><?php echo $row['uploaded_by']; ?></td>
            <td><?php echo $row['uploaded_at']; ?></td>
            <td>
                <a class="delete" 
                   href="?delete=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this note?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <a href="admin_dashboard.php">← Back to Dashboard</a>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>