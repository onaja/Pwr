<?php
    $accessToken = "mSI0zSW1eitEX5yg198VetksAc+gc3OjZgg6NQFQ0FWO1zZPCozJnWvEYoAPNgbl8Qke6WZkqT5yO8WhEmpwxmvSD0g/XqOX97c9CbiEIHXuEYWle/PDFyepyhQ16btAqmoXn1K2KTX4HgJDiSHavAdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
    //รับ id ของผู้ใช้
    $id = $arrayJson['events'][0]['source']['userId'];    
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    $api_key="e0C-QltQdKgdRg4eABS7RTrZ-fiRtPSe";
    $url = 'https://api.mlab.com/api/1/databases/pwr/collections/linebot?apiKey='.$api_key.'';
    $json = file_get_contents('https://api.mlab.com/api/1/databases/pwr/collections/linebot?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data = json_decode($json);
    $isData=sizeof($data);
    $count = 0;
 
 
    if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    //รับข้อความจากผู้ใช้
    $message = $events['events'][0]['message']['text'];
    $message = strtolower($message);
    //รับ id ของผู้ใช้
    $id = $events['events'][0]['source']['userId'];   
    //เชื่อมต่อ mlab
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    $api_key="7vVKdrk-Rg7qp8C5KFUrkQRWmAJaazgQ";
    $url = 'https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'';
    $json = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data = json_decode($json);
    $isData = sizeof($data);
             
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
            $message = "A";

          }
        }
        else{
            $message = "B";
        }
    switch ($typeMessage){
        case 'text':
            switch ($message) {
                case "A":
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
                    
                    $textReplyMessage = "หากคำที่คุณหมายถึงไม่ใช่ทั้ง 'ใช่' และ 'ไม่' คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]";
                    $textMessage = new TextMessageBuilder($textReplyMessage); 
                        
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($buttonMessage);
                    $multiMessage->add($textMessage);   
                    $replyData = $multiMessage; 
                    }
                      
                       
                     
                    break;      
                    
                default:
                    
                    $textReplyMessage = "ว่ายังไงนะครับ";
                    $textMessage = new TextMessageBuilder($textReplyMessage);
                    
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($textMessage);
                    $replyData = $multiMessage;   
                    break;                                      
            }
            break;
        default:
            $textReplyMessage = json_encode($events);
            $replyData = new TextMessageBuilder($textReplyMessage);         
            break;  
    }
}
$response = $bot->replyMessage($replyToken,$replyData);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
 
/*#ตัวอย่าง Message Type "Text"
    else if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Image"
    else if($message == "รูปน้องแมว"){
        $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "พิกัดสยามพารากอน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
        $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
        $arrayPostData['messages'][0]['latitude'] = "13.7465354";
        $arrayPostData['messages'][0]['longitude'] = "100.532752";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "131";
        replyMsg($arrayHeader,$arrayPostData);
    }*/
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
