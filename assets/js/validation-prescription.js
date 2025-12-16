/* Prescription Form Validation */

function validatePrescriptionForm(form) {
    clearFormErrors(form);
    var valid = true;

    var patient = form.patient_id;
    if (patient && !validateSelect(patient, "a patient")) valid = false;

    var diagnosis = form.diagnosis;
    if (diagnosis && !validateMinLength(diagnosis, 3, "Diagnosis")) valid = false;

    var followUp = form.follow_up_date;
    if (followUp && !isEmpty(followUp.value)) {
        if (!isValidFutureDate(followUp.value)) {
            showError(followUp, "Follow-up date cannot be in the past");
            valid = false;
        }
    }

    return valid;
}
