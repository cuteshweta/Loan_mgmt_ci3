<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Admin extends CI_Controller {

    // Declare common properties
    public $session;
    public $form_validation;
    public $Loan_model;
    public $Repayment_model;
    public $benchmark;
	public $hooks;
	public $config;
	public $log;
	public $utf8;
	public $uri;
	public $router;
	public $output;
	public $security;
	public $input;
	public $lang;
    public $db;

    public function __construct() {
        parent::__construct();
       
        if(!is_logged_in() || !is_admin()) redirect('auth/login');
        // Load dependencies
        $this->load =& get_instance()->load;
        $this->session =& get_instance()->session;
        $this->form_validation =& get_instance()->form_validation;
        $this->db =& get_instance()->db;
        $this->load->helper('auth');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Loan_model');
        $this->load->model('Repayment_model');
    }

    // Admin full loan list dashboard 
    public function dashboard() {
       // Get status from query parameter
        $status = $this->input->get('status');
        
        // Sanitize input
        $status = htmlspecialchars($status);
        
        // Pass to model to filter loans
        if($status!='')
        {
            $data['loans'] = $this->Loan_model->get_all_loans($status);
        }
        else{
            $data['loans'] = $this->Loan_model->get_all_loans();
        }
        
        $this->load->view('admin/dashboard', $data);
    }

    // List all loans with filter
    public function loans($status = null) {
       
        $data['loans'] = $this->Loan_model->get_all_loans($status);
        $data['current_filter'] = $status;
        $this->load->view('admin/loans', $data);
    }

    // Loan detail view
    public function loan_detail($loan_id) {
        $data['loan'] = $this->Loan_model->get_loan_details($loan_id);
        $data['repayments'] = $this->Repayment_model->get_by_loan_id($loan_id);
        $this->load->view('admin/loan_detail', $data);
    }

    // Update loan status (AJAX)
    public function update_loan_status() {
        
        $this->form_validation->set_rules('loan_id', 'Loan ID', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[approved,rejected]');

        if(!$this->input->is_ajax_request() || !$this->form_validation->run()) {
            $this->output->set_status_header(400);
            exit(json_encode(['error' => validation_errors()]));
        }

        $loan_id = $this->input->post('loan_id');
        $status = $this->input->post('status');
        $updatestatus=$this->Loan_model->update_status($loan_id, $status);
        if($updatestatus) {
            echo json_encode(['success' => true]);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Update failed']);
        }
    }

    // View repayment history
    public function repayments() {
        $data['repayments'] = $this->Repayment_model->get_all();
        $this->load->view('admin/repayments', $data);
    }
}
?>