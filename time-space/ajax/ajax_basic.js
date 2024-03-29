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
    document.getElementById('show_id').innerHTML = '<img src="/time-space/ajax/ajax-loader.gif"/>';
  }
}