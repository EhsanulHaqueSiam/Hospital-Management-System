<?php
require_once('adminCheck.php');
require_once('../model/medicineModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $medicine_name = trim($_POST['medicine_name']);
    $generic_name = trim($_POST['generic_name']);
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    $manufacturer = trim($_POST['manufacturer']);
    $unit_price = $_POST['unit_price'];
    $stock_quantity = $_POST['stock_quantity'];
    $reorder_level = $_POST['reorder_level'];
    $expiry_date = $_POST['expiry_date'];

    $errors = [];
    if ($err = validateRequired($medicine_name, 'Medicine Name'))
        $errors[] = $err;
    if ($err = validatePositiveNumber($unit_price, 'Unit Price'))
        $errors[] = $err;
    if ($err = validatePositiveInteger($stock_quantity, 'Stock Quantity'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
        $medicine = [
            'medicine_name' => $medicine_name,
            'generic_name' => $generic_name,
            'category' => $category,
            'description' => $description,
            'manufacturer' => $manufacturer,
            'unit_price' => $unit_price,
            'stock_quantity' => $stock_quantity,
            'reorder_level' => $reorder_level,
            'expiry_date' => $expiry_date
        ];

        $status = addMedicine($medicine);

        if ($status) {
            header('location: ../view/medicine_list.php');
        } else {
            echo "Failed to add medicine (Name might be duplicate)";
        }
    }
} else {
    header('location: ../view/medicine_add.php');
}
?>