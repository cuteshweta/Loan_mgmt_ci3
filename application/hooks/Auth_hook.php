<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_hook {
    protected $CI;

    public function __construct() {
        // Get CodeIgniter instance
        $this->CI =& get_instance();
    }

    public function check_login() {
        // Load required components
        $this->CI->load->helper('auth');
        $this->CI->load->library('session');

        // Skip authentication for these routes
        $excluded_routes = [
            'auth/login',
            'auth/register'
        ];

        $current_route = $this->CI->uri->segment(1).'/'.$this->CI->uri->segment(2);

        if (!in_array($current_route, $excluded_routes)) {
            if (!is_logged_in()) {
                redirect('auth/login');
            }
        }
    }
}?>