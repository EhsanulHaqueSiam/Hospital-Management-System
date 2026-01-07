<?php
session_start();
require_once('../models/notice_model.php');

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($action == 'index') {
    $notices = getAllNotices();
    require_once('../view/notice/index.php');
} elseif ($action == 'create') {
    require_once('../view/notice/create.php');
} elseif ($action == 'store') {
    $notice = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'category' => $_POST['category'],
        'is_important' => isset($_POST['is_important']) ? 1 : 0,
        'expiry_date' => $_POST['expiry_date'],
        'created_by' => $_SESSION['user_id']
    ];
    insertNotice($notice);
    header("Location: notice_controller.php");
} elseif ($action == 'details') {
    $notice = getNoticeById($_GET['id']);
    require_once('../view/notice/details.php');
} elseif ($action == 'delete') {
    deleteNotice($_GET['id']);
    header("Location: notice_controller.php");
}
