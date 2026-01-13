<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="nav">
    <strong>Online Notes Sharing</strong>
    <span style="float:right;">
        <a href="notes.php">View Notes</a>
        <a href="upload_notes.php">Upload Notes</a>
        <a href="logout.php">Logout</a>
    </span>
</div>

<div class="container" style="margin-top:40px;">
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h2>
    <p>You are successfully logged in.</p>
</div>

</body>
</html>
