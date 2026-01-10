<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign In</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.3);
        }
        input.is-valid { border-color: #28a745; }
        input.is-invalid { border-color: #dc3545; }
        .field-error { color: #dc3545; font-size: 0.9em; margin-top: 5px; }
        .form-group.has-error label { color: #dc3545; }
        .error-container { background: #ffe6e6; color: #dc3545; padding: 12px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #dc3545; }
        .success-container { background: #e6ffe6; color: #114b22; padding: 12px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #28a745; }
        input[type="checkbox"] { margin-right: 8px; }
        .remember-me { margin: 15px 0; }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover { background: #0056b3; }
        .links { margin-top: 20px; text-align: center; font-size: 0.9em; }
        .links a { color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .credentials { margin-top: 20px; background: #fff3cd; padding: 12px; border-radius: 3px; font-size: 0.9em; border-left: 4px solid #ffc107; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Sign In</h2>

        <?php if (!empty($error)) { ?>
            <div class="error-container"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <?php if (isset($_GET['session_expired'])) { ?>
            <div class="success-container">Your session expired. Please sign in again.</div>
        <?php } ?>

        <?php if (isset($_GET['created'])) { ?>
            <div class="success-container">Admin account created successfully. Please sign in.</div>
        <?php } ?>

        <form method="post" action="../controller/admin_signin.php" id="signinForm" data-validator="true">
            <div class="form-group">
                <label for="user">Username or Email</label>
                <input type="text" 
                       id="user"
                       name="user" 
                       required 
                       data-validate="true"
                       data-label="Username or Email"
                       placeholder="Enter username or email"
                       autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password"
                       name="password" 
                       required 
                       data-validate="true"
                       data-label="Password"
                       placeholder="Enter your password"
                       autocomplete="current-password">
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
            <strong>Test Admin Credentials:</strong><br>
            Username: <strong>admin</strong><br>
            Password: <strong>admin123</strong><br>
            Email: <strong>admin@hospital.com</strong>
        </div>
    </div>

    <script src="../public/js/validator.js"></script>
    <script>
        // Initialize form validator
        const signinForm = new FormValidator('#signinForm');
    </script>
</body>
</html>
