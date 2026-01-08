<?php
require_once('adminCheck.php');
require_once('../model/appointmentModel.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $status = deleteAppointment($id);

    if ($status) {
        header('location: ../view/appointment_list.php');
    } else {
        echo "Failed to delete appointment";
    }
} else {
    header('location: ../view/appointment_list.php');
}
?>