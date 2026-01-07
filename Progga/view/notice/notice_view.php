<?php
if (!isset($notice) || !$notice) {
    echo "Notice not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($notice['title']); ?></title>
</head>
<body>

<a href="notice_user_controller.php">← Back to Notices</a>

<h2><?php echo htmlspecialchars($notice['title']); ?></h2>

<p>
    <strong>Date:</strong> <?php echo date("F d, Y - H:i A", strtotime($notice['created_at'])); ?><br>
    <strong>Category:</strong> <?php echo htmlspecialchars($notice['category'] ?? 'Other'); ?><br>
    <strong>Important:</strong> <?php echo $notice['is_important'] ? 'YES' : 'NO'; ?>
</p>

<hr>

<div style="white-space: pre-wrap; word-wrap: break-word; line-height: 1.6;">
    <?php echo htmlspecialchars($notice['content']); ?>
</div>

<hr>

<a href="notice_user_controller.php"><button>Back to Notices</button></a>

</body>
</html>
