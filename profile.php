<?php


$access_token = '5p2Svod0YdSwlZDN8j9XSInAkuGh6yup9PYZlaXvJy9JmMfxcZuOHDaYM58tUCW7hSlTm9NZ20/v8qFzJjFDG3Y3qxWTlH9UV2R5GKjItiDbVOq8NUxGYRnOKhhnOJ5Xwy7Oq2K12pxLtLtdbs7sTAdB04t89/1O/w1cDnyilFU=
';

$userId = 'Ua2414b8d0f2ba26292c74ffead6a2659';

$url = 'https://api.line.me/v2/bot/profile/'.$userId;

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

