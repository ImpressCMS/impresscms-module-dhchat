<?php
// $Id: admin/index.php,v 1.2 2003/09/03 coded by frankblack
// ------------------------------------------------------------------------- //
// German Xoops-Support-Site                  		
// < http://www.myxoops.de >
// ------------------------------------------------------------------------- //
// Original Author : Pietro Lascari - http://www.cmq.it
// Modified for Xoops 2 : Marko "Predator" Schmuck and frankblack
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../../mainfile.php");		
include("admin_header.php");

xoops_cp_header();

$pagetype = "admin";

OpenTable();
	echo "<h3 align='center'>"._AM_DHCHAT_CHAT."</h1>\n";
	echo ""._AM_DHCHAT_CHAT_ADMINPAGE."";
	echo "<br /><br />\n";

  echo "<table border='0' cellpadding='0' cellspacing='5' align='left'>\n";
	echo "<tr><td align='left' valign='top'>\n";
	echo "<a href='".XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule->getVar('mid')."'>"._AM_DHCHATCONFIG."</a></td>\n";
	echo "<td align='left' valign='top'>"._AM_DHCHAT_ADMENU0."</td></tr>\n";
  
	echo "<tr><td align='left' valign='top'>\n";
	echo "<a href='rooms.php'>"._AM_DHCHAT_AD1."</a></td>\n";
	echo "<td align='left' valign='top'>"._AM_DHCHAT_ADMENU1."</td></tr>\n";
  echo "<tr><td align='left' valign='top'>\n";
	echo "<a href='messages.php'>"._AM_DHCHAT_AD2."</a></td>\n";
	echo "<td align='left' valign='top'>"._AM_DHCHAT_ADMENU2."</td></tr>\n";
	echo "</table>\n";

CloseTable();

xoops_cp_footer();
?>