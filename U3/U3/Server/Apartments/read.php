<?php
require_once "../functions.php";


?>
<?php
//Parametrar = "id", "ids", "apartment_name", limit, include (int eller bool)
$requestMethod = $_SERVER["REQUEST_METHOD"];

//limit
if ($requestMethod == "GET") {
    $database = loadJson("../database.json");
    $allApartments = $database["Apartments"];
    $allTenants = $database["Tenants"];

    if (!isset($_GET["id"]) && !isset($_GET["ids"]) && !isset($_GET["street_name"]) &&  !isset($_GET["limit"])) {
        var_dump($database);
    }



    if (isset($_GET["limit"])) {
        $limitedArray = [];
        $returnApartments = array_slice($allApartments, 0, $_GET["limit"]);
        foreach ($returnApartments as $returnedApartment) {;
            array_push($limitedArray, includer($returnedApartment, $allTenants));
        }
        sendJson($limitedArray);
        exit();
    }

    //  id
    if (isset($_GET["id"])) {
        foreach ($allApartments as $key => $apartment) {
            if ($apartment["id"] == $_GET["id"]) {
                sendJson(includer($apartment, $allTenants));
                exit();
            }
        }
        sendJson("user not found", 404);
    }

    //ids
    if (isset($_GET["ids"])) {
        $idsFound = false;
        $ids = explode(",", $_GET["ids"]);
        $arrayOfApartments = [];
        foreach ($allApartments as $apartment) {
            if (in_array($apartment["id"], $ids)) {
                $idsFound = true;
                $arrayOfApartments[] = includer($apartment, $allTenants);
            }
            if (!$idsFound) {
                sendJson("users not found", 404);
            }
        }
        sendJson($arrayOfApartments);
        exit();
    }


    //street_name
    if (isset($_GET["street_name"])) {
        foreach ($allApartments as $key => $apartment) {
            if ($apartment["street_name"] == $_GET["street_name"]) {
                sendJson(includer($apartment, $allTenants));
                exit();
            }
        }
    }
} else {
    sendJson("you tried using the post method: " . $requestMethod . "." . " Please use GET", 400);
    exit();
}




?>