/* Medical Record Form Validation */

function validateRecordForm(form) {
    clearFormErrors(form);
    var valid = true;

    var patient = form.patient_id;
    if (patient && !validateSelect(patient, "a patient")) valid = false;

    var recordType = form.record_type;
    if (recordType && !validateSelect(recordType, "a record type")) valid = false;

    var date = form.record_date;
    if (date && !validateRequired(date, "Record date")) valid = false;

    return valid;
}
