<?php

class CSVOPS
{
		
	public static function findStoreLimits($connection)
    {   
        $sql = "Select max(the_year) as max_year, min(the_year) as min_year FROM tourist_origins";	 
        
		$result = $connection->query($sql);
        $record_array = array();
        
        $values_count = 0;        
        
        while($record_array[] = $connection->fetch_array($result))
        {
            $values_count++;
        }
        
        array_pop($record_array);
        
        if($values_count>0)
        {
            return $record_array;
        }
        else
            return false;        
                
    }
	
    public static function readCSV($connection, $file_path)
    {
    	
		$limits = self::findStoreLimits($connection);   
        $row = 1;
		if (($handle = fopen($file_path, "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        $num = count($data);
				if($row == 1)
				{
					
				}
				else{
					
					if(end($data) > $limits[0]['max_year'] && end($data) < $limits[0]['min_year'])
					{
										
						self::writeCSVtoStore($connection,$data,$num);
						$row++;
					}
						
				}
				
		        
		        
		    }
		    fclose($handle);
		}

        return $row;
    }
	
	public static function storeCSV($filearr)
    {   
        $allowedExts = array("csv");
		$split_file_name = explode(".", $filearr["csv_file"]["name"]);
		$extension = end($split_file_name);
		if (($filearr["csv_file"]["type"] == "text/csv")
		&& ($filearr["csv_file"]["size"] < 2000000)
		&& in_array($extension, $allowedExts))
		{
		  if ($filearr["csv_file"]["error"] > 0)
		  {
		    return "error";
		  }
		  else
		  {
		      move_uploaded_file($filearr["csv_file"]["tmp_name"],
		      "upload/" . $filearr["csv_file"]["name"]);
		      return "upload/" . $filearr["csv_file"]["name"];	 
		   }
		  }
	      else
		  {
		  	return "error";
		  }


        return "";
    }     

	private static function writeCSVtoStore($connection, $row_data,$row_length)
    {   
		$sql = "INSERT INTO tourist_origins(origin, country, continent, january, february, march, april, may, june, july, august, september, october, november, december, yearamt, the_year)";	
        $sql .= " VALUES("; 
        
		$row_count = 0;
		
        foreach($row_data as $row){
        	$temp = $row;
			$row_count++;
			
			
			if($row_count < 4)
			{
				$sql .= "'" . $temp . "', ";
			}
			else{
				$sql .= $temp . ", ";
			}
        	
        }            
			
		$sql = substr($sql, 0, -2);	
		$sql .= ")";

        $result = $connection->query($sql);
            
        if($result){}
        else
            echo "problem";//$total_errors++;        
        
        
    }     
}

?>