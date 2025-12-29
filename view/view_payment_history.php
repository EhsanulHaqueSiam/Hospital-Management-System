<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if (!isset($_SESSION['payments'])) {
        $_SESSION['payments'] = [
            ['pay_id'=>'PAY2025001', 'bill_id'=>'BILL2025001', 'patient'=>'Mahedy', 'amount'=>'1200.00', 'method'=>'Cash', 'date'=>'2025-12-29', 'received_by'=>'Admin_Mahedy'],
            ['pay_id'=>'PAY2025002', 'bill_id'=>'BILL2025002', 'patient'=>'Hasan', 'amount'=>'5000.00', 'method'=>'Credit Card', 'date'=>'2025-12-28', 'received_by'=>'Admin_Mahedy']
        ];
    }
?>

<html>
<head>
    <title>PAYMENT MANAGEMENT</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
     <form method="post" action="" enctype="application/x-www-form-urlencoded">
        <h2>Payment Records</h2>
        
        <?php 
            if(isset($_POST['success'])){
                echo "Payment processed successfully!";
            }
        ?>

        <table border=1>
            <tr>
                <th>PAYMENT ID</th>
                <th>BILL ID</th>
                <th>PATIENT NAME</th>
                <th>AMOUNT</th>
                <th>METHOD</th>
                <th>DATE</th>
                <th>RECEIVED BY</th>
                <th>ACTION</th>
            </tr>

            <?php
                foreach($_SESSION['payments'] as $p){
            ?>
                <tr>
                    <td><?php echo $p['pay_id']; ?></td>
                    <td><?php echo $p['bill_id']; ?></td>
                    <td><?php echo $p['patient']; ?></td>
                    <td><?=$p['amount']?></td>
                    <td><?=$p['method']?></td>
                    <td><?=$p['date']?></td>
                    <td><?=$p['received_by']?></td>
                    <td>
                        <a href="view_receipt.php?id=<?=$p['pay_id']?>"> VIEW </a> |
                        <a href="delete_payment.php?id=<?=$p['pay_id']?>"> DELETE </a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
     </form>
</body>
</html>