<?php
function tableExists($con, $table) {
    $res = mysqli_query($con, "SHOW TABLES LIKE '$table'");
    return ($res && mysqli_num_rows($res) > 0);
}

function getPatients($con, $filters) {
    if (!tableExists($con, 'patients')) {
        return [];
    }

    $sql = "SELECT * FROM patients WHERE 1=1";

    if (!empty($filters['from_date'])) {
        $sql .= " AND registration_date >= '{$filters['from_date']}'";
    }

    if (!empty($filters['to_date'])) {
        $sql .= " AND registration_date <= '{$filters['to_date']}'";
    }

    if (!empty($filters['gender']) && $filters['gender'] !== 'All') {
        $sql .= " AND gender = '{$filters['gender']}'";
    }

    if (!empty($filters['age_range']) && $filters['age_range'] !== 'All') {
        switch ($filters['age_range']) {
            case '0-18':
                $sql .= " AND age BETWEEN 0 AND 18";
                break;
            case '19-35':
                $sql .= " AND age BETWEEN 19 AND 35";
                break;
            case '36-60':
                $sql .= " AND age BETWEEN 36 AND 60";
                break;
            case '60+':
                $sql .= " AND age > 60";
                break;
        }
    }

    $result = mysqli_query($con, $sql);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}
