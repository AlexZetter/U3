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

    //  id
    if (isset($_GET["id"]) && !isset($_GET["include"])) {
        foreach ($allApartments as $key => $apartment) {
            if ($apartment["id"] == $_GET["id"]) {
                sendJson(includer($apartment, $allTenants));
            }
        }
    }

    //ids
    if (isset($_GET["ids"])) {
        $ids = explode(",", $_GET["ids"]);
        $arrayOfApartments = [];
        foreach ($allApartments as $apartment) {
            if (in_array($apartment["id"], $ids)) {
                $arrayOfApartments[] = includer($apartment, $allTenants);
            }
        }
        sendJson($arrayOfApartments);
    }


    //street_name
    if (isset($_GET["street_name"])) {
        foreach ($allApartments as $key => $apartment) {
            if ($apartment["street_name"] == $_GET["street_name"]) {
                sendJson(includer($apartment, $allTenants));
            }
        }
    }
}




?>