<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">📚 Online Notes</a>

    <div class="navbar">
      <a href="dashboard.php">Dashboard</a>
      <a href="view_notes.php">View Notes</a>
      <a href="upload.php">Upload</a>

      <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
          <a href="admin/admin_dashboard.php">Admin Panel</a>
      <?php } ?>

      <a href="logout.php">Logout</a>
    </div>
  </div>
</nav>