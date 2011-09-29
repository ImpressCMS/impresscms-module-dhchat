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

function dhchat_showchatting() {
        global $xoopsDB;
        mt_srand((double)microtime()*1000000);
        if (mt_rand(1, 100) < 50) {
           include_once(XOOPS_ROOT_PATH."/modules/dhchat/include/functions.php");
           updateUserlist();
        }

        $block = array();
        $result = $xoopsDB->query("SELECT nick,uid FROM ".$xoopsDB->prefix("dhchat_whosonline"));
        $online="";
        $muser=0;
        $mguest=0;
        $count_online=0;
        //$block['title'] = _BL_DHCHAT_WHOSCHATTING;
        $block['count_online']=_BL_DHCHAT_NOUSERONLINE;
        while($res = $xoopsDB->fetchArray($result)) {
          if ($res['uid']>0) {
            $ouser="<a href=".XOOPS_URL."/userinfo.php?uid=".$res['uid'].">".$res['nick']."</a>";
            $muser++;
          } else {
            $ouser=$res['nick'];
            $mguest++;
          }
          if ($count_online>0) {
            $online .= ", ".$ouser;
          } else {
            $online .= $ouser;
          }   
          $count_online++;
          $block['onlines'] = $online;
          $block['count_online']=sprintf(_BL_DHCHAT_USERONLINE,$muser + $mguest);
          $block['count_user']=sprintf(_BL_DHCHAT_MEMBERONLINE,$muser);
          $block['count_guest']=sprintf(_BL_DHCHAT_GUESTONLINE,$mguest);
        }
        return $block;
}
?>