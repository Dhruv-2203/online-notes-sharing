<?php
session_start();
include("../db.php");

// Total Users
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

// Total Notes
$note_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM notes"));

// Total Downloads
$download_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM downloads"));

// If not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// If not admin
if ($_SESSION['role'] != 'admin') {
    echo "<h2>Access Denied!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        .navbar {
            background: #1e3a8a;
            padding: 15px 30px;
            color: white;
        }

        .container {
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card {
           display: inline-block;
           width: 220px;
           padding: 25px;
           margin: 15px;
           background: linear-gradient(135deg, #2563eb, #1e40af);
           color: white;
           border-radius: 10px;
           text-align: center;
           text-decoration: none;
           font-size: 18px;
        }

        .card:hover {
            background: #1e40af;
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>Admin Panel</h2>
</div>

<div class="container">
    <h3>Welcome Admin 👋</h3>

<div style="display:flex; gap:20px; flex-wrap:wrap;">

    <div class="card">
        <h2><?php echo $user_count; ?></h2>
        <p>Total Users</p>
    </div>

    <div class="card">
        <h2><?php echo $note_count; ?></h2>
        <p>Total Notes</p>
    </div>

    <div class="card">
        <h2><?php echo $download_count; ?></h2>
        <p>Total Downloads</p>
    </div>

</div>

<br><br>

<a href="manage_users.php" class="card">
    Manage Users
</a>

<a href="manage_notes.php" class="card">
    Manage Notes
</a>

</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>