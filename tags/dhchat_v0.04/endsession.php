<?php
// $Id: endsession.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../mainfile.php");
include("include/functions.php");
RemoveUser($_SESSION['dhchatuser']);
unset($_SESSION['dhchatuser']);
unset($_SESSION['dhchatroom']);
unset($_SESSION['dhchatroomid']);
unset($_SESSION['dhchat_logintime']);
unset($_SESSION['dhchat_logsession']);
unset($_SESSION['dhchat_chattime']);
unset($_SESSION['dhchat_lastmsg']);
redirect_header("../../index.php", 5, _MA_DHCHAT_YOUAREDISCONNECTED);
?>