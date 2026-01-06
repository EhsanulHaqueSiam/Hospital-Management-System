<?php
require_once('adminCheck.php');
require_once('../model/departmentModel.php');

if (isset($_POST['submit'])) {
    $department_name = $_POST['department_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    if ($department_name == "") {
        echo "Department name is required";
        echo "<br><a href='../view/admin_department_add.php'>Go Back</a>";
        exit;
    }

    $existing = getDepartmentByName($department_name);
    if ($existing) {
        echo "Department '$department_name' already exists!";
        echo "<br><a href='../view/admin_department_add.php'>Go Back</a>";
        exit;
    }

    $department = [
        'department_name' => $department_name,
        'description' => $description
    ];

    $status = addDepartment($department);

    if ($status) {
        header('location: ../view/admin_department_list.php');
        exit;
    } else {
        echo "Failed to add department";
        echo "<br><a href='../view/admin_department_add.php'>Go Back</a>";
        exit;
    }
} else {
    header('location: ../view/admin_department_add.php');
    exit;
}
?>