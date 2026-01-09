<?php
if (!isset($_SESSION['role'])) {
    echo "Please login first.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Notice</title>
    <link rel="stylesheet" href="../../public/css/validation.css">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; }
        form { background: #f5f5f5; padding: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="date"], textarea, select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
        textarea { resize: vertical; min-height: 200px; font-family: Arial, sans-serif; }
        input[type="checkbox"] { margin-right: 8px; }
        .checkbox-label { display: inline; font-weight: normal; }
        input[type="submit"] { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 10px; }
        input[type="submit"]:hover { background: #0056b3; }
        button { padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #545b62; }
        h2 { color: #333; }
        .action-buttons { margin-top: 20px; }
    </style>
</head>
<body>

<h2>Edit Notice</h2>

<form method="post" action="notice_controller.php?action=update">
    <input type="hidden" name="id" value="<?=$notice['id']?>">
    
    <div class="form-group">
        <label for="title" class="required">Title</label>
        <input type="text" id="title" name="title" data-validate="true" data-label="Title" value="<?=htmlspecialchars($notice['title'])?>">
    </div>

    <div class="form-group">
        <label for="category" class="required">Category</label>
        <select id="category" name="category" data-validate="true" data-label="Category">
            <option value="">-- Select Category --</option>
            <option value="Medical" <?=$notice['category'] === 'Medical' ? 'selected' : ''?>>Medical</option>
            <option value="Administrative" <?=$notice['category'] === 'Administrative' ? 'selected' : ''?>>Administrative</option>
            <option value="General" <?=$notice['category'] === 'General' ? 'selected' : ''?>>General</option>
            <option value="Emergency" <?=$notice['category'] === 'Emergency' ? 'selected' : ''?>>Emergency</option>
        </select>
    </div>

    <div class="form-group">
        <label for="content" class="required">Content</label>
        <textarea id="content" name="content" data-validate="true" data-label="Content"><?=htmlspecialchars($notice['content'])?></textarea>
    </div>

    <div class="form-group">
        <input type="checkbox" id="is_important" name="is_important" value="1" <?=$notice['is_important'] ? 'checked' : ''?>>
        <label for="is_important" class="checkbox-label">Mark as Important</label>
    </div>

    <div class="form-group">
        <label for="expiry_date">Expiry Date (Optional)</label>
        <input type="date" id="expiry_date" name="expiry_date" data-validate="true" data-label="Expiry Date" value="<?=$notice['expiry_date']?>">
    </div>

    <div class="action-buttons">
        <input type="submit" value="Update Notice">
        <a href="notice_controller.php"><button type="button">Cancel</button></a>
    </div>
</form>

<script src="../../public/js/validator.js"></script>
</body>
</html>
