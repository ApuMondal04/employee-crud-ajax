<?php
class Employees extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->helper('url');
       
    }

    public function index() {
        $data['employees'] = $this->Employee_model->get_all_employees();
        $this->load->view('employees/index', $data);
    }

    public function create() {
        $this->load->view('employees/create');
    }

    public function store() {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status')
        );
        $this->Employee_model->insert_employee($data);
        $this->session->set_flashdata('success', 'Employee added successfully!');
        redirect('employees');
    }

    public function edit($id) {
        $data['employee'] = $this->Employee_model->get_employee($id);
        $this->load->view('employees/edit', $data);
    }

    public function update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status')
        );
        $this->Employee_model->update_employee($id, $data);
        redirect('employees');
    }

    public function delete($id) {
        $this->Employee_model->delete_employee($id);
        redirect('employees');
    }

    public function set_status($id, $status) {
        $this->Employee_model->set_status($id, $status);
        redirect('employees');
    }

    public function fetch_data() {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value']; 
        $order_column = $this->input->post('order')[0]['column']; 
        $order_dir = $this->input->post('order')[0]['dir']; 
    
        $columns = array('id', 'name', 'email', 'status'); 
        $order_column_name = $columns[$order_column]; 
    
        $employees = $this->Employee_model->get_all_employees($start, $length, $search, $order_column_name, $order_dir);
        $total_records = $this->Employee_model->count_all();
        $filtered_records = $this->Employee_model->count_filtered($search);
    
        $data = array();
        foreach ($employees as $employee) {
            $data[] = array(
                'id' => $employee['id'],
                'name' => $employee['name'],
                'email' => $employee['email'],
                'status' => $employee['status'],
                'actions' => '<div class="action-buttons">'
                            . '<a href="' . site_url('employees/edit/' . $employee['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>'
                            . '<button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $employee['id'] . ')"><i class="fas fa-trash-alt"></i> Delete</button>'
                            . ($employee['status'] == 'active'
                                ? '<a href="' . site_url('employees/set_status/' . $employee['id'] . '/inactive') . '" class="btn btn-secondary btn-sm"><i class="fas fa-ban"></i> Deactivate</a>'
                                : '<a href="' . site_url('employees/set_status/' . $employee['id'] . '/active') . '" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Activate</a>'
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
