<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Auth extends CI_Controller {

    // Declare properties explicitly
    public $session;
    public $form_validation;
    public $User_model;
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
    public $load;
    public $db;
    // private $User_model;
    public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
        $this->load->database();
        // Load dependencies properly

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    // Login functionality
    public function login() {
        if(is_logged_in()) redirect($this->session->userdata('role') === 'admin' ? 'admin/dashboard' : 'customer/dashboard');

        // Initialize core objects
        $this->load =& get_instance()->load;
        $this->session =& get_instance()->session;
        $this->form_validation =& get_instance()->form_validation;

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->User_model->get_by_credentials($username, $password);
            if($user) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => true
                ]);
                
                redirect($user->role === 'admin' ? 'admin/dashboard' : 'customer/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials');
                redirect('login');
            }
        }
        
        $this->load->view('auth/login');
    }

    // User registration
    public function register() {
        if(is_logged_in()) redirect('dashboard');

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if($this->form_validation->run()) {
            $user_data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'customer',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if($this->User_model->create($user_data)) {
                $this->session->set_flashdata('success', 'Registration successful! Please login');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
            }
        }
        
        $this->load->view('auth/register');
    }

    // Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
?>