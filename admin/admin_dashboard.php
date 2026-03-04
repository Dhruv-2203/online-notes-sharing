<?php
session_start();
include("../db.php");

// Total Users
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

// Total Notes
$note_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM notes"));

// Total Downloads
$download_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM downloads"));

$popular_query = mysqli_query($conn, "
    SELECT notes.title, COUNT(downloads.id) as total_downloads
    FROM downloads
    JOIN notes ON downloads.note_id = notes.id
    GROUP BY downloads.note_id
    ORDER BY total_downloads DESC
    LIMIT 1
");

$popular_note = mysqli_fetch_assoc($popular_query);

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<div class="container mt-5">
    <h3 class="mb-4">Welcome Admin 👋</h3>

    <div class="row text-center">

    <!-- Total Users -->
    <div class="col-md-3 mb-4">
        <div class="card shadow p-4 text-white"
             style="background: linear-gradient(45deg, #0d6efd, #3b82f6); border-radius:15px;">
            <h4><?php echo $user_count; ?></h4>
            <p>Total Users</p>
        </div>
    </div>

    <!-- Total Notes -->
    <div class="col-md-3 mb-4">
        <div class="card shadow p-4 text-white"
             style="background: linear-gradient(45deg, #198754, #22c55e); border-radius:15px;">
            <h4><?php echo $note_count; ?></h4>
            <p>Total Notes</p>
        </div>
    </div>

    <!-- Total Downloads -->
    <div class="col-md-3 mb-4">
        <div class="card shadow p-4 text-white"
             style="background: linear-gradient(45deg, #fd7e14, #f97316); border-radius:15px;">
            <h4><?php echo $download_count; ?></h4>
            <p>Total Downloads</p>
        </div>
    </div>

    <!-- Most Downloaded -->
    <div class="col-md-3 mb-4">
        <div class="card shadow p-4 text-white"
             style="background: linear-gradient(45deg, #dc3545, #ef4444); border-radius:15px;">
            <h6>Most Downloaded</h6>
            <p>
                <?php 
                echo $popular_note ? $popular_note['title'] : "No downloads yet";
                ?>
            </p>
        </div>
    </div>
    <div class="card shadow p-4 mt-4">
    <h4 class="text-center mb-4">System Statistics</h4>
    <canvas id="statsChart" height="120"></canvas>
    </div>

</div>

    <div class="text-center mt-4">
    <a href="manage_users.php" class="btn btn-primary me-3 px-4">Manage Users</a>
    <a href="manage_notes.php" class="btn btn-primary px-4">Manage Notes</a>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
<script>
const ctx = document.getElementById('statsChart');

if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Notes', 'Downloads'],
            datasets: [{
                label: 'System Data',
                data: [
                    <?php echo $user_count; ?>,
                    <?php echo $note_count; ?>,
                    <?php echo $download_count; ?>
                ],
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#fd7e14'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        color: '#000'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#000'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
</script>
</body>
</html>