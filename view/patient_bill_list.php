<?php
require_once('../controller/patientCheck.php');
require_once('../model/billModel.php');
require_once('../model/patientModel.php');

$patient = getPatientByUserId($_SESSION['user_id']);
if (!$patient) {
    echo "Patient profile not found. Please contact admin.";
    exit;
}
$bills = getBillsByPatientId($patient['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Bills - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_patient.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>My Medical Bills</h2>
        <p><strong>Your Patient ID:</strong> #<?php echo $patient['id']; ?> (Looking for bills with this ID)</p>

        <fieldset>
            <legend>Actions</legend>
            <a href="dashboard_patient.php"><button>Back to Dashboard</button></a>
        </fieldset>

        <br>

        <fieldset>
            <legend>Billing History</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>Bill ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance Due</th>
                    <th>Status</th>
                    <th>Action</th>
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
                            <td>#
                                <?php echo $bill['id']; ?>
                            </td>
                            <td>
                                <?php echo date('d M Y', strtotime($bill['created_date'])); ?>
                            </td>
                            <td>
                                <?php echo $bill['total_amount']; ?>
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
                                <a href="bill_view.php?id=<?php echo $bill['id']; ?>"><button>View Details /
                                        Invoice</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">No bills found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>