<?php
// $Id: bottom.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

$ubef=array("/kick","/kicktime","/kickday");
      
include("../../mainfile.php");
include_once("include/user.php");
include_once("include/functions.php");
$chatUser = new DHchatUser;
$chatUser->loadUser($_SESSION['dhchatuser']);
if (CheckIfBanned() == TRUE) {
  exit;
}
$room=$_SESSION['dhchatroom'];
hasPermissions($room);

$inputTpl = new XoopsTpl();
$template = 'db:dhchat_input.html';
$header ="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n
 <html><head>\n
 <link rel='stylesheet' type='text/css' media='all' href='".XOOPS_URL."/modules/dhchat/chat.css' />\n
 <title>DH-CHATINPUT</title>
 <script type='text/javascript' src ='".XOOPS_URL."/include/xoops.js'></script>
 <script type='text/javascript'> 
  function setfocus() {
  document.msgform.msgtextbox.focus();
  }
 </script>
 </head>
  <body bgcolor='".$xoopsModuleConfig['inputframecolor']."' onLoad='setfocus()'>
	<form name='msgform' action='bottom.php' method='POST'>
	<input type='hidden' name='op' value='insertmessage'>";
	
$tcolor= "";
$thecolorarr = array(_MA_DHCHAT_COLOR1,_MA_DHCHAT_COLOR2,_MA_DHCHAT_COLOR3,_MA_DHCHAT_COLOR4,
                         _MA_DHCHAT_COLOR5,_MA_DHCHAT_COLOR6,_MA_DHCHAT_COLOR7,_MA_DHCHAT_COLOR8,
                           _MA_DHCHAT_COLOR9);
$thecolornames = array(_MA_DHCHAT_BLACK,_MA_DHCHAT_DARKBLUE,_MA_DHCHAT_BLUE,_MA_DHCHAT_LGREEN,
                             _MA_DHCHAT_GREEN,_MA_DHCHAT_DARKRED,_MA_DHCHAT_RED,_MA_DHCHAT_ORANGE,
                             _MA_DHCHAT_WHITE);
$tcolor.= "<b>"._MA_DHCHAT_SELECTCOLOR."</b>&nbsp;";
$tcolor.= "<select name='colors'>";
$tcolor.= "<option>"._MA_DHCHAT_AUTO."</option>";

$countcolor = 0;
$currentcolor = _MA_DHCHAT_AUTO;
if (isset($_POST['colors'])) {
  if ($_POST['colors'] != "") {
     $currentcolor = $_POST['colors'];
	}
}

foreach ($thecolornames as $c) {
        $tcolor.= "<option";
        if ($currentcolor == $c) {
                $tcolor.= " selected";
        }
        $tcolor.= " style='color: #".$thecolorarr[$countcolor].";'>";
        $tcolor.= $c;
        $tcolor.= "</option>";
        $countcolor++;
}

$tcolor.= "</select>";
$schrift="<input type='checkbox' name='msg_bold'><b>"._MA_DHCHAT_FONTBOLD."</b>&nbsp;<input type='checkbox' name='msg_italic'><i>"._MA_DHCHAT_FONTITALIC."</i>&nbsp;<input type='checkbox' name='msg_underlined'><u>"._MA_DHCHAT_FONTUNDERL."</u>";
$schrift.="&nbsp;&nbsp;".$tcolor;
											
$inputTpl->assign("input_header",$header);
if ($xoopsModuleConfig['inputheight']>1) {
  $inputTpl->assign("input_input","<textarea cols='".$xoopsModuleConfig["inputlength"]."' rows='".$xoopsModuleConfig["inputheight"]."' id='msgtextbox' name='msg'></textarea>");
}else {
  $inputTpl->assign("input_input","<input type='text' size='".$xoopsModuleConfig["inputlength"]."' maxlength='".$xoopsModuleConfig["maxlength"]."' id='msgtextbox' name='msg'>");
}
$inputTpl->assign("input_button","<input type=\"image\" src=\"".XOOPS_URL."/modules/dhchat/imageset/".$xoopsModuleConfig['dhchat_image_set']."/".$xoopsConfig['language']."/"._MI_DHCHAT_GOMESSPIC."\" alt=\""._MA_DHCHAT_MSGSEND."\">");
$inputTpl->assign("input_schrift",$schrift);
$inputTpl->assign("input_smilies",chatSmilies("msgtextbox"));
$inputTpl->assign("input_footer","</form>
 </body></html>");		
 
if (!isset($_SESSION['dhchat_chattime'])) $_SESSION['dhchat_chattime']=time();
																 														
if (isset($_POST['msg'])) {
  if (!$_POST['msg'] == "") {
     $message = $_POST['msg'];
     $myts =& MyTextSanitizer::getInstance();
		 $message = $myts->censorString($message);
		 $dd=explode(" ",$message);
     if (in_array($dd[0],$ubef)) {
       include_once(XOOPS_ROOT_PATH."/modules/dhchat/include/action.php");
     } else {
       if (isset($_POST['msg_underlined'])) if ($_POST['msg_underlined'] == "on") $message = "[u]".$message."[/u]";            
       if (isset($_POST['msg_italic'])) if ($_POST['msg_italic'] == "on") $message = "[i]".$message."[/i]";
       if (isset($_POST['msg_bold'])) if ($_POST['msg_bold'] == "on") $message = "[b]".$message."[/b]";
			 $mcolor = $_POST['colors'];
       if ($mcolor == _MA_DHCHAT_AUTO) {
         $noformat = true;
       } else {
         $noformat = false;
         $list = 0;
         while($mcolor != $thecolornames[$list]) {
           $list++;
         }
       }
			 if ($noformat == false) {
			   $message = '[color='.$thecolorarr[$list].']'.$message.'[/color]';
			 }
       insertMessage($room, $message, $chatUser->nick(), time(), $chatUser->ip());
     }
  }   
}
//$inputTpl->assign("input_help","<a href=\"#chat_help\" onmouseover=\"style.cursor='hand'\" onclick=\"openWithSelfMain('".XOOPS_URL."/modules/dhchat/help.php','"._MA_DHCHAT_HELP."',400,500);\">"._MA_DHCHAT_HELP."</a>");
$inputTpl->display($template);
?>