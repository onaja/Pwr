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
    $count++;
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
    
 
?>
