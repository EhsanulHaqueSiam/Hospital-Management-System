<?php
require_once('db.php');


function getDoctorById($id)
{
    $con = getConnection();
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

function getDoctorsByDepartment($department_id)
{
    $con = getConnection();
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
            VALUES ('{$doctor['user_id']}', '{$doctor['department_id']}', '{$specialization}', '{$bio}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteDoctor($id)
{
    $con = getConnection();
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

    $sql = "UPDATE doctors SET department_id='{$doctor['department_id']}', specialization='{$specialization}', bio='{$bio}' 
            WHERE id='{$doctor['id']}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>