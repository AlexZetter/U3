<?php
require_once "../functions.php";

$inputData = loadJson("php://input");
$requestData = $_SERVER["REQUEST_METHOD"];
$contentType = $_SERVER["CONTENT_TYPE"];


if (isset($inputData)){
    if ($requestData === "POST"){
        if($contentType === "application/json"){
            $database = loadJson("../database.json");
            $allApartments = $database["Apartments"];


            $highestID = max((array_column($database["Apartments"], "id")));
            $nextID = $highestID + 1;

            $streetName = $inputData["street_name"];
            $streetNumber = $inputData["street_number"];
            $realtor = $inputData["realtor"];

            if(!isset($streetName, $streetNumber, $realtor) || trim($streetName) == ''){
                sendJson(["message" => "Du måste fylla i alla fält"], 400);
            }


            $newApartment = [
                "id" => $nextID,
                "street_name" => $streetName,
                "street_number" => $streetNumber,
                "realtor" => $realtor,
                "tenant_id" => $nextID
            ];


            array_push($database["Apartments"], $newApartment);

            saveJson("../database.json", $database);
            sendJson([$newApartment], 201);
            
        }else {
            sendJson(["message" => "bad request!"], 400);
        }
    }
}


?>