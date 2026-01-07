<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/patientModel.php');

if (isset($_POST['submit'])) {
    // User data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Patient data
    $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $gender = $_POST['gender'];
    $blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $emergency_contact = isset($_POST['emergency_contact']) ? $_POST['emergency_contact'] : '';

    if ($full_name == "" || $email == "" || $phone == "" || $username == "" || $password == "" || $gender == "") {
        echo "All required fields must be filled";
        echo "<br><a href='../view/patient_add.php'>Go Back</a>";
    } else {
        // Check if username already exists
        $existingUser = getUserByUsername($username);
        if ($existingUser) {
            echo "Username already exists. Please use a different username.";
            echo "<br><a href='../view/patient_add.php'>Go Back</a>";
        } else {
            // Create user first
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
                // Create patient record
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