<?php
// Initialize variables if not set
$totalPatients = $totalPatients ?? 0;
$totalAppointments = $totalAppointments ?? 0;
$totalRevenue = $totalRevenue ?? 0;
$activeDoctors = $activeDoctors ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Report Dashboard</title>
    <style>
        body { font-family: Arial; }
        .stats, .cards { display: flex; gap: 15px; margin-bottom: 20px; }
        .card {
            border: 1px solid #ccc;
            padding: 15px;
            width: 200px;
            border-radius: 5px;
        }
        .card h4 { margin: 0 0 10px 0; }
        .filter { margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Report Dashboard (Admin)</h2>

<!-- Date Range Filter -->
<div class="filter">
    <form method="get">
        From: <input type="date" name="from_date">
        To: <input type="date" name="to_date">
        <input type="submit" value="Generate Custom Report">
    </form>
</div>

<!-- Quick Stats -->
<div class="stats">
    <div class="card">
        <h4>Total Patients</h4>
        <p><?= $totalPatients ?></p>
    </div>
    <div class="card">
        <h4>Appointments This Month</h4>
        <p><?= $totalAppointments ?></p>
    </div>
    <div class="card">
        <h4>Revenue This Month</h4>
        <p><?= $totalRevenue ?></p>
    </div>
    <div class="card">
        <h4>Active Doctors</h4>
        <p><?= $activeDoctors ?></p>
    </div>
</div>

<!-- Report Categories -->
<div class="cards">
    <?php
    $reports = [
        "Patient Reports" => "View patient statistics",
        "Doctor Reports" => "Doctor activity and availability",
        "Revenue Reports" => "Financial summaries",
        "Appointment Reports" => "Appointment analytics",
        "Medicine Reports" => "Medicine usage",
        "Room Reports" => "Room occupancy"
    ];

    foreach ($reports as $name => $desc) {
    ?>
        <div class="card">
            <h4><?= $name ?></h4>
            <p><?= $desc ?></p>
            <a href="report_controller.php?type=<?= urlencode($name) ?>">
                <button>Generate</button>
            </a>
        </div>
    <?php } ?>
</div>

</body>
</html>
