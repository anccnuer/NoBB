<?php
// router.php
if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false; // serve the requested resource as-is.
} else {
    include_once 'index.php'; // for example, redirect to your index.php script
}