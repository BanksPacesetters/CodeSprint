<?php

class Compare
{
	
    public static function down_trend($records,$yearfrom,$yearto,$no_country)
    {
    	
		$first_value=0;
		$last_value=0;
		$difference = 0;
		$the_country = "";
		$current_country="";
		$max_diff=0;
	
		foreach($records as $record){
			
				
			if(!in_array(trim($record['country']),$no_country)){
					if((strcasecmp($record['country'], $current_country)!=0) ){
			
					//$last_value = $record['yearamt'];
					$difference = $first_value - $last_value;
					if($difference > $max_diff){
						$max_diff = $difference;
						$the_country = $current_country;
			
					}
					
					$last_value = 0;
					$first_value = 0;
					$current_country = $record['country'];
					$first_value = $record['yearamt'];

				}
				else {
					$last_value = $record['yearamt'];
				}
			}	
				
			
			
			
			
			
		}
		
		
		
		return $the_country;
    }
	
	public static function up_trend($records,$yearfrom,$yearto,$no_country)
    {
    	
		$first_value=0;
		$last_value=0;
		$difference = 0;
		$the_country = "";
		$current_country="";
		$max_diff=0;
		
		foreach($records as $record){
			
				
			if(!in_array(trim($record['country']),$no_country)){
					if((strcasecmp($record['country'], $current_country)!=0) ){
					
	
					//$last_value = $record['yearamt'];
					$difference = $last_value - $first_value;
					if($difference > $max_diff){
						$max_diff = $difference;
						$the_country = $current_country;
	
					}
					
					$last_value = 0;
					$first_value = 0;
					$current_country = $record['country'];
					$first_value = $record['yearamt'];
	
				}
				else {
					$last_value = $record['yearamt'];
				}
			}	
				
			
			
			
			
			
		}
		
		
		
		return $the_country;
    }

 
}

?>