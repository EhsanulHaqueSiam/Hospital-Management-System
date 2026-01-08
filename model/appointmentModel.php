<?php
require_once('db.php');


function getAppointmentById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM appointments WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllAppointments()
{
    $con = getConnection();
    $sql = "SELECT * FROM appointments ORDER BY appointment_date DESC";
    $result = mysqli_query($con, $sql);

    $appointments = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}

function getAppointmentsByPatient($patient_id)
{
    $con = getConnection();
    $patient_id = intval($patient_id);
    $sql = "SELECT * FROM appointments WHERE patient_id='{$patient_id}' ORDER BY appointment_date DESC";
    $result = mysqli_query($con, $sql);

    $appointments = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}

function getAppointmentsByDoctor($doctor_id)
{
    $con = getConnection();
    $doctor_id = intval($doctor_id);
    $sql = "SELECT * FROM appointments WHERE doctor_id='{$doctor_id}' ORDER BY appointment_date DESC";
    $result = mysqli_query($con, $sql);

    $appointments = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}

function getAppointmentsByStatus($status)
{
    $con = getConnection();
    $status = mysqli_real_escape_string($con, $status);

    $sql = "SELECT * FROM appointments WHERE status='{$status}' ORDER BY appointment_date DESC";
    $result = mysqli_query($con, $sql);

    $appointments = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}

function addAppointment($appointment)
{
    $con = getConnection();

    $appointment_date = mysqli_real_escape_string($con, $appointment['appointment_date']);
    $appointment_time = isset($appointment['appointment_time']) ? mysqli_real_escape_string($con, $appointment['appointment_time']) : '';
    $status = mysqli_real_escape_string($con, $appointment['status']);
    $reason = mysqli_real_escape_string($con, $appointment['reason']);
    $notes = mysqli_real_escape_string($con, $appointment['notes']);

    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status, reason, notes) 
            VALUES ('" . intval($appointment['patient_id']) . "', '" . intval($appointment['doctor_id']) . "', '{$appointment_date}', '{$appointment_time}', '{$status}', '{$reason}', '{$notes}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteAppointment($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM appointments WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateAppointment($appointment)
{
    $con = getConnection();

    $appointment_date = mysqli_real_escape_string($con, $appointment['appointment_date']);
    $status = mysqli_real_escape_string($con, $appointment['status']);
    $reason = mysqli_real_escape_string($con, $appointment['reason']);
    $notes = mysqli_real_escape_string($con, $appointment['notes']);

    $sql = "UPDATE appointments SET patient_id='" . intval($appointment['patient_id']) . "', doctor_id='" . intval($appointment['doctor_id']) . "', 
            appointment_date='{$appointment_date}', status='{$status}', reason='{$reason}', notes='{$notes}' 
            WHERE id='" . intval($appointment['id']) . "'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateAppointmentStatus($id, $status)
{
    $con = getConnection();
    $id = intval($id);
    $status = mysqli_real_escape_string($con, $status);

    $sql = "UPDATE appointments SET status='{$status}' WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function countAppointmentsByDoctor($doctor_id)
{
    $con = getConnection();
    $doctor_id = intval($doctor_id);
    $sql = "SELECT COUNT(*) as count FROM appointments WHERE doctor_id='{$doctor_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function countAppointmentsByPatient($patient_id)
{
    $con = getConnection();
    $patient_id = intval($patient_id);
    $sql = "SELECT COUNT(*) as count FROM appointments WHERE patient_id='{$patient_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

?>