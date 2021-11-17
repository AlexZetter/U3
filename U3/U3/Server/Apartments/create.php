<?php
require_once "../functions.php";

$inputData = loadJson("php://input");
$requestData = $_SERVER["REQUEST_METHOD"];
$contentType = $_SERVER["CONTENT_TYPE"];

// $database = loadJson("../database.json");
// $allApartments = $database["Apartments"];

// echo "<pre>";
// var_dump($allApartments);
// echo "</pre>"; 

if (isset($inputData)){
    if ($requestData === "POST"){
        if($contentType === "application/json"){
            $json = file_get_contents("../databaseBackUp2.json");
            $data = json_decode($json, true);
            // $database = loadJson("../databaseBackUp2.json");
            // $allApartments = $database["Apartments"];


            $highestID = max((array_column($data["Apartments"], "id")));
            $nextID = $highestID + 1;

            $streetName = $inputData["street_name"];
            $streetNumber = $inputData["street_number"];
            $realtor = $inputData["realtor"];


            $newApartment = [
                "id" => $nextID,
                "street_name" => $streetName,
                "street_number" => $streetNumber,
                "realtor" => $realtor,
                "tenant_id" => $nextID
            ];

            
            echo "<pre>";
            var_dump($newApartment);
            echo "</pre>";


            array_push($data["Apartments"], $newApartment);

            // saveJson("../databaseBackUp2.json", $database);
            $json = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents("../databaseBackUp2.json", $json);
            sendJson(["id" => $newApartment], 201);
            
        }else {
            sendJson(["message" => "bad request!"], 400);
        }
    }
}


?>