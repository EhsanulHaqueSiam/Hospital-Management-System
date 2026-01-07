<?php
require_once('../controller/adminCheck.php');
require_once('../model/paymentModel.php');

$payments = getAllPayments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment History - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="bill_list.php" class="navbar-link">Bills</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Payment History</h2>

        <fieldset>
            <legend>Actions</legend>
            <a href="payment_add.php"><button type="button">Record New Payment</button></a>
        </fieldset>

        <br>

        <fieldset>
            <legend>All Payments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Bill ID</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Trx ID</th>
                    <th>Date</th>
                    <th>Received By</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($payments) > 0): ?>
                    <?php foreach ($payments as $pay): ?>
                        <tr>
                            <td>
                                <?php echo $pay['id']; ?>
                            </td>
                            <td><a href="bill_view.php?id=<?php echo $pay['bill_id']; ?>">#
                                    <?php echo $pay['bill_id']; ?>
                                </a></td>
                            <td>
                                <?php echo $pay['patient_name']; ?>
                            </td>
                            <td>
                                <?php echo $pay['payment_amount']; ?>
                            </td>
                            <td>
                                <?php echo $pay['payment_method']; ?>
                            </td>
                            <td>
                                <?php echo $pay['transaction_id']; ?>
                            </td>
                            <td>
                                <?php echo $pay['payment_date']; ?>
                            </td>
                            <td>
                                <?php echo $pay['received_by']; // This is just ID, ideally name but OK for now ?>
                            </td>
                            <td>
                                <a href="payment_edit.php?id=<?php echo $pay['id']; ?>"><button>Edit</button></a>
                                <a href="../controller/delete_payment.php?id=<?php echo $pay['id']; ?>"
                                    onclick="return confirm('Delete this payment? This will revert the bill balance.');"><button>Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" align="center">No payments found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>