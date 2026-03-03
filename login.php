<?php
session_start();
include("db.php");

if(isset($_POST['email']) && isset($_POST['password'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if($password == $user['password']) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password');</script>";
        }

    } else {
        echo "<script>alert('User Not Found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card shadow p-4" style="width:400px;">
        
        <h3 class="text-center mb-4">
            <i class="fa fa-user"></i> Login
        </h3>

        <form method="POST">
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-sign-in-alt"></i> Login
            </button>

            <div class="text-center mt-3">
                New user? <a href="register.php">Register here</a>
            </div>

        </form>

    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>

