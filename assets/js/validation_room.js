function isValidText(str) {
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

function validateRoomNoBlur() {
    var val = document.getElementsByName('room_no')[0].value.trim();
    if (val === "") { showError('room-no-error', 'Room number required'); return false; }
    if (!isAllDigits(val)) { showError('room-no-error', 'Numbers only'); return false; }
    clearError('room-no-error');
    return true;
}

function validateRoomTypeBlur() {
    var val = document.getElementsByName('room_type')[0].value;
    if (val === "") { showError('type-error', 'Please select a type'); return false; }
    clearError('type-error');
    return true;
}

function validateFloorBlur() {
    var val = document.getElementsByName('room_floor')[0].value.trim();
    if (val === "") { showError('floor-error', 'Floor required'); return false; }
    clearError('floor-error');
    return true;
}

function validatePriceBlur() {
    var val = document.getElementsByName('room_price')[0].value.trim();
    if (val === "") { showError('price-error', 'Price required'); return false; }
    clearError('price-error');
    return true;
}

function validateStatusBlur() {
    var val = document.getElementsByName('room_status')[0].value;
    if (val === "") { showError('status-error', 'Please select status'); return false; }
    clearError('status-error');
    return true;
}

function validatePatientBlur() {
    var val = document.getElementsByName('room_patient')[0].value.trim();
    var status = document.getElementsByName('room_status')[0].value;
    if (status === "Occupied" && val === "") { 
        showError('patient-error', 'Patient name required for occupied rooms'); 
        return false; 
    }
    clearError('patient-error');
    return true;
}

function validateAddRoom() {
    var isTypeValid = validateRoomTypeBlur();
    var isFloorValid = validateFloorBlur();
    var isPriceValid = validatePriceBlur();
    var isStatusValid = validateStatusBlur();
    var isPatientValid = validatePatientBlur();

    if (isTypeValid && isFloorValid && isPriceValid && isStatusValid && isPatientValid) {
        return true; 
    } else {
        alert("Please fill in all required fields correctly.");
        return false; 
    }
}