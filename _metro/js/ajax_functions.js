function getXMLHTTPRequest() {
   var req =  false;
   try {
      /* for Firefox */
      req = new XMLHttpRequest(); 
   } catch (err) {
      try {
         /* for some versions of IE */
         req = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (err) {
         try {
            /* for some other versions of IE */
            req = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (err) {
            req = false;
         }
     }
   }
   
   return req;
}

function getServerTime() {
  var thePage = 'app.php';
  myRand = parseInt(Math.random()*999999999999999);
  var theURL = thePage +"?rand="+myRand;
  //var theURL = thePage;
  myReq.open("GET", theURL, true);
  myReq.onreadystatechange = theHTTPResponse;
  myReq.send(null);
}
function theHTTPResponse() {
  if (myReq.readyState == 4) {
    if(myReq.status == 200) {
       var timeString = myReq.responseXML.getElementsByTagName("timestring")[0];
       document.getElementById('show_id').innerHTML = timeString.childNodes[0].nodeValue;
    }
  } else {
    document.getElementById('show_id').innerHTML = '<img src="/_metro/board/ajax-loader.gif"/>';
  }
}

function getUserId() {
  var url = 'app-getid.php';
  var params = "search_email="+ encodeURI(document.getElementById('search_email').value);
  myReq.open("POST", url, true);
  myReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  myReq.setRequestHeader("Content-length", params.length);
  myReq.setRequestHeader("Connection", "close");
  myReq.onreadystatechange = searhIdHTTPResponse;
  myReq.send(params);
}
function searhIdHTTPResponse() {
  if (myReq.readyState == 4) {
    if(myReq.status == 200) {
       var idString = myReq.responseText;
       document.getElementById('show_id').innerHTML = idString;
    } else {
       document.getElementById('show_id').innerHTML = "응답에 문제가 있습니다.";
       }
  } else {
    document.getElementById('show_id').innerHTML = '<img src="/_metro/board/ajax-loader.gif"/>';
  }
}