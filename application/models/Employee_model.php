<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_employees($start = 0, $length = 10, $search = '', $order_column = 'id', $order_dir = 'asc') {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
        }

        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);
        $query = $this->db->get('employees');
        return $query->result_array();
    }

    public function count_all() {
        return $this->db->count_all('employees');
    }

    public function count_filtered($search = '') {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
        }
        $this->db->from('employees');
        return $this->db->count_all_results();
    }

    public function get_employee($id) {
        return $this->db->get_where('employees', array('id' => $id))->row_array();
    }

    public function insert_employee($data) {
        return $this->db->insert('employees', $data);
    }

    public function update_employee($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('employees', $data);
    }

    public function delete_employee($id) {
        $this->db->where('id', $id);
        return $this->db->delete('employees');
    }

    public function set_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('employees', array('status' => $status));
    }
}
