<?php

class GenGraph
{
	
    public static function gen_year_to_year($records,$yearin,$yearout)
    {
    	
		$months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');		
		 		 
         $year_counter =1;  
		 $data = "";
		
		 foreach($records as $record){
		 
		 	$data .= "var d" . $year_counter . " = [";
			 		
		 	foreach($months as $month){
		 		$data .= "['" . $month . "'," . $record[$month] . "], ";
		 	}
			$data = substr($data, 0,-2);
		 
			$data  .= "];"; 
			$year_counter++;
		 }		
		 
		 $year_counter--;
		 
		 $the_vars = "";
		 
		 while($year_counter >0){
		 	$the_vars .= "{label:'" . $yearout . "',data:d" . $year_counter ."},";
			$yearout--;
			$year_counter--; 
		 }
		 
		 $the_vars = substr($the_vars, 0,-1);
          				
         
		   
     	$script_str = "<script type=\"text/javascript\">

				 $(function() { " . $data .  "

					$.plot(\"#placeholder\", [ " . $the_vars . " ],{
							
						series:{
							lines:{show:true},
							points:{show:true,fill:false}
						},	
						
						xaxis:{
							mode:\"categories\",
							tickLength: 0
						},
						
					legend:{
						show:true,
						noColumns: 2
					}	
					});
			
					 $(\"#footer\").prepend(\"Flot \" + $.plot.version + \" &ndash; \");
				 });</script>";

        return $script_str;
    }


    public static function gen_year_country($records,$countries)
    {
    	
    	$country_counter = 1;
		$country_labels;
		$data = "";
		$the_vars = "";
		
		foreach($countries as $the_country){
			
			$data .= "var d" . $country_counter . " = [";	
			
			foreach($records as $record){
		
				
		 
		 	if($record['country'] == $the_country){	
				
				 	
		 		$data .= "['" . $record['the_year'] . "'," . $record['yearamt'] . "], ";
		 	
				
		 	}
			
			
			
		 }		
		 
			 $data = substr($data, 0,-2);
			 
			 $data  .= "];";
			
			$country_counter++;		
		}
		
		
		$country_counter--;
		
		 		 
		           	
		while($country_counter >0){
		 	$the_vars .= "{label:'" . $countries[$country_counter-1] . "',data:d" . $country_counter ."},";			
			$country_counter--; 
		 }						
         
		   
     	$script_str = "<script type=\"text/javascript\">

				 $(function() { " . $data .  "

					$.plot(\"#placeholder\", [ " . $the_vars . " ],{
						series:{
							lines:{show:true},
							points:{show:true}
						},
						xaxis:{
							mode:\"categories\",
							tickLength: 0
						},
						legend:{
							show:true,
							numColumns:1
						}
					});
			
					 $(\"#footer\").prepend(\"Flot \" + $.plot.version + \" &ndash; \");
				 });</script>";

        return $script_str;
    } 
	
	public static function gen_country_year($records,$yearfrom,$yearto)
    {
		
		
        $data = "var data = [];";
		$labels = "";
		
		$counter = 0;
		 foreach($records as $record){
		 
		 	$data .= "data[" .$counter . "]={";
		 		$data .= "label:'" . $record['country'] . "',data:" . $record['yearamt'] . "}; ";
		 	$counter++;
		 }		
    
        $script_str = "<script type=\"text/javascript\">

				 $(function() { " . $data .  "

					$.plot(\"#placeholder\", data ,{
						series:{
							pie:{show:true,
							radius: 1,
					            label: {
					                show: true,
					                radius: 1,
					                formatter: labelFormatter,
					                background: {
					                    opacity: 0.8
					                }
					            }
							
							}
							
						},legend:{
							show:true,
							noColumns: 3,
							margin: -20
						}
						
					});
					function labelFormatter(label, series) {
		return \"<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>\" + label + \"<br/>\" + Math.round(series.percent) + \"%</div>\";
	}
			
					 $(\"#footer\").prepend(\"Flot \" + $.plot.version + \" &ndash; \");
				 });</script>";

        return $script_str;
    } 
}

?>