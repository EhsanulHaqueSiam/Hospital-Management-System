function isPositiveNumber(str) {
    if (str.length === 0) return false;
    var dotCount = 0;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        if (ch === '.') {
            dotCount++;
            if (dotCount > 1) return false;
            continue;
        }
        if (ch < '0' || ch > '9') return false;
    }
    return parseFloat(str) >= 0;
}

function isValidText(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        var isLetter = (ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z');
        var isDigit = (ch >= '0' && ch <= '9');
        var isAllowed = (ch === ' ' || ch === '-' || ch === '_' || ch === '#');
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

function validateBillIDBlur() {
    var val = document.getElementsByName('bill_id')[0].value.trim();
    if (!val) { showError('bill-id-error', 'Bill ID required'); return false; }
    if (!isValidText(val)) { showError('bill-id-error', 'Invalid characters'); return false; }
    clearError('bill-id-error');
    return true;
}

function validatePatientNameBlur() {
    var val = document.getElementsByName('patient_name')[0].value.trim();
    if (!val) { showError('patient-error', 'Patient name required'); return false; }
    if (val.length < 2) { showError('patient-error', 'Too short'); return false; }
    clearError('patient-error');
    return true;
}

function validateTotalAmountBlur() {
    var val = document.getElementsByName('total_amount')[0].value.trim();
    if (!val) { showError('total-error', 'Total required'); return false; }
    if (!isPositiveNumber(val)) { showError('total-error', 'Invalid amount'); return false; }
    clearError('total-error');
    return true;
}

function validateDiscountBlur() {
    var val = document.getElementsByName('discount')[0].value.trim();
    if (val === '') return true;
    if (!isPositiveNumber(val)) { showError('discount-error', 'Must be numeric'); return false; }
    if (parseFloat(val) > 100) { showError('discount-error', 'Max 100%'); return false; }
    clearError('discount-error');
    return true;
}

function validateTaxBlur() {
    var val = document.getElementsByName('tax')[0].value.trim();
    if (val === '') return true;
    if (!isPositiveNumber(val)) { showError('tax-error', 'Must be numeric'); return false; }
    clearError('tax-error');
    return true;
}

function validatePaidAmountBlur() {
    var val = document.getElementsByName('paid_amount')[0].value.trim();
    if (val === '') return true;
    if (!isPositiveNumber(val)) { showError('paid-error', 'Invalid amount'); return false; }
    clearError('paid-error');
    return true;
}

function validateBillForm() {
    var valid = true;

    if (!validateBillIDBlur()) valid = false;
    if (!validatePatientNameBlur()) valid = false;
    if (!validateTotalAmountBlur()) valid = false;
    if (!validateDiscountBlur()) valid = false;
    if (!validateTaxBlur()) valid = false;
    if (!validatePaidAmountBlur()) valid = false;

    var status = document.getElementsByName('status')[0];
    if (!status.value) { 
        showError('status-error', 'Please select a status'); 
        valid = false; 
    } else { 
        clearError('status-error'); 
    }

    return valid;
}