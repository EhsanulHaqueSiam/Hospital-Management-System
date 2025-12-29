<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'];

    foreach($_SESSION['medicines'] as $key => $m){
        if($m['id'] == $id){
            unset($_SESSION['medicines'][$key]);
            $_SESSION['medicines'] = array_values($_SESSION['medicines']);
            break;
        }
    }

    header('location: medicine_management.php');
?>