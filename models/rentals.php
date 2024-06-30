<?php

function allRentals($db) {
    $sql = "SELECT * FROM rentals";
    return mysqli_query($db, $sql);
}

function createRental($db, array $data) {
    $film_id = $data['film_id'];
    $theater_id = $data['theater_id'];
    $rental_date = $data['rental_date'];
    $return_date = $data['return_date'];
    $price = $data['price'];

    $sql = "INSERT INTO rentals (film_id, theater_id, rental_date, return_date, price) 
            VALUES ('$film_id', '$theater_id', '$rental_date', '$return_date', '$price')";
    mysqli_query($db, $sql);
}

function deleteRental($db, $rental_id) {
    $sql = "DELETE FROM rentals WHERE id = '$rental_id'";
    return mysqli_query($db, $sql);
}
