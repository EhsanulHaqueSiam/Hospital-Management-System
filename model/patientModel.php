<?php
require_once('db.php');


function getPatientById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM patients WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getPatientByUserId($user_id)
{
    $con = getConnection();
    $user_id = intval($user_id);
    $sql = "SELECT * FROM patients WHERE user_id='{$user_id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllPatients()
{
    $con = getConnection();
    $sql = "SELECT * FROM patients ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    $patients = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
    }

    return $patients;
}

function searchPatients($term)
{
    $con = getConnection();
    $term = mysqli_real_escape_string($con, $term);
    $sql = "SELECT p.* FROM patients p 
            JOIN users u ON p.user_id = u.id 
            WHERE u.full_name LIKE '%{$term}%' 
            OR u.phone LIKE '%{$term}%'
            ORDER BY p.id ASC";
    $result = mysqli_query($con, $sql);

    $patients = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
    return $patients;
}

function addPatient($patient)
{
    $con = getConnection();

    $date_of_birth = mysqli_real_escape_string($con, $patient['date_of_birth']);
    $gender = mysqli_real_escape_string($con, $patient['gender']);
    $blood_group = mysqli_real_escape_string($con, $patient['blood_group']);
    $address = mysqli_real_escape_string($con, $patient['address']);
    $emergency_contact = mysqli_real_escape_string($con, $patient['emergency_contact']);
    $medical_history = mysqli_real_escape_string($con, $patient['medical_history']);

    $sql = "INSERT INTO patients (user_id, date_of_birth, gender, blood_group, address, emergency_contact, medical_history) 
            VALUES ('" . intval($patient['user_id']) . "', '{$date_of_birth}', '{$gender}', '{$blood_group}', '{$address}', '{$emergency_contact}', '{$medical_history}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deletePatient($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM patients WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updatePatient($patient)
{
    $con = getConnection();

    $date_of_birth = mysqli_real_escape_string($con, $patient['date_of_birth']);
    $gender = mysqli_real_escape_string($con, $patient['gender']);
    $blood_group = mysqli_real_escape_string($con, $patient['blood_group']);
    $address = mysqli_real_escape_string($con, $patient['address']);
    $emergency_contact = mysqli_real_escape_string($con, $patient['emergency_contact']);
    $medical_history = mysqli_real_escape_string($con, $patient['medical_history']);

    $sql = "UPDATE patients SET date_of_birth='{$date_of_birth}', gender='{$gender}', blood_group='{$blood_group}', address='{$address}', 
            emergency_contact='{$emergency_contact}', medical_history='{$medical_history}' WHERE id='" . intval($patient['id']) . "'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>