<?php
require_once "../functions.php";
$allApartments = loadJson("../databaseApartments.json");

if (!isset($_GET["id"], $_GET["ids"], $_GET["frstname"])) {
    echo "<pre>";
    var_dump($allTenants);
    echo "</pre>";
    echo "<pre>";
    var_dump($allApartments);
    echo "</pre>";
} else {
}







//Parametrar = "id", "ids", "frstname", limit, include (int eller bool)