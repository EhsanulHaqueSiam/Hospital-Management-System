<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/patientModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $patient_id = intval($_POST['patient_id']);
    $user_id = intval($_POST['user_id']);

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $address = trim($_POST['address']);
    $emergency_contact = trim($_POST['emergency_contact']);

    $errors = [];
    if ($err = validateRequired($full_name, 'Full Name'))
        $errors[] = $err;
    if ($err = validateEmail($email))
        $errors[] = $err;
    if ($err = validatePhone($phone))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {

        $user = [
            'id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        $user_status = updateUser($user);


        $patient = getPatientById($patient_id);
        $patient['gender'] = $gender;
        $patient['blood_group'] = $blood_group;
        $patient['address'] = $address;
        $patient['emergency_contact'] = $emergency_contact;

        $patient_status = updatePatient($patient);

        if ($user_status && $patient_status) {
            header('location: ../view/patient_view.php?id=' . $patient_id);
        } else {
            echo "Failed to update patient";
        }
    }
} else {
    header('location: ../view/patient_list.php');
}
?>