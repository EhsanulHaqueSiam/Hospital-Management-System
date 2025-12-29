<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'] ?? 'N/A';
?>
<html>
<body>
    <h1>Bill Details: <?php echo $id; ?></h1>
    <hr>
    <a href="view_all_bills.php">Back to List</a>
</body>
</html>