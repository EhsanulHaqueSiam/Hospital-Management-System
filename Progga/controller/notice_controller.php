<?php
require_once(__DIR__ . '/../models/session_helper.php');
require_once(__DIR__ . '/../models/notice_model.php');
require_once(__DIR__ . '/../core/validator.php');

SessionHelper::initSession();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Only allow admins to use this controller. Others go to public board.
if (!SessionHelper::isAdmin()) {
    // Try to restore from cookie if session expired
    if (!SessionHelper::verifyAuthCookie()) {
        header('Location: ../view/admin_signin.php?session_expired=1');
        exit;
    }
}

if ($action == 'index') {
    $notices = getAllNotices();
    require_once(__DIR__ . '/../view/notice/index.php');
} elseif ($action == 'create') {
    require_once(__DIR__ . '/../view/notice/create.php');
} elseif ($action == 'store') {
    $data = [
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'category' => $_POST['category'] ?? '',
        'expiry_date' => $_POST['expiry_date'] ?? ''
    ];
    $rules = [
        'title' => ['required' => true, 'min' => 5, 'max' => 200, 'required_message' => 'Title is required.'],
        'content' => ['required' => true, 'min' => 10, 'required_message' => 'Content is required.'],
        'category' => ['required' => true, 'required_message' => 'Category is required.'],
        'expiry_date' => ['date' => true]
    ];
    $errs = Validator::validate($data, $rules);
    if (!empty($errs)) {
        $error = implode(' ', $errs);
        require_once(__DIR__ . '/../view/notice/create.php');
        exit;
    }

    $notice = [
        'title' => Validator::sanitize($data['title']),
        'content' => Validator::sanitize($data['content']),
        'category' => Validator::sanitize($data['category']),
        'is_important' => isset($_POST['is_important']) ? 1 : 0,
        'expiry_date' => $data['expiry_date'] ?: null,
        'created_by' => $_SESSION['user_id']
    ];

    createNotice($notice);
    header("Location: notice_controller.php");
} elseif ($action == 'details') {
    $notice = getNoticeById($_GET['id']);
    require_once(__DIR__ . '/../view/notice/details.php');
} elseif ($action == 'edit') {
    $notice = getNoticeById($_GET['id']);
    require_once(__DIR__ . '/../view/notice/edit.php');
} elseif ($action == 'update') {
    $data = [
        'id' => $_POST['id'] ?? '',
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'category' => $_POST['category'] ?? '',
        'expiry_date' => $_POST['expiry_date'] ?? ''
    ];
    $rules = [
        'title' => ['required' => true, 'min' => 5, 'max' => 200, 'required_message' => 'Title is required.'],
        'content' => ['required' => true, 'min' => 10, 'required_message' => 'Content is required.'],
        'category' => ['required' => true, 'required_message' => 'Category is required.'],
        'expiry_date' => ['date' => true]
    ];
    $errs = Validator::validate($data, $rules);
    if (!empty($errs)) {
        $error = implode(' ', $errs);
        $notice = getNoticeById($data['id']);
        require_once(__DIR__ . '/../view/notice/edit.php');
        exit;
    }

    $notice = [
        'id' => (int)$data['id'],
        'title' => Validator::sanitize($data['title']),
        'content' => Validator::sanitize($data['content']),
        'category' => Validator::sanitize($data['category']),
        'is_important' => isset($_POST['is_important']) ? 1 : 0,
        'expiry_date' => $data['expiry_date'] ?: null
    ];
    updateNotice($notice);
    header("Location: notice_controller.php");
} elseif ($action == 'delete') {
    deleteNotice($_GET['id']);
    header("Location: notice_controller.php");
} elseif ($action == 'search') {
    $key = $_GET['key'] ?? '';
    $con = getConnection();
    $sql = "SELECT * FROM notices WHERE title LIKE '%$key%'";
    $result = mysqli_query($con, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
}
