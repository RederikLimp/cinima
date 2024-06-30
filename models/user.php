<?php

function allUsers($db) {
    $sql = "SELECT * FROM users";
    return mysqli_query($db, $sql);
}
