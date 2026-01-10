<!DOCTYPE html>
<html>
<head>
    <title>Patient Report</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        .stats { display: flex; gap: 20px; margin: 15px 0; }
        .box { padding: 10px; border: 1px solid #999; }
    </style>
</head>
<body>

<h2>Patient Report (Admin)</h2>

<form method="post">
    From: <input type="date" name="from_date">
    To: <input type="date" name="to_date">

    Gender:
    <select name="gender">
        <option>All</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select>

    Age Range:
    <select name="age_range">
        <option>All</option>
        <option>0-18</option>
        <option>19-35</option>
        <option>36-60</option>
        <option>60+</option>
    </select>

    <button type="submit" name="generate">Generate</button>
    <button type="submit" name="export_xml">Export XML</button>
    <button type="button" onclick="window.print()">Print</button>
</form>

<div class="stats">
    <div class="box">Total: <?= $stats['total'] ?></div>
    <div class="box">Male: <?= $stats['male'] ?></div>
    <div class="box">Female: <?= $stats['female'] ?></div>
    <div class="box">Other: <?= $stats['other'] ?></div>
    <div class="box">Avg Age: <?= $stats['avg_age'] ?></div>
</div>

<table>
    <tr>
        <th>ID</th><th>Name</th><th>Age</th><th>Gender</th>
        <th>Registration Date</th><th>Last Visit</th>
    </tr>

    <?php foreach ($patients as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['name'] ?></td>
        <td><?= $p['age'] ?></td>
        <td><?= $p['gender'] ?></td>
        <td><?= $p['registration_date'] ?></td>
        <td><?= $p['last_visit'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
