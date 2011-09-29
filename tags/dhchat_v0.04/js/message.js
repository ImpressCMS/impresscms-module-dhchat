var GetChaturl = "message.php";
var lastID = -1; //initial value will be replaced by the latest known id
window.onload = chatinit;

function chatinit() {
	receiveChatText(); //initiates the first data query
}

function receiveChatText() {
	if (httpReceiveChat.readyState == 4 || httpReceiveChat.readyState == 0) {
	  httpReceiveChat.open("GET",GetChaturl + '?lastID=' + lastID + '&rand='+Math.floor(Math.random() * 1000000), true);
    httpReceiveChat.onreadystatechange = handlehHttpReceiveChat; 
  	httpReceiveChat.send(null);
	}
}

function handlehHttpReceiveChat() {
  if (httpReceiveChat.readyState == 4) {
	  
	  if (httpReceiveChat.responseText.length>0) {
      top.MainFrame.MessageFrame.document.getElementById('dhchat_msg').innerHTML = httpReceiveChat.responseText;
      if (Msg_Sort == 1) {
        window.scrollBy(0,9999999);
      }
    }
    setTimeout('receiveChatText();',1000); //executes the next data query in 4 seconds
  }
}


//initiates the XMLHttpRequest object
//as found here: http://www.webpasties.com/xmlHttpRequest
function getHTTPObject() {
  var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
  @else
  xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function getCookie(name) {
   var prefix = name + "="
   var cookieStartIndex = document.cookie.indexOf(prefix)
   if (cookieStartIndex == -1)
                return null
   var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length)
   if (cookieEndIndex == -1)
                cookieEndIndex = document.cookie.length						
   return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex))
}

var httpReceiveChat = getHTTPObject();
if (getCookie("dhchat_para")) {
  clist = getCookie("dhchat_para");
	carr = clist.split("|");
	var Msg_Sort = carr[0];
} else {
	var Msg_Sort = 0;
}

