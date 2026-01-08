function ajaxGet(url, onSuccess, onError) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    onSuccess(data);
                } catch (e) {
                    onSuccess(xhr.responseText);
                }
            } else if (onError) {
                onError(xhr.status);
            }
        }
    };
    xhr.send();
}

function populateSelect(selectId, options, placeholder) {
    var select = document.getElementById(selectId);
    select.innerHTML = '<option value="">' + placeholder + '</option>';

    for (var i = 0; i < options.length; i++) {
        var opt = options[i];
        var option = document.createElement('option');
        option.value = opt.value;
        option.textContent = opt.text;
        if (opt.disabled) option.disabled = true;
        select.appendChild(option);
    }
}

function loadDoctorsByDepartment(departmentId, targetSelectId) {
    var url = '../controller/get_doctors_by_department.php?department_id=' + (departmentId || '');

    ajaxGet(url, function (data) {
        var options = [];

        if (data.success && data.doctors) {
            for (var i = 0; i < data.doctors.length; i++) {
                var doc = data.doctors[i];
                options.push({
                    value: doc.id,
                    text: doc.name + ' - ' + doc.specialization
                });
            }
        }

        populateSelect(targetSelectId, options, '-- Select Doctor --');
    });
}

function loadAvailableSlots(doctorId, date, targetSelectId) {
    if (!doctorId || !date) return;

    var url = '../controller/get_available_slots.php?doctor_id=' + doctorId + '&date=' + date;

    ajaxGet(url, function (data) {
        var options = [];

        if (data.success && data.slots) {
            for (var i = 0; i < data.slots.length; i++) {
                var slot = data.slots[i];
                options.push({
                    value: slot.value,
                    text: slot.label + (slot.available ? '' : ' (Booked)'),
                    disabled: !slot.available
                });
            }
        }

        populateSelect(targetSelectId, options, '-- Select Time --');
    });
}

function ajaxSearchMedicine(query, targetId) {
    var url = '../controller/search_medicine.php?search=' + encodeURIComponent(query);

    ajaxGet(url, function (data) {
        var tbody = document.getElementById(targetId);
        tbody.innerHTML = '';

        if (data.success && data.medicines.length > 0) {
            for (var i = 0; i < data.medicines.length; i++) {
                var m = data.medicines[i];
                var rowStyle = m.low_stock ? 'background-color: #ffcccc;' : '';

                var row = '<tr style="' + rowStyle + '">' +
                    '<td>' + m.id + '</td>' +
                    '<td>' + m.medicine_name + '</td>' +
                    '<td>' + m.generic_name + '</td>' +
                    '<td>' + m.category + '</td>' +
                    '<td>' + m.unit_price + '</td>' +
                    '<td>' + m.stock_quantity + '</td>' +
                    '<td>' + m.manufacturer + '</td>' +
                    '<td>' + m.expiry_date + '</td>' +
                    '<td>' +
                    '<a href="medicine_view.php?id=' + m.id + '"><button>View</button></a> ' +
                    '<a href="medicine_edit.php?id=' + m.id + '"><button>Edit</button></a> ' +
                    '<a href="../controller/delete_medicine.php?id=' + m.id + '" onclick="return confirm(\'Delete this medicine?\');"><button>Delete</button></a>' +
                    '</td>' +
                    '</tr>';

                tbody.innerHTML += row;
            }
        } else {
            tbody.innerHTML = '<tr><td colspan="9" align="center">No medicines found</td></tr>';
        }
    });
}
