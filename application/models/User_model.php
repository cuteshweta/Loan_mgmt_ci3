<?php
class User_model extends CI_Model {
    protected $db;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    public function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function get_by_credentials($username, $password) {
        $user = $this->db->get_where('users', ['username' => $username])->row();
        return ($user && password_verify($password, $user->password)) ? $user : false;
    }
}
?>