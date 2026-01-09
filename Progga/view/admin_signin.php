<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="../public/css/validation.css">
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; }
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
        form { background: #f5f5f5; padding: 20px; border-radius: 5px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
        input[type="checkbox"] { margin-right: 8px; }
        input[type="submit"] { margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        input[type="submit"]:hover { background: #0056b3; }
        .remember-me { margin-top: 15px; }
        .links { margin-top: 20px; text-align: center; font-size: 0.9em; }
        .links a { color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .credentials { margin-top: 20px; background: #fff3cd; padding: 10px; border-radius: 3px; font-size: 0.9em; }
    </style>
</head>
<body>
    <h2>Admin Sign In</h2>

    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <?php if (isset($_GET['session_expired'])) { ?>
        <p class="success">Your session expired. Please sign in again.</p>
    <?php } ?>

    <?php if (isset($_GET['created'])) { ?>
        <p class="success">Admin account created successfully. Please sign in.</p>
    <?php } ?>

    <form method="post" action="../controller/admin_signin.php">
        <div class="form-group">
            <label for="user" class="required">Username or Email</label>
            <input type="text" id="user" name="user" data-validate="true" data-label="Username or Email" autocomplete="username">
        </div>

        <div class="form-group">
            <label for="password" class="required">Password</label>
            <input type="password" id="password" name="password" data-validate="true" data-label="Password" autocomplete="current-password">
        </div>

        <div class="remember-me">
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me" style="display: inline; font-weight: normal;">Remember me for 30 days</label>
        </div>

        <input type="submit" value="Sign In">
    </form>

    <div class="links">
        <p>
            <a href="../controller/notice_user_controller.php">View Public Notices</a>
            <span style="margin: 0 10px;">|</span>
            <a href="./admin_signup.php">Create new admin account</a>
        </p>
    </div>

    <div class="credentials">
        <strong>Test admin credentials:</strong><br>
        Username: <strong>admin</strong><br>
        Password: <strong>admin123</strong><br>
        Email: <strong>admin@hospital.com</strong>
    </div>

    <script src="../public/js/validator.js"></script>
</body>
</html>
