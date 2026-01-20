<?php
if (!isset($_SESSION['role'])) {
    echo "Please login first.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Notice</title>
</head>
<body>

<h2>Edit Notice</h2>

<form method="post" action="notice_controller.php?action=update">
    <input type="hidden" name="id" value="<?=$notice['id']?>">
    Title: <input type="text" name="title" value="<?=htmlspecialchars($notice['title'])?>"><br>
    Category: <input type="text" name="category" value="<?=htmlspecialchars($notice['category'])?>"><br>
    Content: <textarea name="content"><?=htmlspecialchars($notice['content'])?></textarea><br>
    Important: <input type="checkbox" name="is_important" value="1" <?=$notice['is_important'] ? 'checked' : ''?>><br>
    Expiry Date: <input type="date" name="expiry_date" value="<?=$notice['expiry_date']?>"><br>
    <input type="submit" value="Update">
    <a href="notice_controller.php"><button tSype="button">Cancel</button></a>
</form>

</body>
</html>
