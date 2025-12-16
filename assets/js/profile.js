// Profile - Form Validation

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

function validateEditProfile() {
    var name = document.getElementsByName('full_name')[0];
    var phone = document.getElementsByName('phone')[0];

    var nameVal = name.value.trim();
    if (!nameVal) { alert('Name required'); return false; }
    if (nameVal.length < 2) { alert('Name must be at least 2 characters'); return false; }
    if (!isValidName(nameVal)) { alert('Name can only contain letters and spaces'); return false; }

    var phoneVal = phone.value.trim();
    if (!phoneVal) { alert('Phone required'); return false; }
    if (!isValidPhone(phoneVal)) { alert('Invalid phone format. Example: 01712345678'); return false; }

    return true;
}

function validateChangePassword() {
    var curr = document.getElementsByName('current_password')[0];
    var newp = document.getElementsByName('new_password')[0];
    var conf = document.getElementsByName('confirm_password')[0];

    if (!curr.value) { alert('Current password required'); return false; }
    if (!newp.value) { alert('New password required'); return false; }
    if (newp.value.length < 8) { alert('Password must be at least 8 characters'); return false; }
    if (!hasLetterAndNumber(newp.value)) { alert('Password must contain at least one letter and one number'); return false; }
    if (curr.value === newp.value) { alert('New password must be different from current password'); return false; }
    if (newp.value !== conf.value) { alert('Passwords do not match'); return false; }

    return true;
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
