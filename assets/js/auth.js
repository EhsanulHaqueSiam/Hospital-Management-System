// Auth - Form Validation

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

function validateSignin() {
    var user = document.getElementsByName('email_username')[0];
    var pass = document.getElementsByName('password')[0];

    if (!user.value.trim()) { alert('Email or username required'); return false; }
    if (!pass.value) { alert('Password required'); return false; }
    return true;
}

function validateSignup() {
    var name = document.getElementsByName('full_name')[0];
    var email = document.getElementsByName('email')[0];
    var phone = document.getElementsByName('phone')[0];
    var user = document.getElementsByName('username')[0];
    var pass = document.getElementsByName('password')[0];
    var pass2 = document.getElementsByName('confirm_password')[0];

    var nameVal = name.value.trim();
    if (!nameVal) { alert('Name required'); return false; }
    if (nameVal.length < 2) { alert('Name must be at least 2 characters'); return false; }
    if (!isValidName(nameVal)) { alert('Name can only contain letters and spaces'); return false; }

    var emailVal = email.value.trim();
    if (!emailVal) { alert('Email required'); return false; }
    if (!isValidEmail(emailVal)) { alert('Invalid email format (example: user@domain.com)'); return false; }

    var phoneVal = phone.value.trim();
    if (!phoneVal) { alert('Phone required'); return false; }
    if (!isValidPhone(phoneVal)) { alert('Invalid phone format. Example: 01712345678'); return false; }

    var userVal = user.value.trim();
    if (!userVal) { alert('Username required'); return false; }
    if (userVal.length < 3) { alert('Username must be at least 3 characters'); return false; }
    if (userVal.length > 20) { alert('Username cannot exceed 20 characters'); return false; }
    if (!isValidUsername(userVal)) { alert('Username can only contain letters, numbers, and underscore'); return false; }

    if (!pass.value) { alert('Password required'); return false; }
    if (pass.value.length < 8) { alert('Password must be at least 8 characters'); return false; }
    if (pass.value !== pass2.value) { alert('Passwords do not match'); return false; }

    return true;
}

function validateForgotStep1() {
    var email = document.getElementsByName('email')[0];
    var emailVal = email.value.trim();
    if (!emailVal) { alert('Email required'); return false; }
    if (!isValidEmail(emailVal)) { alert('Invalid email format'); return false; }
    return true;
}

function validateForgotStep3() {
    var pass = document.getElementsByName('new_password')[0];
    var pass2 = document.getElementsByName('confirm_password')[0];
    if (!pass.value) { alert('Password required'); return false; }
    if (pass.value.length < 8) { alert('Password must be at least 8 characters'); return false; }
    if (pass.value !== pass2.value) { alert('Passwords do not match'); return false; }
    return true;
}
