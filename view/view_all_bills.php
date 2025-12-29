<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    if (!isset($_SESSION['bills'])) {
        $_SESSION['bills'] = [
            ['bill_id'=>'BILL2025001', 'patient_name'=>'Mahedy', 'date'=>'2025-12-29', 'total'=>'2520.00', 'paid'=>'0.00', 'status'=>'Unpaid'],
            ['bill_id'=>'BILL2025002', 'patient_name'=>'Hasan', 'date'=>'2025-12-28', 'total'=>'5000.00', 'paid'=>'5000.00', 'status'=>'Paid']
        ];
    }
    $bills = $_SESSION['bills'];
?>

<html>
<head>
    <title>Billing Management</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    \<h1>Hospital Billing Records</h1>
    <table border=1>
        <tr>
            <th>Bill ID</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach($bills as $b){ ?>
            <tr>
                <td><?php echo $b['bill_id']; ?></td>
                <td><?php echo $b['patient_name']; ?></td>
                <td><?php echo $b['date']; ?></td>
                <td><?php echo $b['total']; ?></td>
                <td><?php echo $b['paid']; ?></td>
                <td><?php echo $b['status']; ?></td>
                <td>
                    <a href="view_details.php?id=<?=$b['bill_id']?>"> VIEW </a> |
                    <a href="delete_bill.php?id=<?=$b['bill_id']?>"> DELETE </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Create New Bill</h3>
    <form method="POST" action="process_bill.php">
        Bill ID: <input type="text" name="bill_id" required>
        Patient: <input type="text" name="patient_name" required>
        Total: <input type="text" name="total_amount" required>
        Paid: <input type="text" name="paid_amount" value="">
        Status: 
        <select name="status">
            <option value="Unpaid">Unpaid</option>
            <option value="Paid">Paid</option>
        </select>
        <button type="submit" name="submit">Submit</button>
    </form>
    <script src="bill_validation.js"></script>
</body>
</html>