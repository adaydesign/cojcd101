<?php

define("LINEBOT_ACCESS_TOKEN","4CaPW0nMt7/g/JJlwLv5Na3FrXaKlXT8vafjvcTbKLrBoRGTYb+nCLZvn8uHvDNlw+UbXaBBwGC0Sm5smUw34B6S0ezNNM/ztd5knT+tQOeLRv4k4Oz/ZiE1j1jslrhCjpidRnjoW1TfIG1gb2MymQdB04t89/1O/w1cDnyilFU=");
define("LINEBOT_CHANNEL_SECRET","9e65a3cdf681cfff0abaaa0cdb0edd1f");

define("CMD_SEARCH","#search");
define("CMD_LIST","#list");
define("CMD_REGISTER","#register");


include ('vendor/autoload.php');

use \LINE\LINEBot;
use \LINE\LINEBot\Constant\HTTPHeader;
use \LINE\LINEBot\HTTPClient;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;


$httpClient = new CurlHTTPClient(LINEBOT_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, ['channelSecret' => LINEBOT_CHANNEL_SECRET]);
$signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}


//-------------- //
foreach ($events as $event) {

    // Message Event = TextMessage
    if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
      // get message text
      $messageText = strtolower(trim($event->getText()));
      
      $cmd = strpos($messageText, "#")===0;

      // check cmd
      if($cmd){
        $cmd_params = explode(" ",$messageText);
        $cmd_p_size = count($cmd_params);
        $cmd_head   = "";
        $cmd_value  = "";

        if($cmd_p_size==1){
            $cmd_head  = $cmd_params[0];
        }else if($cmd_p_size>=2){
            $cmd_head   = $cmd_params[0];;
            $cmd_value  = $cmd_params[1];;
        }
      }

      // compare cmd
      if(strcmp($cmd_head,CMD_SEARCH)===0){
        //cmd : search
      }else if(strcmp($cmd_head,CMD_LIST)===0){
        //cmd : list

        $columns = array();
        $img_url = "https://cojcd101.herokuapp.com/assets/images/bg101.jpg";
        for($i=0;$i<1;$i++) {
          $actions = array(
            new UriTemplateActionBuilder("View","https://cojcd101.herokuapp.com/list_requesters.php")
          );
          $column = new CarouselColumnTemplateBuilder("รายชื่อผู้รอจัดสรรเข้าพักฯ", "", $img_url , $actions);
          $columns[] = $column;
        }
        $carousel = new CarouselTemplateBuilder($columns);
        $outputText = new TemplateMessageBuilder("Carousel Demo", $carousel);

        $bot->replyMessage($event->getReplyToken(), $outputText);
      }else if(strcmp($cmd_head,CMD_REGISTER)===0){
        //cmd : register
        $outputText = new TextMessageBuilder("Welcome ...");
        $bot->replyMessage($event->getReplyToken(), $outputText);
      }else{
        //else
        $outputText = new TextMessageBuilder("คำสั่ง #list, #search <ชื่อ>");
        $bot->replyMessage($event->getReplyToken(), $outputText);
      }

      
    }
  }  

?>