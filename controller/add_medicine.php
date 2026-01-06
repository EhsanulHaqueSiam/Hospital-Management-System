<?php
require_once('adminCheck.php');
require_once('../model/medicineModel.php');

if (isset($_POST['submit'])) {
    $medicine_name = $_POST['medicine_name'];
    $generic_name = $_POST['generic_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $manufacturer = $_POST['manufacturer'];
    $unit_price = $_POST['unit_price'];
    $stock_quantity = $_POST['stock_quantity'];
    $reorder_level = $_POST['reorder_level'];
    $expiry_date = $_POST['expiry_date'];

    if ($medicine_name == "" || $unit_price == "" || $stock_quantity == "") {
        echo "Required fields (Name, Price, Stock) are missing";
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