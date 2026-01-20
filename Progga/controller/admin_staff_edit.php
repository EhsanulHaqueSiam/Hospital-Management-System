<?php
session_start();

// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../view/auth_signin.php');
    exit;
}

// Autoload classes
require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../core/Validator.php';
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/staff_model.php';
require_once __DIR__ . '/../models/DepartmentModel.php';

$staffModel = new StaffModel();
$departmentModel = new DepartmentModel();

$staff_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$success = false;
$errors = [];
$staff = null;
$departments = [];
$roles = StaffModel::STAFF_ROLES;

if (!$staff_id) {
    header('Location: admin_staff_router.php');
    exit;
}

// Get staff details
$staff = $staffModel->getStaffById($staff_id);

if (!$staff || (isset($staff['deleted']) && $staff['deleted'] == 1)) {
    header('Location: admin_staff_router.php?error=staff_not_found');
    exit;
}

// Get departments
$departments = $departmentModel->getAllDepartments();

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $department_id = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;
    $designation = trim($_POST['designation'] ?? '');
    $salary = !empty($_POST['salary']) ? (float)$_POST['salary'] : NULL;
    $status = isset($_POST['status']) ? (int)$_POST['status'] : (int)($staff['status'] ?? 1);
    $address = trim($_POST['address'] ?? '');

    // Validation rules
    $data = [
        'full_name' => $name,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'department_id' => $department_id,
        'designation' => $designation,
        'address' => $address
    ];

    $rules = [
        'full_name' => [
            'required' => true,
            'min' => 3,
            'max' => 100,
            'required_message' => 'Full name is required.',
            'min_message' => 'Full name must be at least 3 characters.',
            'max_message' => 'Full name cannot exceed 100 characters.'
        ],
        'email' => [
            'required' => true,
            'email' => true,
            'required_message' => 'Email is required.',
            'email_message' => 'Please enter a valid email address.'
        ],
        'phone' => [
            'required' => true,
            'numeric' => true,
            'min_length' => 10,
            'max_length' => 10,
            'required_message' => 'Phone number is required.',
            'numeric_message' => 'Phone must contain only numbers.',
            'min_length_message' => 'Phone must be exactly 10 digits.',
            'max_length_message' => 'Phone must be exactly 10 digits.'
        ],
        'role' => [
            'required' => true,
            'required_message' => 'Role is required.'
        ],
        'department_id' => [
            'required' => true,
            'required_message' => 'Department is required.'
        ],
        'designation' => [
            'required' => true,
            'max' => 100,
            'required_message' => 'Designation is required.',
            'max_message' => 'Designation cannot exceed 100 characters.'
        ],
        'address' => [
            'required' => true,
            'required_message' => 'Address is required.'
        ]
    ];

    $validation_errors = Validator::validate($data, $rules);

    // Check if role is valid
    if (!in_array($role, $roles)) {
        $validation_errors[] = 'Invalid role selected.';
    }

    // Check if email is unique (excluding current staff)
    if ($email !== $staff['email'] && $staffModel->emailExists($email, $staff_id)) {
        $validation_errors[] = 'This email is already registered.';
    }

    if (!empty($validation_errors)) {
        $errors = $validation_errors;
    } else {
        // Handle profile picture upload
        $profile_picture = null;
        if (!empty($_FILES['profile_picture']['name'])) {
            $file = $_FILES['profile_picture'];
            
            // Validate file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowed_types)) {
                $errors[] = 'Invalid image format. Only JPEG, PNG, and GIF are allowed.';
            } elseif ($file['size'] > $max_size) {
                $errors[] = 'Image size must not exceed 2MB.';
            } else {
                // Create uploads directory if it doesn't exist
                $upload_dir = __DIR__ . '/../../uploads/profiles/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Generate unique filename
                $staff_id_clean = str_replace('STF', '', $staff['staff_id'] ?? '');
                $filename = $staff_id_clean . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $upload_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $profile_picture = $filename;
                } else {
                    $errors[] = 'Failed to upload profile picture. Please try again.';
                }
            }
        }

        // If no errors, proceed with update
        if (empty($errors)) {
            $update_data = [
                'name' => Validator::sanitize($name),
                'email' => Validator::sanitize($email),
                'phone' => $phone,
                'role' => $role,
                'department_id' => $department_id,
                'designation' => Validator::sanitize($designation),
                'salary' => $salary,
                'status' => $status,
                'address' => Validator::sanitize($address)
            ];

            // Include profile picture if uploaded
            if ($profile_picture) {
                $update_data['profile_picture'] = $profile_picture;
            }

            if ($staffModel->updateStaff($staff_id, $update_data)) {
                $success = true;
                // Refresh staff data for display
                $staff = $staffModel->getStaffById($staff_id);
            } else {
                $errors[] = 'Failed to update staff information. Please try again.';
            }
        }
    }
}

// Fetch fresh data for form
if (!$success && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $staff = $staffModel->getStaffById($staff_id);
}

include __DIR__ . '/../view/admin_staff_edit.php';
?>

