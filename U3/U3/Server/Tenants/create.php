<?php
require_once "../functions.php";

$inputData = loadJson("php://input");
$requestData = $_SERVER["REQUEST_METHOD"];
$contentType = $_SERVER["CONTENT_TYPE"];

if (isset($inputData)){
    if (!empty($inputData["first_name"]) && !empty($inputData["last_name"]) && !empty($inputData["email"])){
        if ($requestData === "POST"){
            if($contentType === "application/json"){
                $database = loadJson("../database.json");
                $allTenants = $database["Tenants"];

                $highestID = max((array_column($database["Tenants"], "id")));
                $nextID = $highestID + 1;
                $firstName = $inputData["first_name"];
                $lastName = $inputData["last_name"];
                $email = $inputData["email"];

                $newTenant = [
                    "id" => $nextID,
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "email" => $email,
                    "tenant_id" => $nextID
                ];
                array_push($database["Tenants"], $newTenant);
                saveJson("../database.json", $database);
                sendJson([$newTenant], 201);
                
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