<?php
require_once "../functions.php";
$database = loadJson("../database.json");

$allApartments = $database["Apartments"];


if (!isset($_GET["id"], $_GET["ids"], $_GET["frstname"])) {
    echo "<pre>";
    var_dump($allApartments);
    echo "</pre>";
} else {
}



?>





<?php

//Parametrar = "id", "ids", "frstname", limit, include (int eller bool)


$requestMethod = $_SERVER["REQUEST_METHOD"];

//limit
if ($requestMethod == "GET") {
    if (isset($_GET["n"])) {

        $users = loadJson("database.json");
        $returnUsers = array_slice($users, 0, $_GET["n"]);
    }

    //id
    if (isset($_GET["id"])) {
        $users = loadJson("database.json");
        foreach ($users as $key => $user) {
            if ($user["id"] == $_GET["id"]) {
                sendJson($users[$key]);
            }
        }
    }

    //ids
    if (isset($_GET["ids"])) {
        //IDS
        $users = loadJson("database.json");
        $ids = explode(",", $_GET["ids"]);
        $arrayOfUsers = [];
        foreach ($users as $user) {
            if (in_array($user["id"], $ids)) {
                $arrayOfUsers[] = $user;
            }
        }
        sendJson($arrayOfUsers);
    }


    //first_name

    if (isset($_GET["id"])) {
        $users = loadJson("database.json");
        foreach ($users as $key => $user) {
            if ($user["first_name"] == $_GET["first_name"]) {
                sendJson($users[$key]);
            }
        }
    }
}
?>