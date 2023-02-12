<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
		<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />	
		<script type="text/javascript" src="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.min.js"></script>
		<script src="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.validate.js"></script>
		<script src="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css" >
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.rtl.css" type="text/css" />
		
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.min.css" type="text/css" />
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.rtl.css" type="text/css" />
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/rtl-xtra.min.css" type="text/css" />			
		<link rel="stylesheet" href="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css" />
		<script src="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
		<script src="https://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>	
		<script src="/ClientSite/administration/affiliate/style/js/affiliate.js?v=2.1"></script>	
		<link rel="stylesheet" href="/ClientSite/administration/affiliate/style/css/affiliate.css?v=2.1"  type="text/css" />	
		<script type="text/javascript">
			//jQuery.noConflict();
		</script>		
  </head>
  <body style="direction:rtl; text-align:right;">
	<div id="page_wrap" class="container">
		<div class="header jumbotron">
			
			<div id="affiliate-login">
				<?php if($this->user): ?>
			
				  <a href='/affiliate/'>עמוד הבית</a>
				  <a href='/affiliate/leads/all/'>הלידים שלי</a>
				  <a href='/affiliate/estimateForm/form/'>טופס שליחת ליד</a>
				  
				  <b>שלום <?php utpr($this->user['first_name']." ".$this->user['last_name']); ?></b>
				  <br/>
				  <a href='/affiliate/user/details/'>פרטים אישיים</a>
				  <a href = '/affiliate/user/logout/'>יציאה</a>
				<?php else: ?>
				  <a href = '/affiliate/userLogin/login/'>כניסה למערכת</a>
				  <a href = '/affiliate/userLogin/register/'>הרשמה</a>
				<?php endif; ?>
			</div>
			<h1>מערכת השותפים של איי-אל-ביז</h1>
			<?php include('views/messeges/all.php'); ?>
				
		</div>
		<div id="content_wrap">
			<?php $this->$action(); ?>
		</div>
		<div class="footer">
		 © כל הזכויות שומורות <a href="http://www.ilbiz.co.il" class="copyrightBottom" title="פורטל עסקים ישראל">פורטל עסקים ישראל</a>&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.com" class="copyrightBottom" target="_blank" title="IL-BIZ קידום עסקים באינטרנט">IL-BIZ קידום עסקים באינטרנט</a>&nbsp;&nbsp;&nbsp; <a href="http://kidum.ilbiz.co.il/" class="copyrightBottom" target="_blank" title="קידום באינטרנט">קידום באינטרנט</a> - אילן שוורץ&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.co.il/" class="copyrightBottom" target="_blank" title="בניית אתרים">בניית אתרים</a>
		</div>
	</div>
  </body>
<html>