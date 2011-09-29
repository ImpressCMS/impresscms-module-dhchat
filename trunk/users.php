<?php
include("../../mainfile.php");
include_once("include/user.php");
include_once("include/functions.php");

$userTpl = new XoopsTpl();
$chatUser = new DHchatUser;
$chatUser->loadUser($_SESSION['dhchatuser']);
if (CheckIfBanned() == TRUE) {
  exit;
}
$room=$_SESSION['dhchatroom'];
$user_online_summe=CountUser();
$user_online_room=CountUser($_SESSION['dhchatroomid']);
$userTpl->assign("user_summe",sprintf(_MA_DHCHAT_USERONLINE_SUMME,$user_online_summe));
$userTpl->assign("user_raum_text",sprintf(_MA_DHCHAT_USERTEXT,$user_online_room));

$guest_icon     = XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_GUESTAVPIC;
$member_icon    = XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_MEMBERAVPIC;
$moderator_icon = XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_MODAVPIC;
$admin_icon     = XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_ADMINAVPIC;

$res=ListUser($room);
$message=array();
$mess=array();
if (!$xoopsDB->getRowsNum($res) == 0) {
  while($r = $xoopsDB->fetchRow($res)) {
     if ($r[1]>0) {
       $member_handler =& xoops_gethandler('member');
       $thisUser =& $member_handler->getUser($r[1]);
       if (is_object($thisUser) ){
         if ($thisUser->isAdmin()) {
           $icon="<img src=\"".$moderator_icon."\" border=\"0\" title=\""._MA_DHCHAT_USER_MODERATOR."\" />";
         } else {
           $icon="<img src=\"".$member_icon."\" border=\"0\" title=\""._MA_DHCHAT_USER_MEMBER."\" />";
         }
       } else {
         $icon="<img src=\"".$guest_icon."\" border=\"0\" title=\""._MA_DHCHAT_USER_GUEST."\" />";
       }
     } else {
       $icon="<img src=\"".$guest_icon."\" border=\"0\" title=\""._MA_DHCHAT_USER_GUEST."\" />";
     }
		 
     $mess['icon'] =$icon; 
		 if ($r[3] == $_SESSION['dhchatuser']) {
		    $mess['name'] = "<b>".$r[3]."</b>"; 
		 } else {
        //$mess['name'] = $r[3];  
				$mess['name'] = "<a href='#go' onclick='xoopsInsertText(top.MainFrame.InputFrame.document.msgform.msgtextbox,\"".$r[3]." \"); top.MainFrame.InputFrame.document.msgform.msgtextbox.focus();'>".$r[3]."</a>";
		 } 
     $message[]=$mess;
     unset($thisUser);              
  }
  $userTpl->assign("user_list",$message);
} else {
   $userTpl->assign("user_list",_MA_DHCHAT_NOUSERLIST);
}
$template = 'db:dhchat_userlist.html';
$userTpl->display($template);
?>