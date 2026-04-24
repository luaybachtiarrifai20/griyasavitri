<?php
// includes/functions.php

// Suppress error display on the website for a cleaner look
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

/**
 * Simple .env loader
 */
function load_env($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
        $_ENV[trim($name)] = trim($value);
    }
}

load_env(__DIR__ . '/../../.env');

function format_currency($amount) {
    return "Rp " . number_format($amount, 0, ',', '.');
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

/**
 * Generate WhatsApp Link
 */
function get_wa_link($service_name = "") {
    $phone = getenv('WA_NUMBER') ?: '6289619344767';
    $message = "Halo Griya Savitri, saya ingin melakukan reservasi.";
    if ($service_name) {
        $message = "Halo Griya Savitri, saya ingin memesan layanan: " . $service_name;
    }
    return "https://wa.me/" . $phone . "?text=" . urlencode($message);
}
?>
