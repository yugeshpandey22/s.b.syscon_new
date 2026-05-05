<?php
/**
 * Configuration Constants
 * This file defines various settings used throughout the application.
 */

// Site Information
define('SITE_NAME', 'S.B. Syscon Pvt. Ltd.');
define('SITE_EMAIL', 'pyugesh66@gmail.com');
define('SITE_PHONE', '+91 129 4150555');

// Base URL (Adjust this if your site is in a subdirectory)
// For local development, this is often 'http://localhost/sb/'
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $base_url);

?>
