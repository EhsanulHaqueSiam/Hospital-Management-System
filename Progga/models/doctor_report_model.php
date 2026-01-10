<?php

function tableExists($con, $table) {
    $res = mysqli_query($con, "SHOW TABLES LIKE '$table'");
    return ($res && mysqli_num_rows($res) > 0);
}

function getDoctorReport($con, $filters) {
    if (!tableExists($con, 'doctors') || !tableExists($con, 'appointments')) {
        return [];
    }

    $sql = "
        SELECT 
            d.id,
            d.name,
            d.department,
            COUNT(a.id) AS total_appointments,
            COUNT(DISTINCT a.patient_id) AS total_patients
        FROM doctors d
        LEFT JOIN appointments a ON d.id = a.doctor_id
        WHERE 1=1
    ";

    if ($filters['department'] !== 'All') {
        $sql .= " AND d.department = '{$filters['department']}'";
    }

    if ($filters['doctor'] !== 'All') {
        $sql .= " AND d.id = '{$filters['doctor']}'";
    }

    if (!empty($filters['from_date'])) {
        $sql .= " AND a.appointment_date >= '{$filters['from_date']}'";
    }

    if (!empty($filters['to_date'])) {
        $sql .= " AND a.appointment_date <= '{$filters['to_date']}'";
    }

    $sql .= " GROUP BY d.id";

    $result = mysqli_query($con, $sql);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

function getPrescriptionCount($con, $doctorId) {
    if (!tableExists($con, 'prescriptions')) {
        return 0;
    }

    $res = mysqli_query($con, "
        SELECT COUNT(*) AS total 
        FROM prescriptions 
        WHERE doctor_id = '$doctorId'
    ");

    if ($res) {
        $row = mysqli_fetch_assoc($res);
        return $row['total'];
    }

    return 0;
}
