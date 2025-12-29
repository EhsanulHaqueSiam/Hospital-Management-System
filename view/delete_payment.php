<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'];

    foreach($_SESSION['payments'] as $key => $p){
        if($p['pay_id'] == $id){
            unset($_SESSION['payments'][$key]);
            $_SESSION['payments'] = array_values($_SESSION['payments']);
            break;
        }
    }

    header('location: view_payment_history.php');
?>