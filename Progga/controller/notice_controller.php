<?php
session_start();
require_once('../model/notice_model.php');

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($action == 'index') {
    $notices = getAllNotices();
    require_once('../view/notice/index.php');
}
