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

$subject = $_GET['subject'] ?? '';
$subject = mysqli_real_escape_string($conn, $subject);

$query = "SELECT notes.*, users.name 
          FROM notes 
          JOIN users ON notes.user_id = users.id 
          WHERE 1";

if($search != ""){
$query .= " AND title LIKE '%$search%'";
}

if($subject != ""){
$query .= " AND subject='$subject'";
}

$query .= " ORDER BY uploaded_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>


<div class="container" style="margin-top:40px;">
    <h2>All Notes</h2>

    <form method="GET" class="row g-2 mb-3">

    <div class="col-md-5">
    <input type="text" name="search" class="form-control"
    placeholder="Search by title..."
    value="<?php echo htmlspecialchars($search); ?>">
    </div>

    <div class="col-md-4">
    <select name="subject" class="form-control">
    <option value="">All Subjects</option>
    <option value="Maths">Maths</option>
    <option value="Physics">Physics</option>
    <option value="Computer">Computer</option>
    <option value="Chemistry">Chemistry</option>
    <option value="Other">Other</option>
    </select>
    </div>

    <div class="col-md-3">
    <button type="submit" class="btn btn-primary w-100">
    <i class="fa fa-search"></i> Search
    </button>
    </div>

    </form>

    <div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4">All Notes</h3>

        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Preview</th>
                    <th>Download</th>
                    <th>Uploaded By</th>
                    <th>Downloads</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td>
            <a href="uploads/<?php echo $row['file_name']; ?>" target="_blank" class="btn btn-sm btn-primary">
            <i class="fa fa-eye"></i> View
            </a>
            </td>

            <td>
            <a href="download.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">
            <i class="fa fa-download"></i> Download
            </a>
            </td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['downloads']; ?></td>
            <td>
            <?php if($_SESSION['user_id'] == $row['user_id']) { ?>
            <a href="delete_note.php?id=<?php echo $row['id']; ?>" 
            class="btn btn-sm btn-danger"
            onclick="return confirm('Delete this note?');">
            <i class="fa fa-trash"></i> Delete
            </a>
            <?php } ?>
            </td>
            </tr>
            <?php } ?>

            </tbody>
        </table>

    </div>
</div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
