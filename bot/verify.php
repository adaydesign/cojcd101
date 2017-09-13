<?php

$access_token = '4CaPW0nMt7/g/JJlwLv5Na3FrXaKlXT8vafjvcTbKLrBoRGTYb+nCLZvn8uHvDNlw+UbXaBBwGC0Sm5smUw34B6S0ezNNM/ztd5knT+tQOeLRv4k4Oz/ZiE1j1jslrhCjpidRnjoW1TfIG1gb2MymQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;


?>