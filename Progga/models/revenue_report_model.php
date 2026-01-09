<?php

function tableExists($con, $table) {
    $res = mysqli_query($con, "SHOW TABLES LIKE '$table'");
    return ($res && mysqli_num_rows($res) > 0);
}

function getRevenueData($con, $filters) {
    if (!tableExists($con, 'payments')) {
        return [];
    }

    $groupBy = "DATE(payment_date)";
    if ($filters['type'] === 'Weekly') {
        $groupBy = "YEARWEEK(payment_date)";
    } elseif ($filters['type'] === 'Monthly') {
        $groupBy = "DATE_FORMAT(payment_date,'%Y-%m')";
    }

    $sql = "
        SELECT 
            $groupBy AS period,
            COUNT(id) AS bills_generated,
            SUM(total_amount) AS total_amount,
            SUM(paid_amount) AS paid_amount,
            SUM(balance_due) AS unpaid_amount
        FROM payments
        WHERE 1=1
    ";

    $params = [];
    $types = '';
    if (!empty($filters['from_date'])) {
        $sql .= " AND payment_date >= ?";
        $params[] = $filters['from_date'];
        $types .= 's';
    }

    if (!empty($filters['to_date'])) {
        $sql .= " AND payment_date <= ?";
        $params[] = $filters['to_date'];
        $types .= 's';
    }

    $sql .= " GROUP BY period ORDER BY period ASC";

    if (count($params) === 0) {
        $res = mysqli_query($con, $sql);
        return $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
    }

    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return [];

    // bind params dynamically
    $refs = [];
    $refs[] = & $types;
    for ($i = 0; $i < count($params); $i++) {
        $refs[] = & $params[$i];
    }
    call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmt], $refs));
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
    mysqli_stmt_close($stmt);
    return $data;
}
