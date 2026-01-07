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
    $sql = "SELECT * FROM notices WHERE id = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function createNotice($notice){
    $con = getConnection();
    $sql = "INSERT INTO notices 
            VALUES (
                NULL,
                '{$notice['title']}',
                '{$notice['content']}',
                '{$notice['category']}',
                {$notice['is_important']},
                ".($notice['expiry_date'] ? "'{$notice['expiry_date']}'" : "NULL").",
                {$notice['created_by']},
                CURRENT_TIMESTAMP
            )";
    return mysqli_query($con, $sql);
}

function updateNotice($notice){
    $con = getConnection();
    $sql = "UPDATE notices SET
            title = '{$notice['title']}',
            content = '{$notice['content']}',
            category = '{$notice['category']}',
            is_important = {$notice['is_important']},
            expiry_date = ".($notice['expiry_date'] ? "'{$notice['expiry_date']}'" : "NULL")."
            WHERE id = {$notice['id']}";
    return mysqli_query($con, $sql);
}

function deleteNotice($id){
    $con = getConnection();
    $sql = "DELETE FROM notices WHERE id = $id";
    return mysqli_query($con, $sql);
}
?>
