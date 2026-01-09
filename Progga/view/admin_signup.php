<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign Up</title>
</head>
<body>
    <h2>Admin Sign Up</h2>

    <?php if (!empty($error)) { ?>
        <p style="color:red"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="post" action="../controller/admin_signup.php">
        <label>Username:</label><br>
        <input type="text" name="username" required autocomplete="username"><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" required autocomplete="email"><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required autocomplete="new-password"><br><br>
        
        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" required autocomplete="new-password"><br><br>
        
        <input type="submit" value="Sign Up">
    </form>

    <p><a href="admin_signin.php">Back to Admin Sign In</a></p>
</body>
</html>
