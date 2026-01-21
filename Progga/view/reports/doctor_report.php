<?php
// Initialize variables if not set
$overall = $overall ?? ['active_doctors' => 0, 'total_appointments' => 0, 'most_active_doctor' => 'N/A'];
$doctors = $doctors ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Report</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #aaa; padding: 8px; }
        .summary { display: flex; gap: 15px; margin: 15px 0; }
        .box { border: 1px solid #999; padding: 10px; }
    </style>
</head>
<body>

<h2>Doctor Performance Report (Admin)</h2>

<form method="post">
    Department:
    <select name="department">
        <option>All</option>
        <option>Cardiology</option>
        <option>Medicine</option>
        <option>Orthopedic</option>
    </select>

    Doctor ID:
    <input type="text" name="doctor" placeholder="All">

    From:
    <input type="date" name="from_date">

    To:
    <input type="date" name="to_date">

    <button type="submit" name="generate">Generate</button>
    <button type="submit" name="export_xml">Export XML</button>
    <button type="button" onclick="window.print()">Print</button>
</form>

<div class="summary">
    <div class="box">Active Doctors: <?= $overall['active_doctors'] ?></div>
    <div class="box">Total Appointments: <?= $overall['total_appointments'] ?></div>
    <div class="box">Most Active: <?= $overall['most_active_doctor'] ?></div>
</div>

<table>
    <tr>
        <th>Doctor Name</th>
        <th>Department</th>
        <th>Total Appointments</th>
        <th>Total Patients</th>
        <th>Total Prescriptions</th>
        <th>Avg / Day</th>
    </tr>

    <?php foreach ($doctors as $d): ?>
    <tr>
        <td><?= $d['name'] ?></td>
        <td><?= $d['department'] ?></td>
        <td><?= $d['total_appointments'] ?></td>
        <td><?= $d['total_patients'] ?></td>
        <td><?= $d['total_prescriptions'] ?></td>
        <td><?= $d['avg_per_day'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
