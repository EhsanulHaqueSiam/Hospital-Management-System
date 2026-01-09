<?php
/**
 * Simple server-side validator
 */
class Validator {

    // Validate a set of fields against rules
    // $data: associative array of input data
    // $rules: ['field' => ['required'=>true, 'email'=>true, 'min'=>3, 'max'=>50]]
    public static function validate(array $data, array $rules) {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = isset($data[$field]) ? trim($data[$field]) : '';

            if (!empty($fieldRules['required']) && $value === '') {
                $errors[$field] = $fieldRules['required_message'] ?? ucfirst($field) . ' is required.';
                continue;
            }

            if ($value === '') {
                // skip other checks for empty optional fields
                continue;
            }

            if (!empty($fieldRules['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = $fieldRules['email_message'] ?? 'Please enter a valid email address.';
                continue;
            }

            if (!empty($fieldRules['min']) && mb_strlen($value) < (int)$fieldRules['min']) {
                $errors[$field] = $fieldRules['min_message'] ?? ucfirst($field) . " must be at least {$fieldRules['min']} characters.";
                continue;
            }

            if (!empty($fieldRules['max']) && mb_strlen($value) > (int)$fieldRules['max']) {
                $errors[$field] = $fieldRules['max_message'] ?? ucfirst($field) . " cannot exceed {$fieldRules['max']} characters.";
                continue;
            }

            if (!empty($fieldRules['match'])) {
                $other = $fieldRules['match'];
                $otherVal = isset($data[$other]) ? trim($data[$other]) : '';
                if ($value !== $otherVal) {
                    $errors[$field] = $fieldRules['match_message'] ?? ucfirst($field) . ' does not match.';
                    continue;
                }
            }

            if (!empty($fieldRules['date'])) {
                $d = date_parse($value);
                if ($d['error_count'] > 0) {
                    $errors[$field] = $fieldRules['date_message'] ?? 'Invalid date format.';
                    continue;
                }
            }
        }

        return $errors;
    }

    // Basic sanitization
    public static function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

?>
