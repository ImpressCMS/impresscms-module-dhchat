<?php
// $Id: menu.php,v 1.2 2005/08/10 coded by dhcst
// ------------------------------------------------------------------------- //
// German Xoops-Support-Site                  		
// < http://www.myxoops.org >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.01
// Author: DHCST Dirk Herrmann
// Website: http://xoops.dhsoft.de
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../../mainfile.php");		
include("admin_header.php");
include("func.php");

xoops_cp_header();

$pagetype = "admin";

$do="";
$mode="";
$datedfrom="";
$datemfrom="";
$dateyfrom="";
$datedto="";
$datemto="";
$dateyto="";
$sort="";
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
      $$k = $v;
    }
}

OpenTable();
echo "<h3 align='center'>"._AM_DHCHAT_ADMENU2."</h3>\n";
if ($do=="") {
	echo "<center>\n";
	echo "[ <a href='messages.php?do=search'>"._AM_DHCHAT_MSGSEARCH."</a> ]\n";
	echo " [ <a href='messages.php?do=deleteall&ok=0'>"._AM_DHCHAT_MSGTRASH."</a> ]\n";
	echo "</center>\n";
} else {
	switch ($do) {
		case 'deleteall':
			reset_messages($ok);
		break;

		case 'search':
			echo "<h3>"._AM_DHCHAT_MSRC."</h3>\n";
			make_searchmessages_form();
			echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&mode=all'>"._AM_DHCHAT_MLISTALL."</a> ]\n";
			echo " [ <a href='messages.php?do="._AM_DHCHAT_MLIST."&mode=today'>"._AM_DHCHAT_MLISTTODAY."</a> ]\n";
		break;

		case _AM_DHCHAT_MLIST:
			echo "<h3>"._AM_DHCHAT_MSRCRES."</h3>\n";
			echo ""._AM_DHCHAT_MLISTDESCR."<br><br>\n";
			searchmessages_list($mode,$datedfrom,$datemfrom,$dateyfrom,$datedto,$datemto,$dateyto,$sort);
		break;

		case 'delete':
			echo "<h3>"._AM_DHCHAT_MERASEMSG."</h3>\n";
			searchmessages_delete($id,$canc);
		break;
	}
}

echo "<br><br><center>[ <a href='index.php'>"._AM_DHCHAT_ADMININIT."</a> ]</center>\n";
CloseTable();

xoops_cp_footer();

?>
