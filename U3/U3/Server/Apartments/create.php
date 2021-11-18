<?php
require_once "../functions.php";

$inputData = loadJson("php://input");
$requestData = $_SERVER["REQUEST_METHOD"];
$contentType = $_SERVER["CONTENT_TYPE"];

//var_dump($inputData);
if (isset($inputData)){
    if (!empty($inputData["street_name"]) && !empty($inputData["street_number"]) && !empty($inputData["realtor"])){
        //var_dump($inputData["street_name"]);
        if ($requestData === "POST"){
            if($contentType === "application/json"){
                $database = loadJson("../database.json");
                $allApartments = $database["Apartments"];

                $highestID = max((array_column($database["Apartments"], "id")));
                $nextID = $highestID + 1;
                $streetName = $inputData["street_name"];
                $streetNumber = $inputData["street_number"];
                $realtor = $inputData["realtor"];

                // if(!isset($streetName, $streetNumber, $realtor)){
                //     sendJson(["message" => "dom finns inte i ISSET FATTA DE"], 400);
                // }

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
                sendJson(["message" => "not json"], 400);
            }
        } else {
            sendJson(["message" => "method not allowed!"], 400);
        }
    } else {
        sendJson(["message" => "Du har glömt fylla i något av fälten"], 400);
    }
} else {
    sendJson(["message" => "isset är TOOOM"], 400);
} 


?>