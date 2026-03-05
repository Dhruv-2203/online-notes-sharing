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

// Delete user
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // Prevent admin deleting himself
    if ($id == $_SESSION['user_id']) {
        header("Location: manage_users.php");
        exit();
    }

    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 
    <style>
        body { font-family: Arial; background: #f4f6f9; margin: 0; }
        .container {
            width: 80%;
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
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM users");

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
                <?php if($_SESSION['user_id'] != $row['id']) { ?>

                <a href="manage_users.php?delete=<?php echo $row['id']; ?>" 
                class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this user?')">
                Delete
                </a>

                <?php } else { ?>

                <button class="btn btn-secondary btn-sm" disabled>
                Cannot Delete Yourself
                </button>

                <?php } ?>
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