
var objHTTPGetXmlHttp = new ActiveXObject("MSXML2.XMLHTTP");

function GetXmlHttpPost(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.Open("POST", aspPage, false);
    } catch (e) {
        alert("GetXmlHttpPost:" + e.description);
    }
    
    try {
        objHTTP.Send(xmlRequest);
        var szReply = objHTTP.responseXml;
    } catch (e) {
        alert("GetXmlHttpPost:" + e.description);
    }
    
    return szReply;
}

function GetXmlHttp(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.Open("POST", aspPage, false);
    } catch (e) {
        alert("GetXmlHttp:" + e.description);
    }
    
    try {
        objHTTP.SetRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.Send(xmlRequest);
        var szReply = objHTTP.responseXml;
    } catch (e) {
        alert("GetXmlHttp:" + e.description);
    }
    
    return szReply;
}

function GetTextHttp(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
	objHTTP.Open("POST", aspPage, false);
    } catch (e) {
        alert(e.description);
    }
	
    try {
        objHTTP.SetRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.Send(xmlRequest);
        var szReply = objHTTP.ResponseText;
    } catch (e) {
        alert(e.description);
    }
    
    if (objHTTP.status != 200){
        szReply = "" + objHTTP.statusText;
    }
    return szReply;
}  

function GetXmlHttpASC(xmlRequest,aspPage){
    var objHTTP = new ActiveXObject("MSXML2.XMLHTTP");
    try {	
	objHTTP.Open("POST", aspPage, true);
    } catch (e) {
	alert(e.description);
    }
	
    try {
        objHTTP.SetRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        objHTTP.Send(xmlRequest);
    } catch (e) {
        alert(e.description);
    }
    return objHTTP;
}

function GetXmlHttpEX(xmlRequest,aspPage){
    var objHTTP = objHTTPGetXmlHttp;
    try {	
        objHTTP.Open("GET", aspPage + xmlRequest, false);
    } catch (e) {
        alert("Error in Open:" + e.description);
        return;
    }
    
    try {
        objHTTP.SetRequestHeader("Content-Type", "application/x-www-form-urlencoded");    
        objHTTP.Send(xmlRequest);
        var szReply = objHTTP.responseXml;
    } catch (e) {
        alert("Error in Send:" + e.description);
        return;
    }
    
    if (objHTTP.status != 200){
        szReply = "" + objHTTP.statusText;
    }
    return szReply;
}