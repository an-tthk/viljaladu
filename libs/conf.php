<?php

// andmed

$db_server = "localhost";
$db_andmebaas = "an";
$db_kasutaja = "an";
$db_salasona = "qwerty";

// ühendus andmebaasiga
$yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);

// ühenduse kontroll
if (!$yhendus) {
    die("Ei saa ühendust andmebaasiga");
}