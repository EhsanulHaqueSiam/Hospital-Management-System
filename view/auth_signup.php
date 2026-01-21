<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
    <div class="main-container">
        <h2>Sign Up</h2>

        <span class="success-message" id="success-message"></span>

        <form method="POST" action="../controller/signupCheck.php" onsubmit="return validateSignup()">
            <fieldset>
                <legend>Registration Details</legend>
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" onblur="validateNameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="fullname-error"></span></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" onblur="validateEmailBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="email-error"></span></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" onblur="validatePhoneBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="phone-error"></span></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" onblur="validateUsernameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="username-error"></span></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" onblur="validatePasswordBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="password-error"></span></td>
                    </tr>
                    <tr>
                        <td>Re-type Password:</td>
                        <td><input type="password" name="confirm_password" onblur="validateConfirmPasswordBlur()"
                                required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="repassword-error"></span></td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td>
                            <select name="role" required>
                                <option value="">-- Select Role --</option>
                                <option value="Patient">Patient</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="signup" value="Sign Up"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <div class="form-links">
            Already have an account? <a href="auth_signin.php">Sign In</a>
        </div>
    </div>

    <script src="../assets/js/auth.js"></script>
</body>

</html>
