<?php
require_once('../controller/adminCheck.php');
require_once('../model/billModel.php');

$selected_bill_id = isset($_GET['bill_id']) ? $_GET['bill_id'] : '';
$bills = getAllBills();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Record Payment - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function updateAmount() {
            var select = document.getElementById("bill_select");
            var option = select.options[select.selectedIndex];
            var balance = option.getAttribute("data-balance");
            document.getElementById("amount_display").innerText = "Balance Due: " + balance;
            document.getElementById("amount_input").value = balance;
        }
    </script>
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
        <h2>Record Payment</h2>

        <form method="POST" action="../controller/add_payment.php">
            <fieldset>
                <legend>Payment Details</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Select Bill:</td>
                        <td>
                            <select name="bill_id" id="bill_select" onchange="updateAmount()" required>
                                <option value="">-- Select Bill --</option>
                                <?php foreach ($bills as $b): ?>
                                    <?php 
                                        $balance = $b['total_amount'] - $b['paid_amount']; 
                                        if ($balance <= 0 && $selected_bill_id != $b['id']) continue; // Skip fully paid unless selected
                                    ?>
                                    <option value="<?php echo $b['id']; ?>" 
                                        data-balance="<?php echo number_format($balance, 2, '.', ''); ?>"
                                        <?php if($selected_bill_id == $b['id']) echo 'selected'; ?>>
                                        Bill #<?php echo $b['id']; ?> - <?php echo $b['patient_name']; ?> (Due: <?php echo $balance; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Amount:</td>
                        <td>
                            <input type="number" step="0.01" name="amount" id="amount_input" required>
                            <br><small id="amount_display"></small>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Method:</td>
                        <td>
                            <select name="method" required>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Mobile Banking">Mobile Banking</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction ID:</td>
                        <td><input type="text" name="trx_id" placeholder="(Optional)"></td>
                    </tr>
                    <tr>
                        <td>Notes:</td>
                        <td><textarea name="notes" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="submit" value="Record Payment">
                            <a href="<?php echo $selected_bill_id ? 'bill_view.php?id=' . $selected_bill_id : 'payment_list.php'; ?>"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    
    <?php if($selected_bill_id): ?>
    <script>updateAmount();</script>
    <?php endif; ?>
</body>

</html>
