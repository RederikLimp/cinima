<?php
session_start();

$config = require __DIR__ . '/../config.php';
$root = $config['root'];

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $root . "/views/login.php");
}

require __DIR__ . '/../db_connection.php';
require __DIR__ . '/../models/film.php';
require __DIR__ . '/../models/rentals.php';
require __DIR__ . '/../models/theater.php';
global $db;

$films = allFilms($db);
$rentals = [];
$result_rentals = allRentals($db);
while ($row_rental = mysqli_fetch_assoc($result_rentals)) {
    $rentals[] = $row_rental;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['film_id'])) {
        $film_id = $_POST['film_id'];
        deleteFilm($db, $film_id);
    }
    if (isset($_POST['rental_id'])) {
        $rental_id = $_POST['rental_id'];
        deleteRental($db, $rental_id);
    }
    header("Location: " . $root . "/views/main.php");
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
    <nav class="flex justify-end m-8 mb-2 gap-5">
        <a href="<?=$root . "/views/updateFilms.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Обновить фильм</a>
        <a href="<?=$root . "/views/createFilms.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Добавить фильм</a>
        <a href="<?=$root . "/views/main.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Главная</a>
        <a href="<?=$root . "/views/createRentals.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Дать напрокат</a>
        <a href="<?=$root . "/views/logout.php"?>" class="shadow-lg bg-gray-200 px-6 py-2 rounded-xl">Выход</a>
    </nav>
    <div class="flex flex-wrap p-6 shadow-md m-24 bg-gray-100 gap-4">
        <?php while ($row = mysqli_fetch_assoc($films)): ?>
            <div class="flex flex-col shadow-xl p-8 rounded-2xl gap-2">
                <span>ID: <strong><?= $row['id'] ?></strong></span>
                <span>Название фильма: <strong><?= $row['title'] ?></strong></span>
                <span>Режисер: <strong><?= $row['director'] ?></strong></span>
                <span>Жанр: <strong><?= $row['genre'] ?></strong></span>
                <span>Дата выхода: <strong><?= $row['release_date'] ?></strong></span>
                <span>Длительность: <strong><?= $row['duration'] ?> мин.</strong></span>
                <?php
                    $flag = false;
                    foreach ($rentals as $rental) {
                        if ($rental['film_id'] === $row['id']) {
                            $flag = true;
                            $theater = mysqli_fetch_assoc(getTheaterById($db, $rental['theater_id']));
                            echo "<span class='mt-6'>На аренде у кинотеарта:</span>";
                            echo "<span> ID: <strong>" . $theater['id'] . "</strong></span>";
                            echo "<span> Название: <strong>" . $theater['name'] . "</strong></span>";
                            echo "<span> Локация: <strong>" . $theater['location'] . "</strong></span>";
                            echo "<span> Контактная информация: <strong>" . $theater['contact_info'] . "</strong></span>";
                            echo "<span> С: <strong>" . $rental['rental_date'] . "</strong></span>";
                            echo "<span> По: <strong>" . $rental['return_date'] . "</strong></span>";
                            echo "<span> Цена: <strong>" . $rental['price'] . "</strong></span>";
                            echo "<form action='' method='post'>";
                            echo "<input type='hidden' name='rental_id' value='" . $rental['id'] . "' />";
                            echo "<input type='submit' class='shadow-lg bg-gray-300 px-6 py-2 rounded-xl cursor-pointer' value='Убрать с проката' />";
                            echo "</form>";
                        }
                    }
                    if (!$flag) {
                        echo "<form action='' method='post'>";
                        echo "<input type='hidden' name='film_id' value='" . $row['id'] . "' />";
                        echo "<input type='submit' class='shadow-lg bg-gray-300 px-6 py-2 rounded-xl cursor-pointer' value='Удалить' />";
                        echo "</form>";
                    }
                ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
