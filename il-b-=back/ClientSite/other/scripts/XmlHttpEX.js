var objHTTPGetXmlHttp = new XMLHttpRequest();

function GetXmlHttp(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.open("POST", aspPage, false);
    } catch (e) {
        alert("GetXmlHttp:" + e.description);
    }
    
    try {
        objHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.send(xmlRequest);
        var szReply = objHTTP.responseXML;
    } catch (e) {
        alert("GetXmlHttp:" + e.description);
    }
    
    return szReply;
}

function GetXmlHttpPost(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.open("POST", aspPage, false);
    } catch (e) {
        alert("GetXmlHttp:" + e.description);
    }
    
    try {
        objHTTP.send(xmlRequest);
        var szReply = objHTTP.responseXML;
		} catch (e) {
        alert("GetXmlHttpPost:" + e.description);
    }
    
    return szReply;
}

function GetTextHttp(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
	objHTTP.open("POST", aspPage, false);
    } catch (e) {
        alert(e.description);
    }
	
    try {
        objHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.send(xmlRequest);
        var szReply = objHTTP.responseText;
    } catch (e) {
        alert(e.description);
    }
    
    if (objHTTP.status != 200){
        szReply = "" + objHTTP.statusText;
    }
    return szReply;
}  

function GetXmlHttpASC(xmlRequest,aspPage){
    var objHTTP = new XMLHttpRequest();
	
	try {	
		objHTTP.open("POST", aspPage, true);
    } catch (e) {
		alert(e.description);
    }
	
    try {
        objHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.send(xmlRequest);
    } catch (e) {
        alert(e.description);
    }
    return objHTTP;
}

function GetXmlHttpByParams(xmlRequest,aspPage,method,async){
    if (async){
      var objHTTP = new XMLHttpRequest();
    } else {
      var objHTTP = objHTTPGetXmlHttp;
    }
    
    try {	
		if (method == "GET"){
          objHTTP.open(method, aspPage + xmlRequest, async);
        } else {
          objHTTP.open(method, aspPage, async);
        }
    } catch (e) {
        showMsg( "", "Error:GetXmlHttpByParams:open:"+e.description);
        return null;
    }
	
    try {
        objHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.send(xmlRequest);
    } catch (e) {
        showMsg( "", "Error:GetXmlHttpByParams:send:"+e.description);
        return null;
    }
    
    if (async){
      return objHTTP.responseXML;
    } else {
      if (objHTTP.status != 200){
        var szReply = "" + objHTTP.statusText;
      } else {
        var szReply = objHTTP.responseXML;
      }
      return szReply;
    }
}

function GetXmlHttpEX(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.open("GET", aspPage + xmlRequest, false);
    } catch (e) {
        alert("Error in Open:" + e.description);
        return;
    }
    
    try {
        objHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");    
        objHTTP.send(xmlRequest);
        var szReply = objHTTP.responseXML;
    } catch (e) {
        alert("Error in Send:" + e.description);
        return;
    }
    
    if (objHTTP.status != 200){
        szReply = "" + objHTTP.statusText;
    }
    return szReply;
}
