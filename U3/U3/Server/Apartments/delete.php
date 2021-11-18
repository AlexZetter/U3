<?php
require_once "../functions.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$encodedInput = file_get_contents("php://input");
$input = json_decode($encodedInput, true);
$id = $input["id"];


if ($requestMethod == "DELETE") {
    $database = loadJson("../database.json");
    $allApartments = $database["Apartments"];

    $found = FALSE;

    foreach ($allApartments as $key => $apartment) {
        if ($apartment["id"] == $input["id"]) {
            $found = TRUE;
            array_splice($database["Apartments"], $key, 1);
        }
    }
    if ($found == False) {
        sendJson(["message:" => "user not found"]);
    }
    saveJson("../database.json", $database);
    sendJson($id . " deleted");
}
