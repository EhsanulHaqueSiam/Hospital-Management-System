<?php
session_start();
require_once('../models/notification_model.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: notice_user_controller.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$user_id = $_SESSION['user_id'];

if ($action == 'list') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $status = isset($_GET['status']) ? $_GET['status'] : 'all';
    $limit = 20;
    $offset = ($page - 1) * $limit;

    $total = countNotificationsByUser($user_id, $status);
    $totalPages = ceil($total / $limit);
    $notifications = getNotificationsByUser($user_id, $limit, $offset, $status);
    require_once('../view/notifications/notifications_list.php');
    exit;
}

if ($action == 'fetch') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $status = isset($_GET['status']) ? $_GET['status'] : 'all';
    $limit = 20;
    $offset = ($page - 1) * $limit;
    $notifications = getNotificationsByUser($user_id, $limit, $offset, $status);
    header('Content-Type: application/json');
    echo json_encode($notifications);
    exit;
}

if ($action == 'dropdown') {
    $notifications = getNotificationsByUser($user_id, 5, 0, 'all');
    $unread = countNotificationsByUser($user_id, 'unread');
    header('Content-Type: application/json');
    echo json_encode(['unread_count' => $unread, 'notifications' => $notifications]);
    exit;
}

if ($action == 'mark_read' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = (int)($_POST['id'] ?? 0);
    $ok = markNotificationRead($id, $user_id);
    $unread = countNotificationsByUser($user_id, 'unread');
    header('Content-Type: application/json');
    echo json_encode(['success' => (bool)$ok, 'unread_count' => $unread]);
    exit;
}

if ($action == 'mark_all_read' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $ok = markAllNotificationsRead($user_id);
    header('Content-Type: application/json');
    echo json_encode(['success' => (bool)$ok]);
    exit;
}

if ($action == 'clear_all_read' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $ok = clearAllReadNotifications($user_id);
    header('Content-Type: application/json');
    echo json_encode(['success' => (bool)$ok]);
    exit;
}

if ($action == 'view') {
    $id = (int)($_GET['id'] ?? 0);
    // mark read then redirect to link if exists
    markNotificationRead($id, $user_id);
    $con = getConnection();
    $res = mysqli_query($con, "SELECT link FROM notifications WHERE id = $id AND user_id = $user_id");
    if ($row = mysqli_fetch_assoc($res)){
        $link = $row['link'];
        if ($link) header('Location: '.$link);
    }
    header('Location: notification_controller.php');
    exit;
}

?>