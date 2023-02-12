function DisplayColorWindow(name_form){
		
        //mode : BG, FG
        var mywin = window.open("about:blank", "wincolor", "width=550,height=120,toolbar=no,location=no,menubar=no,status=no,scrollbars=no,resizable=no");
        var myDoc = mywin.document;

        //color table
        colors = new Array('0','3','6','9','C','F');

        strColorTable = "<TABLE onclick='assign();' onmouseover='toggleClass();' onmouseout='toggleClass();' WIDTH=100% CELLPADDING=0 CELLSPACING=0 BORDER=0>"
        for(i=0;i<colors.length;i++){
                strColorTable += "<TR>"
                for(j=0;j<colors.length;j++){
                        for(k=0;k<colors.length;k++){
                                strColorTable += "<TD class=col bgcolor=#"+colors[k]+colors[k]+colors[i]+colors[i]+colors[j]+colors[j]+">&nbsp;</TD>"
                        }
                }
                strColorTable += "</TR>"
        }
        strColorTable += "</TABLE>"


        myDoc.open("text/html");
        myDoc.write("<HTML><HEAD></HEAD>"+
        "<STYLE>TD{font-size:10pt;}.col{border:solid 1px buttonface;cursor:hand;}.colO{cursor:hand;border:solid 1px black;}</STYLE>"+
        "<SCRIPT>\n<!--\n"+
        "function toggleClass(){\n"+
        "        var el = window.event.srcElement;if(el.className=='col'){el.className='colO'}else if(el.className=='colO'){el.className='col'}\n"+
        "}\n"+
        "function assign(){\n"+
        "        var el = window.event.srcElement;if(el.className=='col'||el.className=='colO'){window.opener.choose_color("+name_form+");}\n"+
        "}\n--></SCR"+"IPT></TABLE>"+
        "<BODY bgcolor=buttonface topmargin=2 leftmargin=2 style='border:none;font-family:verdana;font-size:10pt;letter-spacing:-0.5pt' onselectstart='return false'>"+
        strColorTable+
        "</BODY></HTML>");
        myDoc.close();

        myDoc.title = "בחר/י צבע";

}

function choose_color(name_form)   {

	var mainPage = opener.document.form_page_update_add;
	mainPage.name_form.value = aa;
	
	opener.focus();
	self.close();
}


	function colors(name,page){
		popup = window.open("choose_color.php?page="+page+"&name="+name+"","","height=400,width=583,scrollbars=yes");
	}
	
	function AddText(AT)	{
		document.text_update_form.content.focus(); 
		document.selection.createRange().text=AT;
	}
	
	function moreDate(id1,id2)
	{
			obj = document.getElementById(id2).style.display;		
			document.getElementById(id2).style.display=(obj?"":"none")		
			
			if (obj)
				document.getElementById(id1).className='maintextBold';	
			else
				document.getElementById(id1).className='maintext';			
	}

                                    
function autotab(original,destination){
if (original.getAttribute&&original.value.length==original.getAttribute("maxlength"))
destination.focus()
}


function more_links_adv_settings_open(id1)
	{
			obj = document.getElementById(id1).style.display;		
			document.getElementById(id1).style.display=(obj?"":"none")		
			
			if (obj)
				document.getElementById(id1).style.display='';	
			else
				document.getElementById(id1).style.display='none';			
	}