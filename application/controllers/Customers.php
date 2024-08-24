<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
    }


    public function index() {
        $data['customers'] = $this->Customer_model->get_all_customers();
        $this->load->view('customers/index', $data);
    }


    public function create() {
        $this->load->view('customers/create');
    }

  
    public function store() {
        $customer_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status')
        );

        $this->Customer_model->insert_customer($customer_data);
        redirect('customers');
    }

    public function edit($id) {
        $data['customer'] = $this->Customer_model->get_customer($id);
        $this->load->view('customers/edit', $data);
    }


    public function update($id) {
        $customer_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status')
        );

        $this->Customer_model->update_customer($id, $customer_data);
        redirect('customers');
    }

 
    public function delete($id) {
        $this->Customer_model->delete_customer($id);
        redirect('customers');
    }


    public function set_status($id, $status) {
        $customer_data = array(
            'status' => $status
        );

        $this->Customer_model->update_customer($id, $customer_data);
        redirect('customers');
    }

    public function fetch_data() {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value']; 
        $order_column = $this->input->post('order')[0]['column']; 
        $order_dir = $this->input->post('order')[0]['dir']; 
    
        $columns = array('id', 'name', 'email', 'status'); 
        $order_column_name = $columns[$order_column]; 
    
        $customers = $this->Customer_model->get_all_customers($start, $length, $search, $order_column_name, $order_dir);
        $total_records = $this->Customer_model->count_all();
        $filtered_records = $this->Customer_model->count_filtered($search);
    
        $data = array();
        foreach ($customers as $customer) {
            $data[] = array(
                'id' => $customer['id'],
                'name' => $customer['name'],
                'email' => $customer['email'],
                'status' => $customer['status'],
                'actions' => '<div class="action-buttons">'
                            . '<a href="' . site_url('customers/edit/' . $customer['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>'
                            . '<button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $customer['id'] . ')"><i class="fas fa-trash-alt"></i> Delete</button>'
                            . ($customer['status'] == 'active'
                                ? '<a href="' . site_url('customers/set_status/' . $customer['id'] . '/inactive') . '" class="btn btn-secondary btn-sm"><i class="fas fa-ban"></i> Deactivate</a>'
                                : '<a href="' . site_url('customers/set_status/' . $customer['id'] . '/active') . '" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Activate</a>'
                            )
                            . '</div>',
            );
        }
    
        $response = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $filtered_records,
            "data" => $data
        );
    
        echo json_encode($response);
    }
}
