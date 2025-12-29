<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');

    ?>
<html>
    <head>
        <title>ADD MEDICINE</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <h2>Add New Medicine</h2>
        
        <form method="POST" action="process_medicine.php" onsubmit="return validateAddMedicine()">
            <div>
                ID: <input type="text" name="med_id" onblur="validateMedIDBlur()"> 
                <span id="id-error"></span>
            </div><br>

            <div>
                Name: <input type="text" name="med_name" onblur="validateMedNameBlur()"> 
                <span id="name-error"></span>
            </div><br>

            <div>
                Category: <input type="text" name="med_cat" onblur="validateCategoryBlur()">
                <span id="cat-error"></span>
            </div><br>

            <div>
                Price: <input type="text" name="med_price" onblur="validatePriceBlur()"> 
                <span id="price-error"></span>
            </div><br>

            <div>
                Qty: <input type="text" name="med_qty" onblur="validateQtyBlur()"> 
                <span id="qty-error"></span>
            </div><br>

            <input type="submit" name="submit" value="SAVE MEDICINE">
            <a href="medicine_management.php">Cancel</a>
        </form>

        <script src="validation_medicine.js"></script>
    </body>
</html>