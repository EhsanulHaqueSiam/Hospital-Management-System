<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Sign Up</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
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
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover { background: #218838; }
        .links { margin-top: 20px; text-align: center; }
        .links a { color: #007bff; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .help-text { font-size: 0.85em; color: #666; margin-top: 3px; }
        .success { background: #e6ffe6; color: #114b22; padding: 12px; border-radius: 3px; margin-bottom: 20px; border-left: 4px solid #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Admin Account</h2>

        <?php if (!empty($error)) { ?>
            <div class="error-container"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form method="post" action="../controller/admin_signup.php" id="signupForm" data-validator="true">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username"
                       name="username" 
                       required 
                       minlength="3"
                       maxlength="50"
                       pattern="[a-zA-Z0-9]+"
                       data-validate="true"
                       data-label="Username"
                       placeholder="Enter username (3-50 chars)"
                       autocomplete="username">
                <div class="help-text">Letters and numbers only, 3-50 characters</div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email"
                       name="email" 
                       required 
                       data-validate="true"
                       data-label="Email"
                       placeholder="Enter valid email"
                       autocomplete="email">
                <div class="help-text">Must be a valid email address</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password"
                       name="password" 
                       required 
                       minlength="6"
                       data-validate="true"
                       data-label="Password"
                       placeholder="Enter password (min 6 chars)"
                       autocomplete="new-password">
                <div class="help-text">Minimum 6 characters</div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" 
                       id="confirm_password"
                       name="confirm_password" 
                       required 
                       data-validate="true"
                       data-label="Confirm Password"
                       data-match="password"
                       placeholder="Re-enter password"
                       autocomplete="new-password">
                <div class="help-text">Must match your password</div>
            </div>

            <input type="submit" value="Create Account">
        </form>

        <div class="links">
            <p>Already have an account? <a href="admin_signin.php">Sign In</a></p>
        </div>
    </div>

    <script src="../public/js/validator.js"></script>
    <script>
        // Initialize form validator
        const signupForm = new FormValidator('#signupForm');
    </script>
</body>
</html>
