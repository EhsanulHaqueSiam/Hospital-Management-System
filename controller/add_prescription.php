<?php
session_start();
require_once('../model/prescriptionModel.php');
require_once('../model/doctorModel.php');
require_once('../model/validationHelper.php');

if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
if ($role != 'admin' && $role != 'doctor') {
    header('location: ../view/prescription_list.php');
    exit;
}

if (isset($_POST['submit'])) {
    $patient_id = intval($_POST['patient_id']);
    $doctor_id = intval($_POST['doctor_id']);
    $diagnosis = trim($_POST['diagnosis']);
    $instructions = trim($_POST['instructions']);
    $follow_up_date = $_POST['follow_up_date'];
    $appointment_id = isset($_POST['appointment_id']) && $_POST['appointment_id'] != '' ? intval($_POST['appointment_id']) : null;

    $medicine_names = $_POST['medicine_name'];
    $dosages = $_POST['dosage'];
    $frequencies = $_POST['frequency'];
    $durations = $_POST['duration'];

    $errors = [];
    if ($patient_id < 1)
        $errors[] = "Patient is required";
    if ($doctor_id < 1)
        $errors[] = "Doctor is required";
    if ($err = validateRequired($diagnosis, 'Diagnosis'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
        $prescription = [
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'diagnosis' => $diagnosis,
            'instructions' => $instructions,
            'follow_up_date' => $follow_up_date ? $follow_up_date : null,
            'appointment_id' => $appointment_id
        ];

        $prescription_id = addPrescription($prescription);

        if ($prescription_id) {
            for ($i = 0; $i < count($medicine_names); $i++) {
                if (!empty($medicine_names[$i])) {
                    $medicine = [
                        'prescription_id' => $prescription_id,
                        'medicine_name' => $medicine_names[$i],
                        'dosage' => $dosages[$i],
                        'frequency' => $frequencies[$i],
                        'duration' => $durations[$i]
                    ];
                    addPrescriptionMedicine($medicine);
                }
            }

            header('location: ../view/prescription_list.php');
        } else {
            echo "Failed to create prescription";
        }
    }
} else {
    header('location: ../view/prescription_add.php');
}
?>