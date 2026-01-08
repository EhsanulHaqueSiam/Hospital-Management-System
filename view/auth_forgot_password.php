<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Main Container -->
    <div class="main-container">
        <h2>Reset Password</h2>

        <!-- Simple Reset Password Form -->
        <form method="POST" action="../controller/forgotPasswordCheck.php"
            onsubmit="return validateForgotPasswordForm()">
            <fieldset>
                <legend>Reset Your Password</legend>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" required onblur="validateForgotUsername(this)"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" name="new_password" required onblur="validateForgotPassword(this)">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input type="password" name="confirm_password" required
                                onblur="validateForgotConfirm(this)"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="reset_password" value="Reset Password"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <div class="form-links">
            <a href="auth_signin.php">Back to Sign In</a>
        </div>
    </div>

    <script src="../assets/js/validation-common.js"></script>
    <script>
        function validateForgotUsername(field) {
            return validateRequiredBlur(field, 'Username');
        }
        function validateForgotPassword(field) {
            if (field.value.length < 4) {
                showFieldError(field, 'Password must be at least 4 characters');
                return false;
            }
            clearFieldError(field);
            return true;
        }
        function validateForgotConfirm(field) {
            var pwd = document.getElementsByName('new_password')[0].value;
            if (field.value !== pwd) {
                showFieldError(field, 'Passwords do not match');
                return false;
            }
            clearFieldError(field);
            return true;
        }

        function validateForgotPasswordForm() {
            var userField = document.getElementsByName('username')[0];
            var newField = document.getElementsByName('new_password')[0];
            var confField = document.getElementsByName('confirm_password')[0];

            var valid = true;
            if (!validateForgotUsername(userField)) valid = false;
            if (!validateForgotPassword(newField)) valid = false;
            if (!validateForgotConfirm(confField)) valid = false;

            return valid;
        }
    </script>
</body>

</html>