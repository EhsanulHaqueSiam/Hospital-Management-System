<?php
session_start();
require_once(__DIR__ . '/../models/notice_model.php');

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($action == 'list') {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    $con = getConnection();
    
    // Build WHERE clause
    $where = "WHERE expiry_date IS NULL OR expiry_date >= CURDATE()";
    if ($category != 'all') {
        $where .= " AND category = '$category'";
    }
    if ($search) {
        $where .= " AND (title LIKE '%$search%' OR content LIKE '%$search%')";
    }
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM notices $where";
    $countResult = mysqli_query($con, $countSql);
    $countRow = mysqli_fetch_assoc($countResult);
    $totalNotices = $countRow['total'];
    $totalPages = ceil($totalNotices / $limit);
    
    // Get notices for current page
    $sql = "SELECT * FROM notices $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($con, $sql);
    $notices = [];
    while($row = mysqli_fetch_assoc($result)){
        $notices[] = $row;
    }
    
    require_once(__DIR__ . '/../view/notice/notice_board.php');
} elseif ($action == 'view') {
    $notice = getNoticeById($_GET['id']);
    require_once(__DIR__ . '/../view/notice/notice_view.php');
} elseif ($action == 'search') {
    $key = $_GET['key'] ?? '';
    $con = getConnection();
    $sql = "SELECT * FROM notices WHERE (title LIKE '%$key%' OR content LIKE '%$key%') AND (expiry_date IS NULL OR expiry_date >= CURDATE()) ORDER BY created_at DESC";
    $result = mysqli_query($con, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
} elseif ($action == 'categories') {
    $con = getConnection();
    $sql = "SELECT DISTINCT category FROM notices WHERE (expiry_date IS NULL OR expiry_date >= CURDATE()) AND category IS NOT NULL ORDER BY category";
    $result = mysqli_query($con, $sql);
    $categories = [];
    while($row = mysqli_fetch_assoc($result)){
        $categories[] = $row['category'];
    }
    header('Content-Type: application/json');
    echo json_encode($categories);
}
?>
