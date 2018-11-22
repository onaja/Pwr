<?php
$access_token = 'yZSOO/AABMcg6JAgHNezv8Pv8DdK9YIqC4As9AWGOZp/SVaxTtBMcp7Ck+fn6BAI8Qke6WZkqT5yO8WhEmpwxmvSD0g/XqOX97c9CbiEIHUOV7lWue8cqg+wdeDGdT84iQ5Rbg8AAGXEj3BP2NdwIQdB04t89/1O/w1cDnyilFU=
';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
