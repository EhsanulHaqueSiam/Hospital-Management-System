<?php
require_once('../controller/adminCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Medicine - Hospital Management System</title>
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
        <h2>Add New Medicine</h2>

        <fieldset>
            <legend>Medicine Information</legend>
            <form method="POST" action="../controller/add_medicine.php" onsubmit="return validateMedicineForm(this)">
                <table cellpadding="5">
                    <tr>
                        <td>Medicine Name:</td>
                        <td><input type="text" name="medicine_name" required></td>
                    </tr>
                    <tr>
                        <td>Generic Name:</td>
                        <td><input type="text" name="generic_name"></td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category">
                                <option value="Painkiller">Painkiller</option>
                                <option value="Antibiotic">Antibiotic</option>
                                <option value="Antiviral">Antiviral</option>
                                <option value="Antihistamine">Antihistamine</option>
                                <option value="Vitamin">Vitamin</option>
                                <option value="Supplement">Supplement</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td>Manufacturer:</td>
                        <td><input type="text" name="manufacturer"></td>
                    </tr>
                    <tr>
                        <td>Unit Price (Tk):</td>
                        <td><input type="number" step="0.01" name="unit_price" required></td>
                    </tr>
                    <tr>
                        <td>Stock Quantity:</td>
                        <td><input type="number" name="stock_quantity" required></td>
                    </tr>
                    <tr>
                        <td>Reorder Level:</td>
                        <td><input type="number" name="reorder_level" value="10"></td>
                    </tr>
                    <tr>
                        <td>Expiry Date:</td>
                        <td><input type="date" name="expiry_date"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="submit" value="Add Medicine">
                            <a href="medicine_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>

    <script src="../assets/js/validation-medicine.js"></script>
</body>

</html>