<?php

include_once "vendor/autoload.php";

$accessToken   = "4CaPW0nMt7/g/JJlwLv5Na3FrXaKlXT8vafjvcTbKLrBoRGTYb+nCLZvn8uHvDNlw+UbXaBBwGC0Sm5smUw34B6S0ezNNM/ztd5knT+tQOeLRv4k4Oz/ZiE1j1jslrhCjpidRnjoW1TfIG1gb2MymQdB04t89/1O/w1cDnyilFU=";
$channelSecret = "9e65a3cdf681cfff0abaaa0cdb0edd1f";

include_once "line-bot.php";

$bot = new BOT_API($channelSecret, $accessToken);
	
if (!empty($bot->isEvents)) {
		
    $bot->replyMessageNew($bot->replyToken, json_encode($bot->message));
    if ($bot->isSuccess()) {
        echo 'Succeeded!';
        //exit();
    }
    $bot->sendMessageNew('U2da8b19feaedf50a33baaeb80ce64ba2', 'Hello World !!');
    if ($bot->isSuccess()) {
        echo 'Succeeded!';
        exit();
    }

    // Failed
    echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
    exit();
}

?>