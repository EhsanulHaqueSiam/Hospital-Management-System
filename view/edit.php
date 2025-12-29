<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
    
    if(!isset($_GET['id'])){
        header('location: medicine_management.php');
        exit();
    }

    $id = $_GET['id'];
    $index = -1;
    foreach($_SESSION['medicines'] as $key => $m){
        if($m['id'] == $id){
            $index = $key;
            break;
        }
    }

    if($index === -1){
        header('location: medicine_management.php');
        exit();
    }

    $medicine = $_SESSION['medicines'][$index];

    if(isset($_POST['submit'])){
        $_SESSION['medicines'][$index]['name'] = $_POST['med_name'];
        $_SESSION['medicines'][$index]['category'] = $_POST['med_cat'];
        $_SESSION['medicines'][$index]['price'] = $_POST['med_price'];
        $_SESSION['medicines'][$index]['quantity'] = $_POST['med_qty'];
        
        header('location: medicine_management.php');
        exit();
    }
?>

<html>
<head>
    <title>Edit Medicine</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Edit Medicine: <?php echo $id; ?></h2>

    <form method="POST" onsubmit="return validateAddMedicine()">
        
        <div>
            Name: <input type="text" name="med_name" value="<?php echo $medicine['name']; ?>" onblur="validateMedNameBlur()">
            <span id="name-error" style="color:red;"></span>
        </div><br>

        <div>
            Category: <input type="text" name="med_cat" value="<?php echo $medicine['category']; ?>" onblur="validateCategoryBlur()">
            <span id="cat-error" style="color:red;"></span>
        </div><br>

        <div>
            Price: <input type="text" name="med_price" value="<?php echo $medicine['price']; ?>" onblur="validatePriceBlur()">
            <span id="price-error" style="color:red;"></span>
        </div><br>

        <div>
            Quantity: <input type="text" name="med_qty" value="<?php echo $medicine['quantity']; ?>" onblur="validateQtyBlur()">
            <span id="qty-error" style="color:red;"></span>
        </div><br>

        <input type="hidden" name="med_id" value="<?php echo $id; ?>">

        <input type="submit" name="submit" value="Update">
        <a href="medicine_management.php">Back</a>
    </form>

    <script src="validation_medicine.js"></script>
</body>
</html>