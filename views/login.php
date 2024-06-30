<?php
session_start();
require __DIR__ . '/../models/user.php';
require __DIR__ . '/../db_connection.php';

$config = require __DIR__ . '/../config.php';
$root = $config['root'];

if (isset($_SESSION['user_id'])) {
    header("Location: " . $root . "/views/main.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name =  $_POST['username'];
    $password = $_POST['password'];
    global $db;
    $res = allUsers($db);

    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['username'] === $name &&
            password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: " . $root . "/views/main.php");
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Киновидеопрокат</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex flex-col p-6 m-24gap-2 items-center justify-center mt-24">
        <h2 class="text-2xl">Авторизация</h2>
        <form action="" method="post" class="flex flex-col gap-5 shadow-lg p-6 rounded-xl">
            <div>
                <label for="username">Логин:</label>
                <input type="text" id="username" name="username" class="border-2 py-1 px-2 rounded-xl" />
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" class="border-2 py-1 px-2 rounded-xl" />
            </div>
            <input type="submit" value="Вход" class="shadow-lg bg-gray-300 px-6 py-2 rounded-xl cursor-pointer" />
        </form>
    </div>
</body>
</html>