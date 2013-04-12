<?php

require_once ('database.php');


class User{
		
	private $id;	
	private $first_name;
	private $last_name;
	private $if_admin;
	
	
	public function __construct($id, $first_name="", $last_name="", $if_admin="")
	{
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->if_admin = $if_admin;					
	}
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_first_name(){
		return $this->first_name;
	}
	
	public function get_full_name(){
		return	$this->first_name . " " . $this->last_name;
	}
	
	public function get_last_name(){
		return $this->last_name;
	}
	
	public function get_if_admin(){
		return $this->if_admin;
	}
	
	private static function hash_password($value)
	{
		return crypt($value, '$2a$useareallylongstringherebecause$');
	}
        
        public static function chk_pass($user_id, $password){
            
            global $database;
            
            $sql = " SELECT username ";
            $sql .= " FROM users ";
            $sql .= " WHERE user_id='" . $user_id . "' AND password= '" . (self::hash_password($password) . "'") ;
            
            $result = $database->query($sql);                        
            
            if($result){
                $array = $database->fetch_array($result);
                if(empty($array))
                    return false;
                else return true;
            }
            else
                return false;
            
        }
        
        public function change_password($password)
	{
		global $database;
				
		$password = self::hash_password($database->escape_value($password));

		$sql = "UPDATE users ";
		$sql .= " SET password = '" . $password . "'";
                                    
                $sql .= " WHERE user_id = " . $this->get_id();
		
		if($database->query($sql))
		{
			return true;
		}
		else
		{
			return false;		
		}
	}
        
	public static function get_user_by_id($id){
                
                global $database;
		
		$sql = "SELECT user_id, username, fname, lname, admin ";
		$sql .= " FROM users ";
                $sql .= " WHERE user_id = '" . $id . "' ";
                $sql .= " LIMIT 1";		                
                
		$result = $database->query($sql);
		$array_set = array();
                
		if($result)
		{
			while($array_set[] = $database->fetch_array($result)){}
                        return $array_set;
		}
		else 
			return false;
        }
        
        
	public static function get_all_users(){
                
                global $database;
		
		$sql = "SELECT user_id, username, fname, lname, admin ";
		$sql .= " FROM users ";		
		
		$result = $database->query($sql);
		$array_set = array();
                
		if($result)
		{
			while($array_set[] = $database->fetch_array($result)){}
                        return $array_set;
		}
		else 
			return false;
        }
	
	public static function authenticate($username, $password)
	{
		
		global $database;
		$username = $database->escape_value($username);
		$password = self::hash_password($database->escape_value($password));
		
		
		
		$sql = "SELECT user_id, fname, lname, admin ";
		$sql .= " FROM users ";
		$sql .= " WHERE username= '" . $username . "' and password= '" . $password . "' " ;		
		echo $sql;
		$result = $database->query($sql);
		
		if($result)
		{
			return $database->fetch_array($result);
		}
		else 
			return false;
		
	}
	
	public static function create($username="", $password="", $first_name="", $last_name="", $admin=0)
	{
		global $database;
		
		$username = $database->escape_value($username);
		$password = self::hash_password($database->escape_value($password));

		$sql = "INSERT INTO users (username,password,fname,lname,admin) ";
		$sql .= " VALUES ('" . $username . "', '" . $password . "', '" . $first_name . "', '" . $last_name . "', " . $admin . ")"; 
		
		if($database->query($sql))
		{
			return $database->insert_id();
		}
		else
		{
			return false;		
		}
	}
        
        public static function update($user_id, $username="", $password="", $first_name="", $last_name="", $admin=0)
	{
		global $database;
		
		$username = $database->escape_value($username);
                
                if(!empty($password) || $password != "")
                    $password = self::hash_password($database->escape_value($password));

		$sql = "UPDATE users ";
		$sql .= " SET username = '" . $username . "',first_name = '" . $first_name .
                        "',last_name = '" . $last_name . "' ,admin = " . $admin. " ";
                
                if(!empty($password) || $password != "")
                    $sql .= " , password ='" . $password . "'";
                    
                
                $sql .= " WHERE user_id = " . $user_id;
                                
		if($database->query($sql))
		{
			return true;
		}
		else
		{
			return false;		
		}
	}
        
        public static function delete($user_id)
	{
		global $database;	    	                            

		$sql = "DELETE FROM users ";                
                
                $sql .= " WHERE user_id = " . $user_id;
                                
		if($database->query($sql))
		{
			return true;
		}
		else
		{
			return false;		
		}
	}
		
}
?>