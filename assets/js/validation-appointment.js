/* Appointment Form Validation */

function validateAppointmentForm(form) {
    clearFormErrors(form);
    var valid = true;

    var patient = form.patient_id;
    if (patient && !validateSelect(patient, "a patient")) valid = false;

    var dept = form.department;
    if (dept && !validateSelect(dept, "a department")) valid = false;

    var doctor = form.doctor_id;
    if (doctor && !validateSelect(doctor, "a doctor")) valid = false;

    var date = form.appointment_date;
    if (date && !validateFutureDate(date, "Appointment date")) valid = false;

    var time = form.time_slot;
    if (time && !validateSelect(time, "a time slot")) valid = false;

    return valid;
}
