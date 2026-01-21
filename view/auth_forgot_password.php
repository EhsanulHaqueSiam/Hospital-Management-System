<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
    <!-- Main Container -->
    <div class="main-container">
        <h2>Forgot Password</h2>

        <span class="success-message"></span>

        <!-- Step 1: Enter Email -->
        <form method="POST" action="../controller/forgot_password.php" onsubmit="return validateForgotStep1()">
            <fieldset>
                <legend>Step 1: Enter Email</legend>
                <table>
                    <tr>
                        <td>Email Address:</td>
                        <td><input type="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="send_code" value="Send Verification Code"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <!-- Step 2: Enter Verification Code -->
        <form method="POST" action="../controller/verify_code.php">
            <input type="hidden" name="email" value="">
            <fieldset>
                <legend>Step 2: Enter Verification Code</legend>
                <table>
                    <tr>
                        <td>Verification Code:</td>
                        <td><input type="text" name="verification_code" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="verify_code" value="Verify Code"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <!-- Step 3: Reset Password -->
        <form method="POST" action="../controller/reset_password.php" onsubmit="return validateForgotStep3()">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="token" value="">
            <fieldset>
                <legend>Step 3: Set New Password</legend>
                <table>
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

    <script src="../assets/js/auth.js"></script>
</body>

</html>
