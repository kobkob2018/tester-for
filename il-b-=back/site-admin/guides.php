<?php
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
$cities_sql = "SELECT * FROM newCities ORDER BY father, name";
$cities_res = mysql_db_query(DB,$cities_sql);
$cities_arr = array();
$cities_arr_by_id = array();
while($city = mysql_fetch_array($cities_res)){
	$cities_arr_by_id[$city['id']] = $city;
	$cities_arr[] = $city;
}
?>
<script type="text/javascript">
	function open_div_box(a_el,box_id){
		jQuery(function($){
			if($(a_el).attr("rel") == "closed"){
				$(a_el).attr("rel","open");
				$(".guid-content").hide();
				$("#"+box_id).show();
			}
			else{
				$(a_el).attr("rel","closed");
				$("#"+box_id).hide();
			}
			
		});
	}
</script>
<style type="text/css">
	.guid-content{
		padding:10px;
		background:white;
		border: 1px solid gray;
	}
</style>
<div style="margin-bottom:30px;padding:10px; background:wheat; border:1px solid gray;">
	<h1>������� ������ ������� ������</h1>
	<a href="?main=global_settings&sesid=<?php echo SESID; ?>" >���� ������ ����</a>
	<br/>
	<a href="?sesid=<?php echo SESID; ?>" >���� ������ ����</a>
	<div id="city_list_wrap">
		<a href="javascript://" onclick="open_div_box(this,'city_list_content')" rel="closed">����� ����� ������</a>
		<div id="city_list_content" class="guid-content"  style="display:none;">
			<h3>����� ����� ������ ������</h3>
			<table border="1" cellpadding="3" style="border-collapse: collapse;">
				<tr>
					<th>���</th>
					<th>����</th>
					<th>����</th>
				</tr>
				<?php foreach($cities_arr as $city): ?>
					<tr>
						<td><?php echo $city['name']; ?></td>
						<td><?php echo $city['id']; ?></td>
						<td><?php echo (isset($cities_arr_by_id[$city['father']]))?$cities_arr_by_id[$city['father']]['name']:""; ?></td>
					</tr>
				<?php endforeach; ?>
				
			</table>
		</div>
	</div>
	<div id="landing_pages_wrap">
		<a href="javascript://" onclick="open_div_box(this,'landing_pages_content')" rel="closed">��� �����</a>
		<div id="landing_pages_content" class="guid-content"  style="display:none;">
			<h2>����� �����</h2>
			<h4>�� ������� ������ ��� ����� �����, �������� ���� �����</h4>
			�� ����� �� ����� ���� ���� ���� �����
			<h4>��� ����� ��� �� ����� ������� ����� ������</h4>
			������ ����� ��������� 1</br>
			����� 0 ��� �� ����� ����� ����
			<h4>������ ����� ���� �� ������ ������ �����.</h4>
			�� �� ������� �� ����, ���� ���� ���� ���� ����- ���� ����� �����
		</div>
	</div>
	
	<div id="design_wrap">
		<a href="javascript://" onclick="open_div_box(this,'design_content')" rel="closed">�����</a>
		<div id="design_content" class="guid-content"  style="display:none;">	
	
	
		<h2>�����</h2>
		
		<h3>������ �������� �������� ���� ����</h3>
		<ul>
			<li>����� - ���� ��� : 1</li>
			<li>����� ������ - ����� ����� �����: 1</li>
			<li>����� ������ - ����� ����� ������: 1  --- ���� �� ���� ����� �����</li>
			<li>����� ������ - ����� ����� ������: 1</li>
		</ul>
		<h2>����� SSL �������:</h2>
		<ul>
			<li>
				���� ������ ����� �� ����: 
				<br/>
				http://beersheva.biz:2222
				<br/>
				user: ilbiz
				<br/>
				pass: agate1234
			</li>
			<li>list users</li>
			<li>��� ����� ilan_123</li>
			<li>��� �� ������� �����</li>
			<li>��� SSL Certificates ���� ������ Advanced features</li>
			<li>��� ������� ������: Use the server's shared signed certificate.</li>
			<li>��� ������� �������: Free & automatic certificate from Let's Encrypt</li>
			<li>���� ���� ���� save</li>
			<li>��� �� ����� ���� ������ ����� ���� ��� �� ������� �����</li>
			<li>��� ��: Domain Setup</li>
			<li>��� ��� �� ������� ����� (��� �� �� �������)</li>
			<li>��� �� ���� ������ Secure SSL, ���� save</li>
			<li>����� ��� ���� ����� ��� ����� ���� ���� ��������� ���� ������ ������</li>
			<li>private_html setup for .... - (SSL must be enabled above)</li>
			<li>��������� ����, ��� �� ������: <br/> Use a symbolic link from private_html to public_html - allows for same data in http and https</li>
			<li>��� save</li>
			<li>���� 5 ���� ����� �� ������� ��� �� https:// ����� ���� ����</li>
			<li>�����. �� ����� SSL �������. </li>
			<li>������</li>
		</ul>
	
	
	
		</div>
	</div>
	
	<div id="contracts_wrap">
		<a href="javascript://" onclick="open_div_box(this,'contracts_content')" rel="closed">����� �����</a>
		<div id="contracts_content" class="guid-content"  style="display:none;">		
	
	
	
	
	
		<h2>����� �����: ����� ������ ������ ����</h2>
		<p style="color:red;">* ��� ��: ����� �� ���� ����� ��� ����� ����� �� ������ ���� �� ��� ���� ������</p>
		<ul>
			<li>���� ������ �SSL ����� ������� ����� (���� ������ ����� SSL)</li>
			<li>
				���� �� ����� ����� �� ����� ����� ����: <br/>
				https://mydomain.co.il?m=work_contract_find
				<p style="color:red;">* �� ������ �� ������ mydomain.co.il ��� ������� �����</p>
			</li>
			<li>���� �� ���� ����� �����</li>
			<li>���� �� ������ ���� ���� ���� ����� ��� ���� ����� ����� ���� ������� ������ �����</li>
		</ul>
		
		<h2>����� ���� ����� ��� (����� �� ��� ���� �����)</h2>
			<h3>��� �� ����� ����</h3>
			<ul>
				<li>���� ���� ���� ������� �� ������ �����</li>
				<li>���� �� ������ �� ����� ����� �� ����� ����� ����</li>
				<li>��� �� ������ ����� font ������� ��� ��� ����� ���� ������ �� ����� PDF. ���� ���� ������ �����</li>
				<li>��� �� �� ����� �������, ��� �� �� ����� ����� �������� ������ �������� �������� ������</li>
				<li>��� ������ ��� ������ ���� �������� ��� (����� ������ �����������)</li>
				<li>�� �� ������ �����, ������� ����� ���� ����� ������ �������, ��� ���� ����� ����� �"�: ���� ���� ���� ���� �����, ����� ����� ������ ����� ���� �����: <br/>
				<input type="text" style="text-align:left;direction:ltr;" name="stam" value="<!--add_after--> " />
				</li>
				<li>���� ���� ������ ����� ������ ���� �����</li>
				<li>��� ����� �����</li>
				<li>���� �� ���� ���� �����, ������ ����� �� ����� �����, ��� �� ���� �����</li>
				<li>����</li>
				<li>��� ������ ����� �����, ���� ����� ������ ����</li>
				<li>������, ����� �����, ���� �� ������� ��������� ��� ������ �������. ���� ��� ��� ���� �����</li>
				<li>������ �����, ���� ��� ���� ������� ������� �����, ����� ����� ��������� ��� �����</li>
				<li>����</li>
				<li>��� �� ���� ������ ����� ����� ����� ����� ���� ���� �� ���</li>
				<li>���� ������ �URL �� ���� ����� ����� ���� ���</li>

			</ul>


			<h3>��� �� ����� �����</h3>
			<ul>
				<li>���� �� ���� ������ ���������� - 	���� ����� �����</li>
				<li>���� ����� ����</li>
				<li>���� �� ����� �� ����� �����, ������ ����� ����. ���� ������ ������� �� ����� ����� ����� �� ����� ����</li>
				<li>���� �� ����� ����� - ��� ���� �� ����� ����</li>
				<li>
					���� �� ����� ��������, �� ������� �� ���� ������ �����:
					<ol>
						<li>title: ����� ����� ����� ������ ������� ����� ������ ������� �������</li>
						<li>contract_page: ���� ����� �� ����� ����(�� ������ ����� ���)</li>
					</ol>
				</li>
				<li>���� �� ���� ����� ������ ��� �����, ��� �� ����� �����</li>
				<li>���� �� ����� �� ����� ����� ��� �����, ��� �� ����� �����</li>
				<li>���� �� ���� ����� ��� �����, ��� �� ����� �����</li>
				<li>����</li>
				<li>���� �� ����� ����� ������ �������(HTTPS)</li>
				<li>���� �� ������ URL ����� ���</li>
				<li>��� �� ����� ����� ���� ����</li>
				<li>���� �� ����� ����� ��� ��� ���� ����� ����� ����� ���� �����</li>
			</ul>
			<h4>������</h4>
		



		</div>
	</div>
	
	<div id="api_connect_wrap">
		<a href="javascript://" onclick="open_div_box(this,'api_connect_content')" rel="closed">������� �API</a>
		<div id="api_connect_content" class="guid-content"  style="display:none;">	




				
				<h3>������� �API</h3>
				���� �������� ������ �� ������ ��� ��� API ���� ���� �� ����� ���:
				
				���� �����.
		<br/>
				�� ��� ����� ������� �API �� ������ ��� ���'�, ��� ���� �� ������ �� ��� ���'� ���� ��� ����� �� ������ ���� �API ����� ������.
		<br/>
				��"� ���� ����� ������ �� �� ����� ����, �� ����� ���� ��� �API, ������� �� ������ ������ ��.
		<br/>
		�� ��� ����� ����� �� �� �� ����� ����� �����, �� �API ���� �� ����� �����:
		<br/>
		���� �����
		<br/>
		-������
		<br/>
		-�� ���
		<br/>
		*��� ���� 
		<br/>
		*����� ����
		<br/>
		*�����
		<br/>
		����� �������� ���(  -  ) �������� �� ������ ������ �����.
		<br/>
		����� �������� ������� (   *   ) �������� �� ������ ������ ������ �����.
		<br/>
		������ ����� 

		
		
		
		</div>
	</div>
	
	<div id="api_app_wrap">
		<a href="javascript://" onclick="open_div_box(this,'api_app_content')" rel="closed">����� API</a>
		<div id="api_app_content" class="guid-content"  style="display:none;">			
		
		
				
		<h3>����� API</h3>
			������� ������ �� ���� ���� ����� API ��������� ��������, ��� ���������, �� ��������
			�� �� ��� ��� ����. ���� �� ����� ����� ��� ���� ������� �� ����� �� ����� ����,
			��� ������ �� ������ ������ �������.
			����� ���� ������ ����:
			phone,name,email,note,answer,time
			<br/>
			���� ������ ������� ������ �� ������� �����...
				
		
					<h3>����� ���� �������� ����� ���� ����� ������ ������ ����� ���� ������</h3>
					������ ����� ������ ��������� ���� ���� �� �������, ������� �� ������, �������� �� �����: 
					<br/>
					�� ������:
					aff_id
					<br/>
					��� ������:
					���� ��������. ���� ����� ������ ����� ������ ������ �� ���� ����� ��
					<br/>
					��� ���� ��� ������ �� ������ ��� �� ������ ���.

					<h3>����� ���� �� �������</h3>
					��� ����� ���� �� ����� ���� ��� ����� ����� �� ����<br/>
					URL<br/><br/>
			
					������ ��� ������� �� ������.
					<br/>
					��� ����� �� ��� �����:
					<br/> 
					�� ������
					<br/>
					��� ������
					<br/>
					������ ������ 
					aff_id
					������� ����� ��������.
					<br/>
					aff_id 
					��� �� ������ 
					���� ����� �������� ��� 7
		,
					����� ���� ����� ������ ����� ����� �������� ���� 7
					<br/>	<br/>
					���� �� ������ ����� ����:
					<br/>
					aff_id=7
					<br/>
					�� �� ����� ���� ������ �� �����, �� ����� �� ����� �� ��� ������� �����:
					<br/>
					&
					<br/>
					��	
					<br/>
					?
					<br/>	<br/>
					��� ��� ���� �������� ����?
					<br/>
				
					����� ������ �� ��� �� ���� ����.
					�� ��� �� ���� ���� �� ���� �� ����� ����.
					�� ��� ����� ���� ���� �� ���� ���� ����.
					<br/>	<br/>
					���� ��� ����� ���� ���� ����� �� ��� ��� ����, ������ ������ ����� �� ����� ����.
					������
					
					��� ������ ������:
					<div style='direction:ltr;text-align:left;'>
						<br/>
						https://�������.co.il/������-������-������/?aff_id=7
						<br/>
						https://�������.co.il/������-������-������/?more_param=200&aff_id=7
						<br/>
						https://xn--8dbacwhj3a.co.il/������-������-������/?aff_id=7
						<br/>
						https://xn--8dbacwhj3a.co.il/%D7%9E%D7%97%D7%99%D7%A8%D7%95%D7%9F-%D7%98%D7%99%D7%A4%D7%95%D7%9C%D7%99-%D7%A9%D7%99%D7%A0%D7%99%D7%99%D7%9D/?aff_id=7
						<br/>
				
						<br/>
						https://�������.co.il/landing.php?ld=538&aff_id=7
						<br/>
						https://�������.co.il/landing.php?ld=538&more_param=200&aff_id=7
						<br/>
					</div>
					������
				


		
		</div>
	</div>
		
		
		
		
		
			
	<div id="fb_leads_wrap">
		<a href="javascript://" onclick="open_div_box(this,'fb_leads_content')" rel="closed">����� ����� ��������</a>
		<div id="fb_leads_content" class="guid-content"  style="display:none;">			
		
			<div>
				<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
					&nbsp;</div>
					<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
						<span style="font-size:24px;"><strong>����� ����� �������� �� ������ ��� ������</strong></span></div>
							<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
								&nbsp;</div>
								<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
									������ ������ ��� ��� ������, ������ ���.
								</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										����� ���� ������ ���, ����� ����� ����� ����, ���� ����� �� zaps, ������ �� ���� �����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										1: ������ ������� - https://zapier.com</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										2: ������ �� make a zap</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										3: choose a trigger app - ������ facebook lead eds, �� �� ����� �� �������</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										4:&nbsp;Select Facebook Lead Ads Trigger, ������ �� ������� ������ - new lead ������� �� ����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										5:&nbsp;Select Facebook Lead Ads Account&nbsp; - ������� ������ �������, ��� �� ����� ���� ������� �������� ������ �� ���� �����, ������ �� ����� ����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										6:&nbsp;Set up Facebook Lead Ads Lead&nbsp; - ������ �� ���� �������� �����, ��� �� ������� ����� ������� ����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										7:&nbsp;Pick A Sample To Set Up Your Zap - �� ������� ����, ��� ������ ����� �������� �� ����� ������. ������ ��� ����������, �� ���� ������� ����� ����� �����..</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										������ ����, ����� ������ �� ���� �� ������(�� ������ �� ������ ������ ����.. ������ ������ ��� �������� ���� �� ������, ��� ������� ���� �� ������</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										����� ����� ����� ������� ���� �� ������ ���� ������ ���� ����� ������. �� ���� action.</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										����� ����� ���� �� �����.</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										8:&nbsp;Choose an Action App&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										������ �������� ������ webhooks, ���� ����. ������ ����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										9:&nbsp;Select Webhooks by Zapier Action - ������ POST ������ ����</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										10:&nbsp;Set up Webhooks by Zapier POST -&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										<strong><span style="font-size:16px;">��� ������ �� ������ ����� ������ ������� ����� ������&nbsp;</span></strong></div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div dir="rtl">
										<div>
											������� �� ������ �� �������� �����:</div>
										<div>
											������� �� ������:</div>
										<div>
											�� ������ ��� ����, ���� ������ (���� ����� ������) ��� ����</div>
										<div>
											phone: Phone Number</div>
										<div>
											name: Full Name</div>
										<div>
											add_id: Ad Id</div>
										<div>
											form_id: Form Id</div>
										<div>
											adset_id: Adset Name</div>
										<div>
											campaign_id: Campaign ID</div>
										<div>
											fb_id: ID&nbsp;</div>
										<div>
											adset_name: Adset Name</div>
										<div>
											ad_name: Ad Name</div>
										<div>
											campaign_name: Campaign Name</div>
										<div>
											ex_city: City</div>
										<div>
											&nbsp;</div>
										<div>
											������� �� ��� ��������:</div>
										<div>
											il_cat: ���� �������� ����� ������</div>
										<div>
											il_city: ���� ���� ����� ������</div>
									</div>
									<p>
										���� ������ �� ����� ���� ���� ����� �����, ������ ������, �� ������ ���� ����� ������� ������ ������� �:</p>
									<p style="direction: ltr; ">
										ex_&nbsp;&nbsp;</p>
									<p>
										������:&nbsp;</p>
									<p style="direction: ltr; ">
										ex_fatherName</p>
									<p style="direction: ltr; ">
										&nbsp;</p>
									<p>
										������ ����.</p>
									<p>
										&nbsp;</p>
									<p>
										11: ���� ����� ����� �����, �� �� �� ���� �������� ��� ������� �����, ����. ��� ����. ������</p>
									</div>
											
		
		</div>
	</div>		
		
		
	