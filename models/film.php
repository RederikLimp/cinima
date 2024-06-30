<?php

function allFilms($db) {
    $sql = "SELECT * FROM films";
    return mysqli_query($db, $sql);
}

function createFilm($db, array $data) {
    $title = $data['title'];
    $director = $data['director'];
    $genre = $data['genre'];
    $release_date = $data['release_date'];
    $duration = $data['duration'];

    $sql = "INSERT INTO films (title, director, genre, release_date, duration) 
            VALUES ('$title', '$director', '$genre', '$release_date', '$duration')";
    mysqli_query($db, $sql);
}

function deleteFilm($db, $film_id) {
    $sql = "DELETE FROM films WHERE id = '$film_id'";
    return mysqli_query($db, $sql);
}

function updateFilm($db, array $data, $film_id) {
    $title = $data['title'];
    $director = $data['director'];
    $genre = $data['genre'];
    $release_date = $data['release_date'];
    $duration = $data['duration'];
    $sql = "UPDATE films
            SET title='$title', director='$director', genre='$genre', release_date='$release_date', duration='$duration'
            WHERE id='$film_id'";
    mysqli_query($db, $sql);
}
