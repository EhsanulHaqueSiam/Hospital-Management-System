<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/patientModel.php');

if (isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $user_id = $_POST['user_id'];


    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];


    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $address = $_POST['address'];
    $emergency_contact = $_POST['emergency_contact'];

    if ($full_name == "" || $email == "" || $phone == "") {
        echo "All required fields must be filled";
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