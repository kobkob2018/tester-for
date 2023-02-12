/***********************************************
* Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/
var delayb4scroll=3000
var marqueespeed=1
var pauseit=1
var copyspeed=marqueespeed
var pausespeed=(pauseit==0)?copyspeed:0
var actualheight=''
function scrollmarquee(){if(parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px"
else
cross_marquee.style.top=parseInt(marqueeheight)+8+"px"}
function initializemarquee(){cross_marquee=document.getElementById("vmarquee")
cross_marquee.style.top=0
marqueeheight=document.getElementById("marqueecontainer").offsetHeight
actualheight=cross_marquee.offsetHeight
if(window.opera||navigator.userAgent.indexOf("Netscape/7")!=-1){cross_marquee.style.height=marqueeheight+"px"
cross_marquee.style.overflow="scroll"
return}
setTimeout('lefttime=setInterval("scrollmarquee()",30)',delayb4scroll)}
if(window.addEventListener)
window.addEventListener("load",initializemarquee,false)
else if(window.attachEvent)
window.attachEvent("onload",initializemarquee)
else if(document.getElementById)
window.onload=initializemarquee
var oMarquees=[],oMrunning,oMInterv=20,oMStep=1,oStopMAfter=0,oResetMWhenStop=false,oMDirection='right';function doMStop(){clearInterval(oMrunning);for(var i=0;i<oMarquees.length;i++){oDiv=oMarquees[i];oDiv.mchild.style[oMDirection]='0px';if(oResetMWhenStop){oDiv.mchild.style.cssText=oDiv.mchild.style.cssText.replace(/;white-space:nowrap;/g,'');oDiv.mchild.style.whiteSpace='';oDiv.style.height='';oDiv.style.overflow='';oDiv.style.position='';oDiv.mchild.style.position='';oDiv.mchild.style.top='';}}
oMarquees=[];}
function doDMarquee(){if(oMarquees.length||!document.getElementsByTagName){return;}
var oDivs=document.getElementsByTagName('div');for(var i=0,oDiv;i<oDivs.length;i++){oDiv=oDivs[i];if(oDiv.className&&oDiv.className.match(/\bdmarquee\b/)){if(!(oDiv=oDiv.getElementsByTagName('div')[0])){continue;}
if(!(oDiv.mchild=oDiv.getElementsByTagName('div')[0])){continue;}
oDiv.mchild.style.cssText+=';white-space:nowrap;';oDiv.mchild.style.whiteSpace='nowrap';oDiv.style.height=oDiv.offsetHeight+'px';oDiv.style.overflow='hidden';oDiv.style.position='relative';oDiv.mchild.style.position='absolute';oDiv.mchild.style.top='0px';oDiv.mchild.style[oMDirection]=oDiv.offsetWidth+'px';oMarquees[oMarquees.length]=oDiv;i+=2;}}
oMrunning=setInterval('aniMarquee()',oMInterv);if(oStopMAfter){setTimeout('doMStop()',oStopMAfter*1000);}}
function aniMarquee(){var oDiv,oPos;for(var i=0;i<oMarquees.length;i++){oDiv=oMarquees[i].mchild;oPos=parseInt(oDiv.style[oMDirection]);if(oPos<=-1*oDiv.offsetWidth){oDiv.style[oMDirection]=oMarquees[i].offsetWidth+'px';}else{oDiv.style[oMDirection]=(oPos-oMStep)+'px';}}}
if(window.addEventListener){window.addEventListener('load',doDMarquee,false);}else if(document.addEventListener){document.addEventListener('load',doDMarquee,false);}else if(window.attachEvent){window.attachEvent('onload',doDMarquee);}