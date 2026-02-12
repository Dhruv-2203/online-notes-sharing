<?php
error_reporting(0);
session_start();
include "db.php";
include "includes/header.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = $_GET['search'] ?? '';
$search = mysqli_real_escape_string($conn, $search);

$search = $_GET['search'] ?? '';
$search = mysqli_real_escape_string($conn, $search);

if ($search != "") {
    $query = "SELECT notes.id, notes.title, notes.file_name, notes.uploaded_by, notes.uploaded_at, users.name
              FROM notes
              JOIN users ON notes.uploaded_by = users.id
              WHERE notes.title LIKE '%$search%'
              ORDER BY notes.uploaded_at DESC";
} else {
    $query = "SELECT notes.id, notes.title, notes.file_name, notes.uploaded_by, notes.uploaded_at, users.name
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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container" style="margin-top:40px;">
    <h2>All Notes</h2>

    <form method="GET" style="margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>Title</th>
            <th>File</th>
            <th>Uploaded By</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td>
        <a href="uploads/<?php echo $row['file_name']; ?>" target="_blank">View</a>
    </td>

    <td><?php echo htmlspecialchars($row['name']); ?></td>
</tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
