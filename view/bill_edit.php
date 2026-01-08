<?php
require_once('../controller/adminCheck.php');
require_once('../model/billModel.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$bill = getBillById($id);
$items = getBillItems($id);
$patients = getAllPatients();

if (!$bill) {
    echo "Bill not found";
    exit;
}
?>

<html>

<head>
    <title>Edit Bill - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body onload="calcBillTotal()">
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="bill_list.php" class="navbar-link">Bills</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Edit Bill #<?php echo $bill['id']; ?></h2>

        <form method="POST" action="../controller/edit_bill.php" onsubmit="return validateForm(this)">
            <input type="hidden" name="id" value="<?php echo $bill['id']; ?>">
            <fieldset>
                <legend>Patient Details</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <input type="text" value="<?php echo $bill['patient_name']; ?>" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td>Notes:</td>
                        <td><textarea name="notes" rows="2"><?php echo $bill['notes']; ?></textarea></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Bill Items</legend>
                <table id="items_table" border="1" cellpadding="5" width="100%">
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><input type="text" name="item_description[]"
                                    value="<?php echo $item['item_description']; ?>" required
                                    onblur="validateRequiredBlur(this, 'Description')"></td>
                            <td><input type="number" name="quantity[]" value="<?php echo $item['quantity']; ?>" min="1"
                                    onchange="calcBillTotal()" onblur="validateIntegerBlur(this, 'Quantity', 1)"></td>
                            <td><input type="number" name="unit_price[]" step="0.01"
                                    value="<?php echo $item['unit_price']; ?>" min="0" onchange="calcBillTotal()"
                                    onblur="validatePositiveNumberBlur(this, 'Price')"></td>
                            <td><span class="subtotal">0.00</span></td>
                            <td><button type="button" onclick="removeBillItem(this)">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
                <button type="button" onclick="addBillItem()">+ Add Item</button>
            </fieldset>

            <br>

            <fieldset>
                <legend>Summary</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Discount (%):</td>
                        <td><input type="number" id="discount" name="discount" value="<?php echo $bill['discount']; ?>"
                                min="0" onchange="calcBillTotal()"
                                onblur="validatePositiveNumberBlur(this, 'Discount')"></td>
                    </tr>
                    <tr>
                        <td>Tax (%):</td>
                        <td><input type="number" id="tax" name="tax" value="<?php echo $bill['tax']; ?>" min="0"
                                onchange="calcBillTotal()" onblur="validatePositiveNumberBlur(this, 'Tax')"></td>
                    </tr>
                    <tr>
                        <td><strong>Grand Total:</strong></td>
                        <td><strong id="grand_total"><?php echo $bill['total_amount']; ?></strong></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <input type="submit" name="update" value="Update Bill">
            <a href="bill_view.php?id=<?php echo $bill['id']; ?>"><button type="button">Cancel</button></a>
        </form>
    </div>
    <script src="../assets/js/validation-common.js"></script>
    <script src="../assets/js/bill.js"></script>
</body>

</html>