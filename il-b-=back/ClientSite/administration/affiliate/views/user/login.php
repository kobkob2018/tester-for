<h3>כניסה למערכת</h3>
<hr/>
<?php if($this->session_err_messege){ ?>
	<div class="err-messege">
		<?php echo $this->session_err_messege; ?>
	</div>
<?php } ?>
<?php if($this->session_success_messege){ ?>
	<div class="success-messege">
		<?php echo $this->session_success_messege; ?>
	</div>
<?php } ?>
<div id="affiliate_login_wrap" class="affiliate-form user-form">
	<form  class="affiliate-form form-validate" action="" method="POST">
	
		<input type="hidden" name="sendAction" value="loginSend" />
		<div class="row-fluid">	
			<div class="form-group span3">
				<label for="user_email" id="user_email_label">אימייל</label>
				<input type="text" name="user_email" class="form-input required email"  data-msg-required="יש למלא כתובת מייל"  data-msg-email="יש למלא כתובת מייל תקינה" />
			</div>
			<div class="form-group  span3">
				<label for="user_pass" id="user_pass_label">סיסמא</label>
				<input type="password" name="user_pass" class="form-input required"  data-msg-required="יש למלא סיסמא"  />
			</div>
		</div>
		<div class="row-fluid">		
			<div class="form-group">
				<input type="submit"  class="submit-btn"  value="שליחה" />
			</div>
			<div class="form-group">
				<a href = '/affiliate/userLogin/forgotPassword/'>שכחתי סיסמא</a>
			</div>		
		</div>
	</form>
</div>