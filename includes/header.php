<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">📚 Online Notes</a>

    <div>
      <a class="btn btn-outline-light me-2" href="dashboard.php">Dashboard</a>
      <a class="btn btn-outline-light me-2" href="notes.php">View Notes</a>
      <a class="btn btn-outline-light me-2" href="upload_notes.php">Upload</a>

      <?php if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){ ?>
        <a class="btn btn-warning me-2" href="admin/dashboard.php">Admin Panel</a>
      <?php } ?>

      <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
