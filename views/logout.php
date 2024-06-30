<?php

$config = require __DIR__ . '/../config.php';
$root = $config['root'];

session_start();
session_unset();
session_destroy();
header("Location: " . $root . "/views/login.php");
