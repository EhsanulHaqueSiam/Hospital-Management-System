/* Individual Field Validation Functions - Called via onblur */

function validateName(field) {
    if (isEmpty(field.value)) {
        showError(field, "Full name is required");
        return false;
    }
    if (!isValidName(field.value)) {
        showError(field, "Name can only contain letters and spaces");
        return false;
    }
    clearError(field);
    return true;
}

function validateEmail(field) {
    if (isEmpty(field.value)) {
        showError(field, "Email is required");
        return false;
    }
    if (!isValidEmail(field.value)) {
        showError(field, "Enter a valid email (example@domain.com)");
        return false;
    }
    clearError(field);
    return true;
}

function validatePhone(field) {
    if (isEmpty(field.value)) {
        showError(field, "Phone is required");
        return false;
    }
    if (!isValidPhone(field.value)) {
        showError(field, "Phone must be 11 digits starting with 01");
        return false;
    }
    clearError(field);
    return true;
}

function validatePassword(field) {
    if (isEmpty(field.value)) {
        showError(field, "Password is required");
        return false;
    }
    if (!isValidPassword(field.value)) {
        showError(field, "Password: 8+ characters, letters and numbers");
        return false;
    }
    clearError(field);
    return true;
}

function validateUsername(field) {
    if (isEmpty(field.value)) {
        showError(field, "Username is required");
        return false;
    }
    if (!isValidUsername(field.value)) {
        showError(field, "Username: 4-20 characters, letters/numbers/underscore");
        return false;
    }
    clearError(field);
    return true;
}

function validateDOB(field) {
    if (isEmpty(field.value)) {
        showError(field, "Date of birth is required");
        return false;
    }
    if (!isValidDOB(field.value)) {
        showError(field, "Date of birth cannot be in the future");
        return false;
    }
    clearError(field);
    return true;
}

function validateFutureDate(field, msg) {
    if (isEmpty(field.value)) {
        showError(field, msg + " is required");
        return false;
    }
    if (!isValidFutureDate(field.value)) {
        showError(field, msg + " cannot be in the past");
        return false;
    }
    clearError(field);
    return true;
}

function validateSelect(field, msg) {
    if (!isValidSelect(field)) {
        showError(field, "Please select " + msg);
        return false;
    }
    clearError(field);
    return true;
}

function validateRequired(field, msg) {
    if (isEmpty(field.value)) {
        showError(field, msg + " is required");
        return false;
    }
    clearError(field);
    return true;
}

function validateMinLength(field, minLen, msg) {
    if (isEmpty(field.value)) {
        showError(field, msg + " is required");
        return false;
    }
    if (!hasMinLength(field.value, minLen)) {
        showError(field, msg + " must be at least " + minLen + " characters");
        return false;
    }
    clearError(field);
    return true;
}
