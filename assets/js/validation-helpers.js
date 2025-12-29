function isEmpty(value) {
    if (value === null || value === undefined) {
        return true;
    }
    return value.toString().trim().length === 0;
}

function hasMinLength(value, minLen) {
    if (isEmpty(value)) return false;
    return value.trim().length >= minLen;
}

// Check if character is a letter using charCodeAt
function isLetter(char) {
    var code = char.charCodeAt(0);
    return (code >= 65 && code <= 90) || (code >= 97 && code <= 122);
}

// Check if character is a digit using charCodeAt
function isDigit(char) {
    var code = char.charCodeAt(0);
    return code >= 48 && code <= 57;
}

// Check if character is alphanumeric
function isAlphaNumeric(char) {
    return isLetter(char) || isDigit(char);
}

function isValidName(value) {
    if (isEmpty(value)) return false;
    var trimmed = value.trim();
    if (trimmed.length < 2) return false;
    for (var i = 0; i < trimmed.length; i++) {
        var char = trimmed.charAt(i);
        if (!isLetter(char) && char !== ' ') return false;
    }
    return true;
}

function isValidEmail(value) {
    if (isEmpty(value)) return false;
    var str = value.trim();
    var atPos = str.indexOf("@");
    if (atPos < 1) return false;
    var afterAt = str.substring(atPos + 1);
    if (afterAt.indexOf("@") !== -1) return false;
    var dotPos = afterAt.indexOf(".");
    if (dotPos < 1) return false;
    if (afterAt.lastIndexOf(".") === afterAt.length - 1) return false;
    return afterAt.substring(afterAt.lastIndexOf(".") + 1).length >= 2;
}

function isAllDigits(value) {
    if (isEmpty(value)) return false;
    for (var i = 0; i < value.length; i++) {
        if (!isDigit(value.charAt(i))) return false;
    }
    return true;
}

function isValidPhone(value) {
    if (isEmpty(value)) return false;
    var str = value.trim();
    if (str.length !== 11) return false;
    if (!isAllDigits(str)) return false;
    return str.substring(0, 2) === "01";
}

function isValidPassword(value) {
    if (isEmpty(value)) return false;
    if (value.length < 8) return false;
    var hasLetter = false;
    var hasNumber = false;
    for (var i = 0; i < value.length; i++) {
        var char = value.charAt(i);
        if (isLetter(char)) hasLetter = true;
        if (isDigit(char)) hasNumber = true;
    }
    return hasLetter && hasNumber;
}

function isValidUsername(value) {
    if (isEmpty(value)) return false;
    var str = value.trim();
    if (str.length < 4 || str.length > 20) return false;
    for (var i = 0; i < str.length; i++) {
        var char = str.charAt(i);
        if (!isAlphaNumeric(char) && char !== '_') return false;
    }
    return true;
}

function isValidDOB(value) {
    if (isEmpty(value)) return false;
    var inputDate = new Date(value);
    if (isNaN(inputDate.getTime())) return false;
    var today = new Date();
    return inputDate <= today;
}

function isValidFutureDate(value) {
    if (isEmpty(value)) return false;
    var inputDate = new Date(value);
    if (isNaN(inputDate.getTime())) return false;
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    return inputDate >= today;
}

function isValidSelect(field) {
    return field.value !== "" && field.value !== null;
}

function showError(field, message) {
    clearError(field);
    var span = document.createElement("span");
    span.className = "error-message";
    span.textContent = message;
    field.parentNode.appendChild(span);
    field.style.borderColor = "red";
}

function clearError(field) {
    var parent = field.parentNode;
    var err = parent.getElementsByClassName("error-message")[0];
    if (err) parent.removeChild(err);
    field.style.borderColor = "";
}

function clearFormErrors(form) {
    var errors = form.getElementsByClassName("error-message");
    while (errors.length > 0) {
        errors[0].parentNode.removeChild(errors[0]);
    }
}
