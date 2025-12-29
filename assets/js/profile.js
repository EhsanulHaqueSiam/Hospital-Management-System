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

function isValidPhone(str) {
    if (str.length !== 11) return false;
    if (str.charAt(0) !== '0' || str.charAt(1) !== '1') return false;
    for (var i = 0; i < 11; i++) {
        var ch = str.charAt(i);
        if (ch < '0' || ch > '9') return false;
    }
    return true;
}

function hasLetterAndNumber(str) {
    var hasLetter = false;
    var hasNumber = false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        if ((ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z')) hasLetter = true;
        if (ch >= '0' && ch <= '9') hasNumber = true;
    }
    return hasLetter && hasNumber;
}

function showError(id, msg) {
    var el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearError(id) {
    var el = document.getElementById(id);
    if (el) el.textContent = '';
}

function validateProfileNameBlur() {
    var val = document.getElementsByName('full_name')[0].value.trim();
    if (!val) { showError('fullname-error', 'Name required'); return false; }
    if (val.length < 2) { showError('fullname-error', 'Name must be at least 2 characters'); return false; }
    if (!isValidName(val)) { showError('fullname-error', 'Name can only contain letters and spaces'); return false; }
    clearError('fullname-error');
    return true;
}

function validateProfilePhoneBlur() {
    var val = document.getElementsByName('phone')[0].value.trim();
    if (!val) { showError('phone-error', 'Phone required'); return false; }
    if (!isValidPhone(val)) { showError('phone-error', 'Invalid format. Example: 01712345678'); return false; }
    clearError('phone-error');
    return true;
}

function validateCurrentPasswordBlur() {
    var val = document.getElementsByName('current_password')[0].value;
    if (!val) { showError('current-password-error', 'Current password required'); return false; }
    clearError('current-password-error');
    return true;
}

function validateNewPasswordBlur() {
    var val = document.getElementsByName('new_password')[0].value;
    if (!val) { showError('new-password-error', 'New password required'); return false; }
    if (val.length < 8) { showError('new-password-error', 'Password must be at least 8 characters'); return false; }
    if (!hasLetterAndNumber(val)) { showError('new-password-error', 'Password must contain a letter and a number'); return false; }
    clearError('new-password-error');
    return true;
}

function validateConfirmNewPasswordBlur() {
    var newp = document.getElementsByName('new_password')[0].value;
    var conf = document.getElementsByName('confirm_password')[0].value;
    if (!conf) { showError('confirm-password-error', 'Please confirm password'); return false; }
    if (newp !== conf) { showError('confirm-password-error', 'Passwords do not match'); return false; }
    clearError('confirm-password-error');
    return true;
}

function validateEditProfile() {
    var valid = true;
    if (!validateProfileNameBlur()) valid = false;
    if (!validateProfilePhoneBlur()) valid = false;
    return valid;
}

function validateChangePassword() {
    var curr = document.getElementsByName('current_password')[0];
    var newp = document.getElementsByName('new_password')[0];

    var valid = true;
    if (!validateCurrentPasswordBlur()) valid = false;
    if (!validateNewPasswordBlur()) valid = false;
    if (!validateConfirmNewPasswordBlur()) valid = false;
    if (curr.value === newp.value) { showError('new-password-error', 'New password must be different'); return false; }
    return valid;
}

function validatePicture() {
    var file = document.getElementById('file-input');
    if (!file.files || !file.files[0]) { alert('Please select a file'); return false; }

    var fileName = file.files[0].name.toLowerCase();
    var validExtensions = ['.jpg', '.jpeg', '.png', '.gif'];
    var isValidType = false;

    for (var i = 0; i < validExtensions.length; i++) {
        if (fileName.indexOf(validExtensions[i]) === fileName.length - validExtensions[i].length) {
            isValidType = true;
            break;
        }
    }

    if (!isValidType) { alert('Only JPG, PNG, and GIF files are allowed'); return false; }
    if (file.files[0].size > 2 * 1024 * 1024) { alert('File size cannot exceed 2MB'); return false; }

    return true;
}

function previewPicture() {
    var file = document.getElementById('file-input');
    var preview = document.getElementById('preview-picture');
    if (file.files && file.files[0] && preview) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file.files[0]);
    }
}
