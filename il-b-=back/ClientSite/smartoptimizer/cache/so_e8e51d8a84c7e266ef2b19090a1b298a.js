var flyingSpeed=25;var url_addProductToBasket='index.php';var url_removeProductFromBasket='index.php';var txt_totalPrice=get_word_txt_totalPrice();var txt_COIN_type=get_word_COIN_type();var shopping_cart_div=false;var flyingDiv=false;var currentProductDiv=false;var shopping_cart_x=false;var shopping_cart_y=false;var slide_xFactor=false;var slide_yFactor=false;var diffX=false;var diffY=false;var currentXPos=false;var currentYPos=false;var ajaxObjects=new Array();function shoppingCart_getTopPos(inputObj)
{var returnValue=inputObj.offsetTop;while((inputObj=inputObj.offsetParent)!=null){if(inputObj.tagName!='HTML')returnValue+=inputObj.offsetTop;}
return returnValue;}
function shoppingCart_getLeftPos(inputObj)
{var returnValue=inputObj.offsetLeft;while((inputObj=inputObj.offsetParent)!=null){if(inputObj.tagName!='HTML')returnValue+=inputObj.offsetLeft;}
return returnValue;}
function addToBasket(productId)
{if(!shopping_cart_div)shopping_cart_div=document.getElementById('shopping_cart');if(!flyingDiv){flyingDiv=document.createElement('DIV');flyingDiv.style.position='absolute';document.body.appendChild(flyingDiv);}
shopping_cart_x=shoppingCart_getLeftPos(shopping_cart_div);shopping_cart_y=shoppingCart_getTopPos(shopping_cart_div);currentProductDiv=document.getElementById('slidingProduct'+productId);currentXPos=shoppingCart_getLeftPos(currentProductDiv);currentYPos=shoppingCart_getTopPos(currentProductDiv);diffX=shopping_cart_x-currentXPos;diffY=shopping_cart_y-currentYPos;document.getElementById('addToBasketButton'+productId).innerHTML="<b><u>"+added_to_cart()+"</u></b>";setTimeout("remove_added( "+productId+" )",2000);var shoppingContentCopy=currentProductDiv.cloneNode(true);shoppingContentCopy.id='';flyingDiv.innerHTML='';flyingDiv.style.left=currentXPos+'px';flyingDiv.style.top=currentYPos+'px';flyingDiv.appendChild(shoppingContentCopy);flyingDiv.style.display='block';flyingDiv.style.width=currentProductDiv.offsetWidth+'px';flyToBasket(productId);}
function remove_added(productId)
{document.getElementById('addToBasketButton'+productId).innerHTML="<div id='addToBasketButton"+productId+"'><a href='javascript:void(0)' onclick=\"addToBasket("+productId+");return false\">"+AfterAddedToCart()+"</a></div>";}
function flyToBasket(productId)
{var maxDiff=Math.max(Math.abs(diffX),Math.abs(diffY));var moveX=(diffX/maxDiff)*flyingSpeed;;var moveY=(diffY/maxDiff)*flyingSpeed;currentXPos=currentXPos+moveX;currentYPos=currentYPos+moveY;flyingDiv.style.left=Math.round(currentXPos)+'px';flyingDiv.style.top=Math.round(currentYPos)+'px';if(moveX>0&&currentXPos>shopping_cart_x){flyingDiv.style.display='none';}
if(moveX<0&&currentXPos<shopping_cart_x){flyingDiv.style.display='none';}
if(flyingDiv.style.display=='block')setTimeout('flyToBasket("'+productId+'")',10);else ajaxAddProduct(productId);}
function showAjaxBasketContent(ajaxIndex)
{var itemBox=document.getElementById('shopping_cart_items');var productItems=ajaxObjects[ajaxIndex].response.split('|||');if(document.getElementById('shopping_cart_items_product'+productItems[0])){var row=document.getElementById('shopping_cart_items_product'+productItems[0]);var items=row.cells[0].innerHTML/1;items=items+1;row.cells[0].innerHTML=items;}else{var tr=itemBox.insertRow(-1);tr.id='shopping_cart_items_product'+productItems[0]
var td=tr.insertCell(-1);td.innerHTML='1';var td=tr.insertCell(-1);td.innerHTML=productItems[1];var td=tr.insertCell(-1);td.style.textAlign='right';td.innerHTML=productItems[2];var td=tr.insertCell(-1);var a=document.createElement('A');td.appendChild(a);a.href='javascript:void(0)';a.title='�����';a.onclick=function(){removeProductFromBasket(productItems[0]);};var img=document.createElement('IMG');img.src='http://ilbiz.co.il/ClientSite/other/sym_img/remove.gif';a.appendChild(img);}
updateTotalPrice();ajaxObjects[ajaxIndex]=false;}
function updateTotalPrice()
{var itemBox=document.getElementById('shopping_cart_items');var totalPrice=0;if(document.getElementById('shopping_cart_totalprice')){for(var no=1;no<itemBox.rows.length;no++){totalPrice=totalPrice+(itemBox.rows[no].cells[0].innerHTML.replace(/[^0-9]/g)*itemBox.rows[no].cells[2].innerHTML);}
document.getElementById('shopping_cart_totalprice').innerHTML=txt_totalPrice+totalPrice.toFixed(2)+" "+txt_COIN_type;}}
function removeProductFromBasket(productId)
{var productRow=document.getElementById('shopping_cart_items_product'+productId);var numberOfItemCell=productRow.cells[0];if(numberOfItemCell.innerHTML=='1'){productRow.parentNode.removeChild(productRow);}else{numberOfItemCell.innerHTML=numberOfItemCell.innerHTML/1-1;}
updateTotalPrice();ajaxRemoveProduct(productId);}
function ajaxValidateRemovedProduct(ajaxIndex)
{if(ajaxObjects[ajaxIndex].response!='OK')alert('Error while removing product from the database');}
function ajaxRemoveProduct(productId)
{var ajaxIndex=ajaxObjects.length;ajaxObjects[ajaxIndex]=new sack();ajaxObjects[ajaxIndex].requestFile=url_removeProductFromBasket;ajaxObjects[ajaxIndex].setVar('productIdToRemove',productId);ajaxObjects[ajaxIndex].onCompletion=function(){ajaxValidateRemovedProduct(ajaxIndex);};ajaxObjects[ajaxIndex].runAJAX();}
function ajaxAddProduct(productId)
{var ajaxIndex=ajaxObjects.length;ajaxObjects[ajaxIndex]=new sack();ajaxObjects[ajaxIndex].requestFile=url_addProductToBasket;ajaxObjects[ajaxIndex].setVar('productId',productId);ajaxObjects[ajaxIndex].onCompletion=function(){showAjaxBasketContent(ajaxIndex);};ajaxObjects[ajaxIndex].runAJAX();}