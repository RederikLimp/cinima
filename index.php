<?php

$config = require __DIR__ . '/config.php';
$root = $config['root'];

if (isset($_SESSION['user_id'])) {
    header("Location: " . $root . "/views/main.php");
} else {
    header("Location: " . $root . "/views/login.php");
}

