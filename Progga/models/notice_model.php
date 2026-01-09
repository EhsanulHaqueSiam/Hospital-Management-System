<?php
require_once('db.php');

function getAllNotices(){
    $con = getConnection();
    $sql = "SELECT * FROM notices 
            WHERE expiry_date IS NULL OR expiry_date >= CURDATE()
            ORDER BY created_at DESC";
    $result = mysqli_query($con, $sql);

    $notices = [];
    while($row = mysqli_fetch_assoc($result)){
        $notices[] = $row;
    }
    return $notices;
}

function getNoticeById($id){
    $con = getConnection();
    $sql = "SELECT * FROM notices WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
    return $row;
}

function createNotice($notice){
    $con = getConnection();
    $sql = "INSERT INTO notices (title, content, category, is_important, expiry_date, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    $expiry = $notice['expiry_date'] ?: null;
    mysqli_stmt_bind_param($stmt, 'sssisi', $notice['title'], $notice['content'], $notice['category'], $notice['is_important'], $expiry, $notice['created_by']);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateNotice($notice){
    $con = getConnection();
    $sql = "UPDATE notices SET title = ?, content = ?, category = ?, is_important = ?, expiry_date = ? WHERE id = ?";
    $expiry = $notice['expiry_date'] ?: null;
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'sssisi', $notice['title'], $notice['content'], $notice['category'], $notice['is_important'], $expiry, $notice['id']);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteNotice($id){
    $con = getConnection();
    $sql = "DELETE FROM notices WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
?>
