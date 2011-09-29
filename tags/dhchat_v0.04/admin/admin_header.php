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
include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
include(XOOPS_ROOT_PATH."/include/cp_functions.php");
if($xoopsUser){
  $xoopsModule = XoopsModule::getByDirname("dhchat");
  if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
    redirect_header(XOOPS_URL."/",3,_NOPERM);
    exit();
 }
} else {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
}
if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once("../language/".$xoopsConfig['language']."/admin.php");
} else {
	include_once("../language/english/admin.php");
}

?>
