// Auth - Form Validation

function validateSignin() {
    var user = document.getElementsByName('email_username')[0];
    var pass = document.getElementsByName('password')[0];

    if (!user.value.trim()) {
        alert('Email or username required');
        return false;
    }
    if (!pass.value) {
        alert('Password required');
        return false;
    }
    return true;
}

function validateSignup() {
    var name = document.getElementsByName('full_name')[0];
    var email = document.getElementsByName('email')[0];
    var phone = document.getElementsByName('phone')[0];
    var user = document.getElementsByName('username')[0];
    var pass = document.getElementsByName('password')[0];
    var pass2 = document.getElementsByName('confirm_password')[0];

    if (!name.value.trim()) { alert('Name required'); return false; }
    if (!email.value.trim()) { alert('Email required'); return false; }
    if (email.value.indexOf('@') < 1) { alert('Invalid email'); return false; }
    if (!phone.value.trim()) { alert('Phone required'); return false; }
    if (!user.value.trim()) { alert('Username required'); return false; }
    if (user.value.length < 3) { alert('Username min 3 chars'); return false; }
    if (!pass.value) { alert('Password required'); return false; }
    if (pass.value.length < 8) { alert('Password min 8 chars'); return false; }
    if (pass.value !== pass2.value) { alert('Passwords do not match'); return false; }

    return true;
}

function validateForgotStep1() {
    var email = document.getElementsByName('email')[0];
    if (!email.value.trim()) { alert('Email required'); return false; }
    if (email.value.indexOf('@') < 1) { alert('Invalid email'); return false; }
    return true;
}

function validateForgotStep3() {
    var pass = document.getElementsByName('new_password')[0];
    var pass2 = document.getElementsByName('confirm_password')[0];

    if (!pass.value) { alert('Password required'); return false; }
    if (pass.value.length < 8) { alert('Password min 8 chars'); return false; }
    if (pass.value !== pass2.value) { alert('Passwords do not match'); return false; }
    return true;
}
