<?php
// $Id: chat.php,v 0.03 2005/09/11 coded by dhcst
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

$chatUser = new DHchatUser;
$chatUser->loadUser($_SESSION['dhchatuser']);
if (CheckIfBanned() == TRUE) {
  exit;
}

$room=$_SESSION['dhchatroom'];
hasPermissions($room);

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"de\" lang=\"de\"><head>\n";
echo "<link rel='stylesheet' type='text/css' media='all' href='".XOOPS_URL."/modules/dhchat/chat.css' />\n";
echo "<title>DH-CHATFRAME</title>";
echo "<script type='text/javascript' src='".XOOPS_URL."/include/xoops.js'></script>";
echo "<script type='text/javascript' src='".XOOPS_URL."/modules/dhchat/js/message.js'></script>\n";
echo " </head><body bgcolor=\"".$xoopsModuleConfig['msgframecolor']."\">";
echo "<div id='dhchat_msg'></div>";
echo "</body>\n";
echo "</html>";
?>