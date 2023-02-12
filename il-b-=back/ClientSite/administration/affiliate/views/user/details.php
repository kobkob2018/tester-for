<h3>ניהול פרטים אישיים</h3>
<hr/>
<div id="affiliate_register_wrap" class="affiliate-form user-form">
	<?php if($this->form_messege){ ?>
		<div class="messeges error-messeges">
			<div class="messege error-messege">
				<b><?php echo $this->form_messege; ?></b>
			</div>
		</div>
	<?php } ?>
	<form name="send_affiliate_form" class="affiliate-form form-validate" id="affiliate_register_form" method="post" action="">
		<input type="hidden" name="sendAction" value="updateSend" />
		<div class="row-fluid">
			<div class="form-group span3">
				<label for="usr[first_name]" id="first_name_label">שם פרטי</label>
				<input type="text" name="usr[first_name]" id="first_name" class="form-input required" data-msg-required="*" value="<?php echo utpr($this->user["first_name"]); ?>"  />
			</div>
			<div class="form-group span3">
				<label for="usr[last_name]" id="first_name_label">שם משפחה</label>
				<input type="text" name="usr[last_name]" id="last_name" class="form-input required" data-msg-required="*" value="<?php utpr($this->user["last_name"]); ?>"  />
			</div>	
			<div class="form-group span3">
				<label for="usr[biz_name]" id="biz_name_label">שם העסק</label>
				<input type="text" name="usr[biz_name]" id="biz_name" class="form-input required" data-msg-required="*" value="<?php utpr($this->user["biz_name"]); ?>"  />
			</div>				
		</div>
		<div class="row-fluid">
			<div class="form-group span3">
				<label for="usr[phone]" id="phone_label">טלפון</label>
				<input type="text" name="usr[phone]" id="phone" class="form-input required"  value="<?php utpr($this->user["phone"]); ?>"   data-msg-required="*" />
			</div>
			<div class="form-group span3">
				<label for="usr[email]" id="email_label">אימייל</label>
				<?php utpr($this->user["email"]); ?>
			</div>
		</div>
		<hr/>
		<div class="row-fluid">		

			<div class="form-group span3">
				<b>עדכון סיסמא</b><br/><small>השאר ריק אם אינך רוצה לשנות סיסמא</small>
			</div>	
		</div>
		<div class="row-fluid">	
		
			<div class="form-group span3">
				<label for="usr[password]" id="password_label">סיסמה</label>
				<input type="password" name="usr[password]" id="password" class="form-input required" data-msg-required="*" />
			</div>
			<div class="form-group span3">
				<label for="usr[password_auth]" id="password_auth_label">אימות סיסמה</label>
				<input type="password" name="usr[password_auth]" id="password_auth" class="form-input required" data-msg-required="*" />
			</div>	
		</div>
		<hr/>
		<div class="row-fluid">	
			<div class="form-group span3">
				<label id="submit_label"></label>
				<input type="submit"  class="submit-btn"  value="שליחה" />
			</div>
		</div>
	</form>
</div>
