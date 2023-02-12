
	function can_i_del()  {
		aa = confirm("?האם את/ה בטוח/ה");
		if(aa == true)
			return true;
		else
			return false;
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
	
	
	function main(unk,ses,mainn)
	{
		var url = "ajax.php?main="+mainn+"&unk="+unk+"&sesid="+ses;  
		new Ajax.Updater("containerDiv", url, {asynchronous:true});
	}
