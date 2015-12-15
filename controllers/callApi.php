<?php

include_once("../class/taxi.class.php");

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
// Headers: array("param" => "value")   

function callAPI($method, $url, $headers = false, $data = false) {
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($curl, CURLOPT_URL, $url);
    if ($headers)
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return $result;
}

// Send request to API with client params
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat=$_POST['lat'];
    $lng=$_POST['lng'];
    $data = array(
        "lat" => $lat, 
        "lon" => $lng

        // Test Version
        //"lat" => "48.872614",
        //"lon" => "2.324037"
    );
    $headers = array(
        'Accept: application/json',
        'X-VERSION: 2',
        'X-API-KEY: xxxxxxxxxxxxxxxxxx'
    );
    $res = callAPI("GET", "https://api.opendatataxi.fr/taxis/", $headers, $data);
    $object = json_decode($res);
    $taxisList = array();
    foreach ($object->data as $key => $value) {
        $taxi = new Taxi($value);
        array_push($taxisList, $taxi);
    }

    $json = array();
    foreach ($taxisList as $taxi) {
        $json[] = $taxi->getCoordinate(); 
    }
    echo json_encode($json);
}
