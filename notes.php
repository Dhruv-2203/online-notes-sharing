<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT notes.*, users.name 
          FROM notes 
          JOIN users ON notes.uploaded_by = users.id 
          ORDER BY notes.uploaded_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Notes</title>
</head>
<body>

<h2>Uploaded Notes</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Uploaded By</th>
        <th>Date</th>
        <th>Download</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['uploaded_at']; ?></td>
        <td>
            <a href="uploads/<?php echo $row['file_name']; ?>" download>
                Download
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
