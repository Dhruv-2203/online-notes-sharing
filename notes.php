<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT notes.*, users.name 
              FROM notes 
              JOIN users ON notes.uploaded_by = users.id
              WHERE notes.title LIKE '%$search%'
              ORDER BY notes.uploaded_at DESC";
} else {
    $query = "SELECT notes.*, users.name 
              FROM notes 
              JOIN users ON notes.uploaded_by = users.id
              ORDER BY notes.uploaded_at DESC";
}


$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Notes</title>
</head>
<body>

<h2>Uploaded Notes</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Search by title">
    <button type="submit">Search</button>
</form>

<br>

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Uploaded By</th>
        <th>Date</th>
        <th>Download</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['uploaded_at']; ?></td>
        <td>
    <a href="uploads/<?php echo $row['file_name']; ?>" download>Download</a>
</td>

<td>
<?php if ($row['uploaded_by'] == $_SESSION['user_id']) { ?>
    <a href="delete_note.php?id=<?php echo $row['id']; ?>" 
       onclick="return confirm('Are you sure you want to delete this note?')">
        Delete
    </a>
<?php } else { ?>
    ---
<?php } ?>
</td>

    </tr>
    <?php } ?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
