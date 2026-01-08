<?php
require_once('db.php');

function getAllRooms()
{
    $con = getConnection();
    $sql = "SELECT * FROM rooms ORDER BY room_number ASC";
    $result = mysqli_query($con, $sql);

    $rooms = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
    return $rooms;
}

function getRoomById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM rooms WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function getRoomByNumber($room_number)
{
    $con = getConnection();
    $number = mysqli_real_escape_string($con, $room_number);
    $sql = "SELECT * FROM rooms WHERE room_number='{$number}'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addRoom($room)
{
    $con = getConnection();
    $number = mysqli_real_escape_string($con, $room['room_number']);
    $type = mysqli_real_escape_string($con, $room['room_type']);
    $floor = mysqli_real_escape_string($con, $room['floor']);
    $capacity = intval($room['capacity']);
    $price = floatval($room['price_per_day']);
    $facilities = mysqli_real_escape_string($con, $room['facilities']);
    $desc = mysqli_real_escape_string($con, $room['description']);
    $status = 'Available';

    $sql = "INSERT INTO rooms (room_number, room_type, floor, capacity, price_per_day, facilities, description, status) 
            VALUES ('{$number}', '{$type}', '{$floor}', '{$capacity}', '{$price}', '{$facilities}', '{$desc}', '{$status}')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateRoom($room)
{
    $con = getConnection();
    $id = intval($room['id']);
    $number = mysqli_real_escape_string($con, $room['room_number']);
    $type = mysqli_real_escape_string($con, $room['room_type']);
    $floor = mysqli_real_escape_string($con, $room['floor']);
    $capacity = intval($room['capacity']);
    $price = floatval($room['price_per_day']);
    $facilities = mysqli_real_escape_string($con, $room['facilities']);
    $desc = mysqli_real_escape_string($con, $room['description']);

    $sql = "UPDATE rooms SET 
            room_number='{$number}', 
            room_type='{$type}', 
            floor='{$floor}', 
            capacity='{$capacity}', 
            price_per_day='{$price}', 
            facilities='{$facilities}', 
            description='{$desc}' 
            WHERE id='{$id}'";

    return mysqli_query($con, $sql);
}

function deleteRoom($id)
{
    $con = getConnection();
    $id = intval($id);
    mysqli_query($con, "DELETE FROM room_assignments WHERE room_id='{$id}'");
    $sql = "DELETE FROM rooms WHERE id='{$id}'";
    return mysqli_query($con, $sql);
}

function assignPatientToRoom($assignment)
{
    $con = getConnection();
    $patient_id = intval($assignment['patient_id']);
    $room_id = intval($assignment['room_id']);
    $admission_date = mysqli_real_escape_string($con, $assignment['admission_date']);
    $expected = mysqli_real_escape_string($con, $assignment['expected_discharge_date']);
    $notes = mysqli_real_escape_string($con, $assignment['admission_notes']);
    $assigned_by = intval($assignment['assigned_by']);

    $sql = "INSERT INTO room_assignments (patient_id, room_id, admission_date, expected_discharge_date, admission_notes, assigned_by) 
            VALUES ('{$patient_id}', '{$room_id}', '{$admission_date}', '{$expected}', '{$notes}', '{$assigned_by}')";

    if (mysqli_query($con, $sql)) {

        $countSql = "SELECT COUNT(*) as count FROM room_assignments WHERE room_id='{$room_id}' AND discharge_date IS NULL";
        $countResult = mysqli_query($con, $countSql);
        $countRow = mysqli_fetch_assoc($countResult);
        $currentPatients = $countRow['count'];


        $room = getRoomById($room_id);
        $capacity = $room['capacity'];


        if ($currentPatients >= $capacity) {
            mysqli_query($con, "UPDATE rooms SET status='Occupied' WHERE id='{$room_id}'");
        }
        return true;
    } else {
        return false;
    }
}

function getActiveAssignments()
{
    $con = getConnection();
    $sql = "SELECT ra.*, p.id as patient_id, u.full_name as patient_name, r.room_number 
            FROM room_assignments ra 
            JOIN rooms r ON ra.room_id = r.id 
            JOIN patients p ON ra.patient_id = p.id 
            JOIN users u ON p.user_id = u.id 
            WHERE ra.discharge_date IS NULL 
            ORDER BY ra.admission_date DESC";

    $result = mysqli_query($con, $sql);

    $assignments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $assignments[] = $row;
    }
    return $assignments;
}

function dischargePatient($assignment_id, $room_id, $date)
{
    $con = getConnection();
    $assignment_id = intval($assignment_id);
    $room_id = intval($room_id);
    $date = mysqli_real_escape_string($con, $date);
    $sql = "UPDATE room_assignments SET discharge_date='{$date}' WHERE id='{$assignment_id}'";
    if (mysqli_query($con, $sql)) {

        $countSql = "SELECT COUNT(*) as count FROM room_assignments WHERE room_id='{$room_id}' AND discharge_date IS NULL";
        $countResult = mysqli_query($con, $countSql);
        $countRow = mysqli_fetch_assoc($countResult);
        $remainingPatients = $countRow['count'];


        if ($remainingPatients == 0) {
            mysqli_query($con, "UPDATE rooms SET status='Available' WHERE id='{$room_id}'");
        }
        return true;
    }
    return false;
}


function getRoomOccupancy($room_id)
{
    $con = getConnection();
    $room_id = intval($room_id);
    $sql = "SELECT COUNT(*) as count FROM room_assignments WHERE room_id='{$room_id}' AND discharge_date IS NULL";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}
?>