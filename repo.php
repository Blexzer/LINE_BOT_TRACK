<?php


$access_token = 'tPROSmwb3NreedHXLbUN3c3mEVoJg3zI6BonkWxGBQUYZiz+4vZGHIoTnSJ0XsZeF9eRfpLL4R59Xat41unaUMBXJ3H7tbwMeorABfztCSmgf9xvxZFhZgvolBXxYr2I428eI3q4VOYQV1on4fgrpgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// echo $access_token;
// Validate parsed JSON data
// if (!is_null($events['events'])) {
//     // Loop through each event
// 	foreach ($events['events'] as $event) {
//         // Reply only when message sent is in 'text' format
// 		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
//             // Get text sent
// 			$text = $event['message']['text'];
//             // Get replyToken
// 			$stringInput = $text;
// 			$lineSession = 'testBot';

// 			$dataX = array("DATA" => $stringInput, "CREATE" => $lineSession);
// 			$data_string = json_encode($dataX);
// 			$urlBWAPI = "http://122.155.180.139/SERVICETRACK/service_linebot_track_temp.php" ;
// 			$resultApi = json_decode(postJSONdataAPI($urlBWAPI, $data_string),true);
// 			// echo sizeof($result);

// 			$replyToken = $event['replyToken'];

// 			for($i =0 ;$i<sizeof($resultApi);$i++){
// 				$bar = $resultApi[$i]["BARCODE"];
// 				$lo = $resultApi[$i]["RESULT"][0]['ACTION_TRACK_DESCRIPTION'];
// 			}
//             // Build message to reply back
// 			$messages = [
// 			'type' => 'text',
// 			'text' => $bar
// 			];

// // 			

//             // Make a POST Request to Messaging API to reply to sender
// 			$url = 'https://api.line.me/v2/bot/message/reply';
// 			$data = [
// 			'replyToken' => $replyToken,
// 			'messages' => [$messages],
// 			];
// 			$post = json_encode($data);
// 			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

// 			$ch = curl_init($url);
// 			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// 			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// 			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// 			$result = curl_exec($ch);
// 			curl_close($ch);

// 			echo $result . "\r\n";

// 		}
// 	}
// }
if (!is_null($events['events'])) {
    // Loop through each event
	foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
			$text = $event['message']['text'];
            // Get replyToken
			$replyToken = $event['replyToken'];

            // Build message to reply back
			"messages":[
			{
				"type":"text",
				"text":"Hello, user"
			},
			{
				"type":"text",
				"text":"May I help you?"
			}
			];

            // Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";


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