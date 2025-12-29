<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    if(isset($_POST['submit'])){
        $newBill = [
            'bill_id'      => $_POST['bill_id'],
            'patient_name' => $_POST['patient_name'],
            'date'         => date("Y-m-d"),
            'total'        => $_POST['total_amount'],
            'paid'         => $_POST['paid_amount'],
            'status'       => $_POST['status']
        ];

        $_SESSION['bills'][] = $newBill;
        
        header('location: view_all_bills.php');
        exit();
    }
?>