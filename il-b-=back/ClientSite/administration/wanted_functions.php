<?php

function wanted_editor(){
	if(isset($_GET['edit'])){
		$func_name = "edit_wanted_".$_GET['edit'];
		if(function_exists($func_name)){
			ob_start();
			$func_name();
			$page_content = ob_get_clean();
			echo iconv("UTF-8", "windows-1255",$page_content);
		}
	}
}

function edit_wanted_filters(){
	if(isset($_REQUEST['add_filter_group'])){		
		$sql = "SELECT * FROM user_wanted_filters_groups WHERE unk = '".UNK."' order by name";
		$res = mysql_db_query(DB,$sql);
		$has_groups = false;
		while($group_row = mysql_fetch_array($res)){
			$has_groups = true;
		}
		if($has_groups){
			?>
			<b style="color:red; font-size:17px;">כעת לא ניתן להוסיף יותר מקבוצת סינון אחת.</b>
			<?php 
		}
		else{
			$sql = "INSERT INTO user_wanted_filters_groups(unk,name) VALUES('".UNK."','".$_REQUEST['group_name']."')";
			$res = mysql_db_query(DB,$sql);
		}
	}
	if(isset($_REQUEST['delete_filter_group'])){
		$sql = "SELECT * FROM user_wanted_filters WHERE group_id = '".$_REQUEST['delete_filter_group']."'";
		$res = mysql_db_query(DB,$sql);
		$has_filters = false;
		while($filter_row = mysql_fetch_array($res)){
			$has_filters = true;
		}
		if($has_filters){
			?>
			<b style="color:red; font-size:17px;">לא ניתן למחוק קבוצה שיש בתוכה מסננים. יש למחוק את המסננים בתוך הקבוצה תחילה</b>
			<?php 
		}
		else{		
			$sql = "DELETE FROM user_wanted_filters_groups WHERE unk = '".UNK."' AND id = '".$_REQUEST['delete_filter_group']."'";
			$res = mysql_db_query(DB,$sql);
		}
	}
	if(isset($_REQUEST['add_filter'])){
		$sql = "INSERT INTO user_wanted_filters(unk,name,group_id) VALUES('".UNK."','".$_REQUEST['filter_name']."',".$_REQUEST['group_id'].")";
		$res = mysql_db_query(DB,$sql);
	}
	if(isset($_REQUEST['delete_filter'])){
		$sql = "DELETE FROM user_wanted_filters WHERE unk = '".UNK."' AND id = '".$_REQUEST['delete_filter']."'";
		$res = mysql_db_query(DB,$sql);
	}	
	$sql = "SELECT * FROM user_wanted_filters_groups WHERE unk = '".UNK."' order by name";
	$res = mysql_db_query(DB,$sql);
	$filters_groups = array();
	$filters_groups_arr = array();
	while($group_row = mysql_fetch_array($res)){
		$filters_groups[] = $group_row;
		$filters_groups_arr[$group_row['id']] = array();
	}
	$sql = "SELECT * FROM user_wanted_filters WHERE unk = '".UNK."' order by name";
	$res = mysql_db_query(DB,$sql);
	while($filter_row = mysql_fetch_array($res)){
		if(!isset($filters_groups_arr[$filter_row['group_id']])){
			$filters_groups_arr[0][] = $filter_row;
		}
		$filters_groups_arr[$filter_row['group_id']][] = $filter_row;
	}
	?>
	<h2>מסננים להודעות דרושים</h2>
	<table border="1">
		<tr>
			
			<th>קבוצת סינון</th>
			<th>מסנן</th>
			<th>מחיקה</th>
			
		</tr>



		<tr>
			<td><b>הוסף קבוצת סינון חדשה</b>
				<br/>
				<form action="" method="POST">
					<input type="hidden" name="add_filter_group" value="1" />
					שם: <input type="text" name="group_name" value="" />
					<input type="submit" value="הוסף" />
				</form>
			</td>
			<td></td>
			<td>
			</td>
		</tr>		

		
		<?php foreach($filters_groups as $filters_group): ?>
			<tr>
				<td><?php echo iconv("windows-1255","UTF-8", $filters_group['name']); ?></td>
				<td></td>
				<td>
					<form action="" method="POST">
						<input type="hidden" name="delete_filter_group" value="<?php echo $filters_group['id']; ?>" />
						<input type="submit" value="מחק קבוצה" />
					</form>
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
				<td><b>הוסף מסנן חדש</b>
					<br/>
					<form action="" method="POST">
						<input type="hidden" name="add_filter" value="1" />
						<input type="hidden" name="group_id" value="<?php echo $filters_group['id']; ?>" />
						שם: <input type="text" name="filter_name" value="" />
						<input type="submit" value="הוסף" />
					</form>
				</td>
				<td>
				</td>
			</tr>			
			<?php foreach($filters_groups_arr[$filters_group['id']] as $filter): ?>
			
				<tr>
					<td></td>
					<td><?php echo iconv("windows-1255","UTF-8", $filter['name']); ?></td>
					<td>
						<form action="" method="POST">
							<input type="hidden" name="delete_filter" value="<?php echo $filter['id']; ?>" />
							<input type="submit" value="מחק מסנן" />
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</table>
	<?php 
}
