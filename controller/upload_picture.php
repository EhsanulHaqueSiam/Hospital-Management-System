<?php
session_start();
require_once('../model/userModel.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] == 0) {
        $src = $_FILES['myfile']['tmp_name'];
        $original_filename = $_FILES['myfile']['name'];
        $file_ext = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

        $target_dir = "../assets/uploads/profiles/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $random_filename = time() . "." . $file_ext;
        $des = $target_dir . $random_filename;

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($file_ext, $allowed_types)) {
            echo "Only JPG, JPEG, PNG & GIF files are allowed!";
            echo "<br>Debug: Detected extension = '$file_ext'";
            echo "<br><a href='../view/profile_upload_picture.php'>Go Back</a>";
            exit;
        }

        if ($_FILES['myfile']['size'] > 2097152) {
            echo "File size must be less than 2MB!";
            exit;
        }

        if (move_uploaded_file($src, $des)) {
            $status = updateProfilePictureWithOriginal($user_id, $des, $original_filename);

            if ($status) {
                echo "Done!";
                echo "<br><a href='../view/profile_view.php'>Go to Profile</a>";
            } else {
                echo "Error updating database!";
            }
        } else {
            echo "Error uploading file!";
        }
    } else {
        echo "No file selected!";
    }
} else {
    header('location: ../view/profile_upload_picture.php');
}
?>