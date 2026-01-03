<?php
require_once('db.php');


function getPrescriptionById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM prescriptions WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllPrescriptions()
{
    $con = getConnection();
    $sql = "SELECT * FROM prescriptions ORDER BY created_date DESC";
    $result = mysqli_query($con, $sql);

    $prescriptions = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prescriptions[] = $row;
        }
    }

    return $prescriptions;
}

function getPrescriptionsByPatient($patient_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM prescriptions WHERE patient_id='{$patient_id}' ORDER BY created_date DESC";
    $result = mysqli_query($con, $sql);

    $prescriptions = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prescriptions[] = $row;
        }
    }

    return $prescriptions;
}

function getPrescriptionsByDoctor($doctor_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM prescriptions WHERE doctor_id='{$doctor_id}' ORDER BY created_date DESC";
    $result = mysqli_query($con, $sql);

    $prescriptions = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prescriptions[] = $row;
        }
    }

    return $prescriptions;
}

function getPrescriptionsByAppointment($appointment_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM prescriptions WHERE appointment_id='{$appointment_id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function addPrescription($prescription)
{
    $con = getConnection();

    $diagnosis = mysqli_real_escape_string($con, $prescription['diagnosis']);
    $instructions = mysqli_real_escape_string($con, $prescription['instructions']);
    $follow_up_date = isset($prescription['follow_up_date']) ? mysqli_real_escape_string($con, $prescription['follow_up_date']) : null;
    $appointment_id = isset($prescription['appointment_id']) ? mysqli_real_escape_string($con, $prescription['appointment_id']) : null;

    $sql = "INSERT INTO prescriptions (patient_id, doctor_id, appointment_id, diagnosis, instructions, follow_up_date) 
            VALUES ('{$prescription['patient_id']}', '{$prescription['doctor_id']}', " .
        ($appointment_id ? "'{$appointment_id}'" : "NULL") . ", '{$diagnosis}', '{$instructions}', " .
        ($follow_up_date ? "'{$follow_up_date}'" : "NULL") . ")";

    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function deletePrescription($id)
{
    $con = getConnection();

    // First delete associated medicines
    $sql = "DELETE FROM prescription_medicines WHERE prescription_id='{$id}'";
    mysqli_query($con, $sql);

    // Then delete the prescription
    $sql = "DELETE FROM prescriptions WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updatePrescription($prescription)
{
    $con = getConnection();

    $diagnosis = mysqli_real_escape_string($con, $prescription['diagnosis']);
    $instructions = mysqli_real_escape_string($con, $prescription['instructions']);
    $follow_up_date = isset($prescription['follow_up_date']) ? mysqli_real_escape_string($con, $prescription['follow_up_date']) : null;

    $sql = "UPDATE prescriptions SET diagnosis='{$diagnosis}', instructions='{$instructions}', 
            follow_up_date=" . ($follow_up_date ? "'{$follow_up_date}'" : "NULL") . " 
            WHERE id='{$prescription['id']}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}


// Prescription Medicines functions

function getPrescriptionMedicines($prescription_id)
{
    $con = getConnection();
    $sql = "SELECT * FROM prescription_medicines WHERE prescription_id='{$prescription_id}'";
    $result = mysqli_query($con, $sql);

    $medicines = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $medicines[] = $row;
        }
    }

    return $medicines;
}

function addPrescriptionMedicine($medicine)
{
    $con = getConnection();

    $medicine_name = mysqli_real_escape_string($con, $medicine['medicine_name']);
    $dosage = mysqli_real_escape_string($con, $medicine['dosage']);
    $frequency = mysqli_real_escape_string($con, $medicine['frequency']);
    $duration = mysqli_real_escape_string($con, $medicine['duration']);

    $sql = "INSERT INTO prescription_medicines (prescription_id, medicine_name, dosage, frequency, duration) 
            VALUES ('{$medicine['prescription_id']}', '{$medicine_name}', '{$dosage}', '{$frequency}', '{$duration}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deletePrescriptionMedicines($prescription_id)
{
    $con = getConnection();
    $sql = "DELETE FROM prescription_medicines WHERE prescription_id='{$prescription_id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>