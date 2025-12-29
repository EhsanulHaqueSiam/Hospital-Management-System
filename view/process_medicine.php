<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if(isset($_POST['submit'])){
        $id = $_POST['med_id'];
        $name = $_POST['med_name'];
        $cat = $_POST['med_cat'];
        $price = $_POST['med_price'];
        $qty = $_POST['med_qty'];

        if($id == "" || $name == "" || $price == "" || $qty == ""){
            echo "Error: Null data submitted";
        } else {
          
            $newMedicine = [
                'id' => $id,
                'name' => $name,
                'category' => $cat,
                'price' => $price . "tk",
                'quantity' => $qty
            ];
            $_SESSION['medicines'][] = $newMedicine;
            header('location: medicine_management.php');
        }
    } else {
        header('location: medicine_management.php');
    }
?>