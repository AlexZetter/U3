<?php
require_once "../functions.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$encodedInput = file_get_contents("php://input");
$decodedInput = json_decode($encodedInput, true);
$found = false;


if($requestMethod === "PATCH"){
    $database = loadJson("../database.json");
    $allApartments = $database["Apartments"];

    if (!empty($decodedInput["id"]) && !empty($decodedInput["street_name"]) && !empty($decodedInput["street_number"]) && !empty($decodedInput["realtor"])){
        foreach($database["Apartments"] as $key => $apartment){

            if($apartment["id"] == $decodedInput["id"]){
                $found = true;
                
                if(isset($decodedInput["street_name"])){
                    $apartment["street_name"] = $decodedInput["street_name"];
                } 

                if(isset($decodedInput["street_number"])){
                    $apartment["street_number"] = $decodedInput["street_number"];
                }

                if(isset($decodedInput["realtor"])){
                    $apartment["realtor"] = $decodedInput["realtor"];
                }
            
            $database["Apartments"][$key] = $apartment;
            $foundApartment = $apartment;
            } 
            
        }
        if (!$found){
            sendJson(["message" => "ID:et finns inte, prova med något annat"], 404);
        }

    } else {
        sendJson(["message" => "Du måste fylla i alla fält"], 400);
    }

    if ($found){
        saveJson("../database.json", $database);
        sendJson([$foundApartment], 200);
    }

} else {
    sendJson(["message" => "Method not allowed"], 405);
}
