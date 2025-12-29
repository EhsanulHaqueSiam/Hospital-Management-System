<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if(isset($_POST['submit'])){
        $id = $_POST['room_no'];
        $type = $_POST['room_type'];
        $floor = $_POST['room_floor'];
        $price = $_POST['room_price'];
        $status = $_POST['room_status'];
        $patient = $_POST['room_patient'];


        if($id == "" || $type == "" || $floor == "" || $price == "" || $status == ""){
            echo "Error: Null data submitted";
        } else {
            $newRoom = [
                'id'      => $id,
                'type'    => $type,
                'floor'   => $floor,
                'price'   => $price . " tk",
                'status'  => $status,
                'patient' => $patient
            ];

            $_SESSION['rooms'][] = $newRoom;
            header('location: room_management.php');
        }
    } else {
        header('location: room_management.php');
    }
?>