<?php
session_start();
require_once('../model/prescriptionModel.php');
require_once('../model/doctorModel.php');


if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $prescription_id = $_POST['prescription_id'];
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $diagnosis = $_POST['diagnosis'];
    $instructions = $_POST['instructions'];
    $follow_up_date = $_POST['follow_up_date'];


    if (empty($prescription_id) || empty($patient_id) || empty($diagnosis)) {
        header('location: ../view/prescription_edit.php?id=' . $prescription_id);
        exit;
    }


    $canEdit = false;
    if ($role == 'admin') {
        $canEdit = true;
    } elseif ($role == 'doctor') {
        $current_doctor = getDoctorByUserId($user_id);
        if ($current_doctor && $current_doctor['id'] == $doctor_id) {
            $canEdit = true;
        }
    }

    if (!$canEdit) {
        header('location: ../view/prescription_list.php');
        exit;
    }


    $prescription = [
        'id' => $prescription_id,
        'patient_id' => $patient_id,
        'doctor_id' => $doctor_id,
        'diagnosis' => $diagnosis,
        'instructions' => $instructions,
        'follow_up_date' => $follow_up_date ? $follow_up_date : null
    ];

    $result = updatePrescription($prescription);

    if ($result) {

        deletePrescriptionMedicines($prescription_id);


        $medicine_names = $_POST['medicine_name'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];
        $durations = $_POST['duration'];

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

        header('location: ../view/prescription_view.php?id=' . $prescription_id);
    } else {
        header('location: ../view/prescription_edit.php?id=' . $prescription_id);
    }
    exit;
} else {
    header('location: ../view/prescription_list.php');
    exit;
}
