function validatePatientForm(form) {
    clearFormErrors(form);
    var valid = true;

    var name = form.full_name;
    if (name && !validateName(name)) valid = false;

    var dob = form.dob;
    if (dob && !validateDOB(dob)) valid = false;

    var email = form.email;
    if (email && !validateEmail(email)) valid = false;

    var phone = form.phone;
    if (phone && !validatePhone(phone)) valid = false;

    var username = form.username;
    if (username && !validateUsername(username)) valid = false;

    var password = form.password;
    if (password && !validatePassword(password)) valid = false;

    return valid;
}

function validatePatientEditForm(form) {
    clearFormErrors(form);
    var valid = true;

    var name = form.full_name;
    if (name && !validateName(name)) valid = false;

    var email = form.email;
    if (email && !validateEmail(email)) valid = false;

    var phone = form.phone;
    if (phone && !validatePhone(phone)) valid = false;

    return valid;
}
