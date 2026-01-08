<?php
require_once('../controller/adminCheck.php');
require_once('../model/billModel.php');

$bills = getAllBills();
?>

<html>

<head>
    <title>Billing List - Hospital Management System</title>
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
        <h2>Billing Maagement</h2>

        <fieldset>
            <legend>Actions</legend>
            <a href="bill_add.php"><button type="button">Create New Bill</button></a>
        </fieldset>

        <br>

        <fieldset>
            <legend>All Bills</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>Bill ID</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Total Details</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($bills) > 0): ?>
                    <?php foreach ($bills as $bill): ?>
                        <?php
                        $balance = $bill['total_amount'] - $bill['paid_amount'];
                        $status = 'Unpaid';
                        $color = 'red';
                        if ($bill['paid_amount'] >= $bill['total_amount']) {
                            $status = 'Paid';
                            $color = 'green';
                        } elseif ($bill['paid_amount'] > 0) {
                            $status = 'Partial';
                            $color = 'orange';
                        }
                        ?>
                        <tr>
                            <td>
                                <?php echo $bill['id']; ?>
                            </td>
                            <td>
                                <?php echo $bill['patient_name']; ?>
                            </td>
                            <td>
                                <?php echo date('d M Y', strtotime($bill['created_date'])); ?>
                            </td>
                            <td>
                                Amount:
                                <?php echo $bill['total_amount']; ?><br>
                                Tax:
                                <?php echo $bill['tax']; ?>%<br>
                                Discount:
                                <?php echo $bill['discount']; ?>%
                            </td>
                            <td>
                                <?php echo $bill['paid_amount']; ?>
                            </td>
                            <td>
                                <?php echo number_format($balance, 2); ?>
                            </td>
                            <td style="color: <?php echo $color; ?>; font-weight: bold;">
                                <?php echo $status; ?>
                            </td>
                            <td>
                                <a href="bill_view.php?id=<?php echo $bill['id']; ?>"><button>View/Invoice</button></a>
                                <a href="bill_edit.php?id=<?php echo $bill['id']; ?>"><button>Edit</button></a>
                                <a href="payment_add.php?bill_id=<?php echo $bill['id']; ?>"><button>Add Payment</button></a>
                                <a href="../controller/delete_bill.php?id=<?php echo $bill['id']; ?>"
                                    onclick="return confirm('Delete this bill?');"><button>Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" align="center">No bills found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>