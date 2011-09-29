<?php
  include("../../mainfile.php");
  include("include/user.php");
  include("include/functions.php");
			
	$chatUser = new DHchatUser;
  $chatUser->loadUser($_SESSION['dhchatuser']);
  if (CheckIfBanned() == TRUE) {
    exit;
  } 
  $room=$_SESSION['dhchatroom'];
  hasPermissions($room);
	$_SESSION['dhchat_chattime']=time();
  if (!isset($_SESSION['dhchat_last_userupdate'])) $_SESSION['dhchat_last_userupdate']=time();
  if ($_SESSION['dhchat_last_userupdate'] < time()- 30) {  //aller 30 Sekunden updaten
    updateUserlist(true);  
    $_SESSION['dhchat_last_userupdate']=time();
  }
	if (!isset($_SESSION['dhchat_lastmsg'])) $_SESSION['dhchat_lastmsg']=0;
	$lastMsg=LastMessage();
	if ($lastMsg != $_SESSION['dhchat_lastmsg'] || $lastMsg=0) {
	  $_SESSION['dhchat_lastmsg']=$lastMsg;
    $template = 'db:dhchat_chat.html';
    $chatTpl = new XoopsTpl();
    $res = getMessages($room);
    $countmessages = 1;
    $message=array();
    $mess=array();
		if ($xoopsDB->getRowsNum($res) > 0) {
      $countmessages = 0;
		  $myts =& MyTextSanitizer::getInstance();
      while($r = $xoopsDB->fetchRow($res)) {
       $mess['date'] = date("H:i:s",$r[5]);
       $mess['msg'] = $myts->displayTarea($r[2]);
			 if ($r[6]=='SYSTEM' || $r[6]=='SYSGO' || $r[3]==$_SESSION['dhchatuser']) {
			   $mess['user'] = $r[3];
			 } else {
         $mess['user'] = "<a href='#go' onclick='xoopsInsertText(top.MainFrame.InputFrame.document.msgform.msgtextbox,\"/to ".$r[3]." \"); top.MainFrame.InputFrame.document.msgform.msgtextbox.focus();'>".$r[3]."</a>";
		   }
       $message[]=$mess;      
       $countmessages++;
     }
		 $mess['date'] = ""; //date("H:i:s",time());
     $mess['msg'] = ""; //$lastMsg;
     $mess['user'] = ""; //$_SESSION['dhchat_last_dbid'];
     $message[]=$mess; 
     $chatTpl->assign("chat_cmsg",$countmessages);
   } else {
     $chatTpl->assign("chat_count",_MA_DHCHAT_NOMESSAGES."(".$room.")");
   }

   if($countmessages == 0) {
     $chatTpl->assign("chat_count",_MA_DHCHAT_NOMSGSTODAY);
   } 

   $chatTpl->assign("chat_msg",$message);
   $chatTpl->display($template);
}
?>