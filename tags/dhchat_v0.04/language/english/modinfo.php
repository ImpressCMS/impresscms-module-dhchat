<?php
// $Id: modinfo.php,v 1.2 2005/08/10 coded by frankblack
// ------------------------------------------------------------------------- //
// German Xoops-Support-Site                  		
// < http://www.myxoops.org >
// ------------------------------------------------------------------------- //
// Vorlage : XoopsChat V1.21
// Author: DHCST Dirk herrmann
// Licence Type : Public GNU/GPL
// ------------------------------------------------------------------------- //

// The name of this module
define("_MI_DHCHAT_NAME","Chat");

// A brief description of this module
define("_MI_DHCHAT_DESC","Chatmodul for ImpressCMS");
define("_MI_DHCHAT_GUESTS","Guest_");

// Names of admin menu items
define("_MI_DHCHATCHATFRAME","Height of the Chatframe");
define("_MI_DHCHATCHATFRAMEDESC","Height of the frame (in pixel) where the messages are displayed");
define("_MI_DHCHATUSERFRAME","Height of the room list");
define("_MI_DHCHATUSERFRAMEDESC","Height of the frame (in pixel) where the rooms are displayed");
define("_MI_DHCHATMSGFRAME","Height of the input-frame");
define("_MI_DHCHATMSGFRAMEDESC","Height of the messages input frame (in pixel)");
define("_MI_DHCHATSTATISTIKFRAME","Width Userlist frame");
define("_MI_DHCHATSTATISTIKFRAMEDESC","Width of the frame (in pixel) where the userlist is displayed");
define("_MI_DHCHAT_INPLENGTH","Length inputfield Chat");
define("_MI_DHCHAT_INPLENGTHDESC","Length definition of the inputfield (in pixel)");
define("_MI_DHCHAT_INPHEIGHT","Numbers of lines for inputfield Chat");
define("_MI_DHCHAT_INPHEIGHTDESC","Here you can define the numbers of lines for the inputfield Chat");
define("_MI_DHCHAT_MAXLENGTH","Max. Characters Chat");
define("_MI_DHCHAT_MAXLENGTHDESC","Here you can define the max. numbers of characters for one message");
define("_MI_DHCHAT_GUESTNAME","Prefix for Guests");
define("_MI_DHCHAT_GUESTNAMEDESC","Here you can define a Prefix for guests. For example:<b>"._GUESTS."12345</b>");
define("_MI_DHCHAT_GUESTLOGIN","Guests allowed / Guest list");
define("_MI_DHCHAT_GUESTLOGINDESC","Here you can define if guests can join the chat");
define("_MI_DHCHAT_GUESTLOGIN_NO","No Entry");
define("_MI_DHCHAT_GUESTLOGIN_PREFIX","Username automatically");
define("_MI_DHCHAT_GUESTLOGIN_NAME","Choose own username");
define("_MI_DHCHATCHATREFRESH","Chat-Refresh");
define("_MI_DHCHATCHATREFRESHDESC","Value for refresh (in seconds) of the message frame");
define("_MI_DHCHATUSERREFRESH","Userlist-refresh");
define("_MI_DHCHATUSERREFRESHDESC","Value for refresh (in seconds) of the userlist");
define("_MI_DHCHAT_MAXMESSAGE","Max. numbers of messages");
define("_MI_DHCHAT_MAXMESSAGEDESC","Here you can define how many messages are displayed in the chatframe (0 for all)");
define("_MI_DHCHAT_ORDER","Order messages");
define("_MI_DHCHAT_ORDERDESC","Here you can define where a new message will be displayed");
define("_MI_DHCHATASC","bottom");
define("_MI_DHCHATDESC","on top");

define("_MI_DHCHAT_ADMENU1","Chatindex");
define("_MI_DHCHAT_ADMENU2","Rooms Administration");
define("_MI_DHCHAT_ADMENU3","Logfile");
define("_MI_DHCHAT_ADMENU4","Suspended User");

define("_MI_DHCHATWHOSCHATTING","Who is chatting?");
define("_MI_DHCHATWHOSCHATTINGDESC","Displays who is chatting at the moment");

define("_MI_DHCHAT_AUTODEL","Autodelete messages");
define("_MI_DHCHAT_AUTODELDESC","Here you can define the numbers of hours after all messages will be deleted");

define("_MI_DHCHAT_VIEWENTRYMSG","View messages by join chatroom");
define("_MI_DHCHAT_VIEWENTRYMSGDESC","Defines how many messages a user can see when she/he joins the chatroom (in seconds / 0 for none)");
define("_MI_DHCHAT_SYSMSGGO","View join / leave messages");
define("_MI_DHCHAT_SYSMSGGODESC","Defines whether it will be displayed in the chatframe when a user join or leave the room.");

define("_MI_DHCHAT_IMG_SET","Imageset");
define("_MI_DHCHAT_IMG_SET_DESC","Select imagesets");

define("_MI_DHCHAT_EXITCOLOR","Backgroundcolour Select_room_frame");
define("_MI_DHCHAT_EXITCOLORDESC","Select the backgroundcolour for Select_room_frame (i.E. #FFFFFF for white)");
define("_MI_DHCHAT_INPUTCOLOR","Backgroundcolour Inputframe");
define("_MI_DHCHAT_INPUTCOLORDESC","Select the backgroundcolour for Inputframe (i.E. #FFFFFF for white)");
define("_MI_DHCHAT_MSGCOLOR","Backgroundcolour Messageframe");
define("_MI_DHCHAT_MSGCOLORDESC","Select the backgroundcolour for messageframe (i.E. #FFFFFF for white)");
define("_MI_DHCHAT_USERCOLOR","Backgroundcolour User in Chat");
define("_MI_DHCHAT_USERCOLORDESC","Select the backgroundcolour for User_in_Chat_frame (i.E. #FFFFFF for white)");
?>