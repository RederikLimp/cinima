<?php

function allTheaters($db) {
    $sql = "SELECT * FROM theaters";
    return mysqli_query($db, $sql);
}

function getTheaterById($db, $id) {
    $sql = "SELECT * FROM theaters WHERE id = $id";
    return mysqli_query($db, $sql);
}