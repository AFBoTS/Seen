<?php
ob_start();
include 'Class.php';

$button_tiid = json_encode(['keyboard'=>[
[['text'=>'تایید شماره','request_contact'=>true]],
[['text'=>'چرا باید شمارمو تایید کنم']],
],'resize_keyboard'=>true]);
$button_manage = json_encode(['keyboard'=>[
[['text'=>'↩️منوی اصلی']],
[['text'=>'پیام همگانی'],['text'=>'فوروارد همگانی']],
[['text'=>'آمار'],['text'=>'تعیین کد رایگان']],
[['text'=>'سکه به کاربر']],
],'resize_keyboard'=>true]);
$button_official = json_encode(['keyboard'=>[
[['text'=>'جمع آوری سکه رایگان 💰']],
[['text'=>'فروشگاه سکه 💸'],['text'=>'انتقال سکه ♐'],['text'=>'ثبت تبلیغات 📝']],
[['text'=>'زیرمجموعه گیری 📮'],['text'=>'حساب کاربری من 💡']],
[['text'=>'ارسال نظر ✉'],['text'=>'راهنما 📋']],
[['text'=>'کد رایگان 🔧']],
],'resize_keyboard'=>true]);
$button_back = json_encode(['keyboard'=>[
[['text'=>'↩️منوی اصلی']],
],'resize_keyboard'=>true]);
$button_nz = json_encode(['inline_keyboard'=>[
[['text'=>'نظر بعدی','callback_data'=>'nzr']],
],'resize_keyboard'=>true]);
$button_nza = json_encode(['inline_keyboard'=>[
[['text'=>'تایید نظر','callback_data'=>'taiid nzr'],['text'=>'رد نظر','callback_data'=>'rad nzr']],
],'resize_keyboard'=>true]);

$update = json_decode(file_get_contents('php://input'));
$data = $update->callback_query->data;
$chatid = $update->callback_query->message->chat->id;
$fromid = $update->callback_query->message->from->id;
$messageid = $update->callback_query->message->message_id;
$data_id = $update->callback_query->id;
$txt = $update->callback_query->message->text;
$chat_id = $update->message->chat->id;
$from_id = $update->message->from->id;
$from_username = $update->message->from->username;
$from_first = $update->message->from->first_name;
$forward_id = $update->message->forward_from->id;
$forward_chat = $update->message->forward_from_chat;
$forward_chat_username = $update->message->forward_from_chat->username;
$forward_chat_msg_id = $update->message->forward_from_message_id;
$text = $update->message->text;
$message_id = $update->message->message_id;
$stickerid = $update->message->sticker->file_id;
$videoid = $update->message->video->file_id;
$voiceid = $update->message->voice->file_id;
$fileid = $update->message->document->file_id;
$photo = $update->message->photo;
$photoid = $photo[count($photo)-1]->file_id;
$musicid = $update->message->audio->file_id;
$caption = $update->message->caption;
$cde = time();
$code = md5("$cde$from_id");
$command = file_get_contents('user/'.$from_id."/command.txt");
$gold = file_get_contents('user/'.$from_id."/gold.txt");
$coin = file_get_contents('user/'.$from_id."/coin.txt");
$wait = file_get_contents('user/'.$from_id."/wait.txt");
$coin_wait = file_get_contents('user/'.$wait."/coin.txt");
$number = file_get_contents('user/'.$from_id."/number.txt");
$code_taiid = file_get_contents('user/'.$from_id."/code taiid.txt");
$Member = file_get_contents('admin/Member.txt');
$NZR = file_get_contents('admin/NZR.txt');
$Tedad_Nazar = file_get_contents('admin/Tedad Nazar.txt');
$ads = file_get_contents('ads/Ads.txt');

// start source
    if (strpos($block , "$from_id") !== false) {
	return false;
	}
	elseif ($from_id != $chat_id and $chat_id != $feed) {
	LeaveChat($chat_id);
	}
	//===============
  elseif($data == 'taiid nzr'){
  AnswerCallbackQuery($data_id,'نظر تایید شد');
  EditMessageText($chatid,$messageid,"نظر تایید شد",'html','true');
  file_put_contents("admin/NZR.txt","$NZR\n(**##**)\n$txt");
  }
  elseif($data == 'rad nzr'){
  AnswerCallbackQuery($data_id,'نظر رد شد');
  EditMessageText($chatid,$messageid,"نظر رد شد",'html','true');
  }
  //===============
  elseif($data == 'nzr'){
  $exp = explode("(**##**)",$NZR);
  $rand = $exp[rand(0,count($exp)-1)];
  $txtt = file_get_contents('admin/Tedad Nazar.txt');
  $member_id = explode("\n",$txtt);
  $mmemcount = count($member_id) -1;
  if($rand == null || $rand == '' || $rand == "\n"){
  EditMessageText($chatid,$messageid,"نظر موجود نیس",'html','true');
  }else{
  AnswerCallbackQuery($data_id,'نظر بعدی');
  EditMessageText($chatid,$messageid,"نظرات: $mmemcount
  
  $rand",'html','true',$button_nz);
  }
  }
  //===============
	elseif(preg_match('/^\/([Ss]tart)(.*)/',$text)){
	preg_match('/^\/([Ss]tart)(.*)/',$text,$match);
	$match[2] = str_replace(" ","",$match[2]);
	$match[2] = str_replace("\n","",$match[2]);
	if($match[2] != null){
	if (strpos($Member , "$from_id") == false){
	if($match[2] != $from_id){
	if (strpos($gold , "$from_id") == false){
	$txxt = file_get_contents('user/'.$match[2]."/gold.txt");
    $pmembersid= explode("\n",$txxt);
    if (!in_array($from_id,$pmembersid)){
      $aaddd = file_get_contents('user/'.$match[2]."/gold.txt");
      $aaddd .= $from_id."\n";
		file_put_contents('user/'.$match[2]."/gold.txt",$aaddd);
    }
	$mtch = file_get_contents('user/'.$match[2]."/coin.txt");
	file_put_contents("user/".$match[2]."/coin.txt",($mtch+1) );
	SendMessage($match[2],"🆕 یک نفر با لینک اختصاصی شما وارد ربات شد","html","true",$button_official);
	}
	}
	}
	}
	SendMessage($chat_id,"سلام خوش اومدی","html","true",$button_official);
	}
	//================
	elseif($update->message->contact and $number == null){
	$rand = rand(11111,55555);
	$ce = $rand;
	file_put_contents('user/'.$from_id."/code taiid.txt",$ce);
	file_put_contents('user/'.$from_id."/command.txt","taiid nashode");
	file_put_contents('user/'.$from_id."/number.txt",$update->message->contact->phone_number);
	SendMessage($chat_id,"خوب حالا کد $ce رو وارد کنید تا ربات فعال شود","html","true",$button_tiid);
	}
	//================
	elseif($command == "taiid nashode"){
	if($text == $code_taiid){
	file_put_contents('user/'.$from_id."/command.txt","none");
	SendMessage($chat_id,"تایید شدید","html","true",$button_official);
	}else{
	SendMessage($chat_id,"کد اشتباه","html","true");
	}
	}
	//===============
  elseif($text == 'چرا باید شمارمو تایید کنم'){
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"دوست عزیز شما برای استفاده از ربات باید شماره خود را ثبت و تایید کنید.","html","true");
  }
	//================
	elseif($number == null){
	SendMessage($chat_id,"حتما باید شمارتونو تایید کنید 💉","html","true",$button_tiid);
	}
	//===============
  elseif($text == '↩️منوی اصلی'){
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"↩️ شما به منوی اصلی برگشتید.","html","true",$button_official);
  }
	//===============
  elseif(preg_match('/^\/([Cc]reator)/',$text)){
  SendMessage($chat_id,"ساخته شده توسط هکتور تیم\n@hektor_tm","html","true",$button_official);
  }
	//===============
  elseif($text == 'فروشگاه سکه 💸'){
  SendMessage($chat_id,"برای خرید سکه میتوانید به صورت زیر عمل کنید.
100coin => 1000t \n 200coin=> 1500t \n 500coin => 3000t\nبرای خرید به ربات پشتیبانی مراجعه کنید:\n@amirpayambot","html","true",$button_official);
  }
  //===============
  elseif($text == 'زیرمجموعه گیری 📮'){
  $member_id = explode("\n",$gold);
  $mmemcount = count($member_id) -1;
  SendMessage($chat_id,"http://telegram.me/$UserNameBot?start=$from_id
  
  تعداد زیرمجموعه های شما: $mmemcount","html","true",$button_official);
  }
  //===============
  elseif($text == 'راهنما 📋'){
  SendMessage($chat_id,"کار با این ربات ساده است. سکه بگیرید و به صورت هوشمند ویو بگیرید و تبلیغ کنید. با استفاده از گزینه جمع آوری سکه رایگان ، تبلیغ ببینید و سکه رایگان دریافت کنید ویا با گزینه زیر مجموعه گیری با لینک اختصاصی کاربران را به ربات دعوت کنید و سکه بگیرید. پس از دریافت حداقل سکه میتونید تبلیغات خود را ثبت کنید","html","true",$button_official);
  }
  //===============
  elseif($text == 'حساب کاربری من 💡'){
  SendMessage($chat_id,"موجودی شما: $coin
  شماره کاربری شما: $from_id","html","true",$button_official);
  }
  //===============
  elseif($text == 'نظرات کاربران 🏆'){
  $exp = explode("(**##**)",$NZR);
  $rand = $exp[rand(0,count($exp)-1)];
  if($rand == null || $rand == '' || $rand == "\n"){
  SendMessage($chat_id,"نظری موجود نیست.","html","true");
  }else{
  $txtt = file_get_contents('admin/Tedad Nazar.txt');
  $member_id = explode("\n",$txtt);
  $mmemcount = count($member_id) -1;
  SendMessage($chat_id,"نظرات کاربران:
  
  $rand","html","true",$button_nz);
  }
  }
  //===============
  elseif($text == 'انتقال سکه ♐'){
  file_put_contents('user/'.$from_id."/command.txt","send coin");
  SendMessage($chat_id,"شماره کاربری مقصد رو وارد کنید:","html","true",$button_back);
  }
  elseif($command == 'send coin'){
  $explode = explode("\n",$Member);
  if($text != $from_id && in_array($text,$explode)){
  file_put_contents('user/'.$from_id."/command.txt","send coin2");
  file_put_contents('user/'.$from_id."/wait.txt",$text);
  SendMessage($chat_id,"مقدار سکه شما: $coin
  چه تعداد سکه میخوای انتقال بدی","html","true",$button_back);
  }else{
  SendMessage($chat_id,"شناسه کاربری نا معتبره یا شناسه کاربری خودتون رو وارد کردین","html","true",$button_back);
  }
  }
  elseif($command == 'send coin2'){
  if(preg_match('/^([0-9])/',$text)){
  if($text > $coin){
  SendMessage($chat_id,"مقدار سکه شما $coin میباشد
شما بیشتر از ان نمیتوانید بردارید.","html","true",$button_back);
  }else{
  file_put_contents("user/$wait/coin.txt",($coin_wait+$text) );
  file_put_contents("user/$from_id/coin.txt",($coin-$text) );
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"انتقال داده شد","html","true",$button_official);
  }
  }else{
  SendMessage($chat_id,"فقط باید عدد وارد کنید","html","true",$button_back);
  SendMessage($wait,"تعداد $text سکه از:\n$from_first\n$from_username\nبه شما تعلق گرفت","html","true",$button_official);
  }
  }
  //===============
  elseif($text == 'ارسال نظر ✉'){
  file_put_contents('user/'.$from_id."/command.txt","contact");
  SendMessage($chat_id,"نظرتون رو وارد کنید","html","true",$button_back);
  }
  elseif($command == 'contact'){
  if($text){
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"ثبت شد","html","true",$button_official);
  if($from_username == null){
  $from_username = '---';
  }else{
  $from_username = "@$from_username";
  }
  SendMessage($admin,"$from_id
  $from_first
  $from_username
  
  $text","html","true",$button_nza);
  file_put_contents("admin/Tedad Nazar.txt","$Tedad_Nazar\n$from_id");
  }else{
  SendMessage($chat_id,"دوست عزیز فقط متن ارسال کنید.","html","true",$button_back);
  }
  }
  //===============
  elseif($text == 'ثبت تبلیغات 📝'){
  if($coin < 20){
  SendMessage($chat_id,"حداقل سکه باید 20 باشد","html","true");
  }else{
  file_put_contents('user/'.$from_id."/command.txt","set ads");
  if( ($coin%2) == 0){
  $coin = $coin;
  }else{
  $coin = $coin-1;
  }
  $cn = $coin / 2;
  SendMessage($chat_id,"شما میتونید $cn بازدید برای پست بزنید","html","true",$button_back);
  }
  }
  elseif($command == 'set ads'){
  if(preg_match('/^([0-9])/',$text)){
  if($coin%2 == 0){
  $coin = $coin;
  }else{
  $coin = $coin-1;
  }
  $cn = $coin / 2;
  if ($cn < $text){
  SendMessage($chat_id,"شما میتونید $cn بازدید برای پست بزنید
چند بازدید میخواهید؟","html","true",$button_back);
  }else{
  file_put_contents('user/'.$from_id."/wait.txt",$text);
  file_put_contents('user/'.$from_id."/command.txt","set ads2");
  SendMessage($chat_id,"پیغام مورد نظر را فوروارد کنید.","html","true",$button_back);
  }
  }else{
  SendMessage($chat_id,"فقط باید عدد وارد کنید","html","true",$button_back);
  }
  }
  elseif($command == 'set ads2'){
  $cd = $code;
  if($forward_chat_username != null){
  file_put_contents('user/'.$from_id."/command.txt","none");
  file_put_contents("ads/ads msg id/$cd.txt",$forward_chat_msg_id);
  file_put_contents("ads/ads tedad/$cd.txt",$wait);
  file_put_contents("ads/ads username/$cd.txt","@$forward_chat_username");
  file_put_contents("ads/ads tally/$cd.txt",'');
  file_put_contents("ads/Ads.txt","$cd\n$ads");
  file_put_contents("ads/ads admin/$cd.txt",$from_id);
  file_put_contents("user/$from_id/coin.txt",($coin - ($wait*2)) );
  SendMessage($chat_id,"ثبت شد
  
  کد سفارش: $cd","html","true",$button_official);
  }else{
  SendMessage($chat_id,"فقط باید از کانال عمومی فوروارد کنید.","html","true");
  }
  }
  //===============
  elseif($text == 'جمع آوری سکه رایگان 💰'){
  $exp = explode("\n",$adnn);
  $rnd = $exp[rand(0,count($exp)-1)];
  $rand = $rnd;
  $adnn = file_get_contents("ads/ads admin/$rand.txt");
  if($rand == null || $rand == '' || $rand == "\n" || $from_id == $adnn){
  SendMessage($chat_id,"تبلیغی برای نمایش وجود ندارد یا دوباره کلیک کنید.","html","true");
  }
else{
  $msg_id = file_get_contents("ads/ads msg id/$rand.txt");
  $msg_user = file_get_contents("ads/ads username/$rand.txt");
  ForwardMessage($chat_id,$msg_user,$msg_id);
  
   $usr = file_get_contents("ads/ads tally/$rand.txt");
    $pmembersid = explode("\n",$usr);
    if (!in_array($from_id,$pmembersid)){
		$aaddd = file_get_contents("ads/ads tally/$rand.txt");
        $aaddd .= $from_id."\n";
		file_put_contents("ads/ads tally/$rand.txt",$aaddd);
    }
	
    $member_id = explode("\n",$usr);
    $mmemcount = count($member_id);
	$tdd = file_get_contents("ads/ads tedad/$rand.txt");
	
	if($mmemcount >= $tdd){
	SendMessage($ads,"سفارش تبلیغ با کد پیگیری $rand تموم شد.","html","true");
	$str = str_replace("\n$rand",'',$adnn);
	$str = str_replace("$rand",'',$ads);
	file_put_contents("ads/Ads.txt",$str);
	unlink("ads/ads msg id/$rand.txt");
    unlink("ads/ads tedad/$rand.txt");
    unlink("ads/ads username/$rand.txt");
    unlink("ads/ads tally/$rand.txt");
    unlink("ads/ads admin/$rand.txt");
	}
	}
  }
  //===============
  elseif($text == 'کد رایگان 🔧'){
  file_put_contents('user/'.$from_id."/command.txt","free code");
  SendMessage($chat_id,"کد مورد نظر رو وارد کنید","html","true",$button_back);
  }
  elseif($command == 'free code'){
  if(file_exists("admin/code/$text.txt")){
  $cde = file_get_contents("admin/code/$text.txt");
  $exp = explode("\n",$cde);
  if(in_array($from_id,$exp)){
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($chat_id,"شما قبلا استفاده کردین","html","true",$button_official);
  }else{
  file_put_contents('user/'.$from_id."/command.txt","none");
  file_put_contents('user/'.$from_id."/coin.txt",($coin+10));
  file_put_contents("admin/code/$text.txt","$cde\n$from_id");
  SendMessage($chat_id,"تعداد 10 سکه رایگان به حساب شما افزوده شد.","html","true",$button_official);
  SendMessage($admin,"کد رایگان زده شد✅\nتوسط:\n$from_first\n@$from_username\n$from_id","html","true",$button_official);
  }
  }else{
  SendMessage($chat_id,"کد وجود نداشت","html","true",$button_back);
  }
  }
  //===============
  elseif($text == '/manage' and $from_id == $admin){
  SendMessage($chat_id,"به پنل مدیریت خوش اومدی","html","true",$button_manage);
  }
  elseif($text == 'آمار' and $from_id == $admin){
	$txtt = file_get_contents('admin/Member.txt');
    $member_id = explode("\n",$txtt);
    $mmemcount = count($member_id) -1;
	SendMessage($chat_id,"کل کاربران: $mmemcount نفر","html","true");
	}
  elseif($text == 'فوروارد همگانی' and $from_id == $admin){
	file_put_contents("user/".$from_id."/command.txt","s2a fwd");
	SendMessage($chat_id,"پیام مورد نظر را فوروارد کنید","html","true",$button_back);
	}
	elseif($command == 's2a fwd' and $from_id == $admin){
	file_put_contents("user/".$from_id."/command.txt","none");
	SendMessage($chat_id,"پیام شما در صف ارسال قرار گرفت.","html","true",$button_manage);
	$all_member = fopen( "admin/Member.txt", 'r');
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			ForwardMessage($user,$admin,$message_id);
		}
	}
	elseif($text == 'پیام همگانی' and $from_id == $admin){
	file_put_contents("user/".$from_id."/command.txt","s2a");
	SendMessage($chat_id,"پیامتون رو وارد کنید","html","true",$button_back);
	}
	elseif($command == 's2a' and $from_id == $admin){
	file_put_contents("user/".$from_id."/command.txt","none");
	SendMessage($chat_id,"پیام شما در صف ارسال قرار گرفت.","html","true",$button_manage);
	$all_member = fopen( "admin/Member.txt", 'r');
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			if($sticker_id != null){
			SendSticker($user,$stickerid);
			}
			elseif($videoid != null){
			SendVideo($user,$videoid,$caption);
			}
			elseif($voiceid != null){
			SendVoice($user,$voiceid,'',$caption);
			}
			elseif($fileid != null){
			SendDocument($user,$fileid,'',$caption);
			}
			elseif($musicid != null){
			SendAudio($user,$musicid,'',$caption);
			}
			elseif($photoid != null){
			SendPhoto($user,$photoid,'',$caption);
			}
			elseif($text != null){
			SendMessage($user,$text,"html","true");
			}
		}
	}
  elseif($text == 'تعیین کد رایگان' and $from_id == $admin){
  file_put_contents('user/'.$from_id."/command.txt","code free2");
  SendMessage($chat_id,"کد مورد نظر رو وارد کنید","html","true",$button_back);
  }
  elseif($command == 'code free2' and $from_id == $admin){
  file_put_contents("admin/code/$text.txt","");
  file_put_contents("user/".$from_id."/command.txt","none");
  SendMessage($chat_id,"کد ثبت شد.","html","true",$button_manage);
  }
  elseif($text == 'سکه به کاربر' and $from_id == $admin){
  file_put_contents('user/'.$from_id."/command.txt","send coin");
  SendMessage($admin,"شماره کاربری مقصد رو وارد کنید:","html","true",$button_back);
  }
  elseif($command == 'send coin'){
  $explode = explode("\n",$Member);
  if($text != $from_id && in_array($text,$explode)){
  file_put_contents('user/'.$from_id."/command.txt","send coin2");
  file_put_contents('user/'.$from_id."/wait.txt",$text);
  SendMessage($admin,"مقدار سکه را وارد کنید.","html","true",$button_back);
  }else{
  SendMessage($admin,"شناسه کاربری نامعتبر!","html","true",$button_back);
  }
  }
  elseif($command == 'send coin2'){
  if(preg_match('/^([0-9])/',$text)){
  if($text > $coin){
  SendMessage($admin,"خطای منبع!","html","true",$button_back);
  }else{
  file_put_contents("user/$wait/coin.txt",($coin_wait+$text) );
  file_put_contents("user/$from_id/coin.txt",($coin-$text) );
  file_put_contents('user/'.$from_id."/command.txt","none");
  SendMessage($admin,"سکه ها به کاربر تعلق گرفتند.","html","true",$button_manage);
  SendMessage($wait,"تعداد $text سکه از ادمین به شما تعلق گرفت","html","true",$button_official);
  }
  }else{
  SendMessage($admin,"فقط عدد","html","true",$button_back);
  }
  }
  // End Source
  if(!file_exists('user/'.$from_id)){
  mkdir('user/'.$from_id);
  }
  if(!file_exists('user/'.$from_id."/coin.txt")){
  file_put_contents('user/'.$from_id."/coin.txt","1");
  }
  $txxt = file_get_contents('admin/Member.txt');
    $pmembersid= explode("\n",$txxt);
    if (!in_array($chat_id,$pmembersid)){
      $aaddd = file_get_contents('admin/Member.txt');
      $aaddd .= $chat_id."\n";
		file_put_contents('admin/Member.txt',$aaddd);
    }unlink('error_log');
	?>