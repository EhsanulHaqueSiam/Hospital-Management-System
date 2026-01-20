<?php
session_start();

// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ./admin_signin.php');
    exit;
}

require_once(__DIR__ . '/../core/validator.php');
require_once(__DIR__ . '/../models/staff_model.php');
require_once(__DIR__ . '/../models/departmentModel.php');

$staffModel = new StaffModel();
$departmentModel = new DepartmentModel();

$errors = [];
$success = false;
$new_staff_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $department_id = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;
    $designation = trim($_POST['designation'] ?? '');
    $joining_date = trim($_POST['joining_date'] ?? date('Y-m-d'));
    $salary = !empty($_POST['salary']) ? (float)$_POST['salary'] : NULL;
    $address = trim($_POST['address'] ?? '');

    // Validation
    $data = [
        'full_name' => $full_name,
        'email' => $email,
        'phone' => $phone,
        'username' => $username,
        'password' => $password,
        'role' => $role,
        'department_id' => $department_id,
        'designation' => $designation,
        'joining_date' => $joining_date,
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
        'username' => [
            'required' => true,
            'min' => 3,
            'max' => 50,
            'alphanumeric' => true,
            'required_message' => 'Username is required.',
            'min_message' => 'Username must be at least 3 characters.',
            'max_message' => 'Username cannot exceed 50 characters.',
            'alphanumeric_message' => 'Username can only contain letters and numbers.'
        ],
        'password' => [
            'required' => true,
            'min' => 8,
            'required_message' => 'Password is required.',
            'min_message' => 'Password must be at least 8 characters.'
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
        'joining_date' => [
            'required' => true,
            'required_message' => 'Joining date is required.'
        ]
    ];

    $validation_errors = Validator::validate($data, $rules);

    // Additional validation
    if (!in_array($role, StaffModel::STAFF_ROLES)) {
        $validation_errors[] = 'Invalid role selected.';
    }

    if ($staffModel->usernameExists($username)) {
        $validation_errors[] = 'Username already exists. Please choose another.';
    }

    if ($staffModel->emailExists($email)) {
        $validation_errors[] = 'Email already registered. Please use another.';
    }

    if (!empty($validation_errors)) {
        $errors = $validation_errors;
    } else {
        // Generate staff ID
        $staff_id = $staffModel->generateStaffId();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Handle file upload
        $profile_picture = NULL;
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
                $filename = $staff_id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $upload_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $profile_picture = 'uploads/profiles/' . $filename;
                } else {
                    $errors[] = 'Failed to upload profile picture. Please try again.';
                }
            }
        }

        // If no errors during file upload, proceed with database insert
        if (empty($errors)) {
            $staff_data = [
                'staff_id' => $staff_id,
                'name' => Validator::sanitize($full_name),
                'email' => Validator::sanitize($email),
                'phone' => $phone,
                'username' => Validator::sanitize($username),
                'password' => $hashed_password,
                'role' => $role,
                'department_id' => $department_id,
                'designation' => Validator::sanitize($designation),
                'joining_date' => $joining_date,
                'salary' => $salary,
                'address' => Validator::sanitize($address),
                'profile_picture' => $profile_picture,
                'status' => 1 // Active
            ];

            if ($staffModel->createStaff($staff_data)) {
                $success = true;
                $new_staff_id = $staff_id;
                
                // TODO: Send welcome email
                // sendWelcomeEmail($email, $username, $password, $full_name);
            } else {
                $errors[] = 'Failed to add staff member. Please try again.';
            }
        }
    }
}

// Get departments for dropdown
$departments = $departmentModel->getAllDepartments();
$roles = StaffModel::STAFF_ROLES;

// Include the view
include(__DIR__ . '/../view/admin_staff_add.php');
?>
