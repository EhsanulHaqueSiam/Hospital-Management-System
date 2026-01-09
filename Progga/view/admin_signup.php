<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="../public/css/validation.css">
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; }
        .error { color: red; margin-bottom: 15px; }
        form { background: #f5f5f5; padding: 20px; border-radius: 5px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
        input[type="submit"] { margin-top: 20px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        input[type="submit"]:hover { background: #218838; }
        .links { margin-top: 20px; text-align: center; }
        .links a { color: #007bff; text-decoration: none; }
        .help-text { font-size: 0.85em; color: #666; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>Admin Sign Up</h2>

    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="post" action="../controller/admin_signup.php">
        <div class="form-group">
            <label for="username" class="required">Username</label>
            <input type="text" id="username" name="username" data-validate="true" data-label="Username" autocomplete="username">
            <div class="help-text">3-50 characters, letters, numbers and spaces only</div>
        </div>

        <div class="form-group">
            <label for="email" class="required">Email</label>
            <input type="email" id="email" name="email" data-validate="true" data-label="Email" autocomplete="email">
            <div class="help-text">Must be a valid email address</div>
        </div>

        <div class="form-group">
            <label for="password" class="required">Password</label>
            <input type="password" id="password" name="password" data-validate="true" data-label="Password" autocomplete="new-password">
            <div class="help-text">Minimum 6 characters</div>
        </div>

        <input type="submit" value="Sign Up">
    </form>

    <div class="links">
        <p><a href="admin_signin.php">Back to Admin Sign In</a></p>
    </div>

    <script src="../public/js/validator.js"></script>
</body>
</html>
