<?php
// Initialize variables if not set
$summary = $summary ?? ['total_revenue' => 0, 'total_bills' => 0, 'paid_bills' => 0, 'unpaid_amount' => 0, 'avg_bill' => 0];
$data = $data ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #aaa; padding: 8px; }
        .summary { display: flex; gap: 15px; margin: 15px 0; }
        .box { border: 1px solid #999; padding: 10px; }
        .chart { display: flex; align-items: flex-end; gap: 10px; height: 200px; margin-top: 20px; }
        .bar {
            width: 30px;
            background: #4CAF50;
            text-align: center;
            color: white;
            font-size: 10px;
        }
    </style>
</head>
<body>

<h2>Revenue Report (Admin)</h2>

<form method="post">
    Report Type:
    <select name="report_type">
        <option>Daily</option>
        <option>Weekly</option>
        <option>Monthly</option>
    </select>

    From:
    <input type="date" name="from_date">

    To:
    <input type="date" name="to_date">

    <button type="submit" name="generate">Generate</button>
    <button type="submit" name="export_xml">Export XML</button>
    <button type="button" onclick="window.print()">Print</button>
</form>

<div class="summary">
    <div class="box">Total Revenue: <?= $summary['total_revenue'] ?></div>
    <div class="box">Total Bills: <?= $summary['total_bills'] ?></div>
    <div class="box">Paid Bills: <?= $summary['paid_bills'] ?></div>
    <div class="box">Unpaid Amount: <?= $summary['unpaid_amount'] ?></div>
    <div class="box">Avg Bill: <?= $summary['avg_bill'] ?></div>
</div>

<h3>Revenue Chart</h3>
<div class="chart">
    <?php foreach ($data as $row): ?>
        <div class="bar" style="height: <?= ($row['paid_amount'] / 10) ?>px">
            <?= $row['paid_amount'] ?>
        </div>
    <?php endforeach; ?>
</div>

<table>
    <tr>
        <th>Period</th>
        <th>Bills</th>
        <th>Total Amount</th>
        <th>Paid</th>
        <th>Unpaid</th>
    </tr>

    <?php foreach ($data as $row): ?>
    <tr>
        <td><?= $row['period'] ?></td>
        <td><?= $row['bills_generated'] ?></td>
        <td><?= $row['total_amount'] ?></td>
        <td><?= $row['paid_amount'] ?></td>
        <td><?= $row['unpaid_amount'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
