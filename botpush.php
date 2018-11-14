<?php
require "vendor/autoload.php";
// การตั้งเกี่ยวกับ bot
require_once 'bot_settings.php';
    
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
    // เชื่อมต่อกับ LINE Messaging API
    $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
    $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
    // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
    $content = file_get_contents('php://input');
   
    // แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
    $events = json_decode($content, true);
    $accessToken = "Dp5cTXj8NHTYDiKoy/fQeb1zcbXljHoONSe4hCHXj1SIQ2FJCCH7qQXjnvfjxR21PWBquHunHE0HZtRL8Ezq9xf7cxTdeI/fKSKy9uNqwBIn3XicVdrptnh7SW4nD77FZeYQgrBWfpTFW9FG1EEujQdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    //รับข้อความจากผู้ใช้
    $message = $events['events'][0]['message']['text'];
    $message = strtolower($message);
    //รับ id ของผู้ใช้
    $id = $events['events'][0]['source']['userId'];   
    
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    //เชื่อมต่อ mlab
    $api_key="7vVKdrk-Rg7qp8C5KFUrkQRWmAJaazgQ";
	
    //colletion พูดคุยทั่วไป
    $url = 'https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'';
    $json = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data = json_decode($json);
    $isData = sizeof($data);
    //collection คำตอบใช่ หรือ ไม่
    $url2 = 'https://api.mlab.com/api/1/databases/rup_db/collections/answer?apiKey='.$api_key.'';
    $json2 = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/answer?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data2 = json_decode($json2);
    $isData2 = sizeof($data2);
    
	$count = 0;
	
        if (strpos($message, 'สอนบอท') !== false) {
            $message = "A";
        }
        else if($isData > 0){
            $message = "B";
        }
	else if($isData2 > 0){
            $message = "C";
        }
   	 else if(strpos($message, 'เริ่มทดสอบ') !== false){
	    $message = "D";
	}
        switch ($message) {
            case "A":
			
				if (strpos($message, 'สอนบอท') !== false) {
				 if (strpos($message, 'สอนบอท') !== false) {
					$x_tra = str_replace("สอนบอท","", $message);
					$pieces = explode("|", $x_tra);
					$_user=str_replace("[","",$pieces[0]);
					$_system=str_replace("]","",$pieces[1]);
					 //Post New Data
					$newData = json_encode(
					  array(
					'user' => $_user,
					'system'=> $_system
					  )
					);
				$opts = array(
				   'http' => array(
				   'method' => "POST",
				   'header' => "Content-type: application/json",
				   'content' => $newData
				   )
				   );
					$context = stream_context_create($opts);
					$returnValue = file_get_contents($url,false,$context);
				   
				  }
				}
			
                    $textReplyMessage = "ขอบคุณที่สอนจ้า";
                    $textMessage = new TextMessageBuilder($textReplyMessage);
                    $stickerID = 41;
                    $packageID = 2;
                    $stickerMessage = new StickerMessageBuilder($packageID,$stickerID);
                    
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($textMessage);
                    $multiMessage->add($stickerMessage);
                    $replyData = $multiMessage; 
            break;
					
            case "B":
                if($isData >0){
                    foreach($data as $rec){
                        $textReplyMessage = $rec->system;
                        $textMessage = new TextMessageBuilder($textReplyMessage);   
                           
                        $multiMessage = new MultiMessageBuilder;
                        $multiMessage->add($textMessage);      
                        $replyData = $multiMessage; 
                        
                       }
                }
				else{
	  
					$textReplyMessage = "คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]";
					$textMessage = new TextMessageBuilder($textReplyMessage); 
							
					$multiMessage = new MultiMessageBuilder;
					$multiMessage->add($textMessage);   
					$replyData = $multiMessage; 
				}
						  
		    break;      
			case "C":
			
				if($isData2 >0){	
					foreach($data2 as $rec2){
						$count++;
						$textReplyMessage = $rec2->system;
						$textMessage = new TextMessageBuilder($textReplyMessage);   
						$textReplyMessage2 = $count;
						$textMessage2 = new TextMessageBuilder($textReplyMessage2); 
						$multiMessage = new MultiMessageBuilder;
						$multiMessage->add($textMessage);  
						$multiMessage->add($textMessage2);  
						$replyData = $multiMessage; 
					}
				}
				
				else{
					$actionBuilder = array(
					new MessageTemplateActionBuilder(
						'ใช่',// ข้อความแสดงในปุ่ม
						'ใช่' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
						),
						new MessageTemplateActionBuilder(
						'ไม่',// ข้อความแสดงในปุ่ม
						'ไม่' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
						),                   
						);
					$imageUrl = 'https://www.picz.in.th/images/2018/10/23/kFKkru.jpg';    
					$buttonMessage = new TemplateMessageBuilder('Button Template',
							new ButtonTemplateBuilder(
							'คำที่คุณพิมพ์หมายถึง ใช่ หรือ ไม่', // กำหนดหัวเรื่อง
							'กรุณาเลือก 1 ข้อ', // กำหนดรายละเอียด
							$imageUrl, // กำหนด url รุปภาพ
							$actionBuilder  // กำหนด action object
						)
						);  
								
					$multiMessage = new MultiMessageBuilder;
					$multiMessage->add($buttonMessage);
					$replyData = $multiMessage; 
				}
			
		    break;
			case "D":
				$textReplyMessage = "คุณคิดว่า คุณสามารถทำให้ดีกว่านี้ได้";
                $textMessage = new TextMessageBuilder($textReplyMessage); 
                $multiMessage = new MultiMessageBuilder;
                $multiMessage->add($textMessage);   
                $replyData = $multiMessage; 
		   break;
        default:
                    
            $actionBuilder = array(
                                new MessageTemplateActionBuilder(
                                    'ใช่',// ข้อความแสดงในปุ่ม
                                    'ใช่' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                ),
                                new MessageTemplateActionBuilder(
                                    'ไม่',// ข้อความแสดงในปุ่ม
                                    'ไม่' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                ),                   
                            );
                        
                    $imageUrl = 'https://www.picz.in.th/images/2018/10/23/kFKkru.jpg';    
                    $buttonMessage = new TemplateMessageBuilder('Button Template',
                        new ButtonTemplateBuilder(
                                'คำที่คุณพิมพ์หมายถึง ใช่ หรือ ไม่', // กำหนดหัวเรื่อง
                                'กรุณาเลือก 1 ข้อ', // กำหนดรายละเอียด
                                $imageUrl, // กำหนด url รุปภาพ
                                $actionBuilder  // กำหนด action object
                        )
                    );  
                    
                    $textReplyMessage = "หากสิ่งที่คุณหมายถึงไม่ใช่ทั้ง 'ใช่' และ 'ไม่' คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]";
                    $textMessage = new TextMessageBuilder($textReplyMessage); 
                        
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($buttonMessage);
                    $multiMessage->add($textMessage);   
                    $replyData = $multiMessage; 
            break;                                         
	}
$response = $bot->replyMessage($replyToken,$replyData);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
 /*
    if (strpos($message, 'สอนบอท') !== false) {
         if (strpos($message, 'สอนบอท') !== false) {
            $x_tra = str_replace("สอนบอท","", $message);
            $pieces = explode("|", $x_tra);
            $_user=str_replace("[","",$pieces[0]);
            $_system=str_replace("]","",$pieces[1]);
             //Post New Data
            $newData = json_encode(
              array(
                'user' => $_user,
                'system'=> $_system
              )
            );
        $opts = array(
           'http' => array(
           'method' => "POST",
           'header' => "Content-type: application/json",
           'content' => $newData
       )
    );
    $context = stream_context_create($opts);
    $returnValue = file_get_contents($url,false,$context);
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = 'ขอบคุณที่สอนจ้า';
    $arrayPostData['messages'][1]['type'] = "sticker";
    $arrayPostData['messages'][1]['packageId'] = "2";
    $arrayPostData['messages'][1]['stickerId'] = "41";
    replyMsg($arrayHeader,$arrayPostData);
  
  }
}
 else{
  if($isData >0){
   foreach($data as $rec){
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = $rec->system;
    replyMsg($arrayHeader,$arrayPostData);
    
   }
  }else{
    
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = 'คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]';
    $arrayPostData['messages'][1]['type'] = "text";
    $arrayPostData['messages'][1]['text'] = $id;
    replyMsg($arrayHeader,$arrayPostData);
    
  }
}
    */
function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
   exit;
?>
