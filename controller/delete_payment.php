<?php
require_once('adminCheck.php');
require_once('../model/paymentModel.php');
require_once('../model/billModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $payment = getPaymentById($id);

    if ($payment) {
        $bill_id = $payment['bill_id'];
        $amount = $payment['payment_amount'];

        $status = deletePayment($id);

        if ($status) {
            updateBillPaidAmount($bill_id, -$amount);
            header('location: ../view/bill_view.php?id=' . $bill_id);
        } else {
            echo "Failed to delete payment";
        }
    } else {
        echo "Payment not found";
    }
} else {
    header('location: ../view/payment_list.php');
}
?>