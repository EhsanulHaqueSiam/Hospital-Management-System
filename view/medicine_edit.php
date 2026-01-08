<?php
require_once('../controller/adminCheck.php');
require_once('../model/medicineModel.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$medicine = getMedicineById($id);

if (!$medicine) {
    echo "Medicine not found!";
    exit;
}
?>

<html>

<head>
    <title>Edit Medicine - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="medicine_list.php" class="navbar-link">Medicines</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Edit Medicine</h2>

        <fieldset>
            <legend>Edit Information</legend>
            <form method="POST" action="../controller/edit_medicine.php" onsubmit="return validateForm(this)">
                <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">
                <table cellpadding="5">
                    <tr>
                        <td>Medicine Name:</td>
                        <td><input type="text" name="medicine_name" value="<?php echo $medicine['medicine_name']; ?>"
                                required onblur="validateRequiredBlur(this, 'Medicine Name')"></td>
                    </tr>
                    <tr>
                        <td>Generic Name:</td>
                        <td><input type="text" name="generic_name" value="<?php echo $medicine['generic_name']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category" required onchange="validateSelectBlur(this, 'Category')">
                                <option value="Painkiller" <?php if ($medicine['category'] == 'Painkiller')
                                    echo 'selected'; ?>>Painkiller</option>
                                <option value="Antibiotic" <?php if ($medicine['category'] == 'Antibiotic')
                                    echo 'selected'; ?>>Antibiotic</option>
                                <option value="Antiviral" <?php if ($medicine['category'] == 'Antiviral')
                                    echo 'selected'; ?>>Antiviral</option>
                                <option value="Antihistamine" <?php if ($medicine['category'] == 'Antihistamine')
                                    echo 'selected'; ?>>Antihistamine</option>
                                <option value="Vitamin" <?php if ($medicine['category'] == 'Vitamin')
                                    echo 'selected'; ?>>Vitamin</option>
                                <option value="Supplement" <?php if ($medicine['category'] == 'Supplement')
                                    echo 'selected'; ?>>Supplement</option>
                                <option value="Other" <?php if ($medicine['category'] == 'Other')
                                    echo 'selected'; ?>>
                                    Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="3"><?php echo $medicine['description']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Manufacturer:</td>
                        <td><input type="text" name="manufacturer" value="<?php echo $medicine['manufacturer']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Unit Price (Tk):</td>
                        <td><input type="number" step="0.01" name="unit_price"
                                value="<?php echo $medicine['unit_price']; ?>" required min="0"
                                onblur="validatePositiveNumberBlur(this, 'Price')"></td>
                    </tr>
                    <tr>
                        <td>Stock Quantity:</td>
                        <td><input type="number" name="stock_quantity"
                                value="<?php echo $medicine['stock_quantity']; ?>" required min="0"
                                onblur="validateIntegerBlur(this, 'Stock Quantity', 0)"></td>
                    </tr>
                    <tr>
                        <td>Reorder Level:</td>
                        <td><input type="number" name="reorder_level" value="<?php echo $medicine['reorder_level']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Expiry Date:</td>
                        <td><input type="date" name="expiry_date" value="<?php echo $medicine['expiry_date']; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="update" value="Update Medicine">
                            <a href="medicine_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>

    <script src="../assets/js/validation-common.js"></script>
</body>

</html>