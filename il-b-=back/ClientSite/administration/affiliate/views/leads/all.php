<h3>הלידים שלי</h3>
<hr/>
<div class="filter-form-wrap">
	<div class="beck-link">
		<a href="/affiliate/leads/resetfilter/">איפוס הגדרות סינון</a>
	</div>
	<h4>סינון לידים</h4>
	<div id="responsive-tables">
		<form class="filter-form table-form" action="" method="POST">
			<table class="col-md-12 table-bordered table-striped table-condensed cf">
				<thead class="cf">
					<tr>
						<th>מתאריך</th>
						<th>עד תאריך</th>
						<th>טלפון</th>
					</tr>
				</thead>
				<tbody>
					<tr class="form-group">
						<td data-title="מתאריך"><input type="text" name="leads_filter[date_from]" class="form-input datepicker-input" value="<?php echo $filter['date_from']; ?>" /></td>
						<td data-title="עד תאריך"><input type="text" name="leads_filter[date_to]" class="form-input datepicker-input" value="<?php echo $filter['date_to']; ?>" /></td>
						<td data-title="טלפון"><input type="text" name="leads_filter[phone]" class="form-input" value="<?php echo $filter['phone']; ?>" /></td>
					
					</tr>
				</tbody>
				<thead class="cf">
					<tr>
						<th>שם</th>
						<th>אימייל</th>
						<th></th>
					</tr>
				</thead>
				<tbody>					
					<tr class="form-group">
						<td data-title="שם"><input type="text" name="leads_filter[name]" class="form-input" value="<?php echo $filter['name']; ?>" /></td>
						<td data-title="אימייל"><input type="text" name="leads_filter[email]" class="form-input" value="<?php echo $filter['email']; ?>" /></td>
						<td data-title=""><input type="submit" value="סינון" /></td>
					</tr>				
				</tbody>
			</table>
		</form>
	</div>
</div>
<div class="leads-list">
	<h4>תוצאות חיפוש</h4>
	<div id="responsive-tables">
		<?php if(empty($leads)): ?>
			<div class="empty-result">לא נמצאו תוצאות</div>
		<?php else: ?>
			<table class="col-md-12 table-bordered table-striped table-condensed cf">
			
				<thead class="cf">
					<tr>
						<th>שם</th>
						<th>טלפון</th>
						<th>זמן שליחה</th>
						<th>שליחה ללקוחות</th>
						<th>פתוח</th>
						<th class="numeric">סגור</th>
						<th class="numeric">חוייבו</th>
						<th class="numeric">כפולים</th>
						<th class="numeric">הוחזרו</th>
						<th class="numeric">סה"כ לתשלום</th>
						<th>צפייה בליד</th>
					</tr>
				</thead>
				<tbody>
				
				
				
        			<tr class="suming-tr">
						<td data-title=""  class="responsive-hide"></td>
						<td data-title="" class=""></td>
						<td data-title="" style="direction:ltr;" class="responsive-full-row">סה"כ <?php echo $lead_count; ?> לידים</td>
        				<td data-title="שליחה ללקוחות"><?php echo $totals_list['total_send']; ?></td>
        				<td data-title="פתוח"><?php echo $totals_list['payByPassword_1']; ?></td>
        				<td data-title="סגור" class="numeric"><?php echo $totals_list['payByPassword_0']; ?></td>
        				<td data-title="חוייבו" class="numeric"><?php echo $totals_list['billed']; ?></td>
        				<td data-title="כפולים %" class="numeric"><?php echo $totals_list['doubled']; ?></td>
        				<td data-title="הוחזרו" class="numeric"><?php echo $totals_list['refunded']; ?></td>
        				<td data-title="סה&quot;כ לתשלום" class="numeric"><?php echo $totals_list['total_pay']; ?></td>
						<td data-title="" class="numeric"></td>
        			</tr>
				
					<?php foreach($leads as $lead) { $sent_data=$lead->users_send_summary; $data=$lead->estimate_form_data; ?>
						<tr>
							<td data-title="<?php echo $data['phone']; ?>"  class="responsive-hide"><?php utpr($data['name']); ?></td>
							<td data-title="<?php utpr($data['name']); ?>" class=""><?php echo $data['phone']; ?></td>
							<td data-title="" style="direction:ltr;" class="responsive-full-row"><?php echo hebdt($data['insert_date']); ?></td>
							<td data-title="שליחה ללקוחות"><?php echo $sent_data['total_send']; ?></td>
							<td data-title="פתוח"><?php echo $sent_data['payByPassword_1']; ?></td>
							<td data-title="סגור" class="numeric"><?php echo $sent_data['payByPassword_0']; ?></td>
							<td data-title="חוייבו" class="numeric"><?php echo $sent_data['billed']; ?></td>
							<td data-title="כפולים %" class="numeric"><?php echo $sent_data['doubled']; ?></td>
							<td data-title="הוחזרו" class="numeric"><?php echo $sent_data['refunded']; ?></td>
							<td data-title="סה&quot;כ לתשלום" class="numeric"><?php echo $sent_data['total_pay']; ?></td>
							<td data-title="צפייה בליד" class="numeric"><a href='/affiliate/leads/show/?id=<?php echo $lead->id; ?>'>לחץ לצפייה</a></td>
						</tr>	
						
					<?php } ?>
				
				</tbody>
				
			</table>
		<?php endif; ?>
	</div>
</div>
