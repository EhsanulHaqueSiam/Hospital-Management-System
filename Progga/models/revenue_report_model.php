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

    if (!empty($filters['from_date'])) {
        $sql .= " AND payment_date >= '{$filters['from_date']}'";
    }

    if (!empty($filters['to_date'])) {
        $sql .= " AND payment_date <= '{$filters['to_date']}'";
    }

    $sql .= " GROUP BY period ORDER BY period ASC";

    $res = mysqli_query($con, $sql);
    return $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
}
