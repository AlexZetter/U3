<?php
require_once "../functions.php";
$contentType = $_SERVER["CONTENT_TYPE"];





$requestMethod = $_SERVER["REQUEST_METHOD"];
$encodedInput = file_get_contents("php://input");
$input = json_decode($encodedInput, true);
$id = $input["id"];


if ($requestMethod == "DELETE") {
    if ($contentType === "application/json") {
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
            sendJson(["message:" => "user not found"], 404);
        }
        saveJson("../database.json", $database);
        sendJson($id . " deleted");
    } else {
        sendJson("Please enter in JSON format", 400);
    }
}
