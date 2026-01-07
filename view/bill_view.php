<?php
session_start();
require_once('../model/billModel.php');
require_once('../model/paymentModel.php');
require_once('../model/patientModel.php');

if (!isset($_SESSION['status'])) {
    header('location: auth_signin.php');
    exit;
}

$id = $_REQUEST['id'];
$bill = getBillById($id);
$items = getBillItems($id);
$payments = getPaymentsByBillId($id);

if (!$bill) {
    echo "Bill not found!";
    exit;
}

if ($_SESSION['role'] == 'patient') {
    $currentPatient = getPatientByUserId($_SESSION['user_id']);
    if ($bill['patient_id'] != $currentPatient['id']) {
        echo "Access Denied: You can only view your own bills.";
        exit;
    }
    $backLink = "dashboard_patient.php";
} else {
    $backLink = "bill_list.php";
}

$subtotal = 0;
foreach ($items as $item) {
    $subtotal += ($item['quantity'] * $item['unit_price']);
}
$discount_amount = ($subtotal * $bill['discount']) / 100;
$after_discount = $subtotal - $discount_amount;
$tax_amount = ($after_discount * $bill['tax']) / 100;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoice #<?php echo $bill['id']; ?> - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar no-print">
        <span class="navbar-title">Hospital Management System</span>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
            <a href="bill_list.php" class="navbar-link">Bills</a>
        <?php else: ?>
            <a href="dashboard_patient.php" class="navbar-link">Dashboard</a>
            <a href="patient_bill_list.php" class="navbar-link">My Bills</a>
        <?php endif; ?>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <br>

    <div class="invoice-box">
        <div class="invoice-header">
            <div>
                <h2>INVOICE</h2>
                <strong>Bill ID:</strong> #<?php echo $bill['id']; ?><br>
                <strong>Date:</strong> <?php echo date('F d, Y', strtotime($bill['created_date'])); ?><br>
                <strong>Status:</strong>
                <?php
                if ($bill['paid_amount'] >= $bill['total_amount'])
                    echo 'PAID';
                elseif ($bill['paid_amount'] > 0)
                    echo 'PARTIAL';
                else
                    echo 'UNPAID';
                ?>
            </div>
            <div style="text-align: right;">
                <h3>City Hospital</h3>
                123 Street, Dhaka<br>
                Phone: 01712345678<br>
                Email: info@cityhospital.com
            </div>
        </div>

        <hr>

        <div class="invoice-header">
            <div>
                <strong>Bill To:</strong><br>
                <?php echo $bill['patient_name']; ?><br>
                <?php echo $bill['address']; ?><br>
                <?php echo $bill['phone']; ?>
            </div>
        </div>

        <table class="item-table">
            <tr style="background-color: #f2f2f2;">
                <th>Item Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['item_description']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['unit_price']; ?></td>
                    <td><?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="total-section">
            <p>Subtotal: <?php echo number_format($subtotal, 2); ?></p>
            <p>Discount (<?php echo $bill['discount']; ?>%): -<?php echo number_format($discount_amount, 2); ?></p>
            <p>Tax (<?php echo $bill['tax']; ?>%): +<?php echo number_format($tax_amount, 2); ?></p>
            <h3>Total Amount: <?php echo number_format($bill['total_amount'], 2); ?></h3>
            <p>Amount Paid: <?php echo number_format($bill['paid_amount'], 2); ?></p>
            <h4 style="color: red;">Balance Due:
                <?php echo number_format($bill['total_amount'] - $bill['paid_amount'], 2); ?>
            </h4>
        </div>

        <?php if (count($payments) > 0): ?>
            <div style="margin-top: 30px;">
                <h4>Payment History</h4>
                <table class="item-table" style="width: 80%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Trx ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $pay): ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i', strtotime($pay['payment_date'])); ?></td>
                                <td><?php echo $pay['payment_amount']; ?></td>
                                <td><?php echo $pay['payment_method']; ?></td>
                                <td><?php echo $pay['transaction_id']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="no-print" style="margin-top: 20px; text-align: center;">
            <button onclick="window.print()">Print Invoice</button>
            <a href="<?php echo $backLink; ?>"><button>Back to List</button></a>
        </div>
    </div>
</body>

</html>