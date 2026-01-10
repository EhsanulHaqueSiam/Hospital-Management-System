/**
 * Client-side Form Validator
 * Supports: required, email, min, max, match, regex, numeric, alpha, alphanumeric, url, phone, date, custom
 */

class FormValidator {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        this.errors = {};
        this.init();
    }

    init() {
        if (!this.form) return;
        
        // Add form submit listener
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Add real-time validation for fields with data-validate attribute
        this.form.querySelectorAll('[data-validate="true"]').forEach(field => {
            field.addEventListener('blur', (e) => this.validateField(e.target));
            field.addEventListener('change', (e) => this.validateField(e.target));
        });
    }

    handleSubmit(e) {
        e.preventDefault();
        this.errors = {};
        
        // Validate all fields
        this.form.querySelectorAll('[data-validate="true"]').forEach(field => {
            this.validateField(field);
        });

        // Show errors or submit
        if (Object.keys(this.errors).length === 0) {
            this.form.submit();
        } else {
            this.displayErrors();
            return false;
        }
    }

    validateField(field) {
        const fieldName = field.name;
        const fieldLabel = field.dataset.label || field.name;
        const value = field.value.trim();

        // Clear previous error
        delete this.errors[fieldName];

        // Required validation
        if (field.required && value === '') {
            this.errors[fieldName] = `${fieldLabel} is required.`;
            this.highlightField(field, true);
            return false;
        }

        // Skip other validations if empty and not required
        if (!field.required && value === '') {
            this.highlightField(field, false);
            return true;
        }

        // Email validation
        if (field.type === 'email' || field.dataset.validate === 'email') {
            if (!this.isValidEmail(value)) {
                this.errors[fieldName] = `${fieldLabel} must be a valid email address.`;
                this.highlightField(field, true);
                return false;
            }
        }

        // Minimum length validation
        if (field.minLength && value.length < field.minLength) {
            this.errors[fieldName] = `${fieldLabel} must be at least ${field.minLength} characters.`;
            this.highlightField(field, true);
            return false;
        }

        // Maximum length validation
        if (field.maxLength && value.length > field.maxLength) {
            this.errors[fieldName] = `${fieldLabel} cannot exceed ${field.maxLength} characters.`;
            this.highlightField(field, true);
            return false;
        }

        // Pattern validation (regex)
        if (field.pattern) {
            const regex = new RegExp(field.pattern);
            if (!regex.test(value)) {
                const message = field.dataset.patternMessage || `${fieldLabel} format is invalid.`;
                this.errors[fieldName] = message;
                this.highlightField(field, true);
                return false;
            }
        }

        // Number validation
        if (field.type === 'number') {
            if (!this.isValidNumber(value)) {
                this.errors[fieldName] = `${fieldLabel} must be a number.`;
                this.highlightField(field, true);
                return false;
            }
        }

        // URL validation
        if (field.type === 'url') {
            if (!this.isValidUrl(value)) {
                this.errors[fieldName] = `${fieldLabel} must be a valid URL.`;
                this.highlightField(field, true);
                return false;
            }
        }

        // Password confirmation
        if (field.dataset.match) {
            const matchField = this.form.querySelector(`[name="${field.dataset.match}"]`);
            if (matchField && value !== matchField.value) {
                this.errors[fieldName] = `${fieldLabel} does not match.`;
                this.highlightField(field, true);
                return false;
            }
        }

        // Custom validation
        if (field.dataset.custom) {
            const customValidator = window[field.dataset.custom];
            if (typeof customValidator === 'function') {
                if (!customValidator(value)) {
                    const message = field.dataset.customMessage || `${fieldLabel} is invalid.`;
                    this.errors[fieldName] = message;
                    this.highlightField(field, true);
                    return false;
                }
            }
        }

        // All validations passed
        this.highlightField(field, false);
        return true;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidNumber(value) {
        return !isNaN(value) && value !== '';
    }

    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch (_) {
            return false;
        }
    }

    isAlpha(value) {
        return /^[a-zA-Z\s]+$/.test(value);
    }

    isAlphanumeric(value) {
        return /^[a-zA-Z0-9\s]+$/.test(value);
    }

    isNumeric(value) {
        return /^\d+$/.test(value);
    }

    highlightField(field, hasError) {
        const fieldGroup = field.closest('.form-group') || field.parentElement;
        
        if (hasError) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
            fieldGroup?.classList.add('has-error');
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            fieldGroup?.classList.remove('has-error');
        }
    }

    displayErrors() {
        // Remove existing error messages
        const errorContainer = this.form.querySelector('[data-errors]');
        const errorElements = this.form.querySelectorAll('.field-error');
        errorElements.forEach(el => el.remove());

        // Display all errors
        if (errorContainer) {
            const errorList = Object.values(this.errors).join('<br>');
            errorContainer.innerHTML = `<div style="color:red;margin-bottom:15px;padding:10px;background:#ffe6e6;border-radius:3px;">${errorList}</div>`;
        } else {
            // Display individual field errors
            Object.keys(this.errors).forEach(fieldName => {
                const field = this.form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    const fieldGroup = field.closest('.form-group') || field.parentElement;
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error';
                    errorDiv.style.cssText = 'color:red;font-size:0.9em;margin-top:5px;';
                    errorDiv.textContent = this.errors[fieldName];
                    fieldGroup.appendChild(errorDiv);
                }
            });
        }

        // Scroll to first error
        const firstError = this.form.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }

    // Sanitize input to prevent XSS
    static sanitize(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }

    // Get all form data as object
    getFormData() {
        const formData = new FormData(this.form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        return data;
    }

    // Clear all errors
    clearErrors() {
        this.errors = {};
        this.form.querySelectorAll('[data-validate="true"]').forEach(field => {
            field.classList.remove('is-invalid', 'is-valid');
        });
        const errorContainer = this.form.querySelector('[data-errors]');
        if (errorContainer) {
            errorContainer.innerHTML = '';
        }
    }

    // Reset form
    reset() {
        this.form.reset();
        this.clearErrors();
    }

    // Add custom validator
    addValidator(fieldName, validator) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.dataset.custom = validator.name;
            window[validator.name] = validator;
        }
    }
}

// Initialize validators on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize forms with data-validator attribute
    document.querySelectorAll('[data-validator]').forEach(form => {
        new FormValidator(form.id || form.querySelector('input').id);
    });

    // Initialize specific forms if needed
    const signUpForm = document.querySelector('form[action*="admin_signup"]');
    if (signUpForm) {
        new FormValidator('form[action*="admin_signup"]');
    }

    const signInForm = document.querySelector('form[action*="admin_signin"]');
    if (signInForm) {
        new FormValidator('form[action*="admin_signin"]');
    }
});

// Utility function to validate a single field
function validateField(fieldName, rules) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (!field) return false;

    const value = field.value.trim();

    for (let rule of rules) {
        if (rule.type === 'required' && value === '') return false;
        if (rule.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return false;
        if (rule.type === 'min' && value.length < rule.value) return false;
        if (rule.type === 'max' && value.length > rule.value) return false;
        if (rule.type === 'match') {
            const matchField = document.querySelector(`[name="${rule.value}"]`);
            if (matchField && value !== matchField.value) return false;
        }
    }

    return true;
}

// Utility function to get form errors
function getFormErrors(form) {
    const errors = {};
    form.querySelectorAll('[data-validate="true"]').forEach(field => {
        const value = field.value.trim();
        if (field.required && value === '') {
            errors[field.name] = `${field.dataset.label || field.name} is required.`;
        }
    });
    return errors;
}
