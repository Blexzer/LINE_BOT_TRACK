<?php
$access_token = 'tPROSmwb3NreedHXLbUN3c3mEVoJg3zI6BonkWxGBQUYZiz+4vZGHIoTnSJ0XsZeF9eRfpLL4R59Xat41unaUMBXJ3H7tbwMeorABfztCSmgf9xvxZFhZgvolBXxYr2I428eI3q4VOYQV1on4fgrpgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// echo $access_token;
// Validate parsed JSON data

if (!is_null($events['events'])) {
    // Loop through each event
	foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
			$text = $event['message']['text'];
            // Get replyToken
			$replyToken = $event['replyToken'];

			$strCut = explode('RDC',strtoupper($text));
			for($i=0;$i<sizeof($strCut);$i++){
				if(strlen($strCut[$i])>=10) {
					$countStr = str_split($strCut[$i], 10);
					if(is_numeric($countStr[0])){
						$barcode = 'RDC'.$countStr[0];
						$getBarcode[] = $barcode;
					}
				}
			}

            // Build message to reply back
			for($i=0;$i<sizeof($getBarcode);$i++){
				$lineSession = 'testBot';

				$dataX = array("DATA" => $getBarcode[$i], "CREATE" => $lineSession);
				$data_string = json_encode($dataX);
				$urlBWAPI = "http://122.155.180.139/SERVICETRACK/service_linebot_track_temp.php" ;
				$resultApi = json_decode(postJSONdataAPI($urlBWAPI, $data_string),true);
				$bar = $resultApi[0]["BARCODE"];
				$lo = $resultApi[0]["RESULT"][0]['ACTION_TRACK_DESCRIPTION'];
				$ACTION_DATETIME = $resultApi[0]["RESULT"][0]['ACTION_DATETIME'];
				$RECEIVER_NAME = $resultApi[0]["RESULT"][0]['RECEIVER_NAME'];
				$DEST_PROVINCE = $resultApi[0]["RESULT"][0]['DEST_PROVINCE'];
				// $lo = $resultApi[0]["RESULT"][0]['ACTION_TRACK_DESCRIPTION'];
				$x = array(
					'type' => 'text',
					'text' => 'Track: '.$bar.'
					ผู้รับ: '.$RECEIVER_NAME.' ('.$DEST_PROVINCE.')'.'
					สถานะ: '. $lo .' ('.$ACTION_DATETIME .')'
					);
				$messages[]=$x;
			}

            // Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
			'replyToken' => $replyToken,
			'messages' => $messages,
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