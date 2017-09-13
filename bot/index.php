<?php

include "line-bot.php";

$channelSecret = "9e65a3cdf681cfff0abaaa0cdb0edd1f";
$access_token  = "4CaPW0nMt7/g/JJlwLv5Na3FrXaKlXT8vafjvcTbKLrBoRGTYb+nCLZvn8uHvDNlw+UbXaBBwGC0Sm5smUw34B6S0ezNNM/ztd5knT+tQOeLRv4k4Oz/ZiE1j1jslrhCjpidRnjoW1TfIG1gb2MymQdB04t89/1O/w1cDnyilFU=";

$bot = new BOT_API($channelSecret, $access_token);
	
if (!empty($bot->isEvents)) {
		
	$bot->replyMessageNew($bot->replyToken, json_encode($bot->message));

	if ($bot->isSuccess()) {
		echo 'Succeeded!';
		exit();
	}

	// Failed
	echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
	exit();

}


?>