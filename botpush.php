<?php

$strAccessToken = "<hkWua6h6czYci6zSMVO3SRx83AXNfDWW62OXB2r+79IyUnzbx90BLaPNQiU36xxWsR8dUmpXZGS1JbFcrzohvF+bmLDhhgJB2YSpLRzg9+hwYL6WZ1JsgAE+A92OzljuG5uiRnA6V+4DdD/KeYNN6AdB04t89/1O/w1cDnyilFU=
=>";  //edited

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);

$strUrl = "https://api.line.me/v2/bot/message/reply";

$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$_msg = $arrJson['events'][0]['message']['text'];


$api_key="e0C-QltQdKgdRg4eABS7RTrZ-fiRtPSe"; //edited
$url = 'https://api.mlab.com/api/1/databases/rup_db/collections/yes?apiKey='.$api_key.'';
$json = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/yes?apiKey='.$api_key.'&q={"user":"'.$_msg.'"}');
$data = json_decode($json);
$isData=sizeof($data);

if (strpos($_msg, 'สอนบอท') !== false) {
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
