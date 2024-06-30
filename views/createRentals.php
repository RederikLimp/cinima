<?php
session_start();

$config = require __DIR__ . '/../config.php';
$root = $config['root'];

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $root . "/views/login.php");
}

require __DIR__ . '/../db_connection.php';
require __DIR__ . '/../models/rentals.php';
require __DIR__ . '/../models/film.php';
require __DIR__ . '/../models/theater.php';
global $db;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    createRental($db, [
        'film_id' => $_POST['film_id'],
        'theater_id' => $_POST['theater_id'],
        'rental_date' => $_POST['rental_date'],
        'return_date' => $_POST['return_date'],
        'price' => $_POST['price'],
    ]);
}

$films = allFilms($db);
$theaters = allTheaters($db);

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
    <nav class="flex justify-end m-8 mb-2 gap-5">
        <a href="<?=$root . "/views/updateFilms.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Обновить фильм</a>
        <a href="<?=$root . "/views/createFilms.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Добавить фильм</a>
        <a href="<?=$root . "/views/main.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Главная</a>
        <a href="<?=$root . "/views/createRentals.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Дать напрокат</a>
        <a href="<?=$root . "/views/logout.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Выход</a>
    </nav>
    <div class="flex flex-col p-6 m-24gap-2 items-center justify-center">
        <h2 class="text-2xl">Дать напрокат</h2>
        <form action="" method="post" class="flex flex-col gap-5 shadow-lg p-6 rounded-xl">
            <div>
                <label for="film_id">Фильм</label>
                <select name="film_id" id="film_id">
                    <?php foreach ($films as $film): ?>
                        <option value="<?=$film['id']?>"><?=$film['title']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="theater_id">Кинотеатр</label>
                <select name="theater_id" id="theater_id">
                    <?php foreach ($theaters as $theater): ?>
                        <option value="<?=$theater['id']?>"><?=$theater['name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="rental_date">Дата начала проката</label>
                <input type="date" name="rental_date" id="rental_date" />
            </div>
            <div>
                <label for="return_date">Дата возврата</label>
                <input type="date" name="return_date" id="return_date" />
            </div>
            <div>
                <label for="price">Цена</label>
                <input type="number" name="price" id="price" step="any" class="border-2 p-2 rounded-xl" />
            </div>
            <input type="submit" value="Дать напрокат" class="shadow-lg bg-gray-300 px-6 py-2 rounded-xl cursor-pointer" />
        </form>
    </div>
</body>
</html>