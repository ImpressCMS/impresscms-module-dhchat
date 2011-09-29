<?php
include "../../mainfile.php";
if ( file_exists("language/".$xoopsConfig['language']."/help.php") ) {
	include("language/".$xoopsConfig['language']."/help.php");
} else {
	include("language/english/help.php");
}
xoops_header(false);
// show javascript close button?
?>
<table border="0" width="250" align="center">
  <th><div align="center"><?php echo _HLP_DHCHAT_TITLE;?></div></th>
</table>
<table border="1" width="250" align="center" cellspacing="5" cellpadding="5">
  <tr>
     <td class="odd" align="center" nowrap><b>/kick</b> <i>Username</i></td>
     <td><?php echo _HLP_DHCHAT_KICK;?></td>
  </tr>
  <tr>
     <td class="odd" align="center" nowrap><b>/kicktime xxx</b> <i>Username</i></td>
     <td><?php echo _HLP_DHCHAT_KICKTIME;?></td>
  </tr>
  <tr>
     <td class="odd" align="center" nowrap><b>/kickday xxx</b> <i>Username</i></td>
     <td><?php echo _HLP_DHCHAT_KICKDAY;?></td>
  </tr>
</table>
<br /><br />
<?php
echo '<div style="text-align:center;"><input class="formButton" value="'._CLOSE.'" type="button" onclick="javascript:window.close();" /></div>';
xoops_footer();
?>