<?php
require_once('adminCheck.php');
require_once('../model/paymentModel.php');
require_once('../model/billModel.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $bill_id = $_POST['bill_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $trx_id = $_POST['trx_id'];
    $notes = $_POST['notes'];

    if ($amount == "") {
        echo "Amount is required";
    } else {

        $oldPayment = getPaymentById($id);
        $diff = $amount - $oldPayment['payment_amount'];

        $payment = [
            'id' => $id,
            'payment_amount' => $amount,
            'payment_method' => $method,
            'transaction_id' => $trx_id,
            'payment_notes' => $notes
        ];

        $status = updatePayment($payment);

        if ($status) {

            if ($diff != 0) {
                updateBillPaidAmount($bill_id, $diff);
            }
            header('location: ../view/payment_list.php');
        } else {
            echo "Failed to update payment";
        }
    }
} else {
    header('location: ../view/payment_list.php');
}
?>