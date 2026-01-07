<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign In</title>
</head>
<body>
    <h2>Admin Sign In</h2>

    <?php if (!empty($error)) { ?>
        <p style="color:red"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="post" action="../controller/admin_signin.php">
        <label>Username or Email:</label><br>
        <input type="text" name="user" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Sign In">
    </form>

    <p>
        <a href="#" onclick="history.back(); return false;">Back to Notices</a>
        <!-- fallback if history unavailable -->
        <span style="margin-left:10px;">|</span>
        <a href="../controller/notice_user_controller.php">Notices (fallback)</a>
    </p>
    <p style="margin-top:20px;color:#666;font-size:0.9em;">Test admin credentials: <strong>admin</strong> / <strong>admin123</strong> (or admin@hospital.com)</p>
</body>
</html>
