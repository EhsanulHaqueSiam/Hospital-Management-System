// Admin - Form Validation

function validateDepartment() {
    var name = document.getElementsByName('department_name')[0];

    if (!name.value.trim()) { alert('Name required'); return false; }
    if (name.value.trim().length < 2) { alert('Name min 2 chars'); return false; }

    return true;
}

function validateDoctor() {
    var name = document.getElementsByName('full_name')[0];
    var email = document.getElementsByName('email')[0];
    var phone = document.getElementsByName('phone')[0];
    var dept = document.getElementsByName('department_id')[0];
    var spec = document.getElementsByName('specialization')[0];

    if (!name.value.trim()) { alert('Name required'); return false; }
    if (!email.value.trim()) { alert('Email required'); return false; }
    if (email.value.indexOf('@') < 1) { alert('Invalid email'); return false; }
    if (!phone.value.trim()) { alert('Phone required'); return false; }
    if (!dept.value) { alert('Select department'); return false; }
    if (!spec.value.trim()) { alert('Specialization required'); return false; }

    // Check for add form (has username/password)
    var user = document.getElementsByName('username')[0];
    var pass = document.getElementsByName('password')[0];

    if (user && !user.value.trim()) { alert('Username required'); return false; }
    if (pass && !pass.value) { alert('Password required'); return false; }
    if (pass && pass.value.length < 8) { alert('Password min 8 chars'); return false; }

    return true;
}
