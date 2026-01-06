<?php
session_start();
setcookie('status', 'true', time() - 10, '/');
setcookie('remember_user', '', time() - 10, '/');

session_unset();
session_destroy();

header('location: ../view/auth_signin.php');
exit;
?>