<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        $CI =& get_instance();
        return $CI->session->userdata('logged_in') === true;
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        $CI =& get_instance();
        return $CI->session->userdata('role') === 'admin';
    }
}
?>