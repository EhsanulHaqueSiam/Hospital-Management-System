<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if(!isset($_GET['id'])){
        header('location: room_management.php');
        exit();
    }

    $id = $_GET['id'];
    $index = -1;
    
    foreach($_SESSION['rooms'] as $key => $r){
        if($r['id'] == $id){
            $index = $key;
            break;
        }
    }
    if($index !== -1){
        $room = $_SESSION['rooms'][$index];
    } else {
       
        header('location: room_management.php');
        exit();
    }

    if(isset($_POST['submit'])){
    $_SESSION['rooms'][$index]['type'] = $_POST['room_type'];
    $_SESSION['rooms'][$index]['floor'] = $_POST['room_floor'];
    $_SESSION['rooms'][$index]['price'] = $_POST['room_price'];
    $_SESSION['rooms'][$index]['status'] = $_POST['room_status'];
    $_SESSION['rooms'][$index]['patient'] = $_POST['room_patient'];
    
    header('location: room_management.php');
    exit(); 
}
?>
<html>
<head>
    <title>Edit Room</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Edit Room: <?php echo $id; ?></h2>
    <form method="POST" onsubmit="return validateAddRoom()">
    
    Type: <input type="text" name="room_type" value="<?=$room['type']?>" onblur="validateRoomTypeBlur()">
    <span id="type-error"></span><br>

    Floor: <input type="text" name="room_floor" value="<?=$room['floor']?>" onblur="validateFloorBlur()">
    <span id="floor-error"></span><br>

    Price: <input type="text" name="room_price" value="<?=$room['price']?>" onblur="validatePriceBlur()">
    <span id="price-error"></span><br>

    Status: <input type="text" name="room_status" value="<?=$room['status']?>" onblur="validateStatusBlur()">
    <span id="status-error"></span><br>

    Patient: <input type="text" name="room_patient" value="<?=$room['patient']?>" onblur="validatePatientBlur()">
    <span id="patient-error"></span><br>

    <input type="submit" name="submit" value="Update">
</form>

<script src="validation_room.js"></script>
</body>
</html>