<?php
require_once "../functions.php";


?>
<?php
//Parametrar = "id", "ids", "tenant_name", limit, include (int eller bool)
$requestMethod = $_SERVER["REQUEST_METHOD"];

//limit
if ($requestMethod == "GET") {
    $database = loadJson("../database.json");
    $allTenants = $database["Tenants"];
    $allTenants = $database["Tenants"];

    if (!isset($_GET["id"]) && !isset($_GET["ids"]) && !isset($_GET["street_name"]) &&  !isset($_GET["limit"])) {
        var_dump($database);
    }



    if (isset($_GET["limit"])) {
        $limitedArray = [];
        $returnTenants = array_slice($allTenants, 0, $_GET["limit"]);
        foreach ($returnTenants as $returnedtenant) {;
            array_push($limitedArray, $returnedtenant, $allTenants);
        }
        sendJson($limitedArray);
        exit();
    }

    //  id
    if (isset($_GET["id"])) {
        foreach ($allTenants as $key => $tenant) {
            if ($tenant["id"] == $_GET["id"]) {
                sendJson($tenant);
                exit();
            }
        }
        sendJson("user not found", 404);
    }

    //ids
    if (isset($_GET["ids"])) {
        $idsFound = false;
        $ids = explode(",", $_GET["ids"]);
        $arrayOfTenants = [];
        foreach ($allTenants as $tenant) {
            if (in_array($tenant["id"], $ids)) {
                $idsFound = true;
                $arrayOfTenants[] = $tenant;
            }
        }
        if (!$idsFound) {
            sendJson("user not found", 404);
        }
        sendJson($arrayOfTenants);
        exit();
    }


    //street_name
    if (isset($_GET["street_name"])) {
        foreach ($allTenants as $key => $tenant) {
            if ($tenant["street_name"] == $_GET["street_name"]) {
                sendJson($tenant);
                exit();
            }
        }
    }
} else {
    sendJson("you tried using the post method: " . $requestMethod . "." . " Please use GET", 400);
    exit();
}




?>