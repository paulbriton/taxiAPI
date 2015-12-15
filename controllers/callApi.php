<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

//https://api.opendatataxi.fr/taxis/
//"Accept":"application/json", "X-VERSION": "2", "X-API-KEY":"46f06ed1-0124-4edc-9283-0df69a604ef4"

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
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
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
        //"lat" => $lat, 
        //"lon" => $lng

        // Test Version
        "lat" => "48.872614",
        "lon" => "2.324037"
    );
    $headers = array(
        'Accept: application/json',
        'X-VERSION: 2',
        'X-API-KEY: 46f06ed1-0124-4edc-9283-0df69a604ef4'
    );
    $res = callAPI("GET", "https://api.opendatataxi.fr/taxis/", $headers, $data);
    var_dump(json_decode($res));
}