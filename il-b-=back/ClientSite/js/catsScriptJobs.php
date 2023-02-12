<?
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
header("content-type: application/x-javascript; charset=windows-1255");

define( 'UNK' , $_GET['unk'] );

$sql = "SELECT bc.id , bc.cat_name  FROM 
		biz_categories as bc , user_wanted_cats as wc , user_wanted as uw WHERE 
			bc.father=0 AND 
			bc.status=1 AND 
			bc.hidden=0 AND
			
			wc.cat_id=bc.id AND
			uw.id=wc.wanted_id  AND
			uw.unk = '".UNK."' AND
			uw.deleted=0
			
			GROUP BY bc.id ORDER BY bc.place";
$resCat = mysql_db_query(DB,$sql); 

$tatCatList = "";
$specList = "";

	while( $dataCat = mysql_fetch_array($resCat) )
	{
		$sql = "SELECT bc.id , bc.cat_name  FROM 
			biz_categories as bc , user_wanted_cats as wc , user_wanted as uw WHERE 
				bc.father=".$dataCat['id']." AND 
				bc.status=1 AND 
				bc.hidden=0 AND
				
				wc.cat_id=bc.id AND
				uw.id=wc.wanted_id  AND
				uw.unk = '".UNK."' AND
				uw.deleted=0
				
				GROUP BY bc.id ORDER BY bc.place";
		$resTatCat = mysql_db_query(DB,$sql); 
		
		$tatCatList_string = "";
		while( $dataTatCat = mysql_fetch_array($resTatCat) )
		{
			$tatCatList_string .= "\"".str_replace('"' , '&quot;' , stripslashes($dataTatCat['cat_name']))."|".$dataTatCat['id']."\",";
			
			$sql = "SELECT bc.id , bc.cat_name  FROM 
			biz_categories as bc , user_wanted_cats as wc , user_wanted as uw WHERE 
				bc.father=".$dataTatCat['id']." AND 
				bc.status=1 AND 
				bc.hidden=0 AND
				
				wc.cat_id=bc.id AND
				uw.id=wc.wanted_id  AND
				uw.unk = '".UNK."' AND
				uw.deleted=0
				
				GROUP BY bc.id ORDER BY bc.place";
			$resSpec = mysql_db_query(DB,$sql); 
			
			$specList_string = "";
			while( $dataSpec = mysql_fetch_array($resSpec) )
			{
				$specList_string .= "\"".str_replace('"' , '&quot;' , stripslashes($dataSpec['cat_name']))."|".$dataSpec['id']."\",";
			}
			
			if( $specList_string != "" )
			$specList .= "specList[".$dataTatCat['id']."]=[\"בחר בהתמחות|0\", ".substr($specList_string , 0, -1)." ]\n";
		}
		
		$tatCatList .= "tatCatList[".$dataCat['id']."]=[\"בחר בתחום|0\", ".substr($tatCatList_string , 0, -1)." ]\n";
	}
	
?>

function changeCatChain(selectObj)
{
	updateTatCat(selectObj.value);
	updateSpecCat(99999999999999999);
	document.searchByCats.Sspec.style.display='none';
}

function updateTatCat(selectedCat)
{
	var tatCat=document.searchByCats.STcat;
	
	var tatCatList=new Array()
	tatCatList[0]=""
	
	<?php
	echo $tatCatList;
	?>
	
	selected_cat = '<?=$_GET['STcat'];?>';
	tatCat.options.length=0
	if (selectedCat>0){
	count = 0;
		if( tatCatList[selectedCat] != null )
		{
			for (i=0; i<tatCatList[selectedCat].length; i++)
			{
				selected_i = tatCatList[selectedCat][i].split("|")[1];
				
				if( selected_cat == selected_i )
					sed = selected_cat;
				else
					sed = false;
				
				tatCat.options[tatCat.options.length]=new Option(tatCatList[selectedCat][i].split("|")[0], tatCatList[selectedCat][i].split("|")[1] , false , sed  )
				count ++ ;
			}
		}
	}
	
	if( count > 0 )
		tatCat.style.display='inline';
	else
		tatCat.style.display='none';
}


function changeSTcatChain(selectObj)
{
	updateSpecCat(selectObj.value);
}



function updateSpecCat(selectedCat)
{
	var spec=document.searchByCats.Sspec;
	
	var specList=new Array()
	specList[0]=""
	
	<?
	echo $specList;
	?>
	
	
	selected_cat = '<?=$_GET['Sspec'];?>';
	spec.options.length=0
	if (selectedCat>0){
	count=0;
		if( specList[selectedCat] != null )
		{
			for (i=0; i<specList[selectedCat].length; i++)
			{
				selected_i = specList[selectedCat][i].split("|")[1];
				
				if( selected_cat == selected_i )
					sed = selected_cat;
				else
					sed = false;
					
				spec.options[spec.options.length]=new Option(specList[selectedCat][i].split("|")[0], specList[selectedCat][i].split("|")[1] , false , sed )
				count++;
			}
		}
	}
	
	if( count > 0 )
		spec.style.display='inline';
	else
		spec.style.display='none';
}