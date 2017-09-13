<?php

include_once "vendor/autoload.php";

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('4CaPW0nMt7/g/JJlwLv5Na3FrXaKlXT8vafjvcTbKLrBoRGTYb+nCLZvn8uHvDNlw+UbXaBBwGC0Sm5smUw34B6S0ezNNM/ztd5knT+tQOeLRv4k4Oz/ZiE1j1jslrhCjpidRnjoW1TfIG1gb2MymQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '9e65a3cdf681cfff0abaaa0cdb0edd1f']);

$response = $bot->replyText('U2da8b19feaedf50a33baaeb80ce64ba', 'hello!');

?>