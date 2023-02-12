/**
 * @author Natanael Elhadad
 */
//////////////////////////// XML FUNCTIONS //////////////////////////
var verboseMode = false;
var timeForMsg = 4000;


if(typeof window.addEventListener != 'undefined'){
  IE = false;
} else {
  IE = true;
}

if(!IE){
	xsltProcessor = new XSLTProcessor();
	serializer = new XMLSerializer();
	xpe = new XPathEvaluator();
	DOMParser = new DOMParser();
} else {
	objXmlDocument =  new ActiveXObject("MSXML2.DOMDocument");
}

function getXmlDom(){
	if (IE) {
		return objXmlDocument.cloneNode(false);
	} else {
		return document.implementation.createDocument('','doc',null);
	}
}

function onloadDocument(xmlDom,func){
	if (IE) {
		xmlDom.onreadystatechange = func;
	} else {
		xmlDom.onload = func;
	}
}

function getNode(xmlDom,xPath){
	if (IE) {
		return xmlDom.selectSingleNode(xPath);
	} else {
		//var res = xmlDom.evaluate(xPath, xmlDom, null, XPathResult.ANY_TYPE, null);
    //return res.iterateNext();
    return evaluateXPath(xmlDom,xPath,false);
	}
}

function getNodes(xmlDom,xPath){
	if (IE) {
		return xmlDom.selectNodes(xPath);
	} else {
		//return xmlDom.evaluate(xPath, xmlDom, null, XPathResult.ANY_TYPE, null);
		return evaluateXPath(xmlDom,xPath,true);
	}
}

function getNodeText(xmlDom,xPath){
	if (IE) {
		return xmlDom.selectSingleNode(xPath).text;
	} else {
		return getNode(xmlDom,xPath).textContent;
	}
}

function getNodeXml(xmlDom,xPath){
	if (IE) {
		return xmlDom.selectSingleNode(xPath).xml;
	} else {
		return serializer.serializeToString(getNode(xmlDom,xPath));
	}
}

function getXml(xmlDom){
	if (IE) {
		return xmlDom.xml;
	} else {
		return serializer.serializeToString(xmlDom);
	}
}

function setNodeText(xmlNode,xPath,value){
	if (IE) {
		xmlNode.selectSingleNode(xPath).text = value;
	} else {
		getNode(xmlNode,xPath).textContent = value;
	}
}

function loadXML(xmlDom,xml){
	if (IE) {
		//return getXmlDom().loadXML(xml);
		xmlDom.loadXML(xml);
	} else {
		var temp = DOMParser.parseFromString(xml,"text/xml");
		var root = xmlDom.ownerDocument == null ? xmlDom.documentElement : xmlDom.ownerDocument.documentElement;
		if (root.firstChild) {
			root.replaceChild(temp.firstChild,root.firstChild);
		} else {
			root.appendChild(temp.firstChild);
		}
	}
}

function isNull(a) {
    return typeof a == 'object' && !a;
}

function getError(xmlNode){
	var err = getNode(xmlNode,"DIV");
	var res = "";
	if( err ){
		if (getNode(err,"@function")){
			res = eval ( getNodeText(err,"@function") + "('" + getNodeText(err,".") + "')" ); 
		} else {
			res = getNodeText(err,".");
		}
	}
	
	if ( res != "" ){
		showMsg("",res);
		return true;
	} else {
		return false;
	}
	/*
	if (verboseMode) {
		if ( res != "" ){
			alert( res );
			return true;
		}
		return false;
	} else {
		if ( res != "" ){
			alert( res );
			return true;
		}
		return res;
	}
	*/
}

function evalMsg(msg){
	return eval(msg);
}

function evaluateXPath(aNode,aExpr,deep) {

  var nsResolver = xpe.createNSResolver(aNode.ownerDocument == null ?
	aNode.documentElement : aNode.ownerDocument.documentElement);
  var result = xpe.evaluate(aExpr, aNode, nsResolver, 0, null);
  
  if (deep){
		var found = [];
		while (res = result.iterateNext()){
			found.push(res);
		}
		return found;
  } else {
		return result.iterateNext();
  }
  
}

function getElementsByXpath(xPath){
	//"count(//p)" sample ...
	var res = document.evaluate(xPath, document, null, XPathResult.ANY_TYPE, null);
		var found = [];
		while (res = result.iterateNext()){
			found.push(res);
		}
		return found;
}

function transform(xmlDom,xslDom){
	var res = null;
	if (IE){
        res = xmlDom.transformNode(xslDom);
	} else {
		try {
           xsltProcessor.reset();
           xsltProcessor.importStylesheet(xslDom);
        } catch(e){
           alert("Error importStylesheet:"+e.description);
           return null;
        }
        res = xsltProcessor.transformToFragment(xmlDom, document);
	}
	return res;
}

//////////////////////////// XML FUNCTIONS //////////////////////////


//////////////////////////// COMMON FUNCTIONS //////////////////////////

function recalcWindow(){
if(IE){
	window.document.recalc(); 
  } else {
			
  }
}


function XBrowserAddHandler(target,eventName,handlerName) { 
  if ( target.addEventListener ) { 
    target.removeEventListener(eventName, function(e){target[handlerName](e);}, false);
    target.addEventListener(eventName, function(e){target[handlerName](e);}, false);
  } else if ( target.attachEvent ) { 
    target.attachEvent("on" + eventName, function(e){target[handlerName](e);});
  } else { 
    var originalHandler = target["on" + eventName]; 
    if ( originalHandler ) { 
      target["on" + eventName] = function(e){originalHandler(e);target[handlerName](e);}; 
    } else { 
      target["on" + eventName] = target[handlerName]; 
    } 
  } 
}

function showMsg(showFlag,msg){
	if ( showFlag != "" ){
		if (showFlag){
			alert(msg);
			return;
		}
	} else {
		if(verboseMode){
			alert(msg);
			return;
		}
	}
	msgWindow.innerHTML = msg;
	msgWindow.style.display = "";
	setTimeout("msgWindow.style.display='none'",timeForMsg);
}

function zeroFilled(inValue) {
  if (inValue > 9) {
      return inValue
  }
  return "0" + inValue
}


function Trim(sString){
  return rightTrim(leftTrim(sString));
}

function leftTrim(sString){
  while (sString.substring(0,1) == ' '){
    sString = sString.substring(1, sString.length);
  }
  return sString;
}

function rightTrim(sString){
  while (sString.substring(sString.length-1, sString.length) == ' '){
    sString = sString.substring(0,sString.length-1);
  }
  return sString;
}

/////////////////////////// ---------- objects -----------------------------------/////////////////////

InitHtmlObject = function(
	urlXml,
	xPath,
	nodeText,
	nodeId,
	parentElement,
	className,
	htmlId,
	xPathFilter,
	event,
	createFunc,
	onDone)
{
    // Params:
    // urlXml - for getting the xml from 
    // xPath -  for node loop 
    // nodeText - for text 
    // nodeId - for value or id 
    // parentElement - html element list names sperated with "," for adding the new html element into .
    // className - for CSS
    // selectionName - html element ID 
    // xPathFilter - for filter the list 
    // event - function to do on click or on change depends on the html element.
    // createFunc - function to run when the xml data is ready to parse .
    // onDone - an extern function to call when the html is constructed .
    // The object is loading the xml from the url and runs over the functions array to draw the html from the xml data .
    // The getXmlDomDoc function returns the xml dom doc data  for further use in this page .
    
    // To Do :
    // To add  a send() function to reload the xml data from the server .
    // To add  a transfrom() function that gets a xsl and transform it from the xml .
    // To add more html draw fucntions .
    
    var xmlDomDoc = getXmlDom();
    var functions = createFunc.split(",");
    var parentElements = parentElement.split(",");
    var xPath = xPath;
    var nodeText = nodeText;
    var nodeId = nodeId;
    var classNames = className.split(",");
    var htmlIds = htmlId.split(",");
    var xPathFilter = xPathFilter;
    var events = event;
    var onDones = onDone.split(",");
    var xmlDoneFlag = 0;
    var urlXml = urlXml;
    var count = 0;
    
    // For further use for extend Options to use .
    //options = options || {};
    //var extendOptions = Object.extend({}, options || {});
    
    var done = function (){
      if (IE){
        if (xmlDomDoc.readyState != 4 ) return false;
      }
      xmlDoneFlag = 1;
      for (count;count<=functions.length-1;count++){
        if ( eval(functions[count]) ){
          if (onDones[count] != ""){
            eval(onDones[count]);
          } 
        } 
      }
    }
    
    onloadDocument(xmlDomDoc,done);
    xmlDomDoc.load(urlXml);
    
    this.getXmlDomDoc = function (){
      if (xmlDoneFlag){
        return xmlDomDoc;
      } else {
        return null;
      }
    }
    
    var createCombo = function() {
        document.getElementById(parentElements[count]).innerHTML = "";
        var selection = document.getElementById(parentElements[count]).appendChild(document.createElement("SELECT"));
        if (events.length > 0){
          if (typeof events[count] == "function"){
            selection.changeHandler = events[count];
            XBrowserAddHandler(selection,"change","changeHandler") ;
          }
        }
        selection.name = htmlIds[count];
        selection.id = htmlIds[count];
        selection.className = classNames[count];
        var nodes = getNodes(xmlDomDoc,xPath);
        for (var x=0;x<nodes.length;x++){
          flag = xPathFilter != ""?getNode(nodes[x],xPathFilter):true;
          if (flag){
            var oOption = document.createElement("OPTION");
            selection.options.add(oOption); 
            oOption.innerHTML = getNodeText(nodes[x],nodeText);
            oOption.title = getNodeText(nodes[x],nodeText);
            oOption.value = getNodeText(nodes[x],nodeId);
          }
        }
        return true;
    }
    
    // TO DO : to create the check box dynamicly and not by HTML string .
    // for now used just one for specified element so no rush .
    var createCheckBox = function(htmlElement){
      var list = "<INPUT onclick='filterLocators(this);' TYPE=CHECKBOX CHECKED all='true'>All locators";
      var nodes = getNodes(xmlDomDoc,xPath);
      for (var x=0;x<nodes.length;x++){
          if (getNode(nodes[x],xPathFilter)){
              name = getNodeText(nodes[x],nodeText);
              list += "<BR><INPUT all='false' typeName='" + name + "' onclick='filterLocators(this);'  TYPE=CHECKBOX CHECKED>"  + name ;
          }
      }
      document.getElementById(parentElements[count]).innerHTML = list;
      return true;
    }
}