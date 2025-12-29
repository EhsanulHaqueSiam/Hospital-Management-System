<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    $id = $_GET['id'];
    $index = -1;

    foreach($_SESSION['medicines'] as $key => $m){
        if($m['id'] == $id){
            $index = $key;
            break;
        }
    }

    if(isset($_POST['submit'])){
        $addAmount = (int)$_POST['add_qty'];
        $_SESSION['medicines'][$index]['quantity'] += $addAmount;
        
        header('location: medicine_management.php');
    }
?>

<html>
<head><title>Restock</title></head>
<body>
    <h2>Restock: <?php echo $_SESSION['medicines'][$index]['name']; ?></h2>
    <p>Current Quantity: <?php echo $_SESSION['medicines'][$index]['quantity']; ?></p>
    <form method="POST">
        Amount to add: <input type="number" name="add_qty" value="0"><br><br>
        <input type="submit" name="submit" value="Add to Stock">
        <a href="medicine_management.php">Back</a>
    </form>
</body>
</html>