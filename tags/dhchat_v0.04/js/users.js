var GetChaturl = "users.php";
var lastID = -1; //initial value will be replaced by the latest known id
window.onload = chatinit;

function chatinit() {
	receiveChatText(); //initiates the first data query
}

function receiveChatText() {
	if (httpReceiveChat.readyState == 4 || httpReceiveChat.readyState == 0) {
	  httpReceiveChat.open("GET",GetChaturl, true);
    httpReceiveChat.onreadystatechange = handlehHttpReceiveChat; 
  	httpReceiveChat.send(null);
	}
}

function handlehHttpReceiveChat() {
  if (httpReceiveChat.readyState == 4) {
    top.MainFrame.UserFrame.document.getElementById('dhchat_user').innerHTML = httpReceiveChat.responseText;  
    setTimeout('receiveChatText();',10000); //executes the next data query in 10 seconds
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

var httpReceiveChat = getHTTPObject();


