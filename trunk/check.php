<?php
// $Id: check.php,v 0.03 2005/09/11 coded by dhcst
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
	
	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
  echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"de\" lang=\"de\"><head>\n";
  echo "<meta http-equiv='refresh' content='10' />\n";
	echo "<title>Checker</title>";
	echo "</head>\n";		
	echo "<body></body>\n";
	$chatUser = new DHchatUser;
  $chatUser->loadUser($_SESSION['dhchatuser']);
  if (CheckIfBanned() == TRUE) { 
    echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
    echo "top.MainFrame.location.reload();\n";
		echo "</script>\n";
  } 
	echo "</html>";
?>