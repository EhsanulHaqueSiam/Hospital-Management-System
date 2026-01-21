<?php
session_start();
setcookie('status', 'true', time() - 10, '/');
setcookie('remember_user', '', time() - 10, '/');
unset($_SESSION['username']);
header('location: ./../view/auth_signin.php');
?>
