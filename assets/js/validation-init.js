/* Form Submit Handler */

function handleFormSubmit(form, validationFunction) {
    var isValid = validationFunction(form);
    return isValid;
}
