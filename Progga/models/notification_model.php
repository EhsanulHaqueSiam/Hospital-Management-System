<?php
require_once('db.php');

function getNotificationsByUser($user_id, $limit=20, $offset=0, $status='all'){
    $con = getConnection();
    $where = "WHERE user_id = $user_id";
    if ($status === 'unread') {
        $where .= " AND is_read = 0";
    } elseif ($status === 'read') {
        $where .= " AND is_read = 1";
    }
    $sql = "SELECT * FROM notifications $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $res = mysqli_query($con, $sql);
    $items = [];
    while($row = mysqli_fetch_assoc($res)) $items[] = $row;
    return $items;
}

function countNotificationsByUser($user_id, $status='all'){
    $con = getConnection();
    $where = "WHERE user_id = $user_id";
    if ($status === 'unread') $where .= " AND is_read = 0";
    if ($status === 'read') $where .= " AND is_read = 1";
    $sql = "SELECT COUNT(*) as total FROM notifications $where";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return (int)$row['total'];
}

function markNotificationRead($id, $user_id){
    $con = getConnection();
    $sql = "UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = $id AND user_id = $user_id";
    return mysqli_query($con, $sql);
}

function markAllNotificationsRead($user_id){
    $con = getConnection();
    $sql = "UPDATE notifications SET is_read = 1, read_at = NOW() WHERE user_id = $user_id AND is_read = 0";
    return mysqli_query($con, $sql);
}

function clearAllReadNotifications($user_id){
    $con = getConnection();
    $sql = "DELETE FROM notifications WHERE user_id = $user_id AND is_read = 1";
    return mysqli_query($con, $sql);
}

function createNotification($user_id, $type, $message, $link = null){
    $con = getConnection();
    $linkSql = $link ? "'".mysqli_real_escape_string($con,$link)."'" : 'NULL';
    $typeEsc = mysqli_real_escape_string($con, $type);
    $messageEsc = mysqli_real_escape_string($con, $message);
    $sql = "INSERT INTO notifications (user_id, type, message, link) VALUES ($user_id, '$typeEsc', '$messageEsc', $linkSql)";
    return mysqli_query($con, $sql);
}

?>
