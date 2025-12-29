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
        <form method="POST" action="../controller/forgotPasswordCheck.php">
            <fieldset>
                <legend>Reset Your Password</legend>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" name="new_password" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input type="password" name="confirm_password" required></td>
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

</body>

</html>