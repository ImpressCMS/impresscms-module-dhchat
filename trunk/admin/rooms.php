<?php
// $Id: menu.php,v 1.2 2005/08/10 coded by dhcst
// ------------------------------------------------------------------------- //
// German Xoops-Support-Site                  		
// < http://www.myxoops.org >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.01
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../../mainfile.php");		
include("admin_header.php");
include("func.php");
xoops_cp_header();

$pagetype = "admin";
$do="";
if (isset($_POST['do'])) $do=$_POST['do'];

OpenTable();
if ($do == "" ) {
	echo "<h3 align='center'>"._MI_DHCHAT_ADMENU1."</h3>\n";
  echo "<b>"._AM_DHCHAT_CHAT_ROOM."</b>\n";
	echo "<form name='roomedit' method='post' action='rooms.php'>\n";				
	echo "<table class='even'>\n";
	echo "<tr><td class='even'  width='5%' nowrap>&nbsp;</td><td class='even' width='50%' nowrap><b>"._AM_DHCHAT_ROOM_NAME."</b></td><td class='even' width='40%' nowrap><b>"._AM_DHCHAT_ROOM_TYPE."</b></td><td class='even' width='5%' align='right' nowrap><b>"._AM_DHCHAT_ROOM_USER."</b></td></tr>\n";
	make_rooms_form();
	echo "</table>\n";
	echo "</form>";
	echo "<br />\n";
	echo "<h4>"._AM_DHCHAT_ADDROOM."</h4>\n";
	make_newroom_form();

} else {
  	switch($do) {
		case 'room_edit':
                                          if ( $_POST['room_id'] > 0 ) {
				echo "<h3 align='center'>"._AM_DHCHAT_EDITROOM."</h3>\n";
				make_editroom_form($_POST['room_id'] );
			}
                                          echo "<br /><div align='center'>[ <a href='index.php'>"._AM_DHCHAT_RINIT."</a> ]</div>\n";
		break;

		case 'room_delete':
			if ($_POST['cancel']==0) {
				delete_room($_POST['room_id'],0);
			} else {
				delete_room($_POST['room_id'],1);
			}
		break;

		case 'room_save':
			save_room($_POST['room_id'],$_POST['room_name'],$_POST['room_type'],$_POST['room_group']);
			echo "<br /><br />\n";
			echo "<div align='center'>[ <a href='rooms.php'>"._AM_DHCHAT_RINIT."</a> ]</div>\n";
		break;

		case 'room_create':
		  $rgroup="";
			if (isset($_POST['room_group'])) $rgroup=$_POST['room_group'];
			create_room($_POST['room_name'],$_POST['room_type'],$rgroup);
			echo "<br /><br />\n";
			echo "<div align='center'>[ <a href='rooms.php'>"._AM_DHCHAT_RINIT."</a> ]</div>\n";
		break;
	}
}

echo "<br /><div align='center'>[ <a href='index.php'>"._AM_DHCHAT_ADMININIT."</a> ]</div>\n";
CloseTable();

xoops_cp_footer();
?>