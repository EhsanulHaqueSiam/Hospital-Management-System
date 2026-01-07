<?php
if (!isset($_SESSION['role'])) {
    echo "Please login first.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notice Board</title>
</head>
<body>

<h2>Hospital Notice Board</h2>

<?php if ($_SESSION['role'] === 'Admin') { ?>
    <p>
        <a href="notice_controller.php?action=create">
            <button>Create Notice</button>
        </a>
    </p>
<?php } ?>

<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Date</th>
        <th>Important</th>
        <th>Action</th>
    </tr>

<?php if (empty($notices)) { ?>
    <tr>
        <td colspan="5" align="center">No notices found</td>
    </tr>
<?php } else { ?>
    <?php foreach ($notices as $notice) { ?>
        <tr style="<?php echo $notice['is_important'] ? 'background-color:#ffe6e6;' : ''; ?>">
            <td><?php echo htmlspecialchars($notice['title']); ?></td>
            <td><?php echo htmlspecialchars($notice['category']); ?></td>
            <td><?php echo date("d M Y", strtotime($notice['created_at'])); ?></td>
            <td><?php echo $notice['is_important'] ? 'YES' : 'NO'; ?></td>
            <td>
                <a href="../../controller/notice_controller.php?action=details&id=<?=$notice['id']?>">Read</a>

                <?php if ($_SESSION['role'] === 'Admin') { ?>
                    |
                    <a href="../../controller/notice_controller.php?action=edit&id=<?=$notice['id']?>">Edit</a>
                    |
                    <a href="../../controller/notice_controller.php?action=delete&id=<?=$notice['id']?>"
                       onclick="return confirm('Delete this notice?')">Delete</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
<?php } ?>

</table>

</body>
</html>
