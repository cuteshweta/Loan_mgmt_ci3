<?php
#[\AllowDynamicProperties]
class Customer extends CI_Controller {

    public $session;
    public $form_validation;
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
    public $Loan_model;
    public $Repayment_model;
    public $db;
    public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
        $this->load->model('Loan_model');
        $this->load->model('Repayment_model');
        // Initialize core components
        $this->load =& get_instance()->load;
        $this->session =& get_instance()->session;
        $this->form_validation =& get_instance()->form_validation;
        $this->db =& get_instance()->db;
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        if(!is_logged_in() || is_admin()) redirect('auth/login');
    }

    public function dashboard() {
        $data['loans'] = $this->Loan_model->get_user_loans($this->session->userdata('user_id'));
        $this->load->view('customer/dashboard', $data);
    }

    public function apply_loan() {
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('tenure', 'Tenure', 'required|integer');
        if($this->form_validation->run()) {
            $loan_data = [
                'user_id' => $this->session->userdata('user_id'),
                'amount' => $this->input->post('amount'),
                'tenure' => $this->input->post('tenure'),
                'purpose' => $this->input->post('purpose')
            ];
            $this->Loan_model->apply_loan($loan_data);
            redirect('customer/dashboard');
        }
        $this->load->view('customer/apply_loan');
    }
    // View repayments
    public function repayments() {
        $user_id = $this->session->userdata('user_id');
        $data['repayments'] = $this->Repayment_model->get_pending($user_id);
        $data['total_pending'] = array_sum(array_column($data['repayments'], 'amount'));
        
        $this->load->view('customer/repayments', $data);
    }

    // Handle payment
    public function make_payment() {
        $this->form_validation->set_rules('repayment_id', 'Repayment ID', 'required|numeric');
        
        if($this->form_validation->run()) {
            $repayment_id = $this->input->post('repayment_id');
            $user_id = $this->session->userdata('user_id');
            
            if($this->Repayment_model->is_owned_by_user($repayment_id, $user_id)) {
                $this->Repayment_model->mark_as_paid($repayment_id);
                $this->session->set_flashdata('success', 'Payment successful!');
            } else {
                $this->session->set_flashdata('error', 'Invalid repayment');
            }
        }
        redirect('customer/repayments');
    }
}
?>