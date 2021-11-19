<?php
function sendJson($data, $statusCode = 200)
{
    header("Content-Type: application/json");
    http_response_code($statusCode);
    $json = json_encode($data);
    echo $json;
    exit();
}

function loadJson($filename)
{
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

function saveJson($filename, $data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}


function includer($apartmentObject, $tenantArray)
{
    if (isset($_GET["include"])) {
        if ($_GET["include"] == "true")
            foreach ($tenantArray as $tenant) {
                if ($apartmentObject["tenant_id"] == $tenant["id"]) {
                    $apartmentObject["tenant_id"] = $tenant;
                }
            }
    }
    return $apartmentObject;
}
