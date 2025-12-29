<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'];

    foreach($_SESSION['bills'] as $key => $i){
        if($i['bill_id'] == $id){
            unset($_SESSION['bills'][$key]);
            $_SESSION['bills'] = array_values($_SESSION['bills']);
            break;
        }
    }

    header('location: view_invoice_history.php');
?>