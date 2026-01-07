function ajaxGet(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            callback(xhr.responseText);
        }
    };
    xhr.send();
}

function loadDoctorsByDepartment(departmentId, targetSelectId) {
    ajaxGet("../controller/get_doctors_by_department.php?department_id=" + (departmentId || ""), function (response) {
        document.getElementById(targetSelectId).innerHTML = response;
    });
}

function loadAvailableSlots(doctorId, date, targetSelectId) {
    if (!doctorId || !date) {
        return;
    }
    ajaxGet("../controller/get_available_slots.php?doctor_id=" + doctorId + "&date=" + date, function (response) {
        document.getElementById(targetSelectId).innerHTML = response;
    });
}

function ajaxSearch(url, query, targetId) {
    ajaxGet(url + "?search=" + encodeURIComponent(query), function (response) {
        document.getElementById(targetId).innerHTML = response;
    });
}
