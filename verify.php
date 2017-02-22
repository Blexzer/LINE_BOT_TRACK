<?php
$access_token = 'tPROSmwb3NreedHXLbUN3c3mEVoJg3zI6BonkWxGBQUYZiz+4vZGHIoTnSJ0XsZeF9eRfpLL4R59Xat41unaUMBXJ3H7tbwMeorABfztCSmgf9xvxZFhZgvolBXxYr2I428eI3q4VOYQV1on4fgrpgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;