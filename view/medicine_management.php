<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    if (!isset($_SESSION['medicines'])) {
        $_SESSION['medicines'] = [
            ['id'=>'MED101', 'name'=>'Napa extra', 'category'=>'Fever', 'price'=>'10tk', 'quantity'=>120],
            ['id'=>'MED102', 'name'=>'Napa star', 'category'=>'Cold', 'price'=>'12tk', 'quantity'=>10],
            ['id'=>'MED103', 'name'=>'Napa', 'category'=>'General', 'price'=>'10tk', 'quantity'=>1200]
        ];
    }
?>

<html>
<head>
    <title>MEDICINE MANAGEMENT</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
     <form method="post" action="" enctype="application/x-www-form-urlencoded">
        <h2>Medicine Inventory</h2>
        
        <?php 
            if(isset($_POST['success'])){
                echo "Medicine added successfully!";
            }
        ?>

        <a href="add_medicine.php" class="addbtn">ADD MEDICINE</a>
        <br><br>

        <table border=1>
            <tr>
                <th>ID</th>
                <th>MEDICINE NAME</th>
                <th>CATEGORY</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>ACTION</th>
            </tr>

            <?php
                foreach($_SESSION['medicines'] as $m){
            ?>
                <tr>
                    <td><?php echo $m['id']; ?></td>
                    <td><?php echo $m['name']; ?></td>
                    <td><?php echo $m['category']; ?></td>
                    <td><?=$m['price']?></td>
                    <td><?=$m['quantity']?></td>
                    <td>
                        <a href="edit.php?id=<?=$m['id']?>"> EDIT </a> |
                        <a href="delete.php?id=<?=$m['id']?>"> DELETE </a>
                        <a href="restock.php?id=<?=$m['id']?>"> RESTOCK </a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
     </form>
     <script src="validation_medicine.js"></script>
</body>
</html>