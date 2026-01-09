<?php
require_once('db.php');

function getNotificationsByUser($user_id, $limit=20, $offset=0, $status='all'){
    $con = getConnection();
    $sql = "SELECT * FROM notifications WHERE user_id = ?";
    if ($status === 'unread') {
        $sql .= " AND is_read = 0";
    } elseif ($status === 'read') {
        $sql .= " AND is_read = 1";
    }
    $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return [];
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $items = [];
    while($row = mysqli_fetch_assoc($res)) $items[] = $row;
    mysqli_stmt_close($stmt);
    return $items;
}

function countNotificationsByUser($user_id, $status='all'){
    $con = getConnection();
    $sql = "SELECT COUNT(*) as total FROM notifications WHERE user_id = ?";
    if ($status === 'unread') $sql .= " AND is_read = 0";
    if ($status === 'read') $sql .= " AND is_read = 1";

    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return 0;
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
    return (int)$row['total'];
}

function markNotificationRead($id, $user_id){
    $con = getConnection();
    $sql = "UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'ii', $id, $user_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function markAllNotificationsRead($user_id){
    $con = getConnection();
    $sql = "UPDATE notifications SET is_read = 1, read_at = NOW() WHERE user_id = ? AND is_read = 0";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function clearAllReadNotifications($user_id){
    $con = getConnection();
    $sql = "DELETE FROM notifications WHERE user_id = ? AND is_read = 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function createNotification($user_id, $type, $message, $link = null){
    $con = getConnection();
    $sql = "INSERT INTO notifications (user_id, type, message, link) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    // bind types: i = int, s = string
    mysqli_stmt_bind_param($stmt, 'isss', $user_id, $type, $message, $link);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

?>
