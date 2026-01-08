<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/patientModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $gender = $_POST['gender'];
    $blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $emergency_contact = isset($_POST['emergency_contact']) ? trim($_POST['emergency_contact']) : '';

    $errors = [];
    if ($err = validateRequired($full_name, 'Full Name'))
        $errors[] = $err;
    if ($err = validateEmail($email))
        $errors[] = $err;
    if ($err = validatePhone($phone))
        $errors[] = $err;
    if ($err = validateUsername($username))
        $errors[] = $err;
    if ($err = validatePassword($password))
        $errors[] = $err;
    if ($err = validateRequired($gender, 'Gender'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
        echo "<br><a href='../view/patient_add.php'>Go Back</a>";
    } else {
        $existingUser = getUserByUsername($username);
        if ($existingUser) {
            echo "Username already exists. Please use a different username.";
            echo "<br><a href='../view/patient_add.php'>Go Back</a>";
        } else {
            $user = [
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'username' => $username,
                'password' => $password,
                'role' => 'patient',
                'address' => $address
            ];

            $new_user_id = addUser($user);

            if ($new_user_id) {
                $patient = [
                    'user_id' => $new_user_id,
                    'date_of_birth' => $date_of_birth,
                    'gender' => $gender,
                    'blood_group' => $blood_group,
                    'address' => $address,
                    'emergency_contact' => $emergency_contact,
                    'medical_history' => ''
                ];

                $patient_status = addPatient($patient);

                if ($patient_status) {
                    header('location: ../view/patient_list.php');
                } else {
                    echo "Failed to add patient record";
                    echo "<br><a href='../view/patient_list.php'>Go Back</a>";
                }
            } else {
                echo "Failed to create user account (email might be duplicate)";
                echo "<br><a href='../view/patient_add.php'>Go Back</a>";
            }
        }
    }
} else {
    header('location: ../view/patient_add.php');
}
?>