<?php
require_once('db.php');

function addPayment($payment)
{
    $con = getConnection();
    $bill_id = $payment['bill_id'];
    $amount = $payment['payment_amount'];
    $method = mysqli_real_escape_string($con, $payment['payment_method']);
    $trx_id = mysqli_real_escape_string($con, $payment['transaction_id']);
    $notes = mysqli_real_escape_string($con, $payment['payment_notes']);
    $received_by = $payment['received_by'];

    $sql = "INSERT INTO payments (bill_id, payment_amount, payment_method, transaction_id, payment_notes, received_by) 
            VALUES ('{$bill_id}', '{$amount}', '{$method}', '{$trx_id}', '{$notes}', '{$received_by}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function getPaymentsByBillId($bill_id)
{
    $con = getConnection();
    $sql = "SELECT p.*, u.full_name as received_by_name 
            FROM payments p 
            JOIN users u ON p.received_by = u.id 
            WHERE p.bill_id='{$bill_id}' 
            ORDER BY p.payment_date DESC";
    $result = mysqli_query($con, $sql);

    $payments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }
    return $payments;
}

function getAllPayments()
{
    $con = getConnection();
    $sql = "SELECT p.*, b.patient_id, u.full_name as patient_name 
            FROM payments p 
            JOIN bills b ON p.bill_id = b.id 
            JOIN patients pt ON b.patient_id = pt.id 
            JOIN users u ON pt.user_id = u.id 
            ORDER BY p.payment_date DESC";
    $result = mysqli_query($con, $sql);

    $payments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }
    return $payments;
}

function getPaymentById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM payments WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function deletePayment($id)
{
    $con = getConnection();
    $sql = "DELETE FROM payments WHERE id='{$id}'";
    return mysqli_query($con, $sql);
}

function updatePayment($payment)
{
    $con = getConnection();
    $id = $payment['id'];
    $amount = $payment['payment_amount'];
    $method = mysqli_real_escape_string($con, $payment['payment_method']);
    $trx_id = mysqli_real_escape_string($con, $payment['transaction_id']);
    $notes = mysqli_real_escape_string($con, $payment['payment_notes']);

    $sql = "UPDATE payments SET payment_amount='{$amount}', payment_method='{$method}', transaction_id='{$trx_id}', payment_notes='{$notes}' WHERE id='{$id}'";
    return mysqli_query($con, $sql);
}
?>