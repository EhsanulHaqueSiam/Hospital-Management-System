<?php
require_once('adminCheck.php');
require_once('../model/departmentModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $department_name = trim($_POST['department_name']);
    $description = trim($_POST['description']);

    $errors = [];
    if ($err = validateRequired($department_name, 'Department Name'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
        $department = [
            'id' => $id,
            'department_name' => $department_name,
            'description' => $description
        ];

        $status = updateDepartment($department);

        if ($status) {
            header('location: ../view/admin_department_list.php');
        } else {
            echo "Failed to update department";
        }
    }
} else {
    header('location: ../view/admin_department_list.php');
}
?>