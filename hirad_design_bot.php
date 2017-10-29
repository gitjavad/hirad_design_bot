<?php
ini_set('error_reporting',E_ALL);
$botToken = "477021117:AAElBQxFnLPV1j0C5SsthU6HwOeHdqkjeJ4";
$website = "https://api.telegram.org/bot".$botToken;
$update1 = file_get_contents('php://input');
$update1 = str_replace('\n','%0A',$update1);
$update = json_decode($update1, true);
$chatid = $update['message']['chat']['id'];
$username = $update["message"]["chat"]["username"];
$photo_array = $update['message']['photo'];
$video_file_id = $update['message']['video']['file_id'];
$doc_file_id =  $update['message']['document']['file_id'];
$message = $update['message']['text'];

    sendmessage($message);

function sendmessage($message){
    $url=$GLOBALS['website']."/sendMessage?chat_id=@hirad_design_test&text=".$message."&parse_mode=HTML";
    file_get_contents($url);
}
