<?

function amuta_fmn__registerForm()
{ 

echo '
<table border=0 cellpadding="0" border="0">
<tr>
<td width=15></td>
<td>
<form action=index.php method=post name=formRegForm onsubmit="return check_mandatory_fields()">
<input type=hidden name=m value=amuta_fmn__regGET>
<input type=hidden name=withoutpay value="">
<table border=0 cellpadding="0" border="0">
    <tbody>
        <tr>
            <td height="40" colspan="2"><font color="#ff0000">אנא מלא/י את הפרטים הבאים. וועד העמותה יצור איתך קשר בכדי להסדיר את דמי החברות.</font></td>
        </tr>
        <tr>
            <td height="40" colspan="2"><label><input type="radio" value="1" name="ngo_type" id="ngo_type" /> חבר עמותה (כ - 120 ש&quot;ח לשנה) </label><label><input type="radio" value="2" name="ngo_type" id="ngo_type" /> חבר עמותה צעיר (כ - 60 ש&quot;ח לשנה) </label></td>
        </tr>
        <tr>
            <td height="40" colspan="2">הנני מעוניין לתרום לעמותת אוהדי מכבי נתניה סכום חד פעמי על סך: <input size="7" name="ngo_price" style="margin-left: 6px; margin-right: 4px;" />ש&quot;ח</td>
        </tr>
        
        <tr>
            <td width="250" height="40">
            <p>* שם משפחה: </p>
            <p><input name="lastname" size="26" id="lastname" /> </p>
            </td>
            <td width="250" height="40">
            <p>* שם פרטי: </p>
            <p><input name="firstname" size="26" /> </p>
            </td>
        </tr>
        <tr>
            <td height="40">
            <p>* תאריך לידה:</p>
            <p><select name="AGE2"><option selected="selected" value=""></option>';
            	for( $y=1930 ; $y<=Date('Y') ; $y++ )
            	{
            		echo '<option value="'.$y.'">'.$y.'</option>';
            	}
            echo '</select> <select name="BDayMM2" size="1" id="BDayMM" style="width: 80px; font-family: Arial;">
            <option selected="selected" value=""></option>
            <option value="01">ינואר</option>
            <option value="02">פברואר</option>
            <option value="03">מרץ</option>
            <option value="04">אפריל</option>
            <option value="05">מאי</option>
            <option value="06">יוני</option>
            <option value="07">יולי</option>
            <option value="08">אוגוסט</option>
            <option value="09">ספטמבר</option>
            <option value="10">אוקטובר</option>
            <option value="11">נובמבר</option>
            <option value="12">דצמבר</option>
            </select> <select name="BDayDD2" size="1" id="BDayDD" style="width: 61px; font-family: Arial;">
            <option selected="selected" value=""></option>';
            	for( $m=1 ; $m<=31 ; $m++ )
            	{
            		echo '<option value="'.$m.'">'.$m.'</option>';
            	}
            echo '</select> </p>
            </td>
            <td height="40">
            <p>* ת.ז: </p>
            <p><input name="ID2" size="26" maxlength="9" /> </p>
            </td>
        </tr>
        <tr>
            <td height="40"><label>* דואר אלקטרוני:<br />
            <br />
            <span class="info"><input name="email" size="26" /> </span><br />
            </label></td>
            <td height="40">
            <p><label>*</label> <span class="info"><label>סלולארי</label> :</span></p>
            <p><span class="info"><input name="cellphone3" size="26" /> </span></p>
            </td>
        </tr>
        <tr>
            <td height="40" colspan="2">
            <p>כתובת (למשלוח דואר): </p>
            <p><span class="info"><input name="city2" size="68" /> </span></p>
            </td>
        </tr>
        <tr>
            <td height="40">
            <p class="info"><label>* עיר מגורים:</label> </p>
            <p class="info"><input name="city" size="26" /> </p>
            </td>
            <td height="40">
            <p class="info"><label>מיקוד:</label> </p>
            <p class="info"><input name="zipcode" size="26" /> </p>
            </td>
        </tr>
        <tr>
            <td height="40" colspan="2"><input type="checkbox" value="1" name="terms" /> * מאשר את תמיכתי בתוכניות העמותה <a href="http://amuta-fmn.com/index.php?m=text&amp;t=18625" target="_blank"><font color="#0000ff"><strong>ובתקנון</strong></font></a>.</td>
        </tr>';
        /*echo '<tr>
            <td height="40" colspan="2"><span style="border-top: medium none; padding-top: 5px;"><input type="checkbox" value="1" name="donait3" /> אני מאשר קבלת מידע שוטף באימייל בנושאי העמותה.</span></td>
        </tr>
        <tr>
            <td height="40" colspan="2"><span style="border-top: medium none; padding-top: 5px;"><input type="checkbox" value="1" name="donait4" /> האם אתה בעל מנוי</span>?</td>
        </tr>
        <tr>
            <td height="40" colspan="2"><span style="border-top: medium none; padding-top: 5px;"><input type="checkbox" value="1" name="donait5" /> האם תרכוש מנוי גם בעונה הבאה?</span> </td>
        </tr>
        <tr>
            <td height="40" colspan="2"><span style="border-top: medium none; padding-top: 5px;"><input type="checkbox" value="1" name="donait6" /> האם אתה מעוניין לקחת חלק פעיל בעמותה?</span> </td>
        </tr>';
        */
        echo '<tr>
            <td height="40" colspan="2"><input type="submit" value="לתשלום דמי חבר" name="submitPay" /> <input type="button" name="submit_without_pay" onclick="check_withoutpay()" value="לתמיכה ללא תשלום" /> </td>
        </tr>
    </tbody>
</table>
</form>
</td>
</tr>
</table>
';
$mandatory_fields = array( 'lastname' , 'firstname', 'AGE2', 'BDayMM2' , 'BDayDD2' , 'ID2' , 'email' , 'cellphone3' , 'city' , 'terms' );

			echo "<script>";
				echo "function check_mandatory_fields()
				{
			";
			for($z=0 ; $z<sizeof($mandatory_fields) ; $z++)
			{
				$val = $mandatory_fields[$z];
				
				if( $val == "terms" )
				{
					echo "
					temp_val = document.formRegForm.{$val};
					if(temp_val.checked != 1)	
					{
						alert(\"עליך לאשר תנאי שימוש\");
						temp_val.focus();   
						return false;\n
					}
					";
				}
				else
				{
					//main_form
					echo "
					temp_val = document.formRegForm.{$val};
					if(temp_val.value == \"\")	
					{
						alert(\"יש להזין תוכן לשדות החובה\");
						temp_val.focus();   
						return false;\n
					}
					";
				}
			}
				
			echo "}";
			
			echo "function check_withoutpay()
				{
			";
			for($z=0 ; $z<sizeof($mandatory_fields) ; $z++)
			{
				$val = $mandatory_fields[$z];
				
				if( $val == "terms" )
				{
					echo "
					temp_val = document.formRegForm.{$val};
					if(temp_val.checked != 1)	
					{
						alert(\"עליך לאשר תנאי שימוש\");
						temp_val.focus();   
						return false;\n
					}
					";
				}
				else
				{
					//main_form
					echo "
					temp_val = document.formRegForm.{$val};
					if(temp_val.value == \"\")	
					{
						alert(\"יש להזין תוכן לשדות החובה\");
						temp_val.focus();   
						return false;\n
					}
					";
				}
			}
				echo "
					document.formRegForm.withoutpay.value='1'
					
					document.formRegForm.submit();
				";
				
			echo "}";
			
			echo "</script>";
}

function GET_amuta_fmn__registerForm()
{
	$fields = array(
		'fname' => $_POST['firstname'],
		'lname' => $_POST['lastname'],
		'tz' => $_POST['ID2'],
		'birthday' => $_POST['AGE2']."-".$_POST['BDayMM2']."-".$_POST['BDayDD2'],
		'email' => $_POST['email'],
		'mobile' => $_POST['cellphone3'],
		'address' => $_POST['city2'],
		'city' => $_POST['city'],
		'zip' => $_POST['zipcode'],
		'ngo_type' => $_POST['ngo_type'],
		'ngo_price' => $_POST['ngo_price'],
		//'check1' => $_POST['donait3'],
		//'check2' => $_POST['donait4'],
		//'check3' => $_POST['donait5'],
		//'check4' => $_POST['donait6'],
		'insert_date' => "insert_date",
		'unk' => UNK,
	);
	
	
	$sql = "INSERT INTO custom_netanya_users ( ";
		foreach( $fields as $key => $value )
			$sql .= $key . " , ";
	$sql = substr( $sql , 0 , -2 ). " ) VALUES (";
		foreach( $fields as $key => $value )
		{
			if( $value == "insert_date" )
				$sql .= "NOW() , ";
			else
				$sql .= "'" . mysql_real_escape_string($value) . "' , ";
		}
	$sql = substr ( $sql , 0 , -2 ). ")";
	
	$res = mysql_db_query(DB, $sql);
  
  if( $_POST['ngo_type'] == "1" )
  {
  	$sql = "insert into user_ecom_items (product_id,unk,client_unickSes) values ( '15173' , '".UNK."', '".$_SESSION['ecom']['unickSES']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	elseif( $_POST['ngo_type'] == "2" )
  {
  	$sql = "insert into user_ecom_items (product_id,unk,client_unickSes) values ( '15174' , '".UNK."', '".$_SESSION['ecom']['unickSES']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	$image_settings = array(
		after_success_goto=>"",
		table_name=>"users_ecom_buy",
	);
	
	$data_arr2['unk'] = UNK;
	$data_arr2['unickSES'] = $_SESSION['ecom']['unickSES'];
	
	$data_arr2['full_name'] = $_POST['firstname']." ".$_POST['lastname'];
	$data_arr2['email'] = $_POST['email'];
	$data_arr2['phone'] = $_POST['cellphone3'];
	$data_arr2['address'] = $_POST['city2'];
	$data_arr2['city'] =  $_POST['city'];
	$data_arr2['zip_code'] = $_POST['zipcode'];
	$data_arr2['delivery_pay'] = "0";
	
	$lastRec = insert_to_db($data_arr2, $image_settings);
	
	$sql = "UPDATE users_ecom_buy SET insert_date = NOW() WHERE unickSES = '".$_SESSION['ecom']['unickSES']."' AND unk = '".UNK."'";
	$res = mysql_db_query( DB, $sql);
	
	if( $_POST['withoutpay'] == "1" )
		echo "<script type='text/javascript'>window.location.href='index.php?m=amuta_fmn__thanks';</script>";
	else
		echo "<script type='text/javascript'>window.location.href='https://secure.ilbiz.co.il/clients/amuta-fmn/index.php?unickSES=".$_SESSION['ecom']['unickSES']."';</script>";
  
  $_SESSION['ecom']['unickSES'] = "";
	$_SESSION['ecom']['active'] = "";
	
 	 exit;
}


function amuta_fmn__thanks()
{
	echo "<p class='maintext' align=center><b>תודה רבה על תמיכתך, למען עתידה של מכבי נתניה</b></p>";
}


function castum_topMenu_flash()
{
	echo '
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/menu/assets/skins/sam/menu.css">
<script src="http://yui.yahooapis.com/2.9.0/build/yahoo-dom-event/yahoo-dom-event.js" type="text/javascript"></script>
<script src="http://yui.yahooapis.com/2.9.0/build/animation/animation-min.js" type="text/javascript"></script>
<script src="http://yui.yahooapis.com/2.9.0/build/container/container_core-min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.9.0/build/menu/menu-min.js"></script>
<style type="text/css">
	';
	if( UNK == "745262061697263702" )
	{
		echo '
    #topMenu .yuimenubar {
        background: url("background.png") repeat-x scroll 0 0;
        border:0;
    }
    #topMenu .yuimenu .bd {
        background-color:#666666;
    }
    #topMenu .yuimenubaritemlabel {
        border:0;
    }
    #topMenu .yuimenubaritemlabel-selected {
        color:#000;
    }
    #topMenu {
        width:775px;
    }
    #topMenu .bd {
        padding-left: 20px;
    }
    #topMenu li,#topMenu a {
        font-family:Arial,serif;
        font-size:12pt;
        color:#fff;
        font-weight:bold;
        direction:rtl;
        text-align:right;
    }
    ';
	}
	elseif( UNK == "138572023197195185" )	//protech-il.com/
	{
   	echo '
    #topMenu .yuimenubar {
        
    }
    #topMenu .yuimenu .bd {
        background-color:#666666;
    }
    #topMenu .yuimenubaritemlabel {
        border:0;
    }
    #topMenu .yuimenubaritemlabel-selected {
        color:#fff;
    }
    #topMenu {
        width:445px;
    }
    #topMenu .bd {
        padding-left: 0px;
    }
    #topMenu li,#topMenu a {
        font-family:Arial,serif;
        font-size:12px;
        color:#fff;
        font-weight:bold;
        direction:rtl;
        text-align:right;
        background: url("button.jpg") repeat-x scroll 0 0;
        border:0;
    }
    ';
  }
  elseif( UNK == "029638488130353217" )	//ysa.co.il
	{
   	echo '
    #topMenu .yuimenubar {
        border:0;
    }
    #topMenu .yuimenu .bd {
        background-color:#666666;
    }
    #topMenu .yuimenubaritemlabel {
        border:0;
    }
    #topMenu .yuimenubaritemlabel-selected {
        color:#000000;
    }
    #topMenu {
        width:525px;
    }
    #topMenu .bd {
        padding: 0px;
    }
    #topMenu li , #topMenu a {
        font-family:Arial,serif;
        font-size:14px;
        color:#000;
        font-weight:bold;
        direction:rtl;
        text-align:right;
        background-color: #f1f1f1;
        /*background: url("button.jpg") repeat-x scroll 0 0;*/
        border:0;
    }
    #topMenu a:hover{
        font-family:Arial,serif;
        font-size:14px;
        color:#000;
        font-weight:bold;
        direction:rtl;
        text-align:right;
        background-color: #cccccc;
        /*background: url("button.jpg") repeat-x scroll 0 0;*/
        border:0;
        cursor: pointer;
    }
    
    ';
  }
  echo '
</style>
<script type="text/javascript">

';
	if( UNK == "745262061697263702" )
	{
		echo '
	YAHOO.util.Event.onContentReady("topMenu", function () {
    var items = [
        {text: " צור קשר <img src=\'mailto.png\' align=\'absmiddle\'> ", url: "http://www.saidman.co.il/index.php?m=co" },
        {text: " ENGLISH <img src=\'en.png\' align=\'absmiddle\'>", url: "http://www.saidman.co.il/index.php?m=text&t=19134" },
        {text:"מוצרים טכניים",id: "tech" , url :"http://www.saidman.co.il/index.php?m=text&t=19352"},
        {text:"חומרים מורכבים",id: "mat", url :"http://www.saidman.co.il/index.php?m=text&t=&la=&lib=1636"},
        {text:"חטיבת הגומי",id: "rubber" , url :"http://www.saidman.co.il/index.php?m=text&t=19131&lib=1635&la="},
        {text:"אודות",url: "http://www.saidman.co.il/index.php?m=text&t=19130"},
        {text:"דף הבית",url: "http://www.saidman.co.il/"}
    ];

    var aSubmenuData = [
    ';
        /*{id: "tech",
            itemdata: [
                { text: "חומרי סיכה", url: "http://www.saidman.co.il/index.php?m=text&t=19133&lib=1637&la=" },
                { text: "חומרי ניקיון", url: "http://www.saidman.co.il/index.php?m=text&t=19145&lib=1637&la=" },
                { text: "מוצרי אחזקה מיוחדים", url: "http://www.saidman.co.il/index.php?m=text&t=19146&lib=1637&la=" }
            ]
        }*/
        echo '{
            id: "mat",
            itemdata: [
            		{ text: "חומרים מרוכבים - דף ראשי", url: "http://www.saidman.co.il/index.php?m=text&t=&la=&lib=1636" },
                { text: "ציפוי מתכות ב ARC", url: "http://www.saidman.co.il/index.php?m=text&t=19271&lib=1636&la=" },
                { text: "ציפוי בטונים ב ARC", url: "http://www.saidman.co.il/index.php?m=text&t=19272&lib=1636&la=" },
                { text: "מוצרי ARC", url: "http://www.saidman.co.il/index.php?m=text&t=19273&lib=1636&la=" }
            ]
        },{
            id: "rubber",
            itemdata: [
            		{ text: "חטיבת הגומי – דף ראשי", url: "http://www.saidman.co.il/index.php?m=text&t=19131&lib=1635&la=" },
                { text: "הדבקת סרטי מסוע", url: "http://www.saidman.co.il/index.php?m=text&t=19140&lib=1635&la=" },
                { text: "תיקון סרטי סינון", url: "http://www.saidman.co.il/index.php?m=text&t=19141&lib=1635&la=" },
                { text: "מוצרי TIP TOP", url: "http://www.saidman.co.il/index.php?m=text&t=19142&lib=1635&la=" },
                { text: "ציפוי מתכות בגומי", url: "http://www.saidman.co.il/index.php?m=text&t=19191&lib=1635&la=" }
            ]
        }
    ];
    ';
  }
  elseif( UNK == "138572023197195185" )	//protech-il.com/
	{
		echo '
	YAHOO.util.Event.onContentReady("topMenu", function () {
    var items = [
			{text: "צור קשר", url: "http://protech-il.com/index.php?m=co" },
			{text:"לקוחות",id: "cus" , url :"http://protech-il.com/index.php?m=text&t=7245"},
			{text:"אודותינו" , url :"http://protech-il.com/index.php?m=text&t=7244"},
			{text:"היכן לרכוש",id: "wher", url :"http://protech-il.com/index.php?m=text&t=19454"},
			{text:"מוצרים",id: "prod" , url :"http://protech-il.com/index.php?m=pr&sub=174"},
			{text:"מידע שימושי",id: "info",url: "http://protech-il.com/index.php?m=text&t=11289&lib=660&la="},
			{text:"דף הבית",url: "http://www.protech-il.com/"}
    ];


    var aSubmenuData = [
    	{
          id: "info",
          itemdata: [
          		{ text: "צבעי עדשות", url: "http://protech-il.com/index.php?m=text&t=11289&lib=660&la=" },
              { text: "תקני אחריות", url: "http://protech-il.com/index.php?m=text&t=8423&lib=660&la" },
          ]
			},{
          id: "prod",
          itemdata: [
          		{ text: "הגנת עיניים", url: "http://protech-il.com/index.php?m=pr&sub=174" },
              { text: "הגנת שמיעה", url: "http://protech-il.com/index.php?m=pr&sub=175" },
              { text: "הגנת פנים וראש", url: "http://protech-il.com/index.php?m=pr&sub=176" },
              { text: "הגנת ידיים", url: "http://protech-il.com/index.php?m=pr&sub=275" },
              { text: "מתכלים", url: "http://protech-il.com/index.php?m=pr&sub=322" },
              { text: "אביזרים נלווים", url: "http://protech-il.com/index.php?m=pr&sub=178" },
          ]
			},{
          id: "wher",
          itemdata: [
          		{ text: "הצפון", url: "http://protech-il.com/index.php?m=text&t=19454" },
              { text: "ירושלים", url: "http://protech-il.com/index.php?m=text&t=19455&lib=1655&la=" },
              { text: "השרון", url: "http://protech-il.com/index.php?m=text&t=19456&lib=1655&la=" },
              { text: "מרכז", url: "http://protech-il.com/index.php?m=text&t=19457&lib=1655&la=" },
              { text: "דרום", url: "http://protech-il.com/index.php?m=text&t=19458&lib=1655&la=" },
          ]
			},{
          id: "cus",
          itemdata: [
          		{ text: "מוסדי", url: "http://protech-il.com/index.php?m=text&t=7245" },
              { text: "פרטי", url: "http://protech-il.com/index.php?m=text&t=19459&lib=1656&la=" },
          ]
			}
			
        
    ];
    ';
	}
	elseif( UNK == "029638488130353217" )	//ysa.co.il
	{
		echo '
	YAHOO.util.Event.onContentReady("topMenu", function () {
    var items = [
			{text: "צור קשר", url: "http://www.ysa.co.il/index.php?m=co" },
			{text:"תמיכה",id: "supp" , url :"http://www.ysa.co.il/index.php?m=text&t=19781"},
			{text:"חומרה ורשת",id: "loc", url :"http://www.ysa.co.il/index.php?m=text&t=19776"},
			{text:"תוכנה ופיתוח",id: "dev" , url :"http://www.ysa.co.il/index.php?m=text&t=19772"},
			{text:"השירות שלנו",id: "serivce",url: "http://www.ysa.co.il/index.php?m=text&t=19770"},
			{text:"אודותינו",url: "http://www.ysa.co.il/index.php?m=text&t=text"},
			{text:"CRM",id: "crr" , url :"http://www.ysa.co.il/index.php?m=text&t=19785"}
    ];


    var aSubmenuData = [
    	{
          id: "serivce",
          itemdata: [
          		{ text: "אמנת השירות שלנו", url: "http://www.ysa.co.il/index.php?m=text&t=19771" },
          ]
			},{
          id: "dev",
          itemdata: [
          		{ text: "פורטל ארגוני", url: "http://www.ysa.co.il/index.php?m=text&t=19773" },
              { text: "ניהול תוכן", url: "http://www.ysa.co.il/index.php?m=text&t=19774" },
              { text: "פיתוח מותאם אישית", url: "http://www.ysa.co.il/index.php?m=text&t=19775" },
          ]
			},{
          id: "loc",
          itemdata: [
          		{ text: "הקמת רשתות", url: "http://www.ysa.co.il/index.php?m=text&t=19777" },
              { text: "תחזוקת רשתות", url: "http://www.ysa.co.il/index.php?m=text&t=19778" },
              { text: "מיקור חוץ", url: "http://www.ysa.co.il/index.php?m=text&t=19779" },
              { text: "אספקת חומרה", url: "http://www.ysa.co.il/index.php?m=text&t=19780" },
          ]
			},{
          id: "supp",
          itemdata: [
          		{ text: "מוקד תמיכה", url: "http://www.ysa.co.il/index.php?m=text&t=19782" },
              { text: "הורדות וקישורים", url: "http://www.ysa.co.il/index.php?m=text&t=19783" },
              { text: "הדרכה", url: "http://www.ysa.co.il/index.php?m=text&t=19784" },
          ]
			},{
          id: "crr",
          itemdata: [
          		{ text: "פיננסים", url: "http://www.ysa.co.il/index.php?m=text&t=19786" },
              { text: "ביטוח", url: "http://www.ysa.co.il/index.php?m=text&t=19787" },
              { text: "מערכת משולבת", url: "http://www.ysa.co.il/index.php?m=text&t=19788" },
          ]
			}
			
			
        
    ];
    ';
	}
	echo '

    var ua = YAHOO.env.ua,oAnim;
    var oMenuBar = new YAHOO.widget.MenuBar("topMenuBar", {
        itemData:items,
        autosubmenudisplay: true,
        hidedelay: 750,
        lazyload: true });

    function onSubmenuBeforeShow(p_sType, p_sArgs) {
        var oBody,oElement,oShadow,oUL;
        if (this.parent) {
            oElement = this.element;
            oShadow = oElement.lastChild;
            oShadow.style.height = "0px";

            if (oAnim && oAnim.isAnimated()) {
                oAnim.stop();
                oAnim = null;
            }
            oBody = this.body;
            if (this.parent && !(this.parent instanceof YAHOO.widget.MenuBarItem)) {
                if (ua.gecko || ua.opera) {
                    oBody.style.width = oBody.clientWidth + "px";
                }
                if (ua.ie == 7) {
                    oElement.style.width = oElement.clientWidth + "px";
                }
            }
            oBody.style.overflow = "hidden";
            oUL = oBody.getElementsByTagName("ul")[0];
            oUL.style.marginTop = ("-" + oUL.offsetHeight + "px");
        }
    }

    function onTween(p_sType, p_aArgs, p_oShadow) {
        if (this.cfg.getProperty("iframe")) {
            this.syncIframe();
        }
        if (p_oShadow) {
            p_oShadow.style.height = this.element.offsetHeight + "px";
        }
    }

    function onAnimationComplete(p_sType, p_aArgs, p_oShadow) {
        var oBody = this.body,oUL = oBody.getElementsByTagName("ul")[0];
        if (p_oShadow) {
            p_oShadow.style.height = this.element.offsetHeight + "px";
        }

        oUL.style.marginTop = "";
        oBody.style.overflow = "";

        if (this.parent && !(this.parent instanceof YAHOO.widget.MenuBarItem)) {
            if (ua.gecko || ua.opera) {
                oBody.style.width = "";
            }
            if (ua.ie == 7) {
                this.element.style.width = "";
            }
        }
    }

    function onSubmenuShow(p_sType, p_sArgs) {
        var oElement,oShadow,oUL;

        if (this.parent) {
            oElement = this.element;
            oShadow = oElement.lastChild;
            oUL = this.body.getElementsByTagName("ul")[0];
            oAnim = new YAHOO.util.Anim(oUL,{ marginTop: { to: 0 } },.5, YAHOO.util.Easing.easeOut);
            oAnim.onStart.subscribe(function () {
                oShadow.style.height = "100%";
            });
            oAnim.animate();

            if (YAHOO.env.ua.ie) {
                oShadow.style.height = oElement.offsetHeight + "px";
                oAnim.onTween.subscribe(onTween, oShadow, this);
            }
            oAnim.onComplete.subscribe(onAnimationComplete, oShadow, this);
        }
    }

    oMenuBar.subscribe("beforeRender", function () {
        var nSubmenus = aSubmenuData.length;
        if (this.getRoot() == this) {
            for (var i = 0; i < nSubmenus; i++) {
                var items = this.getItems();
                var nItems  = items.length;
                var notFound = true;
                var subMenu = aSubmenuData[i];
                while (nItems-- || notFound) {
                    var item = this.getItem(nItems);
                    if(item.id == subMenu.id){
                        item.cfg.setProperty("submenu", subMenu);
                        notFound = false;
                    }
                }                
            }
        }
    });
    oMenuBar.subscribe("beforeShow", onSubmenuBeforeShow);
    oMenuBar.subscribe("show", onSubmenuShow);
    oMenuBar.render("topMenu");
});
</script>
';
}

function shalev_clinic___arr_to_crm($FirstName , $LastName , $Email , $CellPhone , $RefferedBy , $ExtraData )
{
	
	$SERVICE_URL = 'https://simpleBox.MakeBusinessSimple.com/Services/IntegrationWebService.asmx';
	$SERVICE_ACTION = 'http://tempuri.org/RegisterBusinessPartner';
	$SUCCESS_URL = 'success_url.php';
	$ERROR_URL = 'error_url.php';
	$USER = '27329B09-BE80-412E-A';
	$PASS = 'e1fb80';

	$request_body = 
    '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">' .
    	'<s:Body>' .
    		'<RegisterBusinessPartner xmlns="http://tempuri.org/" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">' .
    			'<idNumber>BBCBE727-451F-462A-A483-0C5E3CB541A3</idNumber>' .
    			'<userName>' . $USER . '</userName>' .
    			'<password>' . $PASS . '</password>' .
    			'<fields>' .
    				'<RegisterBusinessPartnerField>' .
    					'<FieldKey>FirstName</FieldKey>' .
    					'<Value>' . shalev_clinic___convert_text(htmlspecialchars($FirstName)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    				'<RegisterBusinessPartnerField>' .
    					'<FieldKey>LastName</FieldKey>' .
    					'<Value>' . shalev_clinic___convert_text(htmlspecialchars($LastName)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    				'<RegisterBusinessPartnerField>' .
    					'<FieldKey>Email</FieldKey>' .
    					'<Value>' . shalev_clinic___convert_text(htmlspecialchars($Email)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    				'<RegisterBusinessPartnerField>' .
    					'<FieldKey>CellPhone</FieldKey>' .
    					'<Value>' . shalev_clinic___convert_text(htmlspecialchars($CellPhone)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    				'<RegisterBusinessPartnerField>' .
    					'<FieldKey>RefferedBy</FieldKey>' .
    					'<Value>' . shalev_clinic___convert_text(htmlspecialchars($RefferedBy)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    				
    				'<RegisterBusinessPartnerField>' .
   					 '<FieldKey>CustomeField_113251</FieldKey>' .
   					 '<Value>' . shalev_clinic___convert_text(htmlspecialchars($ExtraData)) . '</Value>' .
    				'</RegisterBusinessPartnerField>' .
    
    			'</fields>' .
    		'</RegisterBusinessPartner>' .
    	'</s:Body>' .
    '</s:Envelope>';

	
$request_options = array(
		'headers' => array(
			'Content-Type' => 'text/xml; charset=utf-8',
			'SOAPAction' => $SERVICE_ACTION
		)
	);

$response_text = shalev_clinic___http_post_simple($SERVICE_URL, $request_body, $request_options);

if (strpos($response_text, '<IsSuccess>true</IsSuccess>') != false) {
   // header('Location: ' .$SUCCESS_URL); 
   echo "";
}
else {
    $error_message = shalev_clinic___get_tag_contents($response_text, 'faultstring');
    if ($error_message != NULL) {
        $error_message = "Exception: $error_message";
    }
    else {
        $error_message = shalev_clinic___get_tag_contents($response_text, 'ErrorMessage');
        if ($error_message == NULL) {
            $error_message = $response_text;
        }
    }
	
    mail("vladi03@gmail.com" , "error msg - toabox" , $error_message );
}	
}


function shalev_clinic___convert_text($stringg)
{
	return preg_replace("/([\xE0-\xFA])/e","chr(215).chr(ord(\${1})-80)",$stringg);
}

// very simple html tag parsing
function shalev_clinic___get_tag_contents($html, $tag_name) {
    $tag_open = "<$tag_name>";
    $tag_close = "</$tag_name>";
	

    $index_open = strpos($html, $tag_open);
	
    if ($index_open != false) {
        $index_open += strlen($tag_open);
        $index_close = strpos($html, $tag_close);

        return substr($html, $index_open, $index_close - $index_open);
    }
    else {
        return NULL;
    }
}


// like implode() just for assoc. arrays
function shalev_clinic___implode_assoc($outer_glue, $inner_glue, $array) {
	$output = array();
	foreach( $array as $key => $item )
			$output[] = $key . $inner_glue . $item;

	return implode($outer_glue, $output);
}


// wrapper for a simple HTTP POST request
function shalev_clinic___http_post_simple($url, $data, $request_options) {
	$opts = array(
		'http' => array(
			'method' => 'POST',
			'header' => shalev_clinic___implode_assoc("\r\n", ": ", $request_options['headers']) . "\r\n",
			'content' => $data
		)
	);
	
	$context = stream_context_create($opts);
	
	return file_get_contents($url, false, $context);
}


function einYahav_price_page()
{
	if( $_SESSION['einYahav']['userLogin'] != "o.k.1" && $_SESSION['einYahav']['userLogin'] != "o.k.2" )
	{
		einYahav_login_page();
	}
	else
	{
		if(isset($_GET['edit_users'])){
			return einYahav_edit_users_page();
		}
		echo "<div style='float:left;'><a href='?m=einYahav_login_page&edit_users=1&exit=1'>יציאה מהמערכת</a></div>";
		if($_SESSION['einYahav']['userLogin'] == "o.k.1"){
			echo "<div style='float:left;clear:left;'><a href='?m=einYahav_price_page&edit_users=1'>הוספת משתמשים למערכת</a></div>";
		}
		
		$sub_type = ( $_GET['ty'] == "" || $_GET['ty'] == "0" ) ? "0" : "1";
		
		if( $_GET['date1'] != "" )
		{
			$tempDate1 = explode("-" , $_GET['date1'] );
			$date1_val = $tempDate1[2]."-".$tempDate1[1]."-".$tempDate1[0];
			
			$sql = "select a.id, a.date1, a.price, p.pro_name , s.size_name FROM 
					einYahav_adv as a , einYahav_size as s , einYahav_products  as p WHERE type='".$sub_type."' and
					a.pro_id = p.id and a.size_id = s.id and a.deleted=0 and s.deleted=0 AND a.unk = '".UNK."' AND date1='".mysql_real_escape_string($date1_val)."' GROUP BY a.id order by a.id DESC";
			$res = mysql_db_query(DB,$sql);
			$nums = mysql_num_rows($res);
		}
		
		echo "<form action='index.php' method='get' name='date1_serach'>";
		echo "<input type='hidden' name='m' value='einYahav_price_page'>";
		echo "<input type='hidden' name='ty' value='".$sub_type."'>";
		echo "<table border=0 cellpadding='0' border='0' width=100%>";
			echo "<tr>";
				echo "<td align=center>בחר תאריך: </td>";
			echo "</tr>";
			echo "<tr><td height=5></td></tr>";
			echo "<tr>";
				echo "<td align=center><input type='text' name='date1' id='date1' value='".$_GET['date1']."' class='input_style' style='width: 140px; height: 30px; font-size: 16px; text-align:center;' onchange='date1_serach.submit();'></td>";
			echo "</tr>";
			if( $_GET['date1'] != "" )
			{
				echo "<tr><td height=20></td></tr>";
				echo "<tr>";
					echo "<td>";
					if( $nums > 0 )
					{
						echo "<table border=0 cellpadding='0' border='0' width=100% style='font-size: 15px;'>";
							echo "<tr>";
								echo "<td><b>המוצר</b></td>";
								echo "<td width=10></td>";
								echo "<td><b>גודל</b></td>";
								echo "<td width=10></td>";
								echo "<td><b>מחיר</b></td>";
							echo "</tr>";
							while($data = mysql_fetch_array($res) )
							{
								echo "<tr><td height=10 colspan=5></td></tr>";
								echo "<tr>";
									echo "<td>".stripslashes($data['pro_name'])."</td>";
									echo "<td width=10></td>";
									echo "<td>".stripslashes($data['size_name'])."</td>";
									echo "<td width=10></td>";
									echo "<td>".stripslashes($data['price'])."</td>";
								echo "</tr>";
							}
						echo "</table>";
					}
					else
						echo "לא נמצאו תוצאות";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</form>";
	}
}

function einYahav_edit_users_page(){
	if(isset($_REQUEST['edit_ey_user'])){		
			$full_name = str_replace("'","''",$_REQUEST['full_name']);
			$username = str_replace("'","''",$_REQUEST['username']);
			$password = str_replace("'","''",$_REQUEST['password']);		
			$ey_uid = $_REQUEST['edit_ey_user'];
			if($ey_uid == 'new'){
				$sql = "INSERT INTO einYahav_users (full_name,username,password) VALUES('$full_name','$username','$password')";
			}
			else{
				$sql = "UPDATE einYahav_users SET full_name = '$full_name',username = '$username',password = '$password' WHERE id = $ey_uid";
			}
			mysql_db_query(DB,$sql);
			echo "<h3 style='background:green;color:white;padding:5px;'>המשתמש עודכן בהצלחה</h3>";
	}
	if(isset($_REQUEST['delete_user'])){		
		$ey_uid = $_REQUEST['delete_user'];
		$sql = "DELETE FROM einYahav_users WHERE id = $ey_uid";
		mysql_db_query(DB,$sql);
		echo "<h3 style='background:green;color:white;padding:5px;'>המשתמש נמחק</h3>";
	}
	echo "<div style='float:left;'><a href='?m=einYahav_price_page'>חזור לרשימת מחירים</a></div>";
	$sql = "SELECT * FROM einYahav_users";
	$res = mysql_db_query(DB,$sql);
	?>
	
		<h3>רשימת משתמשים</h3>
		<table style="text-align:right;">

			<tr class='einYahav-user' id="einYahav_user_new_view">
				<td colspan='20' style="text-align:center; background:yellow;">הוספת משתמש</td>
			</tr>
			<tr>
				<th>שם מלא</th>
				<th>שם משתמש</th>
				<th>סיסמא</th>
				<th></th>
				<th></th>
			</tr>			
			<tr class='einYahav-user' id="einYahav_user_new_editor">
				<td>
					<form method="POST" action="?m=einYahav_price_page&edit_users=1">
						<input type="hidden" name="edit_ey_user" value="new" />
					<input name="full_name" value="" />
				</td>
				<td><input name="username" value="" /></td>
				<td><input name="password" value="" /></td>
				<td>
					<input type="submit" value="שמור" />
					</form>
				</td>
				<td></td>
			</tr>
			<tr class='einYahav-user' id="einYahav_user_<?php echo $eyuser['id']; ?>_view">
				<td colspan='20' style="text-align:center; background:yellow;">משתמשים קיימים</td>
			</tr>
			<tr>
				<th>שם מלא</th>
				<th>שם משתמש</th>
				<th>סיסמא</th>
				<th></th>
				<th></th>
			</tr>			
			<?php while($eyuser = mysql_fetch_array($res)){ ?>
				<tr class='einYahav-user' id="einYahav_user_<?php echo $eyuser['id']; ?>_view">
					<td><?php echo $eyuser['full_name']; ?></td>
					<td><?php echo $eyuser['username']; ?></td>
					<td><?php echo $eyuser['password']; ?></td>
					<td><a href='javascript://' onClick="open_einYahav_user_editor(<?php echo $eyuser['id']; ?>);">עריכה</a></td>
					<td><a href='?m=einYahav_price_page&edit_users=1&delete_user=<?php echo $eyuser['id']; ?>'>מחק</a></td>
				</tr>
				<tr class='einYahav-user' id="einYahav_user_<?php echo $eyuser['id']; ?>_editor" style="display:none;">
					<td>
						<form method="POST" action="?m=einYahav_price_page&edit_users=1">
							<input type="hidden" name="edit_ey_user" value="<?php echo $eyuser['id']; ?>" />
						<input name="full_name" value="<?php echo $eyuser['full_name']; ?>" />
					</td>
					<td><input name="username" value="<?php echo $eyuser['username']; ?>" /></td>
					<td><input name="password" value="<?php echo $eyuser['password']; ?>" /></td>
					<td>
						<input type="submit" value="שמור" />
						</form>
					</td>
					<td><a href='javascript://' onClick="close_einYahav_user_editor(<?php echo $eyuser['id']; ?>);">ביטול</a></td>
				</tr>				
			<?php } ?>
			
		</table>
		<script type="text/javascript">
			function open_einYahav_user_editor(uid){
				jQuery(function($){
					$("#einYahav_user_"+uid+"_view").hide();
					$("#einYahav_user_"+uid+"_editor").show();
				});
			}
			function close_einYahav_user_editor(uid){
				jQuery(function($){
					$("#einYahav_user_"+uid+"_view").show();
					$("#einYahav_user_"+uid+"_editor").hide();
				});
			}			
		</script>
	
	<?php
}

function einYahav_login_page()
{
	if(isset($_REQUEST['exit'])){
		unset($_SESSION['einYahav']['userLogin']);
		echo "<script>window.location.href='index.php?m=einYahav_login_page'</script>";
		exit;		
	}
	if( $_SESSION['einYahav']['userLogin'] == "o.k.1" ||  $_SESSION['einYahav']['userLogin'] == "o.k.2")
	{
		einYahav_price_page();
	}
	else
	{
		if( $_POST['sent'] == "1" )
		{
			if( $_POST['un1'] == "yofi2018" && $_POST['ps1'] == "yofi2018" )
			{
				$_SESSION['einYahav']['userLogin'] = "o.k.1";				
				echo "<script>window.location.href='index.php?m=einYahav_price_page&ty=".$_POST['ty']."'</script>";
				exit;
			}
			else{
				$username = str_replace("'","''",$_POST['un1']);
				$password = str_replace("'","''",$_POST['ps1']);
				$sql = "SELECT * FROM einYahav_users WHERE username = '$username' AND password='$password'";
				$res = mysql_db_query(DB,$sql);
				$ey_user_data = mysql_fetch_array($res);
				if($ey_user_data['full_name'] != ""){
					$_SESSION['einYahav']['userLogin'] = "o.k.2";				
					echo "<script>window.location.href='index.php?m=einYahav_price_page&ty=".$_POST['ty']."'</script>";
					exit;					
				}
				else
				{
					$msg = "שם משתמש ו\או הסיסמה אינם נכונים";
				}
			}
		}
		
		echo "<form action='index.php' method='post' name='loginForm'>";
		echo "<input type='hidden' name='m' value='einYahav_login_page'>";
		echo "<input type='hidden' name='sent' value='1'>";
		echo "<input type='hidden' name='ty' value='".$_GET['ty']."'>";
		echo "<table border=0 cellpadding='0' border='0'>";
			echo "<tr>";
				echo "<td colspan=3>".$msg."</td>";
			echo "</tr>";
			echo "<tr><td height=10 colspan=3></td></tr>";
			echo "<tr>";
				echo "<td>שם משתמש:</td>";
				echo "<td width=10></td>";
				echo "<td><input type='text' name='un1' class='input_style' style='width:140px; height:18px;'></td>";
			echo "</tr>";
			echo "<tr><td height=10 colspan=3></td></tr>";
			echo "<tr>";
				echo "<td>סיסמה:</td>";
				echo "<td width=10></td>";
				echo "<td><input type='password' name='ps1' class='input_style' style='width:140px; height:18px;'></td>";
			echo "</tr>";
			echo "<tr><td height=10 colspan=3></td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td width=10></td>";
				echo "<td><input type='submit' value='התחבר' class='submit_style' style='width:140px; height:18px;'></td>";
			echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
	
}


function kolaNegev_guides_homepage()
{
if( UNK != "263512086634836547" )
{
	echo "<table border=0 cellpadding='0' border='0'>";
		
		echo "<tr>";
			echo "<td>";
				getKobiaDesigner( "sales" , "3" , "id DESC");
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td>";
				
				$sql = "SELECT id, cat_name FROM user_guide_cats WHERE unk = '".UNK."' AND deleted=0 AND active=0 AND father=0 ORDER BY cat_name";
				$res = mysql_db_query(DB,$sql);
				
				echo "<table border=0 cellpadding='0' border='0'>";
					echo "<tr>";
						echo "<td>";
						$count = 0;
						$biz_id = array();
							while( $data = mysql_fetch_array($res) )
							{
								echo "<a href='index.php?m=KgBm&city=&Scat=".$data['id']."&STcat=0' class='maintext' style=' font-size: 14px;'>" . stripslashes($data['cat_name']) . "</a>";
								
								if( UNK == "192202924562351192" )
								{
									$sql = "SELECT b.id, b.business_name
											FROM 
												user_guide_business as b , user_guide_choosen_biz_guide as b_g, user_guide_choosen_biz_cat as b_c
											WHERE 
												b.deleted=0 AND
												b.active=0 AND
												b.id=b_g.biz_id AND
												".indexSite__global_settings('QueryHomepageBizWithGuideId')."
												b.unk = '".UNK."' AND 
												b_c.cat_id = '".$data['id']."' and
												b.id = b_c.biz_id
											GROUP BY b.id ORDER BY b.premium DESC, b.priority";
									$res2 = mysql_db_query(DB,$sql);
									
									echo "<table border=0 cellpadding='0' border='0'>";
										echo "<tr>";
											echo "<td>";
												$count = 0;
												while( $data2 = mysql_fetch_array($res2) )
												{
													$biz_idss = $data2['id'];
													if( !array_key_exists($biz_idss , $biz_id ) )
													{
														$biz_id[$biz_idss] = $data2['id'];
														echo "<a href='index.php?m=KgBm_p&pid=".$data2['id']."&guide=' class='maintext' style='text-decoration: none; color: #01567d;'>" . stripslashes($data2['business_name']) . "</a>";
														
														$count++;
														//if( $count % 7 == 0 )
														//	echo "<br>";
														//else
															echo "&nbsp;&nbsp;&nbsp;&nbsp;";
													}
												}
											echo "<td>";
										echo "</tr>";
										echo "<tr><td height=10></td></tr>";
									echo "</table>";
								}
								else
								{
									$count++;
									if( $count % 7 == 0 )
										echo "<br>";
									else
										echo "&nbsp;&nbsp;&nbsp;";
								}
								
							}
						echo "<td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		/*if( UNK != "192202924562351192" )
		{
			echo "<tr><td height=10></td></tr>";
			echo "<tr>";
				echo "<td>";
					$sql = "SELECT id, city_name FROM user_guide_cities WHERE unk = '".UNK."' and deleted=0 ORDER BY city_name";
					$res = mysql_db_query(DB,$sql);
					
					echo "<table border=0 cellpadding='0' border='0'>";
						
							
						while( $data = mysql_fetch_array( $res ) )
						{
							$sql = "SELECT b.id, b.business_name
											FROM 
												user_guide_business as b , user_guide_choosen_biz_city as bcity, user_guide_choosen_biz_guide as b_g
											WHERE 
												b.deleted=0 AND
												b.active=0 AND
												b.id=b_g.biz_id AND
												".indexSite__global_settings('QueryHomepageBizWithGuideId')."
												b.unk = '".UNK."' AND 
												bcity.city_id = '".$data['id']."' AND bcity.biz_id = b.id
											GROUP BY b.id ORDER BY b.premium DESC, b.priority";
							$res2 = mysql_db_query(DB,$sql);
							
							echo "<tr>";
								echo "<td><b style='color: #3c7b17; font-size: 14px;'>".stripslashes($data['city_name'])."</b><td>";
							echo "</tr>";
							echo "<tr><td height=2></td></tr>";
							echo "<tr>";
								echo "<td>";
									$count = 0;
									while( $data2 = mysql_fetch_array($res2) )
									{
										echo "<a href='index.php?m=KgBm_p&pid=".$data2['id']."&guide=' class='maintext' style='text-decoration: none; color: #01567d;'>" . stripslashes($data2['business_name']) . "</a>";
										
										$count++;
										//if( $count % 7 == 0 )
										//	echo "<br>";
										//else
											echo "&nbsp;&nbsp;&nbsp;&nbsp;";
										
									}
								echo "<td>";
							echo "</tr>";
							echo "<tr><td height=10></td></tr>";
						}
						
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}*/
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				$sql = "select hp_text from users where unk = '".UNK."'";
				$res_settings = mysql_db_query(DB,$sql);
				$data_settings = mysql_fetch_array($res_settings);
				
				echo stripslashes($data_settings['hp_text']);
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo indexSite__global_settings("indexHomepageBottomLinks");
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}
}


function ilbiz_side_from_hp()
{
	$str = "";
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		$str .= "<tr>";
			$str .= "<td><img src='/new_images/estimate_box_top_border.jpg' border=0 alt=''></td>";
		$str .= "</tr>";
		$str .= "<tr>";
			$str .= "<td background='/new_images/estimate_box_dup_border.jpg' width=205>";
				$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
					$str .= "<tr><td height=7></td></tr>";
					$str .= "<tr>";
						$str .= "<td align=center><h3 style='padding:0; margin:0;'>קבל הצעת מחיר לבניית אתר</h3></td>";
					$str .= "</tr>";
					$str .= "<tr><td height=10></td></tr>";
					$str .= "<tr>";
						$str .= "<td align=center>";
							$str .= "<div id='estimateSiteHeightDiv'><script type='text/javascript'>ajax_estimateSiteHeight(\"616\" , \"617\" , \"\" , \"\" )</script></div>";
						$str .= "</td>";
					$str .= "</tr>";
					$str .= "<tr><td height=10></td></tr>";
				$str .= "</table>";
			$str .= "</td>";
		$str .= "</tr>";
		$str .= "<tr>";
			$str .= "<td><img src='/new_images/estimate_box_bottom_border.jpg' border=0 alt=''></td>";
		$str .= "</tr>";
	$str .= "</table>";
	
	return $str;
}

function top_slice_search_shalevClinic()
{
	global $word;
	//!!!CODE_SERACH_ENGING_2_NOT_DELETE!!!
	
	$str = "<form action=\"index.php\" method=\"get\" name=\"search_form\" style='padding:0; margin:0;'>";
	$str .= "<input type=\"hidden\" name=\"m\" value=\"search\">";
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\" align=center>";
		$str .= "<tr>";
			$str .= "<td><input type=\"text\" name=\"search_val\" class=\"input_style\" style=\"width:150px; height: 20px; font-size: 16px;\"></td>";
			$str .= "<td width=\"2\"></td>";
			$str .= "<td><input type=\"submit\" value=\"".$word[LANG]['1_3_search_submit']."\" class=\"submit_style\" style=\"width:50px;  height: 24px; font-size: 16px;\"></td>";
		$str .= "</tr>";
	$str .= "</table>";
	$str .= "</form>";
	
	return $str;
}