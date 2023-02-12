<div style="direction:rtl;">
	שלום <?php utpr($data_user['first_name']); ?> <?php utpr($data_user['last_name']); ?>.<br/>
	
	<br/><br/>
	להלן פרטי הגישה שלך אל
	<a href="https://<?php print($_SERVER['HTTP_HOST']); ?>/affiliate/"> מערכת שיתוף לידים </a>
	<br/><br/>
	שם משתמש: 
	<?php utpr($data_user['email']);?>
	<br/>
	סיסמה:
	<?php utpr($data_user['password']);?>

</div>
