<?php
/*ini_set('error_reporting',E_ALL);
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
$message = $update['message']['from']['user']['first_name'];

sendblk();
function sendblk(){
    $url=$GLOBALS['website']."/InlineKeyboardButton?text=hi&url=hirad-co.com&parse_mode=HTML";
    file_get_contents($url);
}

function sendmessage($message){
    $url=$GLOBALS['website']."/sendMessage?chat_id=@hirad_design_test&text=".$message."&parse_mode=HTML";
    file_get_contents($url);
}*/

ob_start();
define('API_KEY','477021117:AAElBQxFnLPV1j0C5SsthU6HwOeHdqkjeJ4');

function makeHTTPRequest($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}




// Fetching UPDATE
$update = json_decode(file_get_contents('php://input'));

if(isset($update->callback_query)){
    $callbackMessage = 'آپدیت شد';
    var_dump(makeHTTPRequest('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $tried = $update->callback_query->data+1;
    var_dump(
        makeHTTPRequest('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>($tried)." امین تلاش \n زمان : \n".date('d M y -  h:i:s'),
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"رفرش زمان",'callback_data'=>"$tried"]
                    ]
                ]
            ])
        ])
    );

}else{
    var_dump(makeHTTPRequest('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"اولین تلاش \n زمان :\n ".date('d M y -  h:i:s'),
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"رفرش زمان",'callback_data'=>'1']
                ]
            ]
        ])
    ]));
}

file_put_contents('log',ob_get_clean());
