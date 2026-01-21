<?php
/**
 * Server-side Form Validator with Sanitization
 * Supports: required, email, min, max, match, date, regex, numeric, alpha, alphanumeric, url, phone, unique
 */
class Validator {

    /**
     * Validate a set of fields against rules
     * 
     * @param array $data Associative array of input data
     * @param array $rules Validation rules: ['field' => ['required'=>true, 'email'=>true, 'min'=>3, 'max'=>50]]
     * @return array Errors array, empty if validation passes
     */
    public static function validate(array $data, array $rules) {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = isset($data[$field]) ? trim($data[$field]) : '';

            // Check required
            if (!empty($fieldRules['required']) && $value === '') {
                $errors[$field] = $fieldRules['required_message'] ?? ucfirst($field) . ' is required.';
                continue;
            }

            // Skip other checks for empty optional fields
            if ($value === '') {
                continue;
            }

            // Email validation
            if (!empty($fieldRules['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = $fieldRules['email_message'] ?? 'Please enter a valid email address.';
                continue;
            }

            // Minimum length
            if (!empty($fieldRules['min']) && mb_strlen($value) < (int)$fieldRules['min']) {
                $errors[$field] = $fieldRules['min_message'] ?? ucfirst($field) . " must be at least {$fieldRules['min']} characters.";
                continue;
            }

            // Maximum length
            if (!empty($fieldRules['max']) && mb_strlen($value) > (int)$fieldRules['max']) {
                $errors[$field] = $fieldRules['max_message'] ?? ucfirst($field) . " cannot exceed {$fieldRules['max']} characters.";
                continue;
            }

            // Field matching (e.g., password confirmation)
            if (!empty($fieldRules['match'])) {
                $other = $fieldRules['match'];
                $otherVal = isset($data[$other]) ? trim($data[$other]) : '';
                if ($value !== $otherVal) {
                    $errors[$field] = $fieldRules['match_message'] ?? ucfirst($field) . ' does not match.';
                    continue;
                }
            }

            // Date validation
            if (!empty($fieldRules['date'])) {
                $d = date_parse($value);
                if ($d['error_count'] > 0) {
                    $errors[$field] = $fieldRules['date_message'] ?? 'Invalid date format.';
                    continue;
                }
            }

            // Regex pattern matching
            if (!empty($fieldRules['regex']) && !preg_match($fieldRules['regex'], $value)) {
                $errors[$field] = $fieldRules['regex_message'] ?? ucfirst($field) . ' format is invalid.';
                continue;
            }

            // Numeric validation
            if (!empty($fieldRules['numeric']) && !is_numeric($value)) {
                $errors[$field] = $fieldRules['numeric_message'] ?? ucfirst($field) . ' must be a number.';
                continue;
            }

            // Alpha only (letters)
            if (!empty($fieldRules['alpha']) && !preg_match('/^[a-zA-Z\s]+$/', $value)) {
                $errors[$field] = $fieldRules['alpha_message'] ?? ucfirst($field) . ' must contain only letters.';
                continue;
            }

            // Alphanumeric (letters and numbers)
            if (!empty($fieldRules['alphanumeric']) && !preg_match('/^[a-zA-Z0-9\s]+$/', $value)) {
                $errors[$field] = $fieldRules['alphanumeric_message'] ?? ucfirst($field) . ' must contain only letters and numbers.';
                continue;
            }

            // URL validation
            if (!empty($fieldRules['url']) && !filter_var($value, FILTER_VALIDATE_URL)) {
                $errors[$field] = $fieldRules['url_message'] ?? 'Please enter a valid URL.';
                continue;
            }

            // Phone number validation (basic)
            if (!empty($fieldRules['phone']) && !preg_match('/^[\d\s\-\+\(\)]+$/', $value)) {
                $errors[$field] = $fieldRules['phone_message'] ?? 'Please enter a valid phone number.';
                continue;
            }

            // Integer only
            if (!empty($fieldRules['integer']) && !filter_var($value, FILTER_VALIDATE_INT)) {
                $errors[$field] = $fieldRules['integer_message'] ?? ucfirst($field) . ' must be an integer.';
                continue;
            }

            // IP address validation
            if (!empty($fieldRules['ip']) && !filter_var($value, FILTER_VALIDATE_IP)) {
                $errors[$field] = $fieldRules['ip_message'] ?? 'Please enter a valid IP address.';
                continue;
            }

            // Custom callback validation
            if (!empty($fieldRules['custom']) && is_callable($fieldRules['custom'])) {
                if (!$fieldRules['custom']($value)) {
                    $errors[$field] = $fieldRules['custom_message'] ?? ucfirst($field) . ' validation failed.';
                    continue;
                }
            }
        }

        return $errors;
    }

    /**
     * Sanitize value for XSS prevention
     * 
     * @param string $value Value to sanitize
     * @return string Sanitized value
     */
    public static function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize for database SQL (mysqli_real_escape_string)
     * Note: Use prepared statements instead of this when possible
     * 
     * @param string $value Value to escape
     * @param mysqli $connection Database connection
     * @return string Escaped value
     */
    public static function escapeSql($value, $connection = null) {
        if ($connection) {
            return mysqli_real_escape_string($connection, $value);
        }
        return addslashes($value);
    }

    /**
     * Sanitize for URL
     * 
     * @param string $value Value to sanitize
     * @return string Sanitized URL
     */
    public static function sanitizeUrl($value) {
        return filter_var($value, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize for email
     * 
     * @param string $value Email to sanitize
     * @return string Sanitized email
     */
    public static function sanitizeEmail($value) {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize for HTML (remove tags)
     * 
     * @param string $value Value to sanitize
     * @return string Sanitized value
     */
    public static function stripHtml($value) {
        return strip_tags($value);
    }
}

?>
