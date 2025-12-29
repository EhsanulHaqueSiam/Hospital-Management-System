<?php
require_once('db.php');


function login($credentials)
{
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE username='{$credentials['username']}' AND password='{$credentials['password']}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}


function getUserById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getUserByUsername($username)
{
    $con = getConnection();
    $username = mysqli_real_escape_string($con, $username);
    $sql = "SELECT * FROM users WHERE username='{$username}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getAllUsers()
{
    $con = getConnection();
    $sql = "SELECT * FROM users ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    $users = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    return $users;
}

function addUser($user)
{
    $con = getConnection();

    $full_name = mysqli_real_escape_string($con, $user['full_name']);
    $email = mysqli_real_escape_string($con, $user['email']);
    $phone = mysqli_real_escape_string($con, $user['phone']);
    $username = mysqli_real_escape_string($con, $user['username']);
    $password = mysqli_real_escape_string($con, $user['password']);
    $role = mysqli_real_escape_string($con, $user['role']);
    $address = isset($user['address']) ? mysqli_real_escape_string($con, $user['address']) : '';

    $sql = "INSERT INTO users (full_name, email, phone, username, password, role, address) 
            VALUES ('{$full_name}', '{$email}', '{$phone}', '{$username}', '{$password}', '{$role}', '{$address}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateUser($user)
{
    $con = getConnection();

    $full_name = mysqli_real_escape_string($con, $user['full_name']);
    $email = mysqli_real_escape_string($con, $user['email']);
    $phone = mysqli_real_escape_string($con, $user['phone']);

    // Build update query - only update provided fields
    $sql = "UPDATE users SET full_name='{$full_name}', email='{$email}', phone='{$phone}'";

    // Add optional address field if provided
    if (isset($user['address'])) {
        $address = mysqli_real_escape_string($con, $user['address']);
        $sql .= ", address='{$address}'";
    }

    $sql .= " WHERE id='{$user['id']}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updatePassword($user_id, $password)
{
    $con = getConnection();
    $password = mysqli_real_escape_string($con, $password);
    $sql = "UPDATE users SET password='{$password}' WHERE id='{$user_id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateProfilePicture($user_id, $picture_path)
{
    $con = getConnection();
    $picture_path = mysqli_real_escape_string($con, $picture_path);
    $sql = "UPDATE users SET profile_picture='{$picture_path}' WHERE id='{$user_id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateProfilePictureWithOriginal($user_id, $picture_path, $original_filename)
{
    $con = getConnection();
    $picture_path = mysqli_real_escape_string($con, $picture_path);
    $original_filename = mysqli_real_escape_string($con, $original_filename);
    $sql = "UPDATE users SET profile_picture='{$picture_path}', original_picture_name='{$original_filename}' WHERE id='{$user_id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}


function deleteUser($id)
{
    $con = getConnection();
    $sql = "DELETE FROM users WHERE id='{$id}'";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>