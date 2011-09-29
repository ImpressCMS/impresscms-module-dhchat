<?php
// $Id: frame.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../mainfile.php");
include("include/user.php");
include("include/functions.php");

$_SESSION['dhchat_logintime']=time();
$_SESSION['dhchat_lastmsg']=0;
if (!isset($_SESSION['dhchat_logsession'])) $_SESSION['dhchat_logsession']=md5(time().$_SERVER['REMOTE_ADDR']);

DeleteOldMessages();
updateUserlist();

$chatUser = new DHchatUser;
if (isset($_SESSION['dhchatuser'])&& $_SESSION['dhchatuser']!= "") {
  $chatUser->loadUser($_SESSION['dhchatuser']);
} else {
  $chatUser->loadUser();
	$_SESSION['dhchatuser']=$chatUser->nick();
}
$header = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
$header.= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"de\" lang=\"de\"><head>\n";
$header.= "<link rel='stylesheet' type='text/css' media='all' href='".xoops_getcss($xoopsConfig['theme_set'])."' />\n";
$header.= "<title>DH-CHATFRAME</title>";
$header.= "<script type='text/javascript' src='".XOOPS_URL."/include/xoops.js'></script>";
$header.= "<script type='text/javascript' src='".XOOPS_URL."/modules/dhchat/js/dhchat.js'></script>\n";
$header.= "</head>";
$footer="</html>";

if (CheckIfBanned() == TRUE) {
  echo $header;
  echo "<body><div align='center'><br />"._MA_DHCHAT_YOUWASBANNED3."<br /><br /></div></body>";
  echo $footer;
  exit;
}

$dhchat_msg_list="";
$xoopsModuleConfig['orderascdesc'] == 'ASC' ? $dhchat_msg_list.='1' : $dhchat_msg_list.='0';
setcookie ("dhchat_para",$dhchat_msg_list);

$frameTpl= new XoopsTpl();
$template = 'db:dhchat_frameset.html';
$frameTpl->assign("frame_header",$header);

if (!isset($_POST['op']) == "changeroom") {
  if (empty($_SESSION['dhchatroom'])) {
    //Gets the default ChatRoom.
    $theroom = getDefaultRoom();
	  $_SESSION['dhchatroom'] = $theroom[0];
	  $_SESSION['dhchatroomid'] = $theroom[1];
	}
} else {
   $theroom = $_POST['room'];
	 $oldroom = $_SESSION['dhchatroom'];
   $sql = "SELECT rid FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_name = '".$theroom."'";
	 $res = $xoopsDB->queryF($sql);
   $r=$xoopsDB->fetchRow($res);
   if ($r) {
     $sql="UPDATE ".$xoopsDB->prefix("dhchat_whosonline")." SET user_roomid=".$r[0]." WHERE nick='".$chatUser->nick()."'";
		 $res = $xoopsDB->queryF($sql);
		 if ($oldroom!=$theroom)
		   insertMessage($_SESSION['dhchatroom'],sprintf(_MA_DHCHAT_USEREXIT,$chatUser->nick(),$_SESSION['dhchatroom']),_MA_DHCHAT_SYSGO,time(),'SYSGO');
		 $_SESSION['dhchatroom'] = $theroom;
	   $_SESSION['dhchatroomid'] = $r[0];
		 if ($oldroom!=$theroom)
		   insertMessage($_SESSION['dhchatroom'],sprintf(_MA_DHCHAT_USERENTER,$chatUser->nick(),$_SESSION['dhchatroom']),_MA_DHCHAT_SYSGO,time(),'SYSGO');
	} 
}
AddUser();

$frameTpl->assign("frame_footer",$footer);
$frameTpl->assign("frame_message","<frame name=\"MessageFrame\" src=\"chat.php\" frameborder=\"no\"></frame>");
$frameTpl->assign("frame_input","<frame name=\"InputFrame\" src=\"bottom.php\" frameborder=\"no\"></frame>");
$frameTpl->assign("frame_exit","<frame name='ExitFrame' src=\"exit.php\" frameborder=\"no\"></frame>");
$frameTpl->assign("frame_userlist","<frame name='UserFrame' src=\"userlist.php\" frameborder=\"no\"></frame>");
$frameTpl->assign("frame_checker","<frame name='CheckFrame' src=\"check.php\" frameborder=\"no\"></frame>");
$frameTpl->assign("frame_inputheigth",$xoopsModuleConfig['msgframe']);
$frameTpl->assign("frame_exitheigth",$xoopsModuleConfig['userframe']);
$frameTpl->assign("frame_statistik",$xoopsModuleConfig['statistikframe']);
$frameTpl->display($template);
?>