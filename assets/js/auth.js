function isValidName(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        var isLetter = (ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z');
        var isSpace = (ch === ' ');
        if (!isLetter && !isSpace) return false;
    }
    return true;
}

function isAllDigits(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        if (ch < '0' || ch > '9') return false;
    }
    return true;
}

function isValidEmail(email) {
    var atIndex = email.indexOf('@');
    if (atIndex < 1) return false;
    var afterAt = email.substring(atIndex + 1);
    if (afterAt.length < 3) return false;
    var dotIndex = afterAt.indexOf('.');
    if (dotIndex < 1) return false;
    if (dotIndex === afterAt.length - 1) return false;
    return true;
}

function isValidUsername(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        var isLetter = (ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z');
        var isDigit = (ch >= '0' && ch <= '9');
        var isUnderscore = (ch === '_');
        if (!isLetter && !isDigit && !isUnderscore) return false;
    }
    return true;
}

function isValidPhone(str) {
    if (str.length !== 11) return false;
    if (str.charAt(0) !== '0' || str.charAt(1) !== '1') return false;
    for (var i = 0; i < 11; i++) {
        var ch = str.charAt(i);
        if (ch < '0' || ch > '9') return false;
    }
    return true;
}

function showError(id, msg) {
    var el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearError(id) {
    var el = document.getElementById(id);
    if (el) el.textContent = '';
}

function validateNameBlur() {
    var val = document.getElementsByName('full_name')[0].value.trim();
    if (!val) { showError('fullname-error', 'Name required'); return false; }
    if (val.length < 2) { showError('fullname-error', 'Name must be at least 2 characters'); return false; }
    if (!isValidName(val)) { showError('fullname-error', 'Name can only contain letters and spaces'); return false; }
    clearError('fullname-error');
    return true;
}

function validateEmailBlur() {
    var val = document.getElementsByName('email')[0].value.trim();
    if (!val) { showError('email-error', 'Email required'); return false; }
    if (!isValidEmail(val)) { showError('email-error', 'Invalid email format (example: user@domain.com)'); return false; }
    clearError('email-error');
    return true;
}

function validatePhoneBlur() {
    var val = document.getElementsByName('phone')[0].value.trim();
    if (!val) { showError('phone-error', 'Phone required'); return false; }
    if (!isValidPhone(val)) { showError('phone-error', 'Invalid format. Example: 01712345678'); return false; }
    clearError('phone-error');
    return true;
}

function validateUsernameBlur() {
    var val = document.getElementsByName('username')[0].value.trim();
    if (!val) { showError('username-error', 'Username required'); return false; }
    if (val.length < 3) { showError('username-error', 'Username must be at least 3 characters'); return false; }
    if (val.length > 20) { showError('username-error', 'Username cannot exceed 20 characters'); return false; }
    if (!isValidUsername(val)) { showError('username-error', 'Username can only contain letters, numbers, and underscore'); return false; }
    clearError('username-error');
    return true;
}

function validatePasswordBlur() {
    var val = document.getElementsByName('password')[0].value;
    if (!val) { showError('password-error', 'Password required'); return false; }
    if (val.length < 8) { showError('password-error', 'Password must be at least 8 characters'); return false; }
    clearError('password-error');
    return true;
}

function validateConfirmPasswordBlur() {
    var pass = document.getElementsByName('password')[0].value;
    var conf = document.getElementsByName('confirm_password')[0].value;
    if (!conf) { showError('repassword-error', 'Please confirm password'); return false; }
    if (pass !== conf) { showError('repassword-error', 'Passwords do not match'); return false; }
    clearError('repassword-error');
    return true;
}

function validateSigninUser() {
    var val = document.getElementsByName('username')[0].value.trim();
    if (!val) { showError('user-error', 'Username required'); return false; }
    if (val.length < 3) { showError('user-error', 'Username must be at least 3 characters'); return false; }
    clearError('user-error');
    return true;
}

function validateSigninPass() {
    var val = document.getElementsByName('password')[0].value;
    if (!val) { showError('password-error', 'Password required'); return false; }
    if (val.length < 4) { showError('password-error', 'Password must be at least 4 characters'); return false; }
    clearError('password-error');
    return true;
}

function validateSignin() {
    var user = document.getElementsByName('email_username')[0];
    var pass = document.getElementsByName('password')[0];
    if (!user.value.trim()) { alert('Email or username required'); return false; }
    if (!pass.value) { alert('Password required'); return false; }
    return true;
}

function validateSignup() {
    var valid = true;
    if (!validateNameBlur()) valid = false;
    if (!validateEmailBlur()) valid = false;
    if (!validatePhoneBlur()) valid = false;
    if (!validateUsernameBlur()) valid = false;
    if (!validatePasswordBlur()) valid = false;
    if (!validateConfirmPasswordBlur()) valid = false;
    return valid;
}

function validateForgotStep1() {
    var email = document.getElementsByName('email')[0];
    var emailVal = email.value.trim();
    if (!emailVal) { showError('email-error', 'Email required'); return false; }
    if (!isValidEmail(emailVal)) { showError('email-error', 'Invalid email format'); return false; }
    clearError('email-error');
    return true;
}

function validateForgotStep3() {
    var pass = document.getElementsByName('new_password')[0];
    var pass2 = document.getElementsByName('confirm_password')[0];
    if (!pass.value) { showError('password-error', 'Password required'); return false; }
    if (pass.value.length < 8) { showError('password-error', 'Password must be at least 8 characters'); return false; }
    if (pass.value !== pass2.value) { showError('repassword-error', 'Passwords do not match'); return false; }
    clearError('password-error');
    clearError('repassword-error');
    return true;
}
