<?php
session_start();
include "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
        <h2 class="mb-3">
            Welcome, <?php echo $_SESSION['name']; ?> 👋
        </h2>
        
        <p class="text-muted">Manage and share your study notes easily.</p>

    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
