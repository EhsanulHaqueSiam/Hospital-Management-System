<?php
require_once('../controller/adminCheck.php');
require_once('../model/medicineModel.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$medicine = getMedicineById($id);

if (!$medicine) {
    header('location: medicine_list.php');
    exit;
}
?>

<html>

<head>
    <title>View Medicine - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="medicine_list.php" class="navbar-link">Medicines</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Medicine Details</h2>

        <fieldset>
            <legend>Medicine Information</legend>
            <table cellpadding="8">
                <tr>
                    <td><strong>Medicine ID:</strong></td>
                    <td>
                        <?php echo $medicine['id']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Medicine Name:</strong></td>
                    <td>
                        <?php echo $medicine['medicine_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Generic Name:</strong></td>
                    <td>
                        <?php echo $medicine['generic_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Category:</strong></td>
                    <td>
                        <?php echo $medicine['category']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Description:</strong></td>
                    <td>
                        <?php echo $medicine['description']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Manufacturer:</strong></td>
                    <td>
                        <?php echo $medicine['manufacturer']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Unit Price (Tk):</strong></td>
                    <td>
                        <?php echo $medicine['unit_price']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Stock Quantity:</strong></td>
                    <td>
                        <?php echo $medicine['stock_quantity']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Reorder Level:</strong></td>
                    <td>
                        <?php echo $medicine['reorder_level']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Expiry Date:</strong></td>
                    <td>
                        <?php echo $medicine['expiry_date']; ?>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <div>
            <a href="medicine_edit.php?id=<?php echo $medicine['id']; ?>"><button>Edit Medicine</button></a>
            <a href="medicine_list.php"><button>Back to List</button></a>
        </div>
    </div>
</body>

</html>