
	function can_i_del()  {
		aa = confirm("?האם את/ה בטוח/ה");
		if(aa == true)
			return true;
		else
			return false;
	}
	
	function colors(name,page){
		popup = window.open("../ClientSite/administration/choose_color.php?page="+page+"&name="+name+"","","height=400,width=583,scrollbars=yes");
	}
	
	function from_form(ses,mainn)
	{
		if( mainn == "net_banners" )
		{
			main(ses,"select_banner",mainn,"&storge_type=" + document.sinon_by_banner_form.storge_type.value);
		}
		
		
		if( mainn == "net_search_sites" )
		{
			storge_type = document.search_site_form.storge_type.value; 
			bannaer_id = document.search_site_form.bannaer_id.value; 
			search_name = document.search_site_form.search_name.value; 
			search_domain = document.search_site_form.search_domain.value; 
			
			main(ses,"select_site","net_banners","&storge_type=" + storge_type + "&bannaer_id=" + bannaer_id + "&search_name=" + search_name + "&search_domain=" + search_domain);
		}
		
	}
	
	function main(ses,todo,mainn,moree)
	{
		var url = "ajax.php?main="+mainn+"&todo="+todo + moree +"&sesid="+ses;  
		new Ajax.Updater("containerDiv", url, {asynchronous:true});
	}
	
	
	function net_del_belong_banner( banner_id , user_unk , sesid)
	{
		
			var url = "ajax.php?main=net_del_belong_banner&banner_id="+banner_id +"&user_unk="+ user_unk +"&sesid="+sesid;  
			new Ajax.Updater("net_del_belong_banner_" + user_unk, url, {asynchronous:true});
		
	}
	
	
	function lead__update_user_tashlom( tashlom_id , unk , sesid)
	{
			new_paid = document.getElementById('new_paid_'+tashlom_id).value;
			
			var url = "ajax.php?main=lead__update_user_tashlom&tashlom_id="+tashlom_id +"&unk="+ unk + "&new_paid="+ new_paid +"&sesid="+sesid;  
			new Ajax.Updater("tashlom_" + tashlom_id, url, {asynchronous:true});
	}
	
	function lead__new_user_tashlom( unk , sesid)
	{
			paid = document.form_new_tashlom.paid.value;
			price = document.form_new_tashlom.price.value;
			
			var url = "ajax.php?main=lead__new_user_tashlom&paid="+paid +"&price="+price +"&unk="+ unk + "&sesid="+sesid;  
			new Ajax.Updater("addNewTashlom", url, {asynchronous:true});
			
			setTimeout("remove_added_tashlom()",3000);
	}
	
	
	function remove_added_tashlom()
	{
		document.getElementById('addNewTashlom').innerHTML = '';
		document.form_new_tashlom.reset();
	}
	
	
	function createMysaveForm()
	{
		sesid = document.formi.sesid.value;
		
		cat = document.formi.cat.value;
		if( cat == "" )
		{
			alert('תחום שדה חובה');
		}
		else
		{
			city = document.formi.city.value;
			color = document.formi.color.value;
			tatcat = document.formi.tatcat.value;
			
			var url = "ajax.php?main=createMysaveForm&cat="+cat+"&city="+city+"&color="+color+"&tatcat="+tatcat+"&sesid="+sesid;  
			new Ajax.Updater("formContent", url, {asynchronous:true});
		}
	}
	
	
	function createMysaveFinel()
	{
		sesid = document.createMysaveForm_form.sesid.value;
		
		cat = document.createMysaveForm_form.cat.value;
		city = document.createMysaveForm_form.city.value;
		color = document.createMysaveForm_form.color.value;
		tatcat = document.createMysaveForm_form.tatcat.value;
		
		var url = "ajax.php?main=createMysaveFinel&cat="+cat+"&city="+city+"&color="+color+"&tatcat="+tatcat+"&sesid="+sesid;  
		new Ajax.Updater("formContent", url, {asynchronous:true});
	}
	
	
	function tesk_mission(sesid)
	{
			var url = "ajax.php?main=task_home&sesid="+sesid;  
			new Ajax.Updater("task_homepage", url, {evalScripts:true});
	}
	
	function addNew_tesk_mission(sesid)
	{
			var url = "ajax.php?main=addNewTask&sesid="+sesid;  
			new Ajax.Updater("task_homepage__new_task", url, {evalScripts:true});
	}
	
	function addNew_tesk_mission_Close(sesid)
	{
			var url = "ajax.php?main=close&sesid="+sesid;  
			new Ajax.Updater("task_homepage__new_task", url, {evalScripts:true});
	}
	
	function addnewtaskDb()
	{

		var okowner = true;
		if(jQuery('.reciverRadio:checked').length == 0){
			alert("אנא בחר אחראי משימה");
			return;
		}
		if(jQuery('.task_ownerCheck:checked').length == 0){
			alert("אנא הוסף משתמשים לטיפול");
			return;
		}		
		var url = "ajax.php";  
		var params = Form.serialize($('addNewMission')); 
		new Ajax.Updater("task_homepage__new_task", url, {method:'post', parameters: params,evalScripts:true} );
	}
	
	function showTaskesList(sesid , work_status )
	{
			var url = "ajax.php?main=showTaskesList&work_status=" + work_status + "&sesid="+sesid;  
			new Ajax.Updater("showTaskesList", url, {evalScripts:true});
	}
	
	function updateTaskStatus(sesid , task_id )
	{
		var url = "ajax.php";  
		var params = Form.serialize($('updateTaskStatusForm_'+task_id)); 
		new Ajax.Updater("updateTaskStatus", url, {method:'post', parameters: params,evalScripts:true} );
	}
	
	function task_moreDate(id1,id2,sesid,task_id)
	{
		obj = document.getElementById(id1).className;		
		if( obj == "tesk_subject_tr_open" )
		{
			document.getElementById(id1).className='tesk_subject_tr_close';
			
			var url = "ajax.php?main=close&sesid="+sesid;
			new Ajax.Updater("TaskMoreData_" + task_id , url, {evalScripts:true} );
		}
		else
		{
			document.getElementById(id1).className='tesk_subject_tr_open';
			
			var url = "ajax.php?main=TaskMoreData&task_id=" + task_id + "&sesid="+sesid;  
			new Ajax.Updater("TaskMoreData_" + task_id , url, {evalScripts:true} );
		}
	}
	
	function task_edit_data(id1,id2,sesid,task_id)
	{
		obj = document.getElementById(id1).className;		
		if( obj == "tesk_subject_tr_open_edit" )
		{
			document.getElementById(id1).className='tesk_subject_tr_close';
			
			var url = "ajax.php?main=close&sesid="+sesid;
			new Ajax.Updater("TaskEditData_" + task_id , url, {evalScripts:true} );
		}
		else
		{
			document.getElementById(id1).className='tesk_subject_tr_open_edit';
			
			var url = "ajax.php?main=TaskEditData&task_id=" + task_id + "&sesid="+sesid;  
			new Ajax.Updater("TaskEditData_" + task_id , url, {evalScripts:true} );
		}
	}
	
	function taskViewedMsgIcon(sesid , task_id )
	{
		var url = "ajax.php?main=taskViewedMsgIcon&task_id=" + task_id + "&sesid="+sesid;  
		new Ajax.Updater("msg_viewed_icon_" + task_id , url, {evalScripts:true} );
	}
	
	function showTaskesHoursList(sesid , task_id )
	{
		var url = "ajax.php?main=showTaskesHoursList&task_id=" + task_id + "&sesid="+sesid;  
		new Ajax.Updater("showTaskesHoursList_" + task_id , url, {evalScripts:true} );
	}
	
	function DELTaskesHours(sesid , task_id , hour_id )
	{
		var url = "ajax.php?main=DELTaskesHours&task_id=" + task_id + "&sesid="+sesid + "&hour_id=" + hour_id;  
		new Ajax.Updater("showTaskesHoursList_" + task_id , url, {evalScripts:true} );
	}
	
	function AddTaskesHours(sesid , task_id )
	{
		var url = "ajax.php?main=DELTaskesHours&task_id=" + task_id + "&sesid="+sesid + "&hour_id=" + hour_id;  
		new Ajax.Updater("AddTaskesHours_" + task_id , url, {evalScripts:true} );
	}
	
	function AddTaskesHours(sesid , task_id )
	{
		var url = "ajax.php";  
		var params = Form.serialize($('AddTaskesHours_'+task_id)); 
		new Ajax.Updater("reset_AddHour_Form_" + task_id  , url, {method:'post', parameters: params,evalScripts:true} );
		
		Form.reset($('AddTaskesHours_'+task_id));
	}
	
	function showDiscassionList(sesid , task_id )
	{
		var url = "ajax.php?main=showDiscassionList&task_id=" + task_id + "&sesid="+sesid ;  
		new Ajax.Updater("showDiscassionList_" + task_id , url, {evalScripts:true} );
	}
	
	function AddTaskesDiscassion(sesid , task_id )
	{
		var url = "ajax.php";  
		var params = Form.serialize($('AddTaskesDiscassion_'+task_id)); 
		new Ajax.Updater("reset_AddDiscass_Form_" + task_id  , url, {method:'post', parameters: params,evalScripts:true} );
		
		Form.reset($('AddTaskesDiscassion_'+task_id));
	}
	function delete_task(sesid , task_id )
	{
		var url = "ajax.php?main=delete_task&task_id=" + task_id + "&sesid="+sesid;  
		new Ajax.Updater("DeleteTask" , url, {evalScripts:true} );
	}
	
	
	function close_task( task_id , sesid )
	{
		var url = "ajax.php?main=close&sesid="+sesid;  
		new Ajax.Updater("TaskEditData_" + task_id , url, {evalScripts:true} );
	}
	
	function taskWorkStatusNewMsg( work_status , sesid )
	{
		var url = "ajax.php?main=taskWorkStatusNewMsg&work_status="+work_status+"&sesid="+sesid;  
		new Ajax.Updater("taskWorkStatusNewMsg_" + work_status , url, {evalScripts:true} );
	}
	
	function open_close_div( divit )
	{
		obj = document.getElementById(divit).style.display;		
		document.getElementById(divit).style.display=(obj?"":"none")		
	}
	
	function checkAll()
	{
		var boxes = document.getElementsByTagName("input");
			for (var i = 0; i < boxes.length; i++) {
			myType = boxes[i].getAttribute("type");
			if ( myType == "checkbox") {
				boxes[i].checked=1;
			}
		}
	}
	
	
	function checkNone()
	{
		var boxes = document.getElementsByTagName("input");
			for (var i = 0; i < boxes.length; i++) {
			myType = boxes[i].getAttribute("type");
			if ( myType == "checkbox") {
				boxes[i].checked=0;
			}
		}
	}
