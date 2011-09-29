<?php
// $Id: functions.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk Herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //
global $xoopsConfig;
require_once XOOPS_ROOT_PATH.'/class/template.php';

if ( file_exists(XOOPS_ROOT_PATH."/modules/dhchat/language/".$xoopsConfig['language']."/main.php") ) {
	include_once(XOOPS_ROOT_PATH."/modules/dhchat/language/".$xoopsConfig['language']."/main.php");
} else {
	include_once(XOOPS_ROOT_PATH."/modules/dhchat/language/english/main.php");
}

function DeleteOldMessages() {
   global $xoopsDB, $xoopsModuleConfig;

   if ($xoopsModuleConfig['autodelmsg'] > 0) {
     $deldate = time() - ($xoopsModuleConfig['autodelmsg'] * 3600) ;
     $sql = "DELETE FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE post_time <='".$deldate."'";
     $res = $xoopsDB->query($sql);
   }
	
	 // Datenbankoptimierung
	 $sql="CHECK TABLE ".$xoopsDB->prefix("dhchat_messages");
	 $res = $xoopsDB->queryF($sql);
	 $sql="CHECK TABLE ".$xoopsDB->prefix("dhchat_whosonline");
	 $res = $xoopsDB->queryF($sql);
	 $sql="CHECK TABLE ".$xoopsDB->prefix("dhchat_banned");
	 $res = $xoopsDB->queryF($sql);
	 $sql="REPAIR TABLE ".$xoopsDB->prefix("dhchat_messages");
	 $res = $xoopsDB->queryF($sql);
	 $sql="REPAIR TABLE ".$xoopsDB->prefix("dhchat_whosonline");
	 $res = $xoopsDB->queryF($sql);
	 $sql="REPAIR TABLE ".$xoopsDB->prefix("dhchat_banned");
	 $res = $xoopsDB->queryF($sql);
	 $sql="OPTIMIZE TABLE ".$xoopsDB->prefix("dhchat_messages");
	 $res = $xoopsDB->queryF($sql);
	 $sql="OPTIMIZE TABLE ".$xoopsDB->prefix("dhchat_whosonline");
	 $res = $xoopsDB->queryF($sql);
	 $sql="OPTIMIZE TABLE ".$xoopsDB->prefix("dhchat_banned");
	 $res = $xoopsDB->queryF($sql);
	 $sql="ALTER TABLE ".$xoopsDB->prefix("dhchat_messages")."  AUTO_INCREMENT =0";
	 $res = $xoopsDB->queryF($sql);
	 $sql="ALTER TABLE ".$xoopsDB->prefix("dhchat_whosonline")."  AUTO_INCREMENT =0";
	 $res = $xoopsDB->queryF($sql);
	 $sql="ALTER TABLE ".$xoopsDB->prefix("dhchat_banned")."  AUTO_INCREMENT =0";
	 $res = $xoopsDB->queryF($sql);
}

function updateUserlist($ouser=false) {
  global $xoopsDB;
  if ($ouser==true) { // Benutzertime aktualisieren
     $sql="UPDATE ".$xoopsDB->prefix("dhchat_whosonline")." SET user_time='".time()."' WHERE nick='".$_SESSION['dhchatuser']."'";
     $res = $xoopsDB->queryF($sql);
  } 
  $deltime= time() - 300;
  $sql="DELETE FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE user_time < ".$deltime."";
	$res = $xoopsDB->queryF($sql);
}

function CheckIfBanned() {
   global $xoopsDB,$chatUser;

   $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_banned")." WHERE user = '".$chatUser->nick()."'";
	 $res = $xoopsDB->query($sql);
   if ($xoopsDB->getRowsNum($res) > 0) {
      $userban = $xoopsDB->fetchRow($res);
      $currentTS = time();
      if ($currentTS < $userban[3]) {
        return TRUE;
      } else {
        $sql = "DELETE FROM ".$xoopsDB->prefix("dhchat_banned")." WHERE user = '".$chatUser->nick()."'";
				return $xoopsDB->queryF($sql) ? FALSE : TRUE;
      }
   } 
   return FALSE;
}

function getDefaultRoom() {
        global $xoopsDB;

        $sql = "SELECT room_name,rid FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_type = 2";
        $cr = $xoopsDB->query($sql);
        $res = $xoopsDB->fetchRow($cr);
        return $res;
}

function AddUser() {
        global $xoopsDB, $chatUser,$xoopsModuleConfig;    
				if ($_SESSION['dhchatroom']== "") {
				  $theroom = getDefaultRoom();
	        $_SESSION['dhchatroom'] = $theroom[0];
	        $_SESSION['dhchatroomid'] = $theroom[1];
        }				       
        $insert = false;
				// ist User schon im Chat ?
        $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE nick = '".$chatUser->nick()."' "; //AND user_ip='".$userarray['ipaddress']."'";
        $res = $xoopsDB->queryF($sql);
        if ($xoopsDB->getRowsNum($res) == 0) $insert = true;		
		    $sql = "INSERT INTO ".$xoopsDB->prefix("dhchat_whosonline")." (uid,nick,user_ip,user_roomid,user_time,user_session) VALUES(".$chatUser->uid().",'".$chatUser->nick()."','".$chatUser->ip()."',".$_SESSION['dhchatroomid'].",'".time()."','".$_SESSION['dhchat_logsession']."')";
		    if ($insert == true) {
				   $xoopsDB->queryF($sql);
           insertMessage($_SESSION['dhchatroom'],sprintf(_MA_DHCHAT_USERENTER,$chatUser->nick(),$_SESSION['dhchatroom']),_MA_DHCHAT_SYSGO,time(),'SYSGO');
        }
}


function chatSmilies($textarea_id) {
  global $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();
	$smiles =& $myts->getSmileys();
  $retsmilies="";
	if (empty($smileys)) {
	  $sql = "SELECT * FROM ".$xoopsDB->prefix('smiles')." WHERE display=1";
		$result = $xoopsDB->queryF($sql);
		if ($result) {
			while ($smiles = $xoopsDB->fetchArray($result)) {
			$retsmilies.="<img src='".XOOPS_UPLOAD_URL."/".htmlspecialchars($smiles['smile_url'])."' border='0' onmouseover='style.cursor=\"hand\"' alt='' onclick='xoopsCodeSmilie(\"".$textarea_id."\", \" ".$smiles['code']." \");' />";
			}
		}
	} else {
		$count = count($smiles);
		for ($i = 0; $i < $count; $i++) {
			if ($smiles[$i]['display'] == 1) {
			  $retsmilies.="<img src='".XOOPS_UPLOAD_URL."/".$myts->oopsHtmlSpecialChars($smiles['smile_url'])."' border='0' alt='' onclick='xoopsCodeSmilie(\"".$textarea_id."\", \" ".$smiles[$i]['code']." \");' onmouseover='style.cursor=\"hand\"' />";
			}
		}
	}
	$retsmilies.="&nbsp;[<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' onclick='openWithSelfMain(\"".XOOPS_URL."/misc.php?action=showpopups&amp;type=smilies&amp;target=".$textarea_id."\",\"smilies\",300,475);'>"._MORE."</a>]";
  return $retsmilies;
}  


function getUserRooms() {
    global $xoopsDB, $xoopsUser, $xoopsModule;

    if (is_object($xoopsUser)){
       $uid = $xoopsUser->uid();}
    else $uid=0;

    if (is_object($xoopsUser) and $xoopsUser->isAdmin($xoopsModule->mid())) {
      $sql = "SELECT rid FROM ".$xoopsDB->prefix("dhchat_rooms");
    } elseif(is_object($xoopsUser)) {
      $sql = "SELECT DISTINCT r.rid FROM ".$xoopsDB->prefix("groups_users_link")." as gu, ".$xoopsDB->prefix("dhchat_visibility")." as v, ".$xoopsDB->prefix("dhchat_rooms")." as r WHERE (r.room_type = 2) OR (r.room_type = 3) OR (r.room_type = 4 AND gu.uid = $uid AND gu.groupid = v.groupid AND v.rid = r.rid)";
    } else {
       $sql = "SELECT r.rid FROM ".$xoopsDB->prefix("dhchat_visibility")." as v, ".$xoopsDB->prefix("dhchat_rooms")." as r WHERE (r.room_type = 2) OR (r.room_type = 3) OR (r.room_type = 4 AND v.groupid = 3 AND v.rid = r.rid)";
    }

    $res = $xoopsDB->query($sql);
    $rooms = array();
    while ($row = $xoopsDB->fetchRow($res)) {
      $rooms[]=$row[0];
    }
    return $rooms;
}

function listChatRooms($selectedroom) {
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;

    $userrooms = getUserRooms();
    $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_type>1";
    $roomslist = $xoopsDB->query($sql);
    $list= "<form action=\"frame.php\" target=\"MainFrame\" method=\"post\">";
    $list.= "<select name=\"room\" size=\"1\">";
    $rx=0;
    while($res = $xoopsDB->fetchArray($roomslist)) {
        $rid = $res['rid'];    
        if ( in_array($rid,$userrooms) || $res['room_type']==3 || $res['room_type']==2) {
            $list.= "<option";
            if ($res['room_name'] == $selectedroom) {
                $list.= " selected";
            }
            $list.= ">".$res['room_name']."</option>\r\n";
            $rx++;
        }
    }
    if ($rx<2) {
		  $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_type=2";
			$roomslist = $xoopsDB->query($sql);
			$res = $xoopsDB->fetchArray($roomslist);
			$list= "<div style=\"padding:2px;\"><select name='room' disabled>";
			$rid = $res['rid'];
      $list.= "<option selected>".$res['room_name']."</option>";
			$list.= "</select></div>";
		} else {
      $list.= "</select>";
		}
		$list.= "<input type='hidden' name='op' value='changeroom' />";
		$but=XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_CHANGEROOMPIC;
		$list.= "<input style=\"border:0; text-align:left; padding:2px;\" type=\"image\" src=\"".$but."\" alt=\""._MA_DHCHAT_ROOMSEND."\"";  
		$list.= ($rx<2) ? " disabled />" : " /></form>";
		return $list;
}

function insertMessage($roomname,$msg,$unick,$ts,$ip,$toname="") {
  global $xoopsDB;
  $sql = "INSERT INTO ".$xoopsDB->prefix("dhchat_messages")." VALUES ('','".$roomname."','".$msg."','".$unick."','".$toname."',".$ts.",'".$ip."')";
	$xoopsDB->queryF($sql);
}

function RemoveUser($nick=null) {
    global $xoopsDB, $chatUser;
    if ($nick==null){
		 if (isset($chatUser))
		   $nick = $chatUser->nick();
		}
    
    $sql = "DELETE FROM ".$xoopsDB->prefix("dhchat_whosonline")." ";
    $sql .= "WHERE nick = '".$nick."'";

    $xoopsDB->queryF($sql);

    $sql = "DELETE FROM ".$xoopsDB->prefix("dhchat_requests")." ";
    $sql .= "WHERE req_from OR req_to = '".$nick."'";

    $xoopsDB->queryF($sql);

    $sql = "DELETE FROM ".$xoopsDB->prefix("dhchat_pmsgs")." ";
    $sql .= "WHERE msg_from = '".$nick."'";
    $sql .= "OR msg_to = '".$nick."'";

    $xoopsDB->queryF($sql);
    if ($_SESSION['dhchatroom'] != "") {
      insertMessage($_SESSION['dhchatroom'],sprintf(_MA_DHCHAT_USEREXIT,$nick,$_SESSION['dhchatroom']),_MA_DHCHAT_SYSGO,time(),'SYSGO');
    }
}

function CountUser($roomid=0) {
  global $xoopsDB;
    $sql = "SELECT count(*) as count FROM ".$xoopsDB->prefix("dhchat_whosonline");
    if ($roomid>0) $sql.= " WHERE user_roomid=".$roomid;
    $rl = $xoopsDB->query($sql);
    $res = $xoopsDB->fetchRow($rl);
    if (!$res) return 0;
    $rid = $res[0];
    return $rid;
}

function LastMessage() {
  global $xoopsDB;
    
  $sql = "SELECT mid FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE chatroom='".$_SESSION['dhchatroom']."' ORDER BY mid DESC LIMIT 1";
  $rl = $xoopsDB->query($sql);
  $res = $xoopsDB->fetchRow($rl);
  if (!$res) return 0;
  $rid = $res[0];
	if ($rid<1) $rid=0;
  return $rid;
}

function ListUser($room='') {
  global $xoopsDB;
  if ($room!="") {
    $sql = "SELECT rid FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_name='".$room."'";
    $rl = $xoopsDB->query($sql);
    $res = $xoopsDB->fetchRow($rl);
    if (!$res) return false;
    $rid = $res[0];
    $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE user_roomid=".$rid." ORDER BY nick ASC";
    $res = $xoopsDB->query($sql);
    if (!$res) return false;
    return $res;
  } 
  return false;
}

function hasPermissions($room) {
    global $xoopsDB, $chatUser, $xoopsUser, $xoopsModule;

    $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." ";
    $sql .= "WHERE room_name = '".$room."'";

    $rl = $xoopsDB->query($sql);
    $res = $xoopsDB->fetchRow($rl);
    $rid = $res[0];

    $userrooms = getUserRooms();
    if ( $res[2] == 4 ) {
        if ( (is_object($xoopsUser) and !$xoopsUser->isAdmin($xoopsModule->mid()) or ($chatUser->DHchatUser['uid']==0)) ) {
            if ( !in_array($rid,$userrooms) ) {
                echo "<center>[ "._MA_DHCHAT_NOPERMISSIONS." ]</center>";
                exit;
            }
        }
    }
}


//

function getGroupName() {
        global $xoopsDB,$userarray,$xoopsUser;

        $grps = $xoopsUser->groups();
        $sql = "SELECT groupid,name FROM ".$xoopsDB->prefix("groups")."";
        $gl = $xoopsDB->query($sql);
        while ($res = $xoopsDB->fetchRow($gl)) {
                foreach ($grps as $g) {
                        if ($g == $res[0]) {
                                $groupname = $res[1];
                        }
                }
        }

        return $groupname;
}



function getMessages($chatroom) {
        global $xoopsDB, $xoopsModuleConfig,$xoopsUser;

        $setextra=" AND poster_ip !='SYSGO'";
				if ($xoopsModuleConfig['chatsysmsggo']==1) {
          $setextra="";
        } 
				if ($xoopsModuleConfig["viewentrymsg"]<0) {
				  $lastentry=$_SESSION['dhchat_logintime'];
				} else {
				  $lastentry=$_SESSION['dhchat_logintime'] - $xoopsModuleConfig["viewentrymsg"];
				}
				$setextra.=" AND post_time >=".$lastentry;
        $limit="";
        if ($xoopsModuleConfig["chatmaxmessage"] > 0) {
           if ($xoopsModuleConfig['orderascdesc']=="DESC") {
             $limit=" LIMIT ".intval($xoopsModuleConfig["chatmaxmessage"]);
           } else {
             $sql = "SELECT count(*) as count FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE chatroom = '".$chatroom."'".$setextra;
             $res = $xoopsDB->query($sql);
             $mres = $xoopsDB->fetchRow($res);
             $count=$mres[0] - intval($xoopsModuleConfig["chatmaxmessage"]);
             if ($count < 0) $count=0;
             $limit=" LIMIT ".$count.",".intval($xoopsModuleConfig["chatmaxmessage"]);
          }
        }
				$sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_name = '".$chatroom."'";
				$res = $xoopsDB->query($sql);
        $numthisroom = $xoopsDB->getRowsNum($res);
        if ($numthisroom == 0) {
                echo ""._MA_DHCHAT_WARNING."&nbsp;"._MA_DHCHAT_ROOMNOTEXISTS."\n";
                exit();
        }
        $sql = "SELECT * FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE chatroom = '".$chatroom."'".$setextra." ORDER BY post_time ".$xoopsModuleConfig['orderascdesc'].$limit;
				$res = $xoopsDB->query($sql);
        return $res;
}
?>