<?php
require_once('db.php');

function getAllMedicines()
{
    $con = getConnection();
    $sql = "SELECT * FROM medicines ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    $medicines = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $medicines[] = $row;
        }
    }
    return $medicines;
}

function getMedicineById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM medicines WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function addMedicine($medicine)
{
    $con = getConnection();
    $name = mysqli_real_escape_string($con, $medicine['medicine_name']);
    $generic = mysqli_real_escape_string($con, $medicine['generic_name']);
    $category = mysqli_real_escape_string($con, $medicine['category']);
    $desc = mysqli_real_escape_string($con, $medicine['description']);
    $manufacturer = mysqli_real_escape_string($con, $medicine['manufacturer']);
    $price = mysqli_real_escape_string($con, $medicine['unit_price']);
    $stock = mysqli_real_escape_string($con, $medicine['stock_quantity']);
    $reorder = mysqli_real_escape_string($con, $medicine['reorder_level']);
    $expiry = mysqli_real_escape_string($con, $medicine['expiry_date']);

    $sql = "INSERT INTO medicines (medicine_name, generic_name, category, description, manufacturer, unit_price, stock_quantity, reorder_level, expiry_date) 
            VALUES ('{$name}', '{$generic}', '{$category}', '{$desc}', '{$manufacturer}', '{$price}', '{$stock}', '{$reorder}', '{$expiry}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateMedicine($medicine)
{
    $con = getConnection();
    $id = intval($medicine['id']);
    $name = mysqli_real_escape_string($con, $medicine['medicine_name']);
    $generic = mysqli_real_escape_string($con, $medicine['generic_name']);
    $category = mysqli_real_escape_string($con, $medicine['category']);
    $desc = mysqli_real_escape_string($con, $medicine['description']);
    $manufacturer = mysqli_real_escape_string($con, $medicine['manufacturer']);
    $price = mysqli_real_escape_string($con, $medicine['unit_price']);
    $stock = mysqli_real_escape_string($con, $medicine['stock_quantity']);
    $reorder = mysqli_real_escape_string($con, $medicine['reorder_level']);
    $expiry = mysqli_real_escape_string($con, $medicine['expiry_date']);

    $sql = "UPDATE medicines SET 
            medicine_name='{$name}', 
            generic_name='{$generic}', 
            category='{$category}', 
            description='{$desc}', 
            manufacturer='{$manufacturer}', 
            unit_price='{$price}', 
            stock_quantity='{$stock}', 
            reorder_level='{$reorder}', 
            expiry_date='{$expiry}' 
            WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteMedicine($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM medicines WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function searchMedicines($term)
{
    $con = getConnection();
    $term = mysqli_real_escape_string($con, $term);
    $sql = "SELECT * FROM medicines WHERE medicine_name LIKE '%{$term}%' OR generic_name LIKE '%{$term}%' ORDER BY medicine_name ASC";
    $result = mysqli_query($con, $sql);

    $medicines = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $medicines[] = $row;
    }
    return $medicines;
}
?>