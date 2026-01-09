/**
 * FormValidator - Client-side Form Validation Library
 * Provides comprehensive validation for all forms in the application
 */

class FormValidator {
    
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        this.errors = {};
        this.rules = {};
        this.init();
    }
    
    /**
     * Initialize form validation
     */
    init() {
        if (!this.form) return;
        
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.attachFieldListeners();
    }
    
    /**
     * Attach real-time validation to fields
     */
    attachFieldListeners() {
        const fields = this.form.querySelectorAll('[data-validate]');
        fields.forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('change', () => this.validateField(field));
        });
    }
    
    /**
     * Add validation rule for a field
     */
    addRule(fieldName, rules) {
        this.rules[fieldName] = rules;
    }
    
    /**
     * Validate single field
     */
    validateField(field) {
        const fieldName = field.getAttribute('name');
        const rules = this.rules[fieldName];
        
        if (!rules) return true;
        
        const value = field.value.trim();
        const fieldLabel = field.getAttribute('data-label') || fieldName;
        
        for (const [ruleName, ruleValue] of Object.entries(rules)) {
            const isValid = this.applyRule(ruleName, value, ruleValue, fieldLabel);
            if (!isValid) {
                this.setError(field, ruleValue.message);
                return false;
            }
        }
        
        this.clearError(field);
        return true;
    }
    
    /**
     * Apply validation rule
     */
    applyRule(ruleName, value, ruleValue, fieldLabel) {
        const rules = {
            required: (val) => val.length > 0,
            minLength: (val) => val.length >= ruleValue.value,
            maxLength: (val) => val.length <= ruleValue.value,
            email: (val) => this.isValidEmail(val) || val === '',
            password: (val) => this.isValidPassword(val) || val === '',
            match: (val) => val === document.querySelector(`[name="${ruleValue.value}"]`)?.value || val === '',
            pattern: (val) => new RegExp(ruleValue.value).test(val) || val === '',
            numeric: (val) => /^\d+$/.test(val) || val === '',
            alpha: (val) => /^[a-zA-Z\s]+$/.test(val) || val === '',
            alphanumeric: (val) => /^[a-zA-Z0-9\s]+$/.test(val) || val === '',
            date: (val) => this.isValidDate(val) || val === '',
            url: (val) => this.isValidUrl(val) || val === '',
            phone: (val) => this.isValidPhone(val) || val === ''
        };
        
        if (rules[ruleName]) {
            return rules[ruleName](value);
        }
        
        return true;
    }
    
    /**
     * Validate email format
     */
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    /**
     * Validate password strength
     */
    isValidPassword(password) {
        // At least 6 characters
        return password.length >= 6;
    }
    
    /**
     * Validate date format
     */
    isValidDate(dateString) {
        const date = new Date(dateString);
        return date instanceof Date && !isNaN(date);
    }
    
    /**
     * Validate URL format
     */
    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }
    
    /**
     * Validate phone format
     */
    isValidPhone(phone) {
        // Simple phone validation (international format)
        const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
        return phoneRegex.test(phone);
    }
    
    /**
     * Set error for field
     */
    setError(field, message) {
        field.classList.add('is-invalid');
        
        let errorEl = field.parentElement.querySelector('.error-message');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'error-message';
            field.parentElement.appendChild(errorEl);
        }
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }
    
    /**
     * Clear error for field
     */
    clearError(field) {
        field.classList.remove('is-invalid');
        const errorEl = field.parentElement.querySelector('.error-message');
        if (errorEl) {
            errorEl.style.display = 'none';
        }
    }
    
    /**
     * Validate entire form
     */
    validateForm() {
        this.errors = {};
        let isValid = true;
        
        const fields = this.form.querySelectorAll('[data-validate]');
        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    /**
     * Handle form submission
     */
    handleSubmit(e) {
        if (!this.validateForm()) {
            e.preventDefault();
            this.showSummaryError();
        }
    }
    
    /**
     * Show error summary
     */
    showSummaryError() {
        let errorSummary = this.form.querySelector('.validation-summary');
        if (!errorSummary) {
            errorSummary = document.createElement('div');
            errorSummary.className = 'validation-summary';
            this.form.insertBefore(errorSummary, this.form.firstChild);
        }
        
        const invalidFields = this.form.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            errorSummary.innerHTML = '<strong>Please fix the following errors:</strong>';
            errorSummary.style.display = 'block';
        }
    }
}

/**
 * Initialize validators for common forms
 */
function initializeFormValidation() {
    
    // Admin Sign In Form
    const signinValidator = new FormValidator('form[action*="admin_signin"]');
    signinValidator.addRule('user', {
        required: { message: 'Username or Email is required' }
    });
    signinValidator.addRule('password', {
        required: { message: 'Password is required' }
    });
    
    // Admin Sign Up Form
    const signupValidator = new FormValidator('form[action*="admin_signup"]');
    signupValidator.addRule('username', {
        required: { message: 'Username is required' },
        minLength: { value: 3, message: 'Username must be at least 3 characters' },
        maxLength: { value: 50, message: 'Username cannot exceed 50 characters' },
        alphanumeric: { message: 'Username can only contain letters, numbers, and spaces' }
    });
    signupValidator.addRule('email', {
        required: { message: 'Email is required' },
        email: { message: 'Please enter a valid email address' }
    });
    signupValidator.addRule('password', {
        required: { message: 'Password is required' },
        minLength: { value: 6, message: 'Password must be at least 6 characters' },
        maxLength: { value: 100, message: 'Password cannot exceed 100 characters' },
        password: { message: 'Password is too weak' }
    });
    
    // Notice Create/Edit Form
    const noticeValidator = new FormValidator('form[action*="notice"]');
    if (noticeValidator.form) {
        noticeValidator.addRule('title', {
            required: { message: 'Title is required' },
            minLength: { value: 5, message: 'Title must be at least 5 characters' },
            maxLength: { value: 200, message: 'Title cannot exceed 200 characters' }
        });
        noticeValidator.addRule('content', {
            required: { message: 'Content is required' },
            minLength: { value: 10, message: 'Content must be at least 10 characters' }
        });
        noticeValidator.addRule('category', {
            required: { message: 'Category is required' }
        });
        noticeValidator.addRule('expiry_date', {
            date: { message: 'Please enter a valid date' }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeFormValidation);
