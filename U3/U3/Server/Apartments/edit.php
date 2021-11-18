<?php
require_once "../functions.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$encodedInput = file_get_contents("php://input");
$decodedInput = json_decode($encodedInput, true);

if($requestMethod === "PATCH"){
    $database = loadJson("../database.json");
    $allApartments = $database["Apartments"];

    foreach($database["Apartments"] as $key => $apartment){
        if($apartment["id"] == $decodedInput["id"]){


            if(isset($decodedInput["street_name"])){
                $apartment["street_name"] = $decodedInput["street_name"];
            } 

            if(isset($decodedInput["street_number"])){
                $apartment["street_number"] = $decodedInput["street_number"];
            }

            if(isset($decodedInput["realtor"])){
                $apartment["realtor"] = $decodedInput["realtor"];
            }

            if (empty($decodedInput["street_name"]) || empty($decodedInput["street_number"]) || empty($decodedInput["realtor"])){
                sendJson(["message" => "du måste fylla i alla fält"], 400);
            }
        
           $database["Apartments"][$key] = $apartment;
           $foundApartment = $apartment;
        } 
    }
    saveJson("../database.json", $database);
    sendJson([$foundApartment], 201);
    //sendJson(["message" => "ID:et finns inte, prova med något annat"], 400);
}



?>