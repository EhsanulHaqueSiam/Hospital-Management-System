<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if (!isset($_SESSION['bills'])) {
        $_SESSION['bills'] = [
            ['bill_id'=>'BILL2025001', 'date'=>'2025-12-29', 'total'=>'1200.00', 'paid'=>'1200.00', 'status'=>'Paid'],
            ['bill_id'=>'BILL2025002', 'date'=>'2025-12-28', 'total'=>'5000.00', 'paid'=>'2000.00', 'status'=>'Partial']
        ];
    }

    $invoices = $_SESSION['bills'];

    // Sorting logic
    usort($invoices, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    $totalInvoiced = 0;
    $totalPaid = 0;
    foreach($invoices as $inv) {
        $totalInvoiced += floatval($inv['total']);
        $totalPaid += floatval($inv['paid']);
    }
    $totalOutstanding = $totalInvoiced - $totalPaid;
?>

<html>
<head>
    <title>INVOICE MANAGEMENT</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <form method="post" action="" enctype="application/x-www-form-urlencoded">
        <h2>Invoice History</h2>

        <table border="1" style="margin-bottom: 20px;">
            <tr>
                <td><strong>Total Invoiced:</strong></td>
                <td><?= number_format($totalInvoiced, 2) ?> TK</td>
            </tr>
            <tr>
                <td><strong>Total Paid:</strong></td>
                <td><?= number_format($totalPaid, 2) ?> TK</td>
            </tr>
            <tr>
                <td><strong>Total Outstanding:</strong></td>
                <td><?= number_format($totalOutstanding, 2) ?> TK</td>
            </tr>
        </table>

        <table border=1>
            <tr>
                <th>INVOICE/BILL ID</th>
                <th>DATE</th>
                <th>TOTAL AMOUNT</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>

            <?php
                foreach($invoices as $i){
            ?>
                <tr>
                    <td><?php echo $i['bill_id']; ?></td>
                    <td><?php echo $i['date']; ?></td>
                    <td><?= number_format($i['total'], 2) ?></td>
                    <td><?php echo $i['status']; ?></td>
                    <td>
                        <a href="javascript:window.print()"> PRINT </a> 
                        <a href="delete_invoice.php?id=<?=$i['bill_id']?>"> DELETE </a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
        <br>
    </form>
    
</body>
</html>