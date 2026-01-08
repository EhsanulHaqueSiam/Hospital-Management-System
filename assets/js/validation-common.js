function showFieldError(field, message) {
    clearFieldError(field);
    var span = document.createElement('span');
    span.className = 'error-message';
    span.textContent = message;
    field.parentNode.appendChild(span);
    field.style.borderColor = 'red';
}

function clearFieldError(field) {
    var parent = field.parentNode;
    var errs = parent.querySelectorAll('.error-message');
    for (var i = 0; i < errs.length; i++) {
        parent.removeChild(errs[i]);
    }
    field.style.borderColor = '';
}

function validateRequiredBlur(field, fieldName) {
    var val = field.value.trim();
    if (val === '') {
        showFieldError(field, fieldName + ' is required');
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateNumberBlur(field, fieldName, min) {
    var val = field.value;
    if (val === '') {
        showFieldError(field, fieldName + ' is required');
        return false;
    }
    var num = parseFloat(val);
    if (isNaN(num) || num < min) {
        showFieldError(field, fieldName + ' must be at least ' + min);
        return false;
    }
    clearFieldError(field);
    return true;
}

function validatePositiveNumberBlur(field, fieldName) {
    return validateNumberBlur(field, fieldName, 0);
}

function validateIntegerBlur(field, fieldName, min) {
    var val = field.value;
    if (val === '') {
        showFieldError(field, fieldName + ' is required');
        return false;
    }
    var num = parseInt(val);
    if (isNaN(num) || num < min) {
        showFieldError(field, fieldName + ' must be at least ' + min);
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateFutureDateBlur(field, fieldName) {
    var val = field.value;
    if (val === '') {
        showFieldError(field, fieldName + ' is required');
        return false;
    }
    var selected = new Date(val);
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    if (selected < today) {
        showFieldError(field, fieldName + ' cannot be in the past');
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateDateBlur(field, fieldName) {
    var val = field.value;
    if (val === '') {
        showFieldError(field, fieldName + ' is required');
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateEmailBlur(field) {
    if (!validateRequiredBlur(field, 'Email')) return false;
    var val = field.value.trim();

    var atSymbolCount = 0;
    var atSymbolIndex = -1;
    var dotSymbolIndex = -1;
    var hasSpace = false;

    for (var i = 0; i < val.length; i++) {
        var char = val[i];
        if (char === '@') {
            atSymbolCount++;
            atSymbolIndex = i;
        } else if (char === '.') {
            dotSymbolIndex = i;
        } else if (char === ' ') {
            hasSpace = true;
        }
    }

    if (hasSpace) {
        showFieldError(field, 'Email cannot contain spaces');
        return false;
    }

    if (atSymbolCount !== 1) {
        showFieldError(field, 'Email must contain exactly one @');
        return false;
    }

    if (atSymbolIndex === 0 || atSymbolIndex === val.length - 1) {
        showFieldError(field, 'Invalid placement of @');
        return false;
    }

    if (dotSymbolIndex === -1 || dotSymbolIndex <= atSymbolIndex + 1) {
        showFieldError(field, 'Invalid domain format');
        return false;
    }

    if (dotSymbolIndex === val.length - 1) {
        showFieldError(field, 'Email cannot end with a dot');
        return false;
    }

    clearFieldError(field);
    return true;
}

function validatePhoneBlur(field) {
    if (!validateRequiredBlur(field, 'Phone')) return false;
    var val = field.value.trim();

    var digits = '';
    for (var i = 0; i < val.length; i++) {
        var c = val[i];
        if (c >= '0' && c <= '9') {
            digits += c;
        } else if (c !== ' ' && c !== '-' && c !== '+' && c !== '(' && c !== ')') {
            showFieldError(field, 'Phone contains invalid characters');
            return false;
        }
    }

    if (digits.length < 10 || digits.length > 15) {
        showFieldError(field, 'Phone must be 10-15 digits');
        return false;
    }

    clearFieldError(field);
    return true;
}

function validateUsernameBlur(field) {
    if (!validateRequiredBlur(field, 'Username')) return false;
    var val = field.value.trim();
    if (val.length < 3) {
        showFieldError(field, 'Username must be at least 3 chars');
        return false;
    }
    for (var i = 0; i < val.length; i++) {
        var c = val[i];
        var code = val.charCodeAt(i);
        var isAlpha = (code >= 65 && code <= 90) || (code >= 97 && code <= 122);
        var isDigit = (code >= 48 && code <= 57);
        var isUnder = (c === '_');

        if (!isAlpha && !isDigit && !isUnder) {
            showFieldError(field, 'Only letters, numbers, _ allowed');
            return false;
        }
    }
    clearFieldError(field);
    return true;
}

function validatePasswordBlur(field) {
    if (!validateRequiredBlur(field, 'Password')) return false;
    if (field.value.length < 4) {
        showFieldError(field, 'Password must be at least 4 chars');
        return false;
    }
    clearFieldError(field);
    return true;
}

function validatePastDateBlur(field, fieldName) {
    if (!validateDateBlur(field, fieldName)) return false;
    var val = field.value;
    var selected = new Date(val);
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    if (selected > today) {
        showFieldError(field, fieldName + ' cannot be in the future');
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateSelectBlur(field, fieldName) {
    if (field.value === '' || field.value === null) {
        showFieldError(field, 'Please select ' + fieldName);
        return false;
    }
    clearFieldError(field);
    return true;
}

function validateForm(form) {
    var valid = true;

    if (form.querySelectorAll('.error-message').length > 0) {
        valid = false;
    }

    var fields = form.querySelectorAll('[required]');
    for (var i = 0; i < fields.length; i++) {
        var field = fields[i];
        if (field.value.trim() === '') {
            var name = field.name.replace(/_/g, ' ');
            showFieldError(field, name + ' is required');
            valid = false;
        }
    }
    return valid;
}
