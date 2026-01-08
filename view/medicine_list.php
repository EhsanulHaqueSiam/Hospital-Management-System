<?php
require_once('../controller/adminCheck.php');
require_once('../model/medicineModel.php');

$medicines = getAllMedicines();
?>

<html>

<head>
    <title>Medicine List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/ajax.js"></script>
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Medicine Inventory</h2>


        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        Search: <input type="text" name="search" placeholder="Type Name or Generic..."
                            onkeyup="ajaxSearchMedicine(this.value, 'medicine_table_body')">
                    </td>
                    <td>
                        <a href="medicine_add.php"><button type="button">Add Medicine</button></a>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>All Medicines</legend>
            <table border="1" cellpadding="8" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Medicine Name</th>
                        <th>Generic Name</th>
                        <th>Category</th>
                        <th>Price (Tk)</th>
                        <th>Stock</th>
                        <th>Manufacturer</th>
                        <th>Expiry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="medicine_table_body">
                    <?php if (count($medicines) > 0): ?>
                        <?php foreach ($medicines as $medicine): ?>
                            <tr <?php if ($medicine['stock_quantity'] <= $medicine['reorder_level'])
                                echo 'style="background-color: #ffcccc;"'; ?>>
                                <td>
                                    <?php echo $medicine['id']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['medicine_name']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['generic_name']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['category']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['unit_price']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['stock_quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['manufacturer']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['expiry_date']; ?>
                                </td>
                                <td>
                                    <a href="medicine_view.php?id=<?php echo $medicine['id']; ?>"><button>View</button></a>
                                    <a href="medicine_edit.php?id=<?php echo $medicine['id']; ?>"><button>Edit</button></a>
                                    <a href="../controller/delete_medicine.php?id=<?php echo $medicine['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this medicine?');"><button>Delete</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" align="center">No medicines found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php
            $low_stock = false;
            foreach ($medicines as $m) {
                if ($m['stock_quantity'] <= $m['reorder_level']) {
                    $low_stock = true;
                    break;
                }
            }
            if ($low_stock) {
                echo '<p style="color: red;"><strong>* Red rows indicate low stock (below reorder level)</strong></p>';
            }
            ?>

        </fieldset>
    </div>
</body>

</html>