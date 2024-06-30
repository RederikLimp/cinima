<?php

$config = require __DIR__ . '/config.php';

$db = mysqli_connect(
    $config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']
);

