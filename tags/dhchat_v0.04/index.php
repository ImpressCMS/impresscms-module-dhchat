<?php
// $Id: index.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

include("../../mainfile.php");

// funktioniert leider nicht mehr ??
$xoopsOption['xoops_showlblock'] = 0;
$xoopsOption['xoops_showrblock'] = 0;

include(XOOPS_ROOT_PATH."/header.php");
echo "<iframe style=\"framespacing:0; border:0; frameborder:0; marginwidth:0; marginheight:0;\" width=98% height=".$xoopsModuleConfig["chatframe"]." scrolling=\"auto\" name=\"MainFrame\" src=\"frame.php\"></iframe>";
include(XOOPS_ROOT_PATH."/footer.php");
?>