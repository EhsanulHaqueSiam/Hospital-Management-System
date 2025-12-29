<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'];

    foreach($_SESSION['rooms'] as $key => $r){
        if($r['id'] == $id){
            unset($_SESSION['rooms'][$key]);
            $_SESSION['rooms'] = array_values($_SESSION['rooms']);
            break;
        }
    }
    header('location: room_management.php');
?>