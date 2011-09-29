<?php
// $Id: user.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

class DHchatUser {
  var $DHchatUser = array();
	
	function loadUser($uname="") {
	  global $xoopsUser,$xoopsModuleConfig;
		$un = $xoopsUser ? true : false;
	  if ($un==false) { // Gastlogin
		  if ($xoopsModuleConfig["guestlogin"] == 'name_login') {  //Gastlogin per frei wählbaren Namen
			   $this->DHchatUser['uid'] = 0;
				 $this->DHchatUser['nick'] = $uname;
				 $this->DHchatUser['admin'] = false;
				 $this->DHchatUser['moderator'] = false;
				 $this->DHchatUser['ipaddress'] = $_SERVER['REMOTE_ADDR'];
  		   return $this->DHchatUser;
			} else {
			  $autouser=CreateAutoUser();
				if ($autouser== false) {
				  redirect_header(XOOPS_URL."/",5,_MA_DHCHAT_NOUSERINDBWRITE);                    
          include(XOOPS_ROOT_PATH."/footer.php");
          exit;
				} else {
			    $this->DHchatUser['uid'] = 0;
					if ($uname!="") {
				    $this->DHchatUser['nick'] = $uname;
					} else {
					  $this->DHchatUser['nick'] = $autouser;
					}
				  $this->DHchatUser['admin'] = false;
				  $this->DHchatUser['moderator'] = false;
				  $this->DHchatUser['ipaddress'] = $_SERVER['REMOTE_ADDR'];
  		    return $this->DHchatUser;
				}
			}
		} else {
			$this->DHchatUser['uid'] = $xoopsUser->uid();
		  $this->DHchatUser['nick'] = $xoopsUser->uname();
		  if ($xoopsUser->isAdmin()) {
			  $this->DHchatUser['admin'] = true;
				$this->DHchatUser['moderator'] = true;
			} else {
			  $this->DHchatUser['admin'] = false;
				// Moderator ?
			  $this->DHchatUser['moderator'] = false;
			}
		  $this->DHchatUser['ipaddress'] = $_SERVER['REMOTE_ADDR'];
  		return $this->DHchatUser;
		}
	}

	function nick(){
	  return $this->DHchatUser['nick'];
	}
	function uid(){
	  return $this->DHchatUser['uid'];
	}
	function ip(){
	  return $this->DHchatUser['ipaddress'];
	}
	function isAdmin(){
	  return $this->DHchatUser['admin'] ? true : false;
	}
	function isMod(){
	  return $this->DHchatUser['moderator'] ? true : false;
	}
}

function CreateAutoUser($length = 4) {
    global $xoopsDB,$xoopsModuleConfig;
	  $r=0;
    while ($r < 1000) {
		  $makeuser = $xoopsModuleConfig['guestname'].chat_makezahl();
      $csql="SELECT wid FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE nick='".$makeuser."'";
      $cres=$xoopsDB->query($csql);
      if ($xoopsDB->getRowsNum($cres) == 0) {
        $r=10000;
      } else {
        $r++;
        $makeuser="";
      }
    }
    if ($makeuser!="") {
		  return $makeuser;
		} else {
		  return false;
    }
}

function chat_makezahl($length=4) {
  $maker = "";
	$syllables = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  srand((double)microtime()*1000000);
  $syllable_count = count($syllables);
  for ($count = 1; $count < $length; $count++) {
    if (rand()%10 == 1) {
      $maker .= sprintf("%0.0f",(rand()%50)+1);
    } else {
      $maker .= $syllables[rand()%$syllable_count];
    }
  }
	return $maker;
}
?>