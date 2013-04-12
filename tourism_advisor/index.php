<?php
session_start();

date_default_timezone_set('America/La_Paz');

require_once "lib/database.php";
require_once "lib/csvops.php";
require_once "lib/info_extract.php";
require_once "lib/gen_graph.php";
require_once "lib/compare.php";
require_once "lib/user.php";
require_once "lib/template.inc.php";
require_once "lib/session.inc.php";
require_once "lib/paginator.php";
require_once "lib/misc_ops.php";

$database = new MySQLDatabase();
$person = "";

// if(isset($_SESSION['user']))
// {
	// $person = unserialize($_SESSION['user']);
        // //print_r($person);
// 
        // $mon_for_calendar = "";
        // if(isset($_REQUEST['calendar_month']))
            // $mon_for_calendar = $_REQUEST['calendar_month'];
//         
      // $page = array (
                        // 'site_name'     => 'Case Files',
                        // 'calendar'      => Display::calendar($database, $mon_for_calendar),
			//'primary_links' => '<a href="#" class="pitem">Home</a>
              //                  <a href="?action=visitors" class="pitem">Visitors</a>
                //                <a href="?action=seasons" class="pitem">Seasons</a>' ,
			// //'breadcrumbs' => "",
			// 'section_links' => '<a class="menu-right" href="?action=client_search">Client Search</a>
                                            // <a class="menu-right" href="?action=case_search">Case Search</a>
                                            // <a class="menu-right" href="?action=case_entry">New Case</a>
                                            // <a class="menu-right" href="?action=client_entry">New Client</a>
                                            // <a class="menu-right" href="?action=chg_password">Change Password</a>',
                        // 'footer'        => "Logged in as " . $person->get_full_name() . " &nbsp;&nbsp;<a href='?action=logout'>Log out</a>"                   
		// );
//         
        // if($person->get_if_admin()==1)
        // {
            // $page['section_links'] .= '<a class="menu-right" href="?action=create_user">Create User</a>';
        // }
// }
// else
// {
    // $page = array (
			// 'site_name' => 'Case Files',
                        // 'calendar'      => "",
                        // 'primary_links' => "",
                        // 'section_links' =>"",
                        // 'page_name'     => "User Login",
			// 'content' => parse("pages/login.html"),
                        // 'footer'        => ""  
			// );
// }
// 
// // 1. the current page number ($current_page)
// $thepage = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
// 
// $insert_array = array('case_num' => 1, 'court_id'=>1, 'date'=>'2011-09-30');
// 
// 
// $fname="";
// $lname="";
// $client_id="";

$plinks = "<a href='index.php' class='pitem'>Home</a>
           <a href='?action=trend-country-year-month' class='pitem'>Visitor Trend</a>
           <a href='?action=trendup' class='pitem'>Trending up</a>
           <a href='?action=trenddn' class='pitem'>Trending Down</a>
           <a href='?action=start-upload' class='pitem'>Upload Data</a>";

//handle all incoming requests
$request = @$_REQUEST['action'];

if(($request == NULL || empty($request)) && isset($_SESSION['user']))
{
    redirect_to("index.php?action=trends");   
}

switch($request) {
	
	case 'trendup':
		
		
		$no_country = array();
		$counter = 5;
		
		while($counter >0){
			$data= Extractor::trend_data_by_year_sort_country($database,2005,2011);
			$the_country = Compare::up_trend($data,2005,2011,$no_country);
			$no_country[] = $the_country;
			$counter--;	
		}
		
		
		//echo $the_country;
		$extra_content = GenGraph::gen_year_country($data,$no_country);
		//echo $extra_content;
		
		$page = array (
			 'site_name' => "Tourism Marketing Advisor",
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Top 5 Countries Trending Up",
                         'scripts' => $extra_content,
			 'content' => parse("pages/trends.html"), 
                         'footer'        => ""  
			 );
	 
	 			
	 
	 break;
        
	case 'trenddn':
		
		$no_country = array();
		$counter = 5;
		
		while($counter >0){
			$data= Extractor::trend_data_by_year_sort_country($database,2005,2011);
			$the_country = Compare::down_trend($data,2005,2011,$no_country);
			$no_country[] = $the_country;
			$counter--;	
		}
		$extra_content = GenGraph::gen_year_country($data,$no_country);
		//echo $extra_content;
		
		$page = array (
			 'site_name' => "Tourism Marketing Advisor",
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Top 5 Countries Trending Down",
                         'scripts' => $extra_content,
			 'content' => parse("pages/trends.html"), 
                         'footer'        => ""  
			 );
	 
	 			
	 
	 break;
	 
	 case 'trend-country-year-month':
	 
		$added = ""; 
	 	$yearin = 2006;
		$yearout = 2011;
		
		if(isset($_POST['from_year']) && isset($_POST['to_year']))
		{
			$yearin = $_POST['from_year'];
			$yearout = $_POST['to_year'];
		}
		
		//$extra_content = GenGraph::gen_year_to_year(Extractor::months_by_year_trend_data($database,$yearin,$yearout));
		$data= Extractor::trend_data_by_country_year($database,$yearin,$yearout);
		
		if(!empty($data)){
			$extra_content = GenGraph::gen_country_year($data,$yearin,$yearout);	
		}
		else{
			$extra_content = "";
			$added = "Data not found";
		}
		
		//echo $the_country;
		
		//echo $extra_content;
		
		$page = array (
			 'site_name' => "Tourism Marketing Advisor",
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Visitors From Various Countries " . $yearin . " to " . $yearout . " - " . $added,
                         'scripts' => $extra_content,
			 'content' => parse("pages/month-year.html"),//. $extra_content, 
                         'footer'        => ""  
			 );
	 
	 			
	 
	 break;
	 	
	case 'upload':
		
		
		$error = CSVOPS::storeCSV($_FILES);
		
		if($error = "error")
		{
			$rows = CSVOPS::readCSV($database,"upload/" . $_FILES["csv_file"]["name"]); 
		
			if($rows >1)
			{
				$upload_data = "Last Upload Successful";
			}
			else {
				$upload_data = "Last Upload Unsuccessful - Data was already uploaded.";
			}
			
		}
		else {
				$upload_data = "Last Upload Unsuccessful - CSV File Error";
			}
		
		
		$page = array (
			 'site_name' => 'Tourism Marketing Advisor',
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Upload CSV Data - " . $upload_data,
                         'scripts' => "",
			 'content' => parse("pages/upload.html"),
                         'footer'        => ""  
			 );  
		                       
                
                    
   		break;
		
		case 'start-upload': 
		
		$page = array (
			 'site_name' => 'Tourism Marketing Advisor',
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Upload CSV Data",
                         'scripts' =>"",
			 'content' => parse("pages/upload.html"),
                         'footer'        => ""  
			 );                       
                
                    
   		break;
    
        default:
			
			$yearin = 2006;
		$yearout = 2011;
		$country_select = "";
		$add_to_display = "";
		
		if(isset($_POST['from_year']) && isset($_POST['to_year']))
		{
			$yearin = $_POST['from_year'];
			$yearout = $_POST['to_year'];
		}
		if(isset($_POST['country_select']))
		{
			$country_select = $_POST['country_select'];
		}
		
		if($country_select != "")
		{
			$add_to_display = " For " . $country_select;
		}
		
			$data = Extractor::months_by_year_trend_data($database,$yearin,$yearout,$country_select);
			
			if(!empty($data)){
				$extra_content = GenGraph::gen_year_to_year($data,$yearin,$yearout);	
			}	
			else {
				$extra_content = "";
				$add_to_display = " - No Data to display";
			}
			
			$page = array (
			 'site_name' => "Tourism Marketing Advisor",
                         'calendar'      => "",
                         'primary_links' => $plinks,
                         'section_links' =>"",
                         'page_name'     => "Trends By Year - " . $yearin . " to " . $yearout . $add_to_display,
			 'content' => parse("pages/front.html"),
			             'scripts' => $extra_content,			         
                         'footer'        => ""  
			 );
        break;
}

//to always output a the page, removes multiple statements like this
print template("pages/template.html",$page);	

?>