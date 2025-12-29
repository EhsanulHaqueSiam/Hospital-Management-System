<?php
require_once('db.php');


function getDepartmentById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM departments WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getDepartmentByName($department_name)
{
    $con = getConnection();
    $department_name = mysqli_real_escape_string($con, $department_name);

    $sql = "SELECT * FROM departments WHERE department_name='{$department_name}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}


function getAllDepartments()
{
    $con = getConnection();
    $sql = "SELECT * FROM departments";
    $result = mysqli_query($con, $sql);

    $departments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $departments;
}


function addDepartment($department)
{
    $con = getConnection();

    $department_name = mysqli_real_escape_string($con, $department['department_name']);
    $description = mysqli_real_escape_string($con, $department['description']);

    $sql = "INSERT INTO departments (department_name, description) VALUES ('{$department_name}', '{$description}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}


function deleteDepartment($id)
{
    $con = getConnection();
    $sql = "DELETE FROM departments WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}


function updateDepartment($department)
{
    $con = getConnection();

    $department_name = mysqli_real_escape_string($con, $department['department_name']);
    $description = mysqli_real_escape_string($con, $department['description']);

    $sql = "UPDATE departments SET department_name='{$department_name}', description='{$description}' WHERE id='{$department['id']}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>