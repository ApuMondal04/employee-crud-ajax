<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all customers with pagination and search
    public function get_all_customers($start = 0, $length = 10, $search = '', $order_column = 'id', $order_dir = 'asc') {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
        }

        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);
        $query = $this->db->get('customers');
        return $query->result_array();
    }

    // Count total number of customers
    public function count_all() {
        return $this->db->count_all('customers');
    }

    // Count filtered customers based on search
    public function count_filtered($search = '') {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
        }
        $this->db->from('customers');
        return $this->db->count_all_results();
    }

    // Get a single customer by ID
    public function get_customer($id) {
        $query = $this->db->get_where('customers', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new customer
    public function insert_customer($data) {
        return $this->db->insert('customers', $data);
    }

    // Update an existing customer
    public function update_customer($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('customers', $data);
    }

    // Delete a customer
    public function delete_customer($id) {
        $this->db->where('id', $id);
        return $this->db->delete('customers');
    }

    // Set customer status
    public function set_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('customers', array('status' => $status));
    }
}
