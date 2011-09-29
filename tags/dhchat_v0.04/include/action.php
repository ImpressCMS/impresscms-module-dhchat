<?php
// $Id: aktion.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

function check_message($mess="") {
  global $chatUser;
  $bef=explode (" ", $mess);
  switch ($bef[0]) {
    case '/kick':
		  if ($chatUser->isAdmin() || $chatUser->isMod()) {
        set_ban($bef[1],2);
			} else {
			  echo "<script type='text/javascript'>";
				echo "alert('"._MA_DHCHAT_NOACCESS."')";
				echo "</script>";
			}
      break;
    case '/kicktime':
      if (is_numeric($bef[1])) {
			  if ($chatUser->isAdmin() || $chatUser->isMod()) {
          set_ban($bef[2],$bef[1]);
			  } else {
			    echo "<script type='text/javascript'>";
				  echo "alert('"._MA_DHCHAT_NOACCESS."')";
				  echo "</script>";
			  }
      }
      break;
    case '/kickday':
      if (is_numeric($bef[1])) {
			  if ($chatUser->isAdmin() || $chatUser->isMod()) {
          set_ban($bef[2],$bef[1] * 60 *24);
			  } else {
			    echo "<script type='text/javascript'>";
				  echo "alert('"._MA_DHCHAT_NOACCESS."')";
				  echo "</script>";
			  }						
      }
      break;
		default:
		  echo "<script type='text/javascript'>";
			echo "alert('"._MA_DHCHAT_NOFUNC."')";
			echo "</script>";
			break;
  }
}      

function set_ban($user="",$min=5) {
   global $xoopsDB,$room;

   if ($user!="") {
     $sql="SELECT wid,uid FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE nick='".$user."'";
     $qc = $xoopsDB->queryF($sql);
     if ($xoopsDB->getRowsNum($qc) > 0) {
       $r = $xoopsDB->fetchRow($qc);
       if ($r[1] > 0) {
          $member_handler =& xoops_gethandler('member');
          $thisUser =& $member_handler->getUser($r[1]);
          if (is_object($thisUser) ){		  
            if($thisUser->isAdmin()) {
              // nachfolgendes besser machen ?
              ?>
               <script>
                 alert("Moderatoren können nicht gesperrt werden!");
               </script>
              <?php
              exit;
            }
          }
       }
       $today = time();
       $expires = $today + (60 * $min);
       $sql="INSERT INTO ".$xoopsDB->prefix("dhchat_banned")." VALUES ('', '$user', $today, $expires)";
       $qc = $xoopsDB->queryF($sql);
       if ($qc) {
          insertMessage($room,sprintf(_MA_DHCHAT_USERKICKED,$user),'Hinweis',time(),'SYSTEM');
          RemoveUser($user);
          // nachfolgendes besser machen ?
          ?>
            <script>
            alert("Der Benutzer wurde gesperrt");
            </script>
       <?php
       }
     } else {
       // nachfolgendes besser machen ?
       ?>
       <script>
       alert("Der Benutzer existiert nicht");
      </script>
       <?php
     }
   }     
}

check_message($message);
?>