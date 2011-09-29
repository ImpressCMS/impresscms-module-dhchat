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

function make_rooms_form() {
        global $xoopsDB;

        $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." ORDER BY room_type ASC");
        $count_room = 0;
        while ($room = $xoopsDB->fetchArray($rc)) {
           $rc1=$xoopsDB->query("SELECT count(*) as count FROM ".$xoopsDB->prefix("dhchat_whosonline")." WHERE user_roomid=".$room['rid']);
           $res1 = $xoopsDB->fetchRow($rc1);
           if (!$res1[0] || $res1[0] == "") $res1[0]=0;
           if ($room['room_type']==1) {
             $room_name=_AM_DHCHAT_ROOM_SHOURTBOX;
           } elseif ($room['room_type']==3) {
             $room_name=_AM_DHCHAT_ROOM_ALLUSER;
           } elseif ($room['room_type']==4) {
             $room_name=_AM_DHCHAT_ROOM_GROUPSONLY;
           } else {
             $room_name=_AM_DHCHAT_ROOM_DEFAULT;
           }
           echo "<tr>";
           echo "<td class='odd' align='center'><input type='radio' name='room_id' value='".$room['rid']."'";
           if ($count_room==0) echo " checked";
           echo " /></td>";
           echo "<td class='odd' align='left'>".$room['room_name']."</td>";
           echo "<td class='odd' align='left'>".$room_name."</td>";
           echo "<td class='odd' align='right'>".$res1[0]."</td>";
           echo "</tr>";
           $count_room++;
        }
        if ($count_room == 0) {
          echo "<tr><td clas='odd' >&nbsp;</td><td clas='odd' align='center'>_AM_DHCHAT_ROOM_NOROOM</td><td clas='odd' >&nbsp;</td><td clas='odd' >&nbsp;</td></tr>\n";
        }
        echo "<tr>";
        echo "<td class='odd'>&nbsp;</td>";
        echo "<td class='odd' align='left'>";
        echo "<select name='do'>\n";
        echo "<option selected value='room_edit'>"._AM_DHCHAT_REDIT."</option>\n";
        echo "<option value='room_delete'>"._AM_DHCHAT_RERASE."</option>\n";
        echo "</select>&nbsp;\n";
				echo "<input type='hidden' name='cancel' value='0'>";
        echo "<input name='exec' type='submit' value='"._AM_DHCHAT_PROCEED."' />\n";
        echo "</td><td class='odd' >&nbsp;</td>";
        echo "<td class='odd' >&nbsp;</td>";
        echo "</tr>\n";
}

function make_editroom_form($room) {
        global $xoopsDB;

        $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE rid = ".$room);
        $eroom = $xoopsDB->fetchRow($rc);
        echo "<form name='editroom' method='POST' action='rooms.php'>\n";
        echo "<input type='hidden' name='do' value='room_save' />";
        echo "<table border='0' cellpadding='0' cellspacing='0' align='center' width='100%'>\n";
        echo "<tr><td class='even'>\n";
        echo "<table border='0' cellpadding='4' cellspacing='1' align='center' width='100%'>\n";
        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_CHAT_ID."</b>";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        echo "<b>".$eroom[0]."</b>";     
        echo "<input name='room_id' type='hidden' value='".$eroom[0]."' />\n";
        echo "</td></tr>\n";

        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_NAME."</b>";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        echo "<input name='room_name' type='text' value='".$eroom[1]."' />\n";
        echo "</td></tr>\n";

        if ( $eroom[2] == 1 || $eroom[2] == 2) {
                echo "</table>\n";
                echo "</td></tr></table>\n";
                echo "<br /><br /><input name='go' type='submit' value='"._AM_DHCHAT_PROCEED."' />\n";
                echo "</form>\n";
                return;
        }

        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_TYPE."</b>\n";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        echo "<select name='room_type'>\n";
        echo "<option value='3'";
        if ($eroom[2]==3) echo " selected='selected'";
        echo ">"._AM_DHCHAT_ROOM_ALLUSER."</option>";
        echo "<option value='4'";
        if ($eroom[2]==4) echo " selected='selected'";
        echo ">"._AM_DHCHAT_ROOM_GROUPSONLY."</option>";
        echo "</select>";
        echo "</td></tr>\n";
        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_GROUP."</b>\n";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        print_exoops_groups($eroom[0]);
        echo "</td></tr>\n";
        echo "</table>\n";

        echo "</td></tr>\n";
        echo "</table>\n";
        echo "<br /><br /><input name='go' type='submit' value='"._AM_DHCHAT_PROCEED."' />\n";
        echo "</form>\n";
}

function make_newroom_form() {
        echo "<form name='editroom' method='post' action='rooms.php'>\n";
        echo "<input type='hidden' name='do' value='room_create' />";
        echo "<table border='0' cellpadding='0' cellspacing='0' align='center' width='100%'>\n";
        echo "<tr><td class='even'>\n";
        echo "<table border='0' cellpadding='4' cellspacing='1' align='center' width='100%'>\n";
        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_NAME."</b>\n";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        echo "<input name='room_name' type='text' size='30' maxlength='30' />\n";
        echo "</td></tr>\n";

        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_TYPE."</b>";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        echo "<select name='room_type'>\n";
        echo "<option value='3'>"._AM_DHCHAT_ROOM_ALLUSER."</option>";
        echo "<option value='4'>"._AM_DHCHAT_ROOM_GROUPSONLY."</option>";
        echo "</select>";
        echo "</td></tr>\n";

        echo "<tr><td align='left' valign='middle' width='20%' class='even'>\n";
        echo "<b>"._AM_DHCHAT_ROOM_GROUP."</b>";
        echo "</td>\n";
        echo "<td align='left' valign='middle' width='80%' class='odd'>\n";
        print_exoops_groups();
        echo "</td></tr>\n";
        echo "</table>\n";
        echo "</td></tr>\n";
        echo "</table>\n";
        echo "<br /><input type='submit' value='"._AM_DHCHAT_ADDROOM."' />\n";
        echo "</form>\n";
}

function save_room($id,$name,$type,$group) {
    global $xoopsDB;

    $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE rid = ".$id."");

    if ( $xoopsDB->getRowsNum($rc) == 0 ) {
        echo _AM_DHCHAT_WARNING._AM_DHCHAT_NOTFOUND;
        echo "<br /><br />\r\n";
        echo "<center><a href='rooms.php'>"._AM_DHCHAT_RINIT."</a></center>";
        exit();
    }
    $room = $xoopsDB->fetchRow($rc);
		$oldroom=$room[1];

    if ( $room[2] == 1 ||  $room[2] == 2) {
       $qc = $xoopsDB->query("UPDATE ".$xoopsDB->prefix("dhchat_rooms")." SET room_name = '".$name."' WHERE rid = ".$id);
    }

    if ( $room[2] == 3 ||  $room[2] == 4) {
        if ( $type == "1" || $type == "2" ) {
            echo _AM_DHCHAT_WARNING._AM_DHCHAT_TYPEMISMATCH;
            echo "<br /><br />\r\n";
            echo "<center><a href='rooms.php'>"._AM_DHCHAT_RINIT."</a></center>";
            return;
        }
        $qc = $xoopsDB->query("UPDATE ".$xoopsDB->prefix("dhchat_rooms")." SET room_name = '".$name."' , room_type = ".$type." WHERE rid =".$id);
    }
    if ( $type == "4" ) {
        $err = update_room_groups($id,$group);
        if ($err != 0) {
            echo _CHAT_GRPUPDATE;
        }
    }
    $qc = $xoopsDB->query("UPDATE ".$xoopsDB->prefix("dhchat_messages")." SET chatroom = '$name' WHERE chatroom = '$oldroom'");


    $err = $xoopsDB->error();
    if ( $err == 0 ) {
        echo sprintf(_AM_DHCHAT_RUPDATED, $name);
    } else {
        echo _AM_DHCHAT_RDBERR."<br /><br /><b>.$err.</b>";
    }
}

function print_exoops_groups($rid=-1) {
    global $xoopsDB;
    $rc = $xoopsDB->query("SELECT g.groupid, g.name, v.rid FROM ".$xoopsDB->prefix("groups")." as g LEFT OUTER JOIN ".$xoopsDB->prefix("dhchat_visibility")." as v ON g.groupid = v.groupid and v.rid = $rid");

    echo "<select name='room_group[]' multiple='yes'>";
    while ( $gn = $xoopsDB->fetchRow($rc) ) {
        echo "<option";
        if ($gn[2]==$rid) {
            echo " selected";
        }
        echo " value='{$gn[0]}'>".$gn[1]."</option>";
    }
    echo "</select>";
}

function update_room_groups($rid,$rmgroup=array()) {
    global $xoopsDB;

    //remove old room-group associations
    $qc = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("dhchat_visibility")." WHERE rid = $rid");

    if ($err = $xoopsDB->error()) return $err;

    // add new room-group associations
    if (count($rmgroup) > 0) {
        $valueslist = '';
        foreach ($rmgroup as $groupid) {
            $valueslist .= "(null,$rid,$groupid),";
        }
        $valueslist = substr($valueslist,0,-1);
        $err = $xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("dhchat_visibility")." VALUES $valueslist");

        if ($err = $xoopsDB->error()) return $err;
    }
    return 0;  // no error!
}

function delete_room($rname,$rcancel) {
    global $xoopsDB;

    $rc = $xoopsDB->query("SELECT room_type, room_name FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE rid = '$rname'");

    $isprinc = $xoopsDB->fetchRow($rc);
    
    if ( $isprinc[0] == 1 || $isprinc[0] == 2) {
        echo _AM_DHCHAT_WARNING._AM_DHCHAT_UNABLETOERASE;
        echo "<br /><br />\r\n";
        echo "<center><a href='rooms.php'>"._AM_DHCHAT_RINIT."</a></center>\r\n";
        return;
    }

    if ( $rcancel == 0 ) {
        echo sprintf(_AM_DHCHAT_SURETODELETE, $isprinc[1]);
        echo "<br /><br />\r\n";
        echo "<form action='rooms.php' name='delete_room' method='post'>";
        echo "<input type='hidden' name='do' value='room_delete' />";
        echo "<input type='hidden' name='cancel' value='1'>";
        echo "<input type='hidden' name='room_id' value='".$rname."' />";
        echo "<input type='submit' name='button' value='"._AM_DHCHAT_DELCONFIRM."' />";
        echo "</form>";
        echo "<a href='rooms.php'>[ "._AM_DHCHAT_RINIT." ]</a>";
    } else {
        if ( $isprinc[0] == "4" ) {
            $err = update_room_groups($rname);
            if ($err != 0) {
                echo _CHAT_GRPUPDATE;
            }
        }

     $qc = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE rid = ".$rname);
     $qc = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE chatroom = '".$isprinc[1]."'");


     $err = $xoopsDB->error();
        if ( $err == 0 ) {
            echo sprintf(_AM_DHCHAT_RDELETED, $isprinc[1]);
            echo "<br /><br />";
            echo "<a href='rooms.php'>"._AM_DHCHAT_RINIT."</a>";
        } else {
            echo _AM_DHCHAT_RDBERR."<br /><br /><b>.$err.</b>";
        }
    }
}

function create_room($rmname,$rmtype,$rmgroup) {
    global $xoopsDB;

    $proceed = true;
    if ( $rmtype == "1" ) {
       $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_type = 1");
       if ( $xoopsDB->getRowsNum($rc) == 0 ) {
            $proceed = true;
        } else {
            $proceed = false;
        }
    } elseif ( $rmtype == "2" ) {
       $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_type = 2");
       if ( $xoopsDB->getRowsNum($rc) == 0 ) {
            $proceed = true;
        } else {
            $proceed = false;
        }
    }

    $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("dhchat_rooms")." WHERE room_name = '$rmname'");

    if ( $xoopsDB->getRowsNum($rc) != 0 ) {
        $proceed = false;
    }

    if ( empty($rmname) ) {
        $proceed = false;
    }

    if ( empty($rmtype) ) {
        $proceed = false;
    }

    if ( $proceed == true ) {
        if (empty($rmgroup) || is_array($rmgroup)) {
        $qc = $xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("dhchat_rooms")." VALUES ('', '$rmname', '$rmtype')");
        $err = $xoopsDB->error();
            if ( $err != 0 ) {
                echo _AM_DHCHAT_RDBERR."<br /><br /><b>.$err.</b>";
            } elseif ($rmtype == "4") {
                $rmid = $xoopsDB->getInsertId();
                $err = update_room_groups($rmid,$rmgroup);
                if ($err != 0) {
                   echo _CHAT_GRPUPDATE;
                }
            }
            if ($err == 0) echo sprintf(_AM_DHCHAT_RCREATED, $rmname);
        }
        else {
            echo _CHAT_GRPARRAY;
        }
    } else {
        echo "<b>"._AM_DHCHAT_WARNING."</b>"._AM_DHCHAT_DEFECTION;
    }
}

function reset_messages($confirm) {
        global $xoopsDB;

        if ( $confirm == 0 ) {
                echo _AM_DHCHAT_MSURETODELETEALL;
                echo "<br /><br />\n";
                echo "[ <a href='messages.php?do=deleteall&ok=1'>"._AM_DHCHAT_MDELOK."</a> ]\n";
                echo " [ <a href='messages.php'>"._AM_DHCHAT_MINIT."</a> ]\n";
        }

        if ( $confirm == 1 ) {
        $xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE mid");
                $err = $xoopsDB->error();
                if ( $err == 0 ) {
                        echo _AM_DHCHAT_MDALL."\n";
                        echo "<br /><br />\n";
                        echo "[ <a href='messages.php'>"._AM_DHCHAT_MINIT."</a> ]\n";
                } else {
                        echo _AM_DHCHAT_RDBERR."<br /><br /><b>.$err.</b>\n";
                }
        }
}

function make_searchmessages_form() {
        echo "<form name='searchform' action='messages.php' method='GET'>\n";
        echo "<input name='do' type='hidden' value='"._AM_DHCHAT_MLIST."' />\n";
        echo "<input name='mode' type='hidden' value='date' />\n";
        echo _AM_DHCHAT_SEARCHCRITERIA."\n";
        echo "<br /><br />"._AM_DHCHAT_DFROM."&nbsp;\n";
        echo "<input name='datedfrom' type='text' maxlength='2' size='2' value='01' />\n";
        echo "<input name='datemfrom' type='text' maxlength='2' size='2' value='".date("m",time())."' />\n";
        echo "<input name='dateyfrom' type='text' maxlength='4' size='4' value='".date("Y",time())."' />\n";
        echo "&nbsp;"._AM_DHCHAT_DTO."&nbsp;\n";
        echo "<input name='datedto' type='text' maxlength='2' size='2' value='".date("d",time())."' />\n";
        echo "<input name='datemto' type='text' maxlength='2' size='2' value='".date("m",time())."' />\n";
        echo "<input name='dateyto' type='text' maxlength='4' size='4' value='".date("Y",time())."' />\n";
        echo "<br /><br /><input name='datego' type='submit' value='"._AM_DHCHAT_MLIST."' />\n";
        echo "</form>\n";
}

function searchmessages_list($smode,$dfrom,$mfrom,$yfrom,$dto,$mto,$yto,$orderby) {
        global $xoopsDB;

        if (empty($orderby)) {
                $orderby = "chatroom";
        }

        $tsfrom = mktime($mfrom,$dfrom,$yfrom);
        $tsto = mktime($mto,$dto,$yto);

        if ($smode == "") {
                $smode = "all";
        }

        if ($smode == "date") {
          $qc = "SELECT * FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE post_time BETWEEN $tsfrom AND $tsto";
        } else if ($smode == "today") {
				  $mins = mktime(0,0,0,date("m"),date("d"),date("Y"));
          $maxs = mktime(23,59,59,date("m"),date("d"),date("Y"));
          $qc = "SELECT * FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE post_time BETWEEN $mins AND $maxs";
        } else {
          if ($smode == "all") {
            $qc = "SELECT * FROM ".$xoopsDB->prefix("dhchat_messages")."";
          }
        }
        $qc .= " ORDER BY $orderby ASC";

        $rc = $xoopsDB->query($qc);

        if ( !$xoopsDB->getRowsNum($rc) == 0 ) {

                echo "<script language='JavaScript'>\n";
                echo "<!--\n";
                echo "        function doDelete(link) {\n";
                echo "                window.open(link,'_self');\n";
                echo "                opener = self;\n";
                echo "        }\n";
                echo "//-->\n";
                echo "</script>\n";

                echo "<table border=0 cellpadding=0 cellspacing=0 align='center' width='100%'>\n";
                echo "<tr><td class='bg2'>\n";
                echo "<table border=0 cellpadding=4 cellspacing=1 align='center' width='100%'>\n";
                echo "<tr>\n";
                echo "<td align='center' class='bg1' width='5%'>\n";
                echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&datedfrom=".$dfrom."&datemfrom=".$mfrom."&dateyfrom=".$yfrom."&datedto=".$dto."&datemto=".$mto."&dateyto=".$yto."&sort=mid&mode=".$smode."'>"._AM_DHCHAT_MID."</a> ]\n";
                echo "</td>\n";
                echo "<td align='center' class='bg3' width='15%'>\n";
                echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&datedfrom=".$dfrom."&datemfrom=".$mfrom."&dateyfrom=".$yfrom."&datedto=".$dto."&datemto=".$mto."&dateyto=".$yto."&sort=chatroom&mode=".$smode."'>"._AM_DHCHAT_MROOM."</a> ]\n";
                echo "</td>\n";
                echo "<td align='center' class='bg1' width='60%'>\n";
                echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&datedfrom=".$dfrom."&datemfrom=".$mfrom."&dateyfrom=".$yfrom."&datedto=".$dto."&datemto=".$mto."&dateyto=".$yto."&sort=message&mode=".$smode."'>"._AM_DHCHAT_MMSG."</a> ]\n";
                echo "</td>\n";
                echo "<td align='center' class='bg3' width='11%'>\n";
                echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&datedfrom=".$dfrom."&datemfrom=".$mfrom."&dateyfrom=".$yfrom."&datedto=".$dto."&datemto=".$mto."&dateyto=".$yto."&sort=poster&mode=".$smode."'>"._AM_DHCHAT_MPOSTEDBY."</a> ]\n";
                echo "</td>\n";
                echo "<td align='center' class='bg1' width='9%'>\n";
                echo "[ <a href='messages.php?do="._AM_DHCHAT_MLIST."&datedfrom=".$dfrom."&datemfrom=".$mfrom."&dateyfrom=".$yfrom."&datedto=".$dto."&datemto=".$mto."&dateyto=".$yto."&sort=post_time&mode=".$smode."'>"._AM_DHCHAT_MDATE."</a> ]\n";
                echo "</td>\n";
                echo "</tr>\n";
                $myts =& MyTextSanitizer::getInstance();
                while ( $msg = $xoopsDB->fetchRow($rc) ) {
                        echo "<tr>\n";
                        echo "<td align='center' class='even' width'5%'>\n";
                        echo $msg[0];
                        echo "</td>\n";
                        echo "<td align='left' class='even' width='15%'>\n";
                        echo $msg[1];
                        echo "</td>\n";
                        echo "<td align='left' class='even' OnMouseover=this.className='odd'\n";
                        echo " OnMouseout=this.className='even' width='60%' style='cursor: hand;'\n";
                        echo " OnClick=javascript:doDelete('messages.php?do=delete&id=".$msg[0]."&canc=0')> \n";
												echo $myts->displayTarea($msg[2]);
                        echo "</td>\n";
                        echo "<td align='center' class='even' width='11%'>\n";
                        echo $msg[3];
                        echo "</td>\n";
                        echo "<td align='right' class='even' width='9%'>\n";
                        echo date("d.m.Y", $msg[5])."<br />\n";
                        echo date("H:i:s", $msg[5]);
                        echo "</td>\n";
                        echo "</tr>\n";
                }

                echo "</table>\n";
                echo "</td></tr>\n";
                echo "</table>\n";
        } else {
                echo _AM_DHCHAT_MNOMESSAGES;
                echo "<br /><br />\n";
                echo "[ <a href='messages.php?do=search'>"._AM_DHCHAT_REPEATSEARCH."</a> ]\n";
                echo " [ <a href='messages.php'>"._AM_DHCHAT_MINIT."</a> ]\n";
        }
}

function searchmessages_delete($id,$confirmed) {
        global $xoopsDB;

if ( $confirmed == 1 ) {

$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("dhchat_messages")." WHERE mid='$id'");



                echo _AM_DHCHAT_MDELETED;
                echo "<br /><br />\n";
                echo "[ <a href='messages.php'>"._AM_DHCHAT_MCLOSEWIN."</a> ]\n";
        } else {
                echo _AM_DHCHAT_MERASECONFIRMATION;
                echo "<br /><br />\n";
                echo "[ <a href='messages.php?do=delete&id=".$id."&canc=1'>\n";
                echo _AM_DHCHAT_ERASEDEFINIT."</a> ]\n";
                echo " [ <a href='messages.php'>"._AM_DHCHAT_MCLOSEWIN."</a> ]\n";
        }
}

function ban_make_userslist() {
        global $xoopsDB,$qc,$rc;

        $rc = $xoopsDB->query("SELECT rank_id FROM ".$xoopsDB->prefix("ranks")." WHERE rank_title = 'Webmaster'");

        $cat = $xoopsDB->fetchArray($rc);

        $rc = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("users")."");


        echo "<center>\n";
        echo "<form name='banuser' action='banusers.php?do="._AM_XCHAT_BSELECT."' method='POST'>\n";
        echo _AM_XCHAT_BANAUSER."&nbsp;";
        echo "<select name='nick'>\n";
        while ( $user = $xoopsDB->fetchArray($rc) ) {
                if ( $user["rank"] != $cat["rank_id"] ) {
                        echo "<option>".$user['uname']."</option>\n";
                }
        }
        echo "</select>\n";
        echo "<br /><br /><input name='goban' type='submit' value='"._AM_XCHAT_CHATGO."' />\n";
        echo "</form>\n";
        echo "</center>\n";
}

function make_ban_form($user) {
        echo sprintf(_AM_XCHAT_BBAN, $user);
        echo "<form name='ban' action='banusers.php?do="._AM_XCHAT_BSET."&user=".$user."' method='POST'>\n";
        echo _AM_XCHAT_BFOR."&nbsp;";
        echo "<input name='bandays' type='text' maxlength='2' size='2' value='1' />\n";
        echo _AM_XCHAT_BDAYS."<br /><br />\n";
        echo "<input name='gobset' type='submit' value='"._AM_XCHAT_BANUSER."' />\n";
        echo "</form>\n";
}

function set_ban($user,$days) {
        global $xoopsDB,$qc,$rc,$timestamp;

        $today = $timestamp->evalDate(date("d"),date("m"),date("Y"));
        $expires = $timestamp->evalDate(date("d") + $days,date("m"),date("Y"));

        $qc = $xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("myxoopschat_banned")." VALUES ('', '$user', $today, $expires)");


        echo sprintf(_AM_XCHAT_BBANNED, $user).sprintf(_AM_XCHAT_BBANNEDTIME, $days);
        echo "<br /><br />[ <a href='banusers.php'>"._AM_XCHAT_BINIT."</a> ]\n";
}

function ban_make_bannedusers() {
        global $xoopsDB,$qc,$rc;

        $rc = $xoopsDB->query("SELECT DISTINCT bid,user FROM ".$xoopsDB->prefix("myxoopschat_banned")."");


        if ($xoopsDB->getRowsNum($rc) > 0) {
                echo "<center>\n";
                echo "<form name='unban' action='banusers.php?do="._AM_XCHAT_BDEL."' method='POST'>\n";
                echo "<select name='unbanuser'>\n";

                while ($banned = $xoopsDB->fetchRow($rc)) {
                        echo "<option>".$banned[1]."</option>\n";
                }

                echo "</select>\n";
                echo "<br /><br /><input name='gounban' type='submit' value='"._AM_XCHAT_CHATGO."' />\n";
                echo "</form>\n";
                echo "</center>\n";
        } else {
                echo _AM_XCHAT_NOUSERSBANNED;
        }
}

function rmv_ban($user) {
        global $xoopsDB,$qc,$rc;

        $qc = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("myxoopschat_banned")." WHERE user = '$user'");


        echo _AM_XCHAT_BREM."<br /><br />\n";
        echo "[ <a href='banusers.php'>"._AM_XCHAT_BINIT."</a> ]\n";
}

?>