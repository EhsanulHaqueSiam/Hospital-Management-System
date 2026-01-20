<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../view/auth_signin.php');
    exit;
}

// Autoload classes
require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/staff_model.php';
require_once __DIR__ . '/../models/DepartmentModel.php';

$staff_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$staff_id) {
    header('Location: admin_staff_router.php');
    exit;
}

$staffModel = new StaffModel();
$departmentModel = new DepartmentModel();
$staff = $staffModel->getStaffById($staff_id);

if (!$staff || (isset($staff['deleted']) && $staff['deleted'] == 1)) {
    header('Location: admin_staff_router.php?error=staff_not_found');
    exit;
}

// Calculate years of service
$joining_date = new DateTime($staff['joining_date']);
$today = new DateTime();
$interval = $today->diff($joining_date);
$years_of_service = $interval->y;
$months_of_service = $interval->m;

// Prepare staff data for display
$display_staff = [
    'staff_id' => $staff['staff_id'] ?? 'N/A',
    'name' => $staff['name'] ?? 'N/A',
    'email' => $staff['email'] ?? 'N/A',
    'phone' => $staff['phone'] ?? 'N/A',
    'role' => $staff['role'] ?? 'N/A',
    'department_id' => $staff['department_id'] ?? 'N/A',
    'designation' => $staff['designation'] ?? 'N/A',
    'joining_date' => $staff['joining_date'] ?? 'N/A',
    'salary' => $staff['salary'] ?? 0,
    'address' => $staff['address'] ?? 'N/A',
    'profile_picture' => $staff['profile_picture'] ?? null,
    'status' => $staff['status'] ?? 1,
    'years_of_service' => $years_of_service,
    'months_of_service' => $months_of_service,
    'user_id' => $staff['user_id'] ?? $staff_id
];

// Get department name
$departmentModel = new DepartmentModel();
$department = null;
if ($display_staff['department_id']) {
    $departments = $departmentModel->getAllDepartments();
    foreach ($departments as $dept) {
        if ($dept['department_id'] == $display_staff['department_id']) {
            $department = $dept;
            break;
        }
    }
}

include __DIR__ . '/../view/admin_staff_view.php';
?>
