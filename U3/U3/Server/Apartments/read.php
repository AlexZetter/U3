<?php
require_once "../functions.php";
$database = loadJson("../database.json");
$allApartments = $database["Apartments"];
$allTenants = $database["Tenants"];
?>
<?php
//Parametrar = "id", "ids", "apartment_name", limit, include (int eller bool)
$requestMethod = $_SERVER["REQUEST_METHOD"];

//limit
if ($requestMethod == "GET") {
    if (isset($_GET["n"])) {
        $returnUsers = array_slice($users, 0, $_GET["n"]);
    }

    // //id
    // if (isset($_GET["id"])) {
    //     foreach ($allApartments as $key => $apartment) {
    //         if ($apartment["id"] == $_GET["id"]) {
    //             sendJson($allApartments[$key]);
    //         }
    //     }
    // }

    //ids
    if (isset($_GET["ids"])) {
        $ids = explode(",", $_GET["ids"]);
        $arrayOfApartments = [];
        foreach ($allApartments as $apartment) {
            if (in_array($apartment["id"], $ids)) {
                $arrayOfApartments[] = $apartment;
            }
        }
        sendJson($arrayOfApartments);
    }


    //first_name
    if (isset($_GET["street_name"])) {
        foreach ($allApartments as $key => $apartment) {
            if ($apartment["street_name"] == $_GET["street_name"]) {
                sendJson($allApartments[$key]);
            }
        }
    }
}

//include
if (isset($_GET["include"], $_GET["id"])) {
    if ($_GET["include"] == "true") {
        foreach ($allApartments as $keyApartments => $apartment) {
            if ($apartment["id"] == $_GET["id"]) {
                foreach ($allTenants as $keyTenants => $tenant) {
                    if ($apartment["id"] == $tenant["apartment_id"]) {
                        $mergedObject = [
                            "id" => $apartment["id"],
                            "Tenant" => $tenant["id"]
                        ];
                        sendJson($mergedObject);
                    }
                }
            }
        }
    } elseif ($_GET["include"] == "false") {
        sendJson(["error"]);
    }
}


?>