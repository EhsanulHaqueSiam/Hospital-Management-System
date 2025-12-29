<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_SESSION['bills'])) {
            foreach ($_SESSION['bills'] as $key => $b) {
                if ($b['bill_id'] == $id) {
                    unset($_SESSION['bills'][$key]);
                    $_SESSION['bills'] = array_values($_SESSION['bills']);
                    break;
                }
            }
        }
    }

    header("Location: view_all_bills.php");
    exit();
?>