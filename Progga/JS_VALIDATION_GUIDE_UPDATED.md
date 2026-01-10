# JavaScript Form Validation Guide

## Overview
Complete client-side form validation system with real-time feedback, error handling, and sanitization.

## Features Implemented

### 1. **Form Validator Class**
Main class for handling form validation with automatic initialization.

```javascript
// Basic initialization
const validator = new FormValidator('#myForm');

// Or use data attribute
// <form data-validator="true" id="myForm">
```

### 2. **Validation Rules Supported**

#### **Required Field**
```html
<input type="text" name="username" required data-validate="true">
```

#### **Email Validation**
```html
<input type="email" name="email" required data-validate="true">
<!-- OR -->
<input type="text" name="email" data-validate="email">
```

#### **Min/Max Length**
```html
<input type="text" name="username" minlength="3" maxlength="50" data-validate="true">
```

#### **Pattern Matching (Regex)**
```html
<input type="text" 
       name="username" 
       pattern="[a-zA-Z0-9]+"
       data-pattern-message="Username can only contain letters and numbers"
       data-validate="true">
```

#### **Number/Integer**
```html
<input type="number" name="age" data-validate="true">
```

#### **URL Validation**
```html
<input type="url" name="website" data-validate="true">
```

#### **Password Confirmation**
```html
<input type="password" name="password" data-validate="true">
<input type="password" 
       name="confirm_password" 
       data-validate="true"
       data-match="password">
```

#### **Custom Attributes**
```html
<input type="text" 
       name="username" 
       data-validate="true"
       data-label="Username"
       data-custom="validateUsername"
       data-custom-message="Username is already taken">
```

### 3. **Real-time Validation**
Fields with `data-validate="true"` automatically validate on:
- `blur` event (when user leaves field)
- `change` event (when value changes)

### 4. **Form Submit Validation**
Full validation occurs on form submit:
```javascript
form.addEventListener('submit', (e) => {
    e.preventDefault();
    if (validator.validateAllFields()) {
        // Submit form
    }
});
```

### 5. **Visual Feedback**
- ✅ Green border for valid fields (`.is-valid`)
- ❌ Red border for invalid fields (`.is-invalid`)
- Error messages displayed below field (`.field-error`)
- Focus on first error field

### 6. **Sanitization Methods**

#### **XSS Prevention**
```javascript
// Automatically applied to prevent injection attacks
const safe = FormValidator.sanitize(userInput);
```

#### **Custom Validation Function**
```javascript
function validateUsername(value) {
    return value.length > 2 && /^[a-zA-Z0-9]+$/.test(value);
}

// Use in HTML
// <input data-custom="validateUsername">
```

---

## Usage Examples

### Basic Form Setup
```html
<!DOCTYPE html>
<html>
<head>
    <style>
        input.is-valid { border-color: green; }
        input.is-invalid { border-color: red; }
        .field-error { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <form id="myForm">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required data-validate="true" data-label="Email">
        </div>
        
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required minlength="6" data-validate="true" data-label="Password">
        </div>
        
        <input type="submit" value="Submit">
    </form>

    <script src="js/validator.js"></script>
    <script>
        const form = new FormValidator('#myForm');
    </script>
</body>
</html>
```

### Sign Up Form with Password Confirmation
```html
<form id="signupForm">
    <input type="text" 
           name="username" 
           required 
           minlength="3" 
           maxlength="50"
           pattern="[a-zA-Z0-9]+"
           data-validate="true"
           data-label="Username">
    
    <input type="email" 
           name="email" 
           required 
           data-validate="true"
           data-label="Email">
    
    <input type="password" 
           name="password" 
           required 
           minlength="6"
           data-validate="true"
           data-label="Password">
    
    <input type="password" 
           name="confirm_password" 
           required 
           data-validate="true"
           data-label="Confirm Password"
           data-match="password"
           data-match-message="Passwords do not match">
    
    <button type="submit">Sign Up</button>
</form>

<script src="js/validator.js"></script>
<script>
    const form = new FormValidator('#signupForm');
</script>
```

---

## API Reference

### **FormValidator Class Methods**

#### **Constructor**
```javascript
new FormValidator(formSelector)
```
- Creates new validator for form matching CSS selector

#### **validateField(field)**
```javascript
validator.validateField(inputElement);
// Returns: boolean (true if valid, false if invalid)
```

#### **getFormData()**
```javascript
const data = validator.getFormData();
// Returns: Object with all form field values
```

#### **clearErrors()**
```javascript
validator.clearErrors();
// Removes all error messages and highlights
```

#### **reset()**
```javascript
validator.reset();
// Resets form and clears all errors
```

#### **addValidator(fieldName, validator)**
```javascript
validator.addValidator('username', validateUsername);
// Adds custom validation function
```

---

## Utility Functions

### **validateField(fieldName, rules)**
Validate single field with custom rules:
```javascript
const isValid = validateField('email', [
    { type: 'required' },
    { type: 'email' }
]);
```

### **getFormErrors(form)**
Get all form errors as object:
```javascript
const errors = getFormErrors(document.querySelector('#myForm'));
// Returns: { fieldName: 'Error message', ... }
```

---

## Error Display Options

### Option 1: Error Container
```html
<div data-errors></div> <!-- Errors display here -->
<form id="myForm">
    <!-- fields -->
</form>
```

### Option 2: Inline Errors
```html
<form id="myForm">
    <div class="form-group">
        <input type="text" name="username" data-validate="true">
        <!-- Error appears below field -->
    </div>
</form>
```

### Option 3: Custom Error Display
```javascript
const form = new FormValidator('#myForm');
// After validation attempt:
console.log(form.errors);
// { username: 'Username is required', ... }
```

---

## Styling Classes

```css
/* Valid field */
input.is-valid {
    border-color: #28a745;
}

/* Invalid field */
input.is-invalid {
    border-color: #dc3545;
}

/* Field error message */
.field-error {
    color: #dc3545;
    font-size: 0.9em;
    margin-top: 5px;
}

/* Form group with error */
.form-group.has-error label {
    color: #dc3545;
}
```

---

## Current Implementation in Application

### **Admin Sign In** (`view/admin_signin.php`)
✅ Real-time validation on username/email and password
✅ Visual feedback with colored borders
✅ Error messages below fields
✅ Form submit validation

### **Admin Sign Up** (`view/admin_signup.php`)
✅ Username validation (alphanumeric, length)
✅ Email validation
✅ Password validation (minimum 6 characters)
✅ Password confirmation with matching
✅ Real-time feedback on all fields
✅ Styled error messages

---

## Best Practices

1. **Always use server-side validation too** - Client-side can be bypassed
2. **Sanitize input** - Use `FormValidator.sanitize()` for user input
3. **Custom messages** - Use `data-label` and `data-*-message` attributes
4. **Real-time feedback** - Use `data-validate="true"` for better UX
5. **Accessibility** - Include proper labels for all fields
6. **Error handling** - Display clear, helpful error messages

---

## Troubleshooting

### Validation not working?
1. Ensure script is loaded: `<script src="js/validator.js"></script>`
2. Check form selector is correct: `new FormValidator('#formId')`
3. Verify `data-validate="true"` on input fields
4. Check browser console for errors

### Custom validation not running?
1. Define function in global scope: `window.myValidator = function() {...}`
2. Reference in HTML: `data-custom="myValidator"`
3. Function should return true/false

### Errors not displaying?
1. Add CSS for `.field-error` class
2. Ensure form has proper structure with form-groups
3. Check that `data-errors` container is present (optional)

