function isValidMedicineText(str) {
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

function showError(id, msg) {
    var el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearError(id) {
    var el = document.getElementById(id);
    if (el) el.textContent = '';
}

function validateMedIDBlur() {
    var val = document.getElementsByName('med_id')[0].value.trim();
    if (val === "") { showError('id-error', 'ID is required'); return false; }
    clearError('id-error');
    return true;
}

function validateMedNameBlur() {
    var val = document.getElementsByName('med_name')[0].value.trim();
    if (val === "") { showError('name-error', 'Medicine name is required'); return false; }
    if (!isValidMedicineText(val)) { showError('name-error', 'Only letters and spaces allowed'); return false; }
    clearError('name-error');
    return true;
}

function validateCategoryBlur() {
    var val = document.getElementsByName('med_cat')[0].value.trim();
    if (val === "") { showError('cat-error', 'Category is required'); return false; }
    if (!isValidMedicineText(val)) { showError('cat-error', 'Invalid category format'); return false; }
    clearError('cat-error');
    return true;
}

function validatePriceBlur() {
    var val = document.getElementsByName('med_price')[0].value.trim();
    if (val === "") { showError('price-error', 'Price is required'); return false; }
    if (isNaN(parseFloat(val))) { showError('price-error', 'Must be a valid number'); return false; }
    clearError('price-error');
    return true;
}

function validateQtyBlur() {
    var val = document.getElementsByName('med_qty')[0].value.trim();
    if (val === "") { showError('qty-error', 'Quantity is required'); return false; }
    if (!isAllDigits(val)) { showError('qty-error', 'Must be a whole number'); return false; }
    clearError('qty-error');
    return true;
}

function validateAddMedicine() {
    var valid = true;

    if (!validateMedIDBlur()) valid = false;
    if (!validateMedNameBlur()) valid = false;
    if (!validateCategoryBlur()) valid = false;
    if (!validatePriceBlur()) valid = false;
    if (!validateQtyBlur()) valid = false;
    
    return valid;
}