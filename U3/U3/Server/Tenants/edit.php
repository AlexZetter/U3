<?php
require_once "../functions.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$encodedInput = file_get_contents("php://input");
$decodedInput = json_decode($encodedInput, true);
$found = false;


if($requestMethod === "PATCH"){
    $database = loadJson("../database.json");
    $allTenants = $database["Tenants"];

    if (!empty($decodedInput["id"]) && !empty($decodedInput["first_name"]) && !empty($decodedInput["last_name"]) && !empty($decodedInput["email"])){
        foreach($database["Tenants"] as $key => $tenant){

            if($tenant["id"] == $decodedInput["id"]){
                $found = true;
                
                if(isset($decodedInput["first_name"])){
                    $tenant["first_name"] = $decodedInput["first_name"];
                } 

                if(isset($decodedInput["last_name"])){
                    $tenant["last_name"] = $decodedInput["last_name"];
                }

                if(isset($decodedInput["email"])){
                    $tenant["email"] = $decodedInput["email"];
                }
            
            $database["Tenants"][$key] = $tenant;
            $foundTenant = $tenant;
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
        sendJson([$foundTenant], 201);
    }

} else {
    sendJson(["message" => "Method not allowed"], 405);
}

?>