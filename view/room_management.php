<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if (!isset($_SESSION['rooms'])) {
        $_SESSION['rooms'] = [
            ['id'=>'101', 'type'=>'General Ward', 'floor'=>'1st', 'price'=>'2000tk', 'status'=>'Available', 'patient'=>''],
            ['id'=>'205', 'type'=>'Private Room', 'floor'=>'2nd', 'price'=>'10000tk', 'status'=>'Occupied', 'patient'=>'Mahedy'],
            ['id'=>'301', 'type'=>'ICU', 'floor'=>'3rd', 'price'=>'250000tk', 'status'=>'Maintenance', 'patient'=>'']
        ];
    }
?>

<html>
<head>
    <title>ROOM MANAGEMENT</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
     <form method="post" action="" enctype="application/x-www-form-urlencoded">
        <h2>Hospital Room Inventory</h2>
        
        <?php 
            if(isset($_POST['success'])){
                echo "Room added successfully!";
            }
        ?>

        <a href="add_room.php" class="addbtn">ADD ROOM</a>
        <br><br>

        <table border=1>
            <tr>
                <th>ROOM NO</th>
                <th>TYPE</th>
                <th>FLOOR</th>
                <th>PRICE</th>
                <th>STATUS</th>
                <th>PATIENT</th>
                <th>ACTION</th>
            </tr>

            <?php
                foreach($_SESSION['rooms'] as $r){
            ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo $r['type']; ?></td>
                    <td><?php echo $r['floor']; ?></td>
                    <td><?=$r['price']?></td>
                    <td><?=$r['status']?></td>
                    <td><?=$r['patient']?></td>
                    <td>
                        <a href="edit_room.php?id=<?=$r['id']?>"> EDIT </a>
                        <a href="delete_room.php?id=<?=$r['id']?>"> DELETE </a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
     </form>
     <script src="validation_room.js"></script>
</body>
</html>