function validateMedicineForm(form) {
    var name = form.medicine_name.value.trim();
    var genericName = form.generic_name.value.trim();
    var category = form.category.value;
    var price = form.unit_price.value;
    var stock = form.stock_quantity.value;
    var errors = [];

    if (name === '') {
        errors.push('Medicine name is required');
    }

    if (genericName === '') {
        errors.push('Generic name is required');
    }

    if (category === '' || category === null) {
        errors.push('Category is required');
    }

    if (price === '' || parseFloat(price) < 0) {
        errors.push('Unit price must be positive');
    }

    if (stock === '' || parseInt(stock) < 0) {
        errors.push('Stock quantity must be positive');
    }

    if (errors.length > 0) {
        alert('Errors:\n' + errors.join('\n'));
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    var nameField = document.querySelector('input[name="medicine_name"]');
    var genericField = document.querySelector('input[name="generic_name"]');
    var categoryField = document.querySelector('select[name="category"]');
    var priceField = document.querySelector('input[name="unit_price"]');
    var stockField = document.querySelector('input[name="stock_quantity"]');

    if (nameField) {
        nameField.onblur = function () {
            if (this.value.trim() === '') {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        };
    }

    if (genericField) {
        genericField.onblur = function () {
            if (this.value.trim() === '') {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        };
    }

    if (categoryField) {
        categoryField.onchange = function () {
            if (this.value === '' || this.value === null) {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        };
    }

    if (priceField) {
        priceField.onblur = function () {
            if (this.value === '' || parseFloat(this.value) < 0) {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        };
    }

    if (stockField) {
        stockField.onblur = function () {
            if (this.value === '' || parseInt(this.value) < 0) {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        };
    }
});
