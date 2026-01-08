<?php
require_once('adminCheck.php');
require_once('../model/billModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $patient_id = intval($_POST['patient_id']);
    $appointment_id = isset($_POST['appointment_id']) ? intval($_POST['appointment_id']) : 0;
    $notes = trim($_POST['notes']);
    $discount = floatval($_POST['discount']);
    $tax = floatval($_POST['tax']);

    $descriptions = $_POST['item_description'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['unit_price'];

    $errors = [];
    if ($patient_id < 1)
        $errors[] = "Patient is required";
    if (empty($descriptions) || count($descriptions) == 0)
        $errors[] = "At least one item is required";

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
        exit;
    }
    $subtotal = 0;
    for ($i = 0; $i < count($descriptions); $i++) {
        $qty = $quantities[$i];
        $price = $prices[$i];
        $subtotal += ($qty * $price);
    }

    $discount_amount = ($subtotal * $discount) / 100;
    $after_discount = $subtotal - $discount_amount;
    $tax_amount = ($after_discount * $tax) / 100;
    $total_amount = $after_discount + $tax_amount;

    $bill = [
        'patient_id' => $patient_id,
        'appointment_id' => $appointment_id,
        'total_amount' => $total_amount,
        'discount' => $discount,
        'tax' => $tax,
        'notes' => $notes
    ];

    $bill_id = createBill($bill);

    if ($bill_id) {
        for ($i = 0; $i < count($descriptions); $i++) {
            if (!empty($descriptions[$i])) {
                $item = [
                    'bill_id' => $bill_id,
                    'item_description' => $descriptions[$i],
                    'quantity' => $quantities[$i],
                    'unit_price' => $prices[$i]
                ];
                addBillItem($item);
            }
        }
        header('location: ../view/bill_list.php');
    } else {
        echo "Failed to create bill";
    }
} else {
    header('location: ../view/bill_add.php');
}
?>