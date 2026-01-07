<?php
require_once('../controller/adminCheck.php');
require_once('../model/paymentModel.php');
require_once('../model/billModel.php');

$id = $_REQUEST['id'];
$payment = getPaymentById($id);

if (!$payment) {
    echo "Payment not found";
    exit;
}

$bill = getBillById($payment['bill_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Payment - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="payment_list.php" class="navbar-link">Payments</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Edit Payment #
            <?php echo $payment['id']; ?>
        </h2>

        <form method="POST" action="../controller/edit_payment.php">
            <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
            <input type="hidden" name="bill_id" value="<?php echo $payment['bill_id']; ?>">

            <fieldset>
                <legend>Payment Details</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Bill:</td>
                        <td>
                            <strong>Bill #
                                <?php echo $bill['id']; ?> -
                                <?php echo $bill['patient_name']; ?>
                            </strong>
                            <br>Total Bill:
                            <?php echo $bill['total_amount']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Amount:</td>
                        <td>
                            <input type="number" step="0.01" name="amount"
                                value="<?php echo $payment['payment_amount']; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Method:</td>
                        <td>
                            <select name="method" required>
                                <option value="Cash" <?php if ($payment['payment_method'] == 'Cash')
                                    echo 'selected'; ?>
                                    >Cash</option>
                                <option value="Card" <?php if ($payment['payment_method'] == 'Card')
                                    echo 'selected'; ?>
                                    >Card</option>
                                <option value="Mobile Banking" <?php if ($payment['payment_method'] == 'Mobile Banking')
                                    echo 'selected'; ?>>Mobile Banking</option>
                                <option value="Bank Transfer" <?php if ($payment['payment_method'] == 'Bank Transfer')
                                    echo 'selected'; ?>>Bank Transfer</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction ID:</td>
                        <td><input type="text" name="trx_id" value="<?php echo $payment['transaction_id']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Notes:</td>
                        <td><textarea name="notes" rows="2"><?php echo $payment['payment_notes']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="update" value="Update Payment">
                            <a href="payment_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</body>

</html>