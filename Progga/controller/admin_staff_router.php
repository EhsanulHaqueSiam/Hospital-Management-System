<?php
session_start();

// Check authentication
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ./admin_signin.php');
    exit;
}

// Get the action from query parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Load required files
require_once(__DIR__ . '/../core/base_controller.php');
require_once(__DIR__ . '/../core/base_model.php');
require_once(__DIR__ . '/../models/db.php');
require_once(__DIR__ . '/../models/staffModel.php');
require_once(__DIR__ . '/../models/departmentModel.php');

// Create instances
$staffModel = new StaffModel();
$departmentModel = new DepartmentModel();

// Handle POST requests for status changes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    
    switch ($action) {
        case 'activate':
            handleActivateStaff();
            break;
        case 'deactivate':
            handleDeactivateStaff();
            break;
        case 'soft_delete':
            handleSoftDeleteStaff();
            break;
        default:
            header('Location: ./admin_staff_router.php');
            break;
    }
    exit;
}

// Route to appropriate action
switch ($action) {
    case 'list':
        handleListStaff();
        break;
        
    case 'view':
        handleViewStaff();
        break;
        
    case 'search':
        handleSearchStaff();
        break;
        
    case 'change_status':
        handleChangeStatus();
        break;
        
    case 'delete':
        handleDeleteStaff();
        break;
        
    case 'export_xml':
        handleExportXML();
        break;
        
    default:
        handleListStaff();
        break;
}

/**
 * Handle list staff action
 */
function handleListStaff() {
    global $staffModel, $departmentModel;
    
    // Get query parameters
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = 20;
    $role = isset($_GET['role']) && !empty($_GET['role']) ? $_GET['role'] : null;
    $department = isset($_GET['department']) && !empty($_GET['department']) ? $_GET['department'] : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;
    
    // Get staff data
    $staff = $staffModel->getAllStaff($page, $limit, $role, $department, $search);
    $totalStaff = $staffModel->getTotalStaffCount($role, $department, $search);
    $totalPages = ceil($totalStaff / $limit);
    
    // Get all departments for filter dropdown
    $departments = $departmentModel->getAllDepartments();
    
    // Get staff roles
    $roles = StaffModel::STAFF_ROLES;
    
    // Validate page
    if ($page > $totalPages && $totalPages > 0) {
        $page = $totalPages;
    }
    
    // Include the view
    $selectedRole = $role;
    $selectedDepartment = $department;
    $searchTerm = $search;
    $currentPage = $page;
    
    include(__DIR__ . '/../view/admin_staff_list.php');
}

/**
 * Handle view staff details
 */
function handleViewStaff() {
    global $staffModel;
    
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($user_id <= 0) {
        header('Location: ./admin_staff_router.php');
        exit;
    }
    
    $staff = $staffModel->getStaffById($user_id);
    
    if (!$staff) {
        header('Location: ./admin_staff_router.php');
        exit;
    }
    
    include(__DIR__ . '/../view/admin_staff_view.php');
}

/**
 * Handle AJAX search
 */
function handleSearchStaff() {
    global $staffModel;
    
    $searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
    
    if (strlen($searchTerm) < 2) {
        echo json_encode(['results' => []]);
        exit;
    }
    
    $results = $staffModel->searchStaff($searchTerm, 10);
    
    header('Content-Type: application/json');
    echo json_encode(['results' => $results]);
    exit;
}

/**
 * Handle change status
 */
function handleChangeStatus() {
    global $staffModel;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $status = isset($_POST['status']) ? (int)$_POST['status'] : -1;
    
    if ($user_id <= 0 || !in_array($status, [0, 1])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }
    
    if ($staffModel->updateStaffStatus($user_id, $status)) {
        $statusText = $status == 1 ? 'Activated' : 'Deactivated';
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => "Staff member {$statusText} successfully"]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
    exit;
}

/**
 * Handle delete staff
 */
function handleDeleteStaff() {
    global $staffModel;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    
    if ($user_id <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid staff ID']);
        exit;
    }
    
    if ($staffModel->deleteStaff($user_id)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Staff member deleted successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to delete staff member']);
    }
    exit;
}

/**
 * Handle export to XML
 */
function handleExportXML() {
    global $staffModel;
    
    $role = isset($_GET['role']) && !empty($_GET['role']) ? $_GET['role'] : null;
    $department = isset($_GET['department']) && !empty($_GET['department']) ? $_GET['department'] : null;
    
    $staff = $staffModel->getAllStaffForExport($role, $department);
    
    // Set headers for XML download
    header('Content-Type: application/xml; charset=utf-8');
    header('Content-Disposition: attachment; filename="staff_' . date('Y-m-d_H-i-s') . '.xml"');
    
    // Create XML
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><staff></staff>');
    $xml->addAttribute('exportDate', date('Y-m-d H:i:s'));
    $xml->addAttribute('totalRecords', count($staff));
    
    foreach ($staff as $member) {
        $staffMember = $xml->addChild('member');
        $staffMember->addChild('staffId', htmlspecialchars($member['staff_id'] ?? ''));
        $staffMember->addChild('name', htmlspecialchars($member['name'] ?? ''));
        $staffMember->addChild('email', htmlspecialchars($member['email'] ?? ''));
        $staffMember->addChild('role', htmlspecialchars($member['role'] ?? ''));
        $staffMember->addChild('department', htmlspecialchars($member['department_name'] ?? 'N/A'));
        $staffMember->addChild('phone', htmlspecialchars($member['phone'] ?? ''));
        $staffMember->addChild('status', $member['status'] == 1 ? 'Active' : 'Inactive');
        $staffMember->addChild('joinDate', htmlspecialchars($member['created_at'] ?? ''));
    }
    
    echo $xml->asXML();
    exit;
}

/**
 * Handle activate staff
 */
function handleActivateStaff() {
    global $staffModel;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    $user_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($user_id <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid staff ID']);
        exit;
    }
    
    if ($staffModel->updateStaffStatus($user_id, 1)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Staff member activated successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to activate staff member']);
    }
    exit;
}

/**
 * Handle deactivate staff
 */
function handleDeactivateStaff() {
    global $staffModel;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    $user_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($user_id <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid staff ID']);
        exit;
    }
    
    if ($staffModel->updateStaffStatus($user_id, 0)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Staff member deactivated successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to deactivate staff member']);
    }
    exit;
}

/**
 * Handle soft delete staff (mark as deleted)
 */
function handleSoftDeleteStaff() {
    global $staffModel;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    $user_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($user_id <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid staff ID']);
        exit;
    }
    
    if ($staffModel->softDeleteStaff($user_id)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Staff member deleted successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to delete staff member']);
    }
    exit;
}
?>
