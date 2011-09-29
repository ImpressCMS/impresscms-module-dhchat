<?php
// $Id: xoops_version.php,v 0.03 2005/09/11 coded by dhcst
// ------------------------------------------------------------------------- //
// Support-Site                  		
// < http://xoops.dhsoft.de >
// ------------------------------------------------------------------------- //
// Vorlage : DH-Chat V0.03
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //


$modversion['name'] = _MI_DHCHAT_NAME;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_DHCHAT_DESC;
$modversion['credits'] = "Dirk Herrmann (alfred) <http://xoops.dhsoft.de> und Karl Georg Mayr (taxham) <http://www.kama.net>";
$modversion['author'] = "Dirk Herrmann";
$modversion['license'] = "GNU/GPL";
$modversion['official'] = 1;
$modversion['status_version'] = "Final";
$modversion['status'] = "Final";
$modversion['image'] = "images/icon_big.png";
$modversion['iconsmall'] = 'images/icon_small.png';
$modversion['iconbig'] = 'images/icon_big.png';
$modversion['dirname'] = "dhchat";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "dhchat_messages";
$modversion['tables'][1] = "dhchat_rooms";
$modversion['tables'][2] = "dhchat_whosonline";
$modversion['tables'][3] = "dhchat_banned";
$modversion['tables'][4] = "dhchat_visibility";

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Main contents
$modversion['hasMain'] = 1;


// Templates
$modversion['templates'][1]['file'] = 'dhchat_chat.html';
$modversion['templates'][1]['description'] = 'Die Chatnachrichtenanzeige';
$modversion['templates'][2]['file'] = 'dhchat_input.html';
$modversion['templates'][2]['description'] = 'Der Eingabebereich';
$modversion['templates'][3]['file'] = 'dhchat_userlist.html';
$modversion['templates'][3]['description'] = 'Der Members-online-bereich';
$modversion['templates'][4]['file'] = 'dhchat_login.html';
$modversion['templates'][4]['description'] = 'Der Login-bereich';
$modversion['templates'][5]['file'] = 'dhchat_frameset.html';
$modversion['templates'][5]['description'] = 'Der Chat Aufbau';
$modversion['templates'][6]['file'] = 'dhchat_frameexit.html';
$modversion['templates'][6]['description'] = 'Der Chat Ausgang und die Raumliste';



// Blocks
$modversion['blocks'][1]['file'] = "whoschatting.php";
$modversion['blocks'][1]['name'] = _MI_DHCHATWHOSCHATTING;
$modversion['blocks'][1]['description'] = _MI_DHCHATWHOSCHATTINGDESC;
$modversion['blocks'][1]['show_func'] = "dhchat_showchatting";
$modversion['blocks'][1]['template'] = 'dhchat_block_whochat.html';

/*
$modversion['blocks'][2]['file'] = "chatblock.php";
$modversion['blocks'][2]['name'] = _MI_DHCHATBLOCKNAME;
$modversion['blocks'][2]['description'] = _MI_DHCHATBLOCKDESC;
$modversion['blocks'][2]['show_func'] = "dhchat_show";
$modversion['blocks'][2]['edit_func'] = "dhchat_edit";
$modversion['blocks'][2]['template'] = 'dhchat_block_chat.html';
$modversion['blocks'][2]['options'] = "16|150|170";
*/

require_once(ICMS_ROOT_PATH.'/class/xoopslists.php');
$imagesets =& XoopsLists::getDirListAsArray(ICMS_ROOT_PATH.'/modules/dhchat/imageset/');
// Configsettings
$i=1;
$modversion['config'][$i]['name']	= 'dhchat_image_set';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_IMG_SET';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_IMG_SET_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = $imagesets;
$modversion['config'][$i]['default'] = "default";

$i++;
$modversion['config'][$i]['name'] = 'chatframe';
$modversion['config'][$i]['title'] = '_MI_DHCHATCHATFRAME';
$modversion['config'][$i]['description'] = '_MI_DHCHATCHATFRAMEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 500;

$i++;
$modversion['config'][$i]['name'] = 'userframe';
$modversion['config'][$i]['title'] = '_MI_DHCHATUSERFRAME';
$modversion['config'][$i]['description'] = '_MI_DHCHATUSERFRAMEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 100;

$i++;
$modversion['config'][$i]['name'] = 'statistikframe';
$modversion['config'][$i]['title'] = '_MI_DHCHATSTATISTIKFRAME';
$modversion['config'][$i]['description'] = '_MI_DHCHATSTATISTIKFRAMEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200;

$i++;
$modversion['config'][$i]['name'] = 'msgframe';
$modversion['config'][$i]['title'] = '_MI_DHCHATMSGFRAME';
$modversion['config'][$i]['description'] = '_MI_DHCHATMSGFRAMEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 115;

$i++;
$modversion['config'][$i]['name'] = 'chatmaxmessage';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_MAXMESSAGE';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_MAXMESSAGEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 50;

$i++;
$modversion['config'][$i]['name'] = 'orderascdesc';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_ORDER';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_ORDERDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(	_MI_DHCHATASC=>'ASC',
					_MI_DHCHATDESC=>'DESC'
				  );
$modversion['config'][$i]['default'] = 'ASC';

$i++;
$modversion['config'][$i]['name'] = 'autodelmsg';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_AUTODEL';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_AUTODELDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 48;

$i++;
$modversion['config'][$i]['name'] = 'chatsysmsggo';
$modversion['config'][$i]['title' ] = '_MI_DHCHAT_SYSMSGGO';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_SYSMSGGODESC';
$modversion['config'][$i]['formtype' ] = 'yesno';
$modversion['config'][$i]['valuetype' ] = 'int';
$modversion['config'][$i]['default' ] = 0;

$i++;
$modversion['config'][$i]['name'] = 'inputheight';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_INPHEIGHT';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_INPHEIGHTDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'inputlength';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_INPLENGTH';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_INPLENGTHDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 50;

$i++;
$modversion['config'][$i]['name'] = 'maxlength';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_MAXLENGTH';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_MAXLENGTHDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 100;

$i++;
$modversion['config'][$i]['name'] = 'guestlogin';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_GUESTLOGIN';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_GUESTLOGINDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array(	_MI_DHCHAT_GUESTLOGIN_NO=>'no_login',
					_MI_DHCHAT_GUESTLOGIN_PREFIX=>'prefix_login'
 				  );
$modversion['config'][$i]['default'] ='prefix_login';

$i++;
$modversion['config'][$i]['name'] = 'guestname';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_GUESTNAME';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_GUESTNAMEDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_DHCHAT_GUESTS;

$i++;
$modversion['config'][$i]['name'] = 'viewentrymsg';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_VIEWENTRYMSG';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_VIEWENTRYMSGDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '120';

$i++;
$modversion['config'][$i]['name'] = 'msgframecolor';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_MSGCOLOR';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_MSGCOLORDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';

$i++;
$modversion['config'][$i]['name'] = 'inputframecolor';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_INPUTCOLOR';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_INPUTCOLORDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';

$i++;
$modversion['config'][$i]['name'] = 'exitframecolor';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_EXITCOLOR';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_EXITCOLORDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';

$i++;
$modversion['config'][$i]['name'] = 'userframecolor';
$modversion['config'][$i]['title'] = '_MI_DHCHAT_USERCOLOR';
$modversion['config'][$i]['description'] = '_MI_DHCHAT_USERCOLORDESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFFFF';

unset($i);
?>
