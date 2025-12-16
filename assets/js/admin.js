// Admin - Form Validation

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

function isValidText(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        var isLetter = (ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z');
        var isDigit = (ch >= '0' && ch <= '9');
        var isAllowed = (ch === ' ' || ch === '.' || ch === ',' || ch === '-' || ch === '&');
        if (!isLetter && !isDigit && !isAllowed) return false;
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

function validateDeptNameBlur() {
    var val = document.getElementsByName('department_name')[0].value.trim();
    if (!val) { showError('department-name-error', 'Department name required'); return false; }
    if (val.length < 2) { showError('department-name-error', 'Name must be at least 2 characters'); return false; }
    if (val.length > 50) { showError('department-name-error', 'Name cannot exceed 50 characters'); return false; }
    if (!isValidText(val)) { showError('department-name-error', 'Only letters, numbers, and basic punctuation'); return false; }
    clearError('department-name-error');
    return true;
}

function validateDoctorNameBlur() {
    var val = document.getElementsByName('full_name')[0].value.trim();
    if (!val) { showError('fullname-error', 'Name required'); return false; }
    if (val.length < 2) { showError('fullname-error', 'Name must be at least 2 characters'); return false; }
    if (!isValidName(val)) { showError('fullname-error', 'Name can only contain letters and spaces'); return false; }
    clearError('fullname-error');
    return true;
}

function validateDoctorEmailBlur() {
    var val = document.getElementsByName('email')[0].value.trim();
    if (!val) { showError('email-error', 'Email required'); return false; }
    if (!isValidEmail(val)) { showError('email-error', 'Invalid email format'); return false; }
    clearError('email-error');
    return true;
}

function validateDoctorPhoneBlur() {
    var val = document.getElementsByName('phone')[0].value.trim();
    if (!val) { showError('phone-error', 'Phone required'); return false; }
    if (!isValidPhone(val)) { showError('phone-error', 'Invalid format. Example: 01712345678'); return false; }
    clearError('phone-error');
    return true;
}

function validateDoctorUsernameBlur() {
    var el = document.getElementsByName('username')[0];
    if (!el) return true;
    var val = el.value.trim();
    if (!val) { showError('username-error', 'Username required'); return false; }
    if (val.length < 3) { showError('username-error', 'Username must be at least 3 characters'); return false; }
    if (val.length > 20) { showError('username-error', 'Username cannot exceed 20 characters'); return false; }
    if (!isValidUsername(val)) { showError('username-error', 'Only letters, numbers, and underscore'); return false; }
    clearError('username-error');
    return true;
}

function validateDoctorPasswordBlur() {
    var el = document.getElementsByName('password')[0];
    if (!el) return true;
    var val = el.value;
    if (!val) { showError('password-error', 'Password required'); return false; }
    if (val.length < 8) { showError('password-error', 'Password must be at least 8 characters'); return false; }
    clearError('password-error');
    return true;
}

function validateSpecializationBlur() {
    var val = document.getElementsByName('specialization')[0].value.trim();
    if (!val) { showError('specialization-error', 'Specialization required'); return false; }
    if (val.length < 2) { showError('specialization-error', 'Must be at least 2 characters'); return false; }
    if (!isValidText(val)) { showError('specialization-error', 'Only letters, numbers, and basic punctuation'); return false; }
    clearError('specialization-error');
    return true;
}

function validateDepartment() {
    return validateDeptNameBlur();
}

function validateDoctor() {
    var valid = true;
    if (!validateDoctorNameBlur()) valid = false;
    if (!validateDoctorEmailBlur()) valid = false;
    if (!validateDoctorPhoneBlur()) valid = false;
    if (!validateSpecializationBlur()) valid = false;
    if (!validateDoctorUsernameBlur()) valid = false;
    if (!validateDoctorPasswordBlur()) valid = false;

    var dept = document.getElementsByName('department_id')[0];
    if (!dept.value) { showError('department-error', 'Please select a department'); valid = false; }
    else { clearError('department-error'); }

    return valid;
}
