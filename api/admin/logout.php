<?php
// admin/logout.php
session_start();
session_destroy();
require_once '../includes/functions.php';
header("Location: index.php");
exit();
?>
