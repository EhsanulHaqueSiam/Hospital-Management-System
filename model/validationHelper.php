<?php
function validateRequired($value, $fieldName)
{
    if (empty(trim($value))) {
        return "$fieldName is required";
    }
    return null;
}

function validateEmail($email)
{
    if (empty(trim($email))) {
        return "Email is required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }
    return null;
}

function validatePhone($phone)
{
    if (empty(trim($phone))) {
        return "Phone is required";
    }
    $cleaned = str_replace([' ', '-', '(', ')', '+'], '', $phone);
    if (!ctype_digit($cleaned)) {
        return "Phone must contain only numbers";
    }

    if (strlen($cleaned) < 10 || strlen($cleaned) > 15) {
        return "Phone must be between 10 and 15 digits";
    }
    return null;
}

function validateUsername($username)
{
    if (empty(trim($username))) {
        return "Username is required";
    }
    if (strlen($username) < 3) {
        return "Username must be at least 3 characters";
    }
    $len = strlen($username);
    for ($i = 0; $i < $len; $i++) {
        $char = $username[$i];
        if (!ctype_alnum($char) && $char !== '_') {
            return "Username can only contain letters, numbers, and underscores";
        }
    }
    return null;
}

function validatePassword($password)
{
    if (empty($password)) {
        return "Password is required";
    }
    if (strlen($password) < 4) {
        return "Password must be at least 4 characters";
    }
    return null;
}

function validatePositiveNumber($value, $fieldName)
{
    if ($value === '' || $value === null) {
        return "$fieldName is required";
    }
    if (!is_numeric($value) || floatval($value) < 0) {
        return "$fieldName must be a positive number";
    }
    return null;
}

function validatePositiveInteger($value, $fieldName)
{
    if ($value === '' || $value === null) {
        return "$fieldName is required";
    }
    if (!is_numeric($value) || intval($value) < 1) {
        return "$fieldName must be a positive integer";
    }
    return null;
}

function validateDate($date, $fieldName)
{
    if (empty($date)) {
        return "$fieldName is required";
    }
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) {
        return "Invalid date format";
    }
    return null;
}

function validateFutureDate($date, $fieldName)
{
    $error = validateDate($date, $fieldName);
    if ($error)
        return $error;

    $inputDate = new DateTime($date);
    $today = new DateTime('today');
    if ($inputDate < $today) {
        return "$fieldName cannot be in the past";
    }
    return null;
}
?>