<?php
require_once('adminCheck.php');
require_once('../model/paymentModel.php');
require_once('../model/billModel.php');

if (isset($_POST['submit'])) {
    $bill_id = $_POST['bill_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $trx_id = $_POST['trx_id'];
    $notes = $_POST['notes'];
    $received_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$received_by) {
        echo "Please login first";
        exit;
    }

    if ($bill_id == "" || $amount == "") {
        echo "Bill ID and Amount are required";
    } else {
        $payment = [
            'bill_id' => $bill_id,
            'payment_amount' => $amount,
            'payment_method' => $method,
            'transaction_id' => $trx_id,
            'payment_notes' => $notes,
            'received_by' => $received_by
        ];

        $status = addPayment($payment);

        if ($status) {
            updateBillPaidAmount($bill_id, $amount);
            header('location: ../view/bill_view.php?id=' . $bill_id);
        } else {
            echo "Failed to record payment";
        }
    }
} else {
    header('location: ../view/payment_add.php');
}
?>