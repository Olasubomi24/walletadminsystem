<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_utility extends CI_Model {
    
  /*  protected $return_type = 'array';
     public $before_create = array('prep_data');
   

    protected function prep_data($smsuser)
    {
         $smsuser['status'] = '1';
        return $smsuser;
        //$book['created_at'] = $book['updated_at'] = date('Y-m-d H:i:s');
      //  return $book;
    }
    */
    function __construct() {
        parent::__construct();
    }

    function get_user_table() {
        $table = 'USERS';
        return $table;
    }
	//==================TRANSACTIONS=================
	function get_transaction_table() {
        $table = 'TRANSACTIONS';
        return $table;
    }
	function _update_transaction($id, $data) {
        $table = $this->get_transaction_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }
    //=====================================================
	
	

    function getAll() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        return $query;
    }

    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where($id) {
        $table = $this->get_table();
        $this->db->where('ID', $id);
        $query = $this->db->get($table);
        return $query;
    }

    

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
    }

    function _update($id, $data) {
        $table = $this->get_table();
        $this->db->where('ID', $id);
        $this->db->update($table, $data);
    }

    function _delete($id) {
        $table = $this->get_table();
        $this->db->where('ID', $id);
        $this->db->delete($table);
    }

    function count_where($column, $value) {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

  
    function _custom_insert($table, $data) {
        $this->db->insert($table, $data);
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
         return $query;
    }

    

   function _custom_num_rows_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        $num_rows = $query->num_rows();
        return $num_rows;
    }
  
}
