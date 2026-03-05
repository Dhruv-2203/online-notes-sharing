<?php
session_start();
include "db.php";
include "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$top_notes_query = "SELECT title, subject, downloads 
                    FROM notes 
                    ORDER BY downloads DESC 
                    LIMIT 5";

$top_notes_result = mysqli_query($conn, $top_notes_query);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>


<div class="container mt-5">
    <div class="card shadow p-4 text-center">
        <?php
        include("db.php");
        $count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM notes"));
        ?>

        <p class="text-muted">Total Notes Available: <?php echo $count; ?></p>
        <h2 class="mb-3">
            Welcome, <?php echo $_SESSION['name']; ?> 👋
        </h2>
        
        <p class="text-muted">Manage and share your study notes easily.</p>

    </div>
    <div class="container mt-4">
    <div class="card shadow p-4">

        <h4 class="mb-4">⭐ Top Downloaded Notes</h4>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Downloads</th>
                </tr>
            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($top_notes_result)) { ?>

                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['downloads']; ?></td>
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
