<?php
session_start();

$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'Admin'; 

echo "Login successful.<br>";
echo "<a href='controller/notice_controller.php'>Go to Notice Board</a>";
