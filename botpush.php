<?php

$strAccessToken = "<mSI0zSW1eitEX5yg198VetksAc+gc3OjZgg6NQFQ0FWO1zZPCozJnWvEYoAPNgbl8Qke6WZkqT5yO8WhEmpwxmvSD0g/XqOX97c9CbiEIHXuEYWle/PDFyepyhQ16btAqmoXn1K2KTX4HgJDiSHavAdB04t89/1O/w1cDnyilFU
=>";  //edited

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);

$strUrl = "https://api.line.me/v2/bot/message/reply";

$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$_msg = $arrJson['events'][0]['message']['text'];


$api_key="e54a7a81744c49dc852707f8613c29a9"; //edited
$url = 'https://api.mlab.com/api/1/databases/pwr/collections/linebot?apiKey='.$api_key.'';
$json = file_get_contents('https://api.mlab.com/api/1/databases/pwr/collections/linebot?apiKey='.$api_key.'&q={"user":"'.$_msg.'"}');
$data = json_decode($json);
$isData=sizeof($data);

if (strpos($_msg, 'สอนบอทจ้า') !== false) {
  if (strpos($_msg, 'สอนบอท') !== false) {
    $x_tra = str_replace("สอนบอท","", $_msg);
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
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = 'ขอบคุณที่สอนจ้า';
  }
}else{
  if($isData >0){
   foreach($data as $rec){
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = $rec->system;
   }
  }else{
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = 'คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]';
  }
}


$channel = curl_init();
curl_setopt($channel, CURLOPT_URL,$strUrl);
curl_setopt($channel, CURLOPT_HEADER, false);
curl_setopt($channel, CURLOPT_POST, true);
curl_setopt($channel, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($channel, CURLOPT_RETURNTRANSFER,true);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($channel);
curl_close ($channel);
?>
