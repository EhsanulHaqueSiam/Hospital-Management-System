<?php
require_once('../model/medicineModel.php');

$term = isset($_GET['search']) ? $_GET['search'] : '';
$medicines = searchMedicines($term);

if (count($medicines) > 0) {
    foreach ($medicines as $medicine) {
        $stockStyle = ($medicine['stock_quantity'] <= $medicine['reorder_level']) ? 'style="background-color: #ffcccc;"' : '';

        echo "<tr {$stockStyle}>
                <td>{$medicine['id']}</td>
                <td>{$medicine['medicine_name']}</td>
                <td>{$medicine['generic_name']}</td>
                <td>{$medicine['category']}</td>
                <td>{$medicine['unit_price']}</td>
                <td>{$medicine['stock_quantity']}</td>
                <td>{$medicine['manufacturer']}</td>
                <td>{$medicine['expiry_date']}</td>
                <td>
                    <a href='medicine_edit.php?id={$medicine['id']}'><button>Edit</button></a>
                    <a href='../controller/delete_medicine.php?id={$medicine['id']}' onclick=\"return confirm('Are you sure you want to delete this medicine?');\"><button>Delete</button></a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9' align='center'>No medicines found</td></tr>";
}
?>