# PHP Validation Implementation Guide

## Overview
The application has a comprehensive server-side **Validator class** with 13+ validation rules and multiple sanitization methods.

## Validation Rules Implemented

### 1. **Required**
Checks if field is not empty
```php
'username' => ['required' => true]
```

### 2. **Email**
Validates email format using `FILTER_VALIDATE_EMAIL`
```php
'email' => ['email' => true]
```

### 3. **Minimum Length**
Validates minimum string length (uses `mb_strlen`)
```php
'password' => ['min' => 6]
```

### 4. **Maximum Length**
Validates maximum string length (uses `mb_strlen`)
```php
'username' => ['max' => 50]
```

### 5. **Field Matching**
Compares value with another field (e.g., password confirmation)
```php
'confirm_password' => ['match' => 'password']
```

### 6. **Date**
Validates date format
```php
'birth_date' => ['date' => true]
```

### 7. **Regex Pattern**
Custom regex pattern matching
```php
'phone' => ['regex' => '/^[\d\-\+\(\)]+$/']
```

### 8. **Numeric**
Checks if value is numeric
```php
'age' => ['numeric' => true]
```

### 9. **Alpha (Letters Only)**
Allows only letters and spaces
```php
'first_name' => ['alpha' => true]
```

### 10. **Alphanumeric**
Allows only letters, numbers, and spaces
```php
'username' => ['alphanumeric' => true]
```

### 11. **URL**
Validates URL format using `FILTER_VALIDATE_URL`
```php
'website' => ['url' => true]
```

### 12. **Phone**
Validates phone number format
```php
'phone' => ['phone' => true]
```

### 13. **Integer**
Validates integer format
```php
'quantity' => ['integer' => true]
```

### 14. **IP Address**
Validates IP address format
```php
'server_ip' => ['ip' => true]
```

### 15. **Custom Callback**
Custom validation function
```php
'username' => [
    'custom' => function($value) {
        return strlen($value) > 2 && ctype_alnum($value);
    }
]
```

---

## Usage Examples

### Basic Form Validation
```php
require_once('core/validator.php');

$data = [
    'username' => $_POST['username'] ?? '',
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? ''
];

$rules = [
    'username' => [
        'required' => true,
        'min' => 3,
        'max' => 50,
        'alphanumeric' => true
    ],
    'email' => [
        'required' => true,
        'email' => true
    ],
    'password' => [
        'required' => true,
        'min' => 6
    ]
];

$errors = Validator::validate($data, $rules);

if (!empty($errors)) {
    // Display errors
    foreach ($errors as $field => $error) {
        echo "$field: $error<br>";
    }
} else {
    // Process valid data
    // Sanitize before saving
    $username = Validator::sanitize($_POST['username']);
    $email = Validator::sanitizeEmail($_POST['email']);
}
```

### Password Confirmation
```php
$rules = [
    'password' => [
        'required' => true,
        'min' => 6
    ],
    'confirm_password' => [
        'required' => true,
        'match' => 'password',
        'match_message' => 'Passwords do not match'
    ]
];
```

### Custom Error Messages
```php
$rules = [
    'username' => [
        'required' => true,
        'required_message' => 'Username is mandatory',
        'min' => 3,
        'min_message' => 'Username must be at least 3 characters long'
    ]
];
```

---

## Sanitization Methods

### 1. **XSS Prevention** - `sanitize()`
```php
$safe_value = Validator::sanitize($user_input);
// Uses htmlspecialchars() with ENT_QUOTES
```

### 2. **SQL Escaping** - `escapeSql()`
```php
$escaped = Validator::escapeSql($value, $connection);
// Note: Use prepared statements instead
```

### 3. **URL Sanitization** - `sanitizeUrl()`
```php
$url = Validator::sanitizeUrl($user_url);
```

### 4. **Email Sanitization** - `sanitizeEmail()`
```php
$email = Validator::sanitizeEmail($user_email);
```

### 5. **HTML Stripping** - `stripHtml()`
```php
$text = Validator::stripHtml($user_input);
// Removes all HTML tags
```

---

## Current Implementation in Controllers

### Admin Sign In (`controller/admin_signin.php`)
✅ Validates required fields (username/email, password)

### Admin Sign Up (`controller/admin_signup.php`)
✅ Validates username (required, min 3, max 50, alphanumeric)
✅ Validates email (required, valid email format)
✅ Validates password (required, min 6 characters)
✅ Validates password confirmation (must match password)
✅ Checks for duplicate username/email
✅ Sanitizes all input before saving

---

## Files Location
- **Validator Class:** `Progga/core/validator.php`
- **Admin Sign In:** `Progga/controller/admin_signin.php`
- **Admin Sign Up:** `Progga/controller/admin_signup.php`

---

## Security Best Practices Implemented

1. ✅ Server-side validation (not relying on client-side only)
2. ✅ Input sanitization using `htmlspecialchars()`
3. ✅ Email validation with `FILTER_VALIDATE_EMAIL`
4. ✅ Alphanumeric validation for usernames
5. ✅ Prepared statements in models (SQL injection prevention)
6. ✅ Password confirmation matching
7. ✅ Duplicate account checking
8. ✅ Custom error messages for better UX

---

## Future Enhancements

- [ ] Implement password hashing (PASSWORD_BCRYPT)
- [ ] Add CSRF token validation
- [ ] Implement rate limiting for login attempts
- [ ] Add email verification on registration
- [ ] Implement two-factor authentication
- [ ] Add custom validation database callbacks (e.g., unique email check)

