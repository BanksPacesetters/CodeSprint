<?php

//redirect to another page
function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function get_court_by_id($court_id)
{
    global $database;    
    
    $sql = "SELECT court_name FROM courts WHERE court_id= " . $court_id . " LIMIT 1";     
    $result = $database->query($sql);
    
    if($result)
    {
        $court = $database->fetch_array($result);
        return $court;
    }
    else
        return false;        
}



function get_courts()
{
    global $database;
    $sql = "SELECT court_id, court_name FROM courts ";
            
    $result = $database->query($sql);
    
    $result_array = array();    
    
    if($result)
    {
        while($result_array[]=$database->fetch_array($result)){}
        array_pop($result_array);
        return $result_array;
    }
    else
        return false;        
}

function get_court_fields($id=-1)
{
    global $database;    
    
    $courts = get_courts();
    
    $str = "";
    
    $str .= "<option value=''>-</option>";
    foreach($courts as $court)
    {
        if($court['court_id']== $id)
            $str .= "<option selected='true' value='" . $court['court_id'] . "'>" . $court['court_name'] . "</option>";
        else        
            $str .= "<option value='" . $court['court_id'] . "'>" . $court['court_name'] . "</option>";
    }
    
    return $str;
    
}

function get_next_work_week()
{
    return date("Y-m-d", strtotime("+1 week"));
    
}

function style_event_list($events)
{
    $str = "<ul>";
    if(!empty($events))
    {
        foreach($events as $event)
        {
            $str .= "<li>" . $event['details'] . " (" . $event['date'] . ")</li><hr /> ";
        }
        
        $str = substr($str, 0, -2);
    }
    $str .= "</ul>";    
    
    
    return $str;
}

function get_person_list($persons)
{
    $str = "";
    if(!empty($persons))
    {
        foreach($persons as $person)
        {
            $str .= $person['fname'] . " " . $person['lname'] . ", ";
        }
        
        $str = substr($str, 0, -2);
    }
    
    return $str;
}

function get_client_fields($id=-1)
{
    global $database;    
    
    $clients = Client::get_all_clients($database);    
    
    $str = "";
    
    $str .= "<option value=''>-</option>";
    
    foreach($clients as $client)
    {
        if($client['client_id'] == $id)
            $str .= "<option selected='true' value='" . $client['client_id'] . "'>" . $client['fname'] . " " . $client['lname'] . "</option>";
        else
            $str .= "<option value='" . $client['client_id'] . "'>" . $client['fname'] . " " . $client['lname'] . "</option>";
    }
    
    return $str;
    
}

function option_list_clients($clients)
{    
    $str = "";
     
    foreach($clients as $client)
    {
        $str .= "<option value='" . $client['client_id'] . "'>" . $client['fname'] . " " . $client['lname'] . "</option>";
    }
    
    return $str;
    
}

function create_month_form($num_of_month){
    $str= "<form id='calendar_form' method='post' action=''><select name='calendar_month'>";
    
    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $mon_num=1;
    foreach($months as $month)
    {
        if($num_of_month == $mon_num)
            $str .= "<option selected='true' value='" . $mon_num . "'>" . $month . "</option>";
        else    
            $str .= "<option value='" . $mon_num . "'>" . $month . "</option>";
        
        $mon_num++;
    }
    
    $str .= "</select></form>";
    return $str;
}
?>