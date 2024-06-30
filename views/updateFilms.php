<?php
session_start();

$config = require __DIR__ . '/../config.php';
$root = $config['root'];

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $root . "/views/login.php");
}

require __DIR__ . '/../db_connection.php';
require __DIR__ . '/../models/film.php';
global $db;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film_id = $_POST['film_id'];
    $title = $_POST['title'];
    $director = $_POST['director'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $duration = $_POST['duration'];

    updateFilm($db, [
        'title' => $title,
        'director' => $director,
        'genre' => $genre,
        'release_date' => $release_date,
        'duration' => $duration,
    ], $film_id);
}

$films = allFilms($db);

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
        <h2 class="text-2xl">Обновить данные фильма</h2>
        <form action="" method="post" class="flex flex-col gap-5 shadow-lg p-6 rounded-xl">
            <div>
                <label for="film_id">Фильм:</label>
                <select id="film_id" name="film_id">
                    <?php while($row = mysqli_fetch_assoc($films)): ?>
                        <option value="<?=$row['id']?>"><?=$row['title']?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="title">Название:</label>
                <input type="text" name="title" id="title" class="border-2 p-2 rounded-xl" />
            </div>
            <div>
                <label for="director">Режиссер:</label>
                <input type="text" name="director" id="director" class="border-2 p-2 rounded-xl" />
            </div>
            <div>
                <label for="genre">Жанр:</label>
                <input type="text" name="genre" id="genre" class="border-2 p-2 rounded-xl" />
            </div>
            <div>
                <label for="release_date">Дата релиза:</label>
                <input type="date" name="release_date" id="release_date" class="border-2 p-2 rounded-xl" />
            </div>
            <div class="flex flex-col">
                <label for="duration">Продолжитльность в минутах:</label>
                <input type="number" name="duration" id="duration" class="border-2 p-2 rounded-xl" />
            </div>
            <input type="submit" value="Обновить" class="shadow-lg bg-gray-300 px-6 py-2 rounded-xl cursor-pointer" />
        </form>
    </div>
</body>
</html>
