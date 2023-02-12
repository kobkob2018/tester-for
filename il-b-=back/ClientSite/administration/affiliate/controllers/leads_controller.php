<?php
  class LeadsController extends Controller{
	public $add_models = array("leads");
    public function all() {
		$date = new DateTime();
		$month_first_day = $date->format('01-m-Y');
		$today = $date->format('d-m-Y');
		$filter = array(
			"date_from"=>$month_first_day,
			"date_to"=>$today,
			"date_from_str"=>"",
			"date_to_str"=>"",
			"phone"=>"",
			"name"=>"",
			"email"=>"",
		);
		if(isset($_REQUEST['leads_filter'])){
			$_SESSION['leads_filter'] = $_REQUEST['leads_filter'];
			$filter = $_REQUEST['leads_filter'];
		}
		elseif(isset($_SESSION['leads_filter'])){
			$filter = $_SESSION['leads_filter'];
		}
      // we store all the posts in a variable
      $leads_data = Leads::all($filter);
	  $leads = $leads_data['list'];
	  $lead_count = $leads_data['lead_count'];
	  $totals_list = $leads_data['totals_list'];
      include('views/leads/all.php');
    }

    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $lead = Leads::find($_GET['id']);
      include('views/leads/show.php');
    }
    public function resetfilter() {
		unset($_SESSION['leads_filter']);
		$url = "/affiliate/leads/all/";
		header('Location: '.$url);
	}	
  }
?>