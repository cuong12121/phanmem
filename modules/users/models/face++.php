<?php
class UsersModelsFace extends FSModels{
    function __construct(){
        parent::__construct();
        $this->table_name = 'fs_members';
    }
 	function checkExitsEmail($email)
    {
        global $db;

        if (!$email)
        {
            return false;
        }
        $sql = 'SELECT *
    			FROM '.$this->table_name.' 
    			WHERE email = \''.$email.'\'
    			';
        // $db->query($sql);
		return $db->getObject($sql);
    }
    function save($user)
    {
        global $db;
        $row = array();
        $row['email'] = $user->email;
        $row['username'] = $user->email;
        $row['face'] = 1;
        $row['full_name'] = $user->last_name.' '.$user->first_name;
        $row['gender'] = $user->gender;
        $row['published'] = 1;
        $row['created_time'] = date("Y-m-d H:i:s");
        $id = $this->_add($row, $this->table_name);
        return $id;
    }
    
}