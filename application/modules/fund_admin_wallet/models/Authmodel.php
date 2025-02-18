<?php 
class Authmodel extends CI_Model{
 
    

    public function validate_user($email,$password){
        $sqlQuery = $this->db->query("SELECT * FROM reconsilation")->result_array();
        return $sqlQuery;
    }
 
}
?>