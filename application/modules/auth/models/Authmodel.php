<?php 
class Authmodel extends CI_Model{
    public function insert_data($user_data){
        $sqlQuery  = $this->db->insert('user_details', $user_data);
        return $sqlQuery;
    }
    public function check_user_email($user_email){
        $sqlQuery = $this->db->get_where('user_details', array('email'=>$user_email))->result_array();
        return $sqlQuery;
    }

    public function validate_user($email,$password){
        $sqlQuery = $this->db->query("SELECT first_name,last_name,email,staff_type,staff_id FROM user_details WHERE email='$email' AND password='$password'")->result_array();
        return $sqlQuery;
    }
}
?>