<?php
// $Id: exit.php,v 0.03 2005/09/11 coded by dhcst
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

$frameTpl= new XoopsTpl();
$template = 'db:dhchat_frameexit.html';
// Button zum Verlassen definieren
$exitbutton="<img src=\"".XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_EXITPIC."\" border=\"0\" title=\""._MA_DHCHAT_LEAVECHAT."\" />";
$header= "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
$header.= "<html><head>\n";
$header.= "<link rel='stylesheet' type='text/css' media='all' href='".XOOPS_URL."/modules/dhchat/chat.css' />\n";
$header.= "<title>DH-EXITFRAME</title>";
$header.= "<script type='text/javascript' src='".XOOPS_URL."/modules/dhchat/js/dhchat.js'></script>\n";
$header.= "<script type='text/javascript' src='".XOOPS_URL."/include/xoops.js'></script>\n";
$header.= " </head><body bgcolor=\"".$xoopsModuleConfig['exitframecolor']."\">";
$footer= "</body>\n";
$footer.= "</html>";
$frameTpl->assign("frame_header",$header);
$frameTpl->assign("frame_footer",$footer);
//$xoopsTpl->assign("frame_aktuser",$chatUser->nick());
$frameTpl->assign("frame_chatexit","<a href='endsession.php' target='_top'>".$exitbutton."</a>");
$frameTpl->assign("frame_roomlist",listChatRooms($_SESSION['dhchatroom']));
$frameTpl->display($template);
?>