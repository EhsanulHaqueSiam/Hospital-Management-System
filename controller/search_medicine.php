<?php
require_once('../model/medicineModel.php');

header('Content-Type: application/json');

$term = isset($_GET['search']) ? $_GET['search'] : '';
$medicines = searchMedicines($term);

$result = [];
foreach ($medicines as $m) {
    $result[] = [
        'id' => $m['id'],
        'medicine_name' => $m['medicine_name'],
        'generic_name' => $m['generic_name'],
        'category' => $m['category'],
        'unit_price' => $m['unit_price'],
        'stock_quantity' => $m['stock_quantity'],
        'manufacturer' => $m['manufacturer'],
        'expiry_date' => $m['expiry_date'],
        'low_stock' => ($m['stock_quantity'] <= $m['reorder_level'])
    ];
}

echo json_encode(['success' => true, 'medicines' => $result, 'count' => count($result)]);
?>