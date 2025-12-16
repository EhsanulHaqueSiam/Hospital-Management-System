// Profile - Form Validation

function validateEditProfile() {
    var name = document.getElementsByName('full_name')[0];
    var phone = document.getElementsByName('phone')[0];

    if (!name.value.trim()) { alert('Name required'); return false; }
    if (!phone.value.trim()) { alert('Phone required'); return false; }

    return true;
}

function validateChangePassword() {
    var curr = document.getElementsByName('current_password')[0];
    var newp = document.getElementsByName('new_password')[0];
    var conf = document.getElementsByName('confirm_password')[0];

    if (!curr.value) { alert('Current password required'); return false; }
    if (!newp.value) { alert('New password required'); return false; }
    if (newp.value.length < 8) { alert('Password min 8 chars'); return false; }
    if (curr.value === newp.value) { alert('New password must be different'); return false; }
    if (newp.value !== conf.value) { alert('Passwords do not match'); return false; }

    return true;
}

function validatePicture() {
    var file = document.getElementById('file-input');
    if (!file.files || !file.files[0]) {
        alert('Select a file');
        return false;
    }

    var name = file.files[0].name.toLowerCase();
    if (name.indexOf('.jpg') < 0 && name.indexOf('.jpeg') < 0 &&
        name.indexOf('.png') < 0 && name.indexOf('.gif') < 0) {
        alert('Only JPG, PNG, GIF allowed');
        return false;
    }

    if (file.files[0].size > 2 * 1024 * 1024) {
        alert('Max 2MB');
        return false;
    }

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
