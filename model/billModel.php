<?php
require_once('db.php');

function createBill($bill)
{
    $con = getConnection();
    $patient_id = intval($bill['patient_id']);
    $appointment_id = $bill['appointment_id'] ? intval($bill['appointment_id']) : "NULL";
    $total = floatval($bill['total_amount']);
    $discount = floatval($bill['discount']);
    $tax = floatval($bill['tax']);
    $notes = mysqli_real_escape_string($con, $bill['notes']);

    $sql = "INSERT INTO bills (patient_id, appointment_id, total_amount, discount, tax, notes) 
            VALUES ('{$patient_id}', {$appointment_id}, '{$total}', '{$discount}', '{$tax}', '{$notes}')";

    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function addBillItem($item)
{
    $con = getConnection();
    $bill_id = intval($item['bill_id']);
    $desc = mysqli_real_escape_string($con, $item['item_description']);
    $qty = intval($item['quantity']);
    $price = floatval($item['unit_price']);

    $sql = "INSERT INTO bill_items (bill_id, item_description, quantity, unit_price) 
            VALUES ('{$bill_id}', '{$desc}', '{$qty}', '{$price}')";

    return mysqli_query($con, $sql);
}

function getAllBills()
{
    $con = getConnection();
    $sql = "SELECT b.*, u.full_name as patient_name 
            FROM bills b 
            JOIN patients p ON b.patient_id = p.id 
            JOIN users u ON p.user_id = u.id 
            ORDER BY b.created_date DESC";
    $result = mysqli_query($con, $sql);

    $bills = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = $row;
    }
    return $bills;
}

function getBillsByPatientId($patient_id)
{
    $con = getConnection();
    $patient_id = intval($patient_id);
    $sql = "SELECT b.*, u.full_name as patient_name 
            FROM bills b 
            JOIN patients p ON b.patient_id = p.id 
            JOIN users u ON p.user_id = u.id 
            WHERE b.patient_id='{$patient_id}'
            ORDER BY b.created_date DESC";
    $result = mysqli_query($con, $sql);

    $bills = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = $row;
    }
    return $bills;
}

function getBillById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT b.*, u.full_name as patient_name, u.phone, u.address 
            FROM bills b 
            JOIN patients p ON b.patient_id = p.id 
            JOIN users u ON p.user_id = u.id 
            WHERE b.id='{$id}'";
    $result = mysqli_query($con, $sql);

    return mysqli_fetch_assoc($result);
}

function getBillItems($bill_id)
{
    $con = getConnection();
    $bill_id = intval($bill_id);
    $sql = "SELECT * FROM bill_items WHERE bill_id='{$bill_id}'";
    $result = mysqli_query($con, $sql);

    $items = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return $items;
}

function updateBillPaidAmount($bill_id, $amount)
{
    $con = getConnection();
    $bill_id = intval($bill_id);
    $amount = floatval($amount);
    $sql = "UPDATE bills SET paid_amount = paid_amount + {$amount} WHERE id='{$bill_id}'";
    return mysqli_query($con, $sql);
}

function deleteBill($id)
{
    $con = getConnection();
    $id = intval($id);
    mysqli_query($con, "DELETE FROM bill_items WHERE bill_id='{$id}'");
    mysqli_query($con, "DELETE FROM payments WHERE bill_id='{$id}'");
    $sql = "DELETE FROM bills WHERE id='{$id}'";
    return mysqli_query($con, $sql);
}

function deleteBillItems($bill_id)
{
    $con = getConnection();
    $bill_id = intval($bill_id);
    return mysqli_query($con, "DELETE FROM bill_items WHERE bill_id='{$bill_id}'");
}

function updateBill($bill)
{
    $con = getConnection();
    $id = intval($bill['id']);
    $total = floatval($bill['total_amount']);
    $discount = floatval($bill['discount']);
    $tax = floatval($bill['tax']);
    $notes = mysqli_real_escape_string($con, $bill['notes']);

    $sql = "UPDATE bills SET total_amount='{$total}', discount='{$discount}', tax='{$tax}', notes='{$notes}' WHERE id='{$id}'";

    return mysqli_query($con, $sql);
}

function countBillsByPatient($patient_id)
{
    $con = getConnection();
    $patient_id = intval($patient_id);
    $sql = "SELECT COUNT(*) as count FROM bills WHERE patient_id='{$patient_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

?>