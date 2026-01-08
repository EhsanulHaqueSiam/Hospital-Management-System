<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign In - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Main Container -->
    <div class="main-container">
        <h2>Sign In</h2>

        <span class="success-message" id="success-message"></span>

        <form method="POST" action="../controller/signinCheck.php" onsubmit="return validateSignin()">
            <fieldset>
                <legend>Login Details</legend>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" value="" required onblur="validateSigninUser()"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="user-error"></span></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" required onblur="validateSigninPass()"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="password-error"></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="checkbox" name="remember_me"> Remember Me</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="signin" value="Sign In"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <div class="form-links">
            <a href="auth_forgot_password.php">Forgot Password?</a>
            <br><br>
            Don't have an account? <a href="auth_signup.php">Sign Up</a>
        </div>
    </div>

    <script src="../assets/js/auth.js"></script>
</body>

</html>