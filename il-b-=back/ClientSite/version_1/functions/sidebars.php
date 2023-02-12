<?php
function put_leftbar_items(){
	global $data_extra_settings,$data_colors;
	?>
	<?php if($data_colors['home_portal_version'] == '1'): ?>
	<?php require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/modules/hp.php"); version_1_hp_products($data); ?>
	<?php endif; ?>
	
	<?php 
	$fb_page = "https://www.facebook.com/pages/%D7%A9%D7%99%D7%A8%D7%95%D7%AA-10-%D7%9E%D7%97%D7%99%D7%A8-10/278800778833579"; 
	$fb_title = "שירות 10 מחיר 10";
	if($data_extra_settings['fb_page'] != ''){
		$fb_page = $data_extra_settings['fb_page'];
		$fb_title = $data_extra_settings['fb_title'];
	}
	?>
	<?php if($fb_page != "0"): ?>
	
		<style type="text/css">
		#fb-root {
		  display: none;
		}

		/* To fill the container and nothing else */
		.fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe[style] {
		  width: 100% !important;
		  position:static;
		}
		</style>
		<div class="fb-page" data-height="450" data-href="<?php echo $fb_page; ?>" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="<?php echo $fb_page; ?>">
					<a href="<?php echo $fb_page; ?>">‏
						<?php echo $fb_title; ?>
					‏</a>
				</blockquote>
			</div>
		</div>
	<?php endif; ?>
		<div class="clear-top"></div>
		<div class="top-banners">
			<?php
			if( $data_extra_settings['indexSite'] == "1" )
			{
						Guide_Banners("up" , "0" , "view" );
			}
			?>
		</div>
		
		<?php		
		$type_id = $_GET['t'];
		if($_GET['t'] == ""){
			$type_id = "text";
		}
		$sql = "select  primeryCat , subCat, cat_spec , choosenClientId from estimate_miniSite_defualt_block where unk = '".UNK."' AND type = '".$type_id."' ";
		$res = mysql_db_query(DB,$sql);
		$data_estimate2 = mysql_fetch_array($res);
		echo "<div class='sidebar-products'>";
			echo half_price_products($data_estimate2['primeryCat'] , $data_estimate2['subCat'], $data_estimate2['cat_spec'] , 0 ); 	
			//echo "<div style='direction:ltr; text-align:left;'>1: ".$data_estimate2['primeryCat']." ,2: ". $data_estimate2['subCat'].", 3:". $data_estimate2['cat_spec']."<br/></div>";
			
		echo "</div>";		
		if( $data_estimate2['choosenClientId'] == "0" )
		{
			echo "<div>";
					echo get_category_product_supliers_cubes( $data_estimate2['primeryCat'] , $data_estimate2['subCat'], $data_estimate2['cat_spec'] , 0 );
			echo "</div>";
		}

			echo "<div class='net_clients_cat_banner_wrap'>";
					echo get_net_clients_cat_banner( $data_estimate2['primeryCat'] , $data_estimate2['subCat'], $data_estimate2['cat_spec']);
			echo "</div>";				
		
		?>
	<?php
}
