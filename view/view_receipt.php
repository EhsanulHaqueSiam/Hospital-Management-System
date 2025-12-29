<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');


    $pay_id = $_GET['id'] ?? die("No payment ID provided.");
    
    $payment = null;
    if (isset($_SESSION['payments'])) {
        foreach($_SESSION['payments'] as $p) {
           
            if($p['pay_id'] == $pay_id) { 
                $payment = $p; 
                break; 
            }
        }
    }

    if (!$payment) { 
        die("Payment record not found."); 
    }


    $bill_total = 0;
    $current_paid = 0;
    if (isset($_SESSION['bills'])) {
        foreach($_SESSION['bills'] as $b) {
            if($b['bill_id'] == $payment['bill_id']) {
                $bill_total = floatval($b['total']);
                $current_paid = floatval($b['paid']);
                break;
            }
        }
    }

    $this_payment = floatval($payment['amount']);
    if($current_paid == 0) $current_paid = $this_payment; 
    
    $previous_paid = $current_paid - $this_payment;
    $remaining_balance = $bill_total - $current_paid;
?>
<html>
<head>
    <title>Receipt <?php echo $pay_id; ?></title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

  
        <h1>AIUB HOSPITAL</h1>
        <p>Kuril,aiub</p>
        <h2>PAYMENT RECEIPT</h2>
    
    
    <p>
        <strong>Payment ID:</strong> <?php echo $payment['pay_id']; ?><br>
        <strong>Date:</strong> <?php echo $payment['date']; ?><br>
        <strong>Patient Name:</strong> <?php echo $payment['patient']; ?>
    </p>
    

    
    <p>
        <strong>Bill ID:</strong> <?php echo $payment['bill_id']; ?><br>
        <strong>Bill Total:</strong> <?php echo number_format($bill_total, 2); ?> TK<br>
        <strong>Previous Paid:</strong> <?php echo number_format($previous_paid, 2); ?> TK
    </p>
    
    <p>
        <b>THIS PAYMENT: <?php echo number_format($this_payment, 2); ?> TK</b><br>
        <strong>Payment Method:</strong> <?php echo $payment['method']; ?>
    </p>
    
    <p>
        <strong>Total Paid to Date:</strong> <?php echo number_format($current_paid, 2); ?> TK<br>
        <b>REMAINING BALANCE: <?php echo number_format($remaining_balance, 2); ?> TK</b>
    </p>
    
    <p><strong>Received By:</strong> <?php echo $payment['received_by']; ?></p>
    
    <br><br>
    
    <button onclick="window.print()">Print Receipt</button>
    
    <a href="view_payment_history.php"><button type="button">Back to List</button></a>

</body>
</html>