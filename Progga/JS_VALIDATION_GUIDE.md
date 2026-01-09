/**
 * Validation Rules Reference
 * Complete guide to validation rules and usage
 */

# Client-Side Form Validation

## Overview

The application includes a comprehensive JavaScript validation library (`validator.js`) that provides real-time form validation with user-friendly error messages.

## Validation Rules

### 1. **required** - Field must have a value
```javascript
addRule('fieldName', {
    required: { message: 'Field is required' }
});
```

### 2. **minLength** - Minimum character length
```javascript
addRule('fieldName', {
    minLength: { value: 3, message: 'Must be at least 3 characters' }
});
```

### 3. **maxLength** - Maximum character length
```javascript
addRule('fieldName', {
    maxLength: { value: 50, message: 'Cannot exceed 50 characters' }
});
```

### 4. **email** - Valid email format
```javascript
addRule('fieldName', {
    email: { message: 'Please enter a valid email address' }
});
```

### 5. **password** - Password strength (minimum 6 chars)
```javascript
addRule('fieldName', {
    password: { message: 'Password must be at least 6 characters' }
});
```

### 6. **match** - Field must match another field
```javascript
addRule('confirm_password', {
    match: { value: 'password', message: 'Passwords must match' }
});
```

### 7. **pattern** - Regex pattern matching
```javascript
addRule('fieldName', {
    pattern: { value: '^[A-Z].*', message: 'Must start with uppercase' }
});
```

### 8. **numeric** - Must be numbers only
```javascript
addRule('fieldName', {
    numeric: { message: 'Must contain only numbers' }
});
```

### 9. **alpha** - Letters and spaces only
```javascript
addRule('fieldName', {
    alpha: { message: 'Must contain only letters and spaces' }
});
```

### 10. **alphanumeric** - Letters, numbers, and spaces only
```javascript
addRule('fieldName', {
    alphanumeric: { message: 'Must contain only letters, numbers, and spaces' }
});
```

### 11. **date** - Valid date format
```javascript
addRule('fieldName', {
    date: { message: 'Please enter a valid date' }
});
```

### 12. **url** - Valid URL format
```javascript
addRule('fieldName', {
    url: { message: 'Please enter a valid URL' }
});
```

### 13. **phone** - Valid phone number (10+ digits)
```javascript
addRule('fieldName', {
    phone: { message: 'Please enter a valid phone number' }
});
```

## HTML Integration

### Basic Form Setup
```html
<form method="post" action="process.php">
    <!-- Form fields with data-validate attribute -->
    <input type="text" name="username" data-validate="true" data-label="Username">
    <input type="submit" value="Submit">
</form>

<script src="public/js/validator.js"></script>
```

### Form Field Attributes

- `name` - Field name (required)
- `data-validate="true"` - Enable validation for this field
- `data-label` - Custom label for error messages (optional)
- `id` - Form field ID (optional but recommended)

### Form Structure Example
```html
<div class="form-group">
    <label for="username" class="required">Username</label>
    <input type="text" 
           id="username" 
           name="username" 
           data-validate="true" 
           data-label="Username"
           placeholder="Enter username">
    <div class="error-message"></div>
</div>
```

## CSS Classes

### Validation States

- `.is-invalid` - Applied to invalid fields
- `.is-valid` - Applied to valid fields
- `.error-message` - Error message container
- `.validation-summary` - Summary of all errors
- `.required` - Indicator for required fields
- `.help-text` - Helper text below fields

### Styling Example
```css
/* Error styling */
input.is-invalid {
    border-color: #dc3545;
    background-color: #fff5f5;
}

/* Error message */
.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
```

## JavaScript API

### FormValidator Class

#### Constructor
```javascript
const validator = new FormValidator('form[action*="process"]');
```

#### Methods

##### addRule(fieldName, rules)
Add validation rules to a field
```javascript
validator.addRule('email', {
    required: { message: 'Email is required' },
    email: { message: 'Invalid email format' }
});
```

##### validateField(field)
Validate a single field
```javascript
const field = document.querySelector('[name="email"]');
const isValid = validator.validateField(field);
```

##### validateForm()
Validate entire form
```javascript
if (validator.validateForm()) {
    console.log('Form is valid');
}
```

##### getErrors()
Get all errors
```javascript
const errors = validator.getErrors();
```

## Implementation Examples

### Admin Sign In
```javascript
const validator = new FormValidator('form[action*="admin_signin"]');
validator.addRule('user', {
    required: { message: 'Username or Email is required' }
});
validator.addRule('password', {
    required: { message: 'Password is required' }
});
```

### Admin Sign Up
```javascript
const validator = new FormValidator('form[action*="admin_signup"]');
validator.addRule('username', {
    required: { message: 'Username is required' },
    minLength: { value: 3, message: 'Minimum 3 characters' },
    alphanumeric: { message: 'Only letters, numbers, spaces' }
});
validator.addRule('email', {
    required: { message: 'Email is required' },
    email: { message: 'Invalid email' }
});
validator.addRule('password', {
    required: { message: 'Password is required' },
    minLength: { value: 6, message: 'Minimum 6 characters' }
});
```

### Notice Create/Edit
```javascript
const validator = new FormValidator('form[action*="notice"]');
validator.addRule('title', {
    required: { message: 'Title is required' },
    minLength: { value: 5, message: 'Minimum 5 characters' },
    maxLength: { value: 200, message: 'Maximum 200 characters' }
});
validator.addRule('content', {
    required: { message: 'Content is required' },
    minLength: { value: 10, message: 'Minimum 10 characters' }
});
validator.addRule('category', {
    required: { message: 'Category is required' }
});
validator.addRule('expiry_date', {
    date: { message: 'Valid date required' }
});
```

## Real-Time Validation

The validator provides real-time feedback:

1. **On Blur** - Field validation when user leaves the field
2. **On Change** - Field validation when value changes
3. **On Submit** - Form-wide validation before submission

## Error Display

### Inline Errors
Error messages appear directly below the invalid field with red styling.

### Error Summary
A summary box appears at the top of the form listing all validation issues.

## Features

✅ **Real-time validation** - Instant feedback as user types
✅ **Multiple rules** - Combine multiple validation rules
✅ **Custom messages** - Personalized error messages
✅ **Auto-initialization** - Automatically validates known forms
✅ **Accessible** - Proper labels and ARIA support
✅ **Responsive** - Works on all devices
✅ **Easy integration** - Just add `data-validate="true"` to fields

## Adding New Forms

To add validation to a new form:

1. Add `data-validate="true"` to form fields
2. Include `validator.js` in your view
3. Add new validator rules in `validator.js`:

```javascript
const myValidator = new FormValidator('form[action*="myform"]');
myValidator.addRule('fieldName', {
    required: { message: 'Field is required' },
    minLength: { value: 3, message: 'Minimum 3 characters' }
});
```

## Browser Support

Works on all modern browsers:
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers

## Security Note

**Client-side validation is for UX only.** Always validate on the server-side as well to prevent security issues.
