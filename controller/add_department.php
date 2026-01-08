<?php
require_once('adminCheck.php');
require_once('../model/departmentModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $department_name = trim($_POST['department_name']);
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $errors = [];
    if ($err = validateRequired($department_name, 'Department Name'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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