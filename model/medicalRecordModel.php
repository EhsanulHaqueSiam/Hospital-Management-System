<?php
require_once('db.php');


function getMedicalRecordById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM medical_records WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllMedicalRecords()
{
    $con = getConnection();
    $sql = "SELECT * FROM medical_records ORDER BY record_date DESC";
    $result = mysqli_query($con, $sql);

    $records = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
    }

    return $records;
}

function getMedicalRecordsByPatient($patient_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM medical_records WHERE patient_id='{$patient_id}' ORDER BY record_date DESC";
    $result = mysqli_query($con, $sql);

    $records = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
    }

    return $records;
}

function getMedicalRecordsByType($record_type)
{
    $con = getConnection();
    $record_type = mysqli_real_escape_string($con, $record_type);

    $sql = "SELECT * FROM medical_records WHERE record_type='{$record_type}' ORDER BY record_date DESC";
    $result = mysqli_query($con, $sql);

    $records = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
    }

    return $records;
}

function getMedicalRecordsByUploader($user_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM medical_records WHERE uploaded_by='{$user_id}' ORDER BY record_date DESC";
    $result = mysqli_query($con, $sql);

    $records = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
    }

    return $records;
}

function addMedicalRecord($record)
{
    $con = getConnection();

    $record_type = mysqli_real_escape_string($con, $record['record_type']);
    $description = mysqli_real_escape_string($con, $record['description']);
    $file_path = mysqli_real_escape_string($con, $record['file_path']);
    $record_date = mysqli_real_escape_string($con, $record['record_date']);

    $sql = "INSERT INTO medical_records (patient_id, record_type, description, file_path, record_date, uploaded_by) 
            VALUES ('{$record['patient_id']}', '{$record_type}', '{$description}', '{$file_path}', '{$record_date}', '{$record['uploaded_by']}')";

    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function deleteMedicalRecord($id)
{
    $con = getConnection();
    $sql = "DELETE FROM medical_records WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateMedicalRecord($record)
{
    $con = getConnection();

    $record_type = mysqli_real_escape_string($con, $record['record_type']);
    $description = mysqli_real_escape_string($con, $record['description']);
    $record_date = mysqli_real_escape_string($con, $record['record_date']);

    $sql = "UPDATE medical_records SET record_type='{$record_type}', description='{$description}', 
            record_date='{$record_date}' WHERE id='{$record['id']}'";

    // If new file path is provided, update it
    if (isset($record['file_path'])) {
        $file_path = mysqli_real_escape_string($con, $record['file_path']);
        $sql = "UPDATE medical_records SET record_type='{$record_type}', description='{$description}', 
                record_date='{$record_date}', file_path='{$file_path}' WHERE id='{$record['id']}'";
    }

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>