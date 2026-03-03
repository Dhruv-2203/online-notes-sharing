<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">
        <i class="fa fa-book"></i> Online Notes
    </a>

    <div>
      <a class="btn btn-light btn-sm me-2" href="dashboard.php">Dashboard</a>
      <a class="btn btn-light btn-sm me-2" href="notes.php">View Notes</a>
      <a class="btn btn-light btn-sm me-2" href="upload_notes.php">Upload</a>

      <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
          <a class="btn btn-warning btn-sm me-2" href="admin/admin_dashboard.php">
              <i class="fa fa-user-shield"></i> Admin
          </a>
      <?php } ?>

      <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
      <button class="btn btn-dark btn-sm ms-2" onclick="toggleDarkMode()">🌙</button>
    </div>
  </div>
</nav>