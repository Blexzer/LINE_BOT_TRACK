<?php
$stringInput = 'กชรุณาช่วยค้นหาrdc0200018411และ RDC0200018410ด้วยครับ';
$lineSession = 'testBot';
$data = array("DATA" => $stringInput, "CREATE" => $lineSession);
$data_string = json_encode($data);
// echo $data_string;
//          /// call API Main
$urlBWAPI = "http://122.155.180.139/SERVICETRACK/service_linebot_track_temp.php" ;
$result = postJSONdataAPI($urlBWAPI, $data_string);
echo $result;

function postJSONdataAPI($URL, $JSON_STRING)
{
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_STRING);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($JSON_STRING))
    );

    return curl_exec($ch);
}