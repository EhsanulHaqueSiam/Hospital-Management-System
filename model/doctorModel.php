<?php
require_once('db.php');


function getDoctorById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM doctors WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getDoctorByUserId($user_id)
{
    $con = getConnection();
    $user_id = intval($user_id);
    $sql = "SELECT * FROM doctors WHERE user_id='{$user_id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllDoctors()
{
    $con = getConnection();
    $sql = "SELECT * FROM doctors ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    $doctors = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
    }

    return $doctors;
}

function searchDoctors($term)
{
    $con = getConnection();
    $term = mysqli_real_escape_string($con, $term);
    $sql = "SELECT d.* FROM doctors d 
            JOIN users u ON d.user_id = u.id 
            WHERE u.full_name LIKE '%{$term}%' 
            OR d.specialization LIKE '%{$term}%'
            ORDER BY d.id ASC";
    $result = mysqli_query($con, $sql);

    $doctors = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
    return $doctors;
}

function getDoctorsByDepartment($department_id)
{
    $con = getConnection();
    $department_id = intval($department_id);
    $sql = "SELECT * FROM doctors WHERE department_id='{$department_id}' ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    $doctors = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
    }

    return $doctors;
}

function addDoctor($doctor)
{
    $con = getConnection();

    $specialization = mysqli_real_escape_string($con, $doctor['specialization']);
    $bio = mysqli_real_escape_string($con, $doctor['bio']);

    $sql = "INSERT INTO doctors (user_id, department_id, specialization, bio) 
            VALUES ('" . intval($doctor['user_id']) . "', '" . intval($doctor['department_id']) . "', '{$specialization}', '{$bio}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteDoctor($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM doctors WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateDoctor($doctor)
{
    $con = getConnection();

    $specialization = mysqli_real_escape_string($con, $doctor['specialization']);
    $bio = mysqli_real_escape_string($con, $doctor['bio']);

    $sql = "UPDATE doctors SET department_id='" . intval($doctor['department_id']) . "', specialization='{$specialization}', bio='{$bio}' 
            WHERE id='" . intval($doctor['id']) . "'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateDoctorDepartment($doctor_id, $department_id)
{
    $con = getConnection();
    $doctor_id = intval($doctor_id);
    $department_id = intval($department_id);

    $sql = "UPDATE doctors SET department_id='{$department_id}' WHERE id='{$doctor_id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>