<?php
// admin/auth_check.php
session_start();
require_once '../includes/functions.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>
