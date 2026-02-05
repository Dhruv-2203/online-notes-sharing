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
    <div class="logo">
        Online Notes Sharing
    </div>

    <div class="menu">
        <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="notes.php"><i class="fa fa-book"></i> View Notes</a>
        <a href="upload_notes.php"><i class="fa fa-upload"></i> Upload</a>
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>
        Welcome,
        <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'User'; ?> 👋
</h2>

    <p>You are successfully logged in.</p>
    <p>Use the navigation bar above to upload or view notes.</p>
</div>

</body>
</html>
