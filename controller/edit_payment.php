<?php
require_once('adminCheck.php');
require_once('../model/paymentModel.php');
require_once('../model/billModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $bill_id = intval($_POST['bill_id']);
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $trx_id = trim($_POST['trx_id']);
    $notes = trim($_POST['notes']);

    $errors = [];
    if ($err = validatePositiveNumber($amount, 'Amount'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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