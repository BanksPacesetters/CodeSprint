<?php

class Extractor
{
	
    public static function trend_data_by_year($connection, $yearFrom, $yearTo)
    {   
       	$sql = "SELECT the_year, sum(yearamt) as visitors FROM tourist_origins where the_year >=" . $yearFrom . " AND the_year <=" . $yearTo . " group by the_year";
        
        
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
	
	public static function get_countries($connection)
    {   
       	$sql = "SELECT country FROM tourist_origins group by country";
        
        
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
	
	public static function months_by_year_trend_data($connection, $yearFrom, $yearTo,$country)
    {   
       	$sql = "SELECT the_year, sum(january) as january ,sum(february) as february, sum(march) as march, sum(april) as april,sum(may) as may ,sum(june) as june,sum(july) as july,sum(august) as august, sum(september) as september,sum(october) as october,sum(november) as november,sum(december) as december FROM tourist_origins where the_year >=" . $yearFrom . " AND the_year <=" . $yearTo; 
        
        if($country != ""){
        	$sql .= " AND country = '" . $country . "'";
		}
		
		$sql .= " group by the_year";
		
		
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
	
	public static function trend_data_by_year_sort_country($connection, $yearFrom, $yearTo)
    {   
       	$sql = "SELECT country,the_year,  sum(yearamt) as yearamt FROM tourist_origins where the_year >=" 
       			. $yearFrom . " AND the_year <=" . $yearTo . "  group by country, the_year order by country, the_year";
       
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
	
	public static function trend_data_by_country_year($connection, $yearFrom, $yearTo)
    {   
       	$sql = "SELECT country, sum(yearamt) as yearamt FROM tourist_origins where the_year >=" 
       			. $yearFrom . " AND the_year <=" . $yearTo . "  group by country";
       
        
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
	
	public static function months_by_year_trend_data_by_country($connection, $yearFrom, $yearTo, $country)
    {   
       	$sql = "SELECT the_year, sum(january) as january ,sum(february) as february, sum(march) as march, sum(april) as april,sum(may) as may ,sum(june) as june,sum(july) as july,sum(august) as august, sum(september) as september,sum(october) as october,sum(november) as november,sum(december) as december FROM tourist_origins where the_year >=" .
       			 $yearFrom . " AND the_year <=" . $yearTo . "AND country='" . $country .  "' group by the_year";
       			 
        
        
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
	
	public static function months_by_year_trend_data_by_continent($connection, $yearFrom, $yearTo, $cont)
    {   
       	$sql = "SELECT the_year, sum(january) as january ,sum(february) as february, sum(march) as march, sum(april) as april,sum(may) as may ,sum(june) as june,sum(july) as july,sum(august) as august, sum(september) as september,sum(october) as october,sum(november) as november,sum(december) as december FROM tourist_origins where the_year >=" .
       			 $yearFrom . " AND the_year <=" . $yearTo . "AND continent='" . $cont .  "' group by the_year";
       			 
        
        
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
	
	
	
}

?>