<?php
class Repayment_model extends CI_Model {
    public $db;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    // Get repayments by loan ID
    public function get_by_loan_id($loan_id) {
        return $this->db
            ->where('loan_id', $loan_id)
            ->order_by('due_date', 'ASC')
            ->get('repayments')
            ->result();
    }

    // Create repayment schedule when loan is approved
    public function create_schedule($loan_id, $amount, $tenure) {
        $installment = $amount / $tenure;
        $due_date = date('Y-m-d', strtotime('+1 month'));
        
        $repayments = [];
        for($i = 0; $i < $tenure; $i++) {
            $repayments[] = [
                'loan_id' => $loan_id,
                'amount' => round($installment, 2),
                'due_date' => $due_date,
                'status' => 'pending'
            ];
            $due_date = date('Y-m-d', strtotime($due_date . ' +1 month'));
        }
        
        return $this->db->insert_batch('repayments', $repayments);
    }

    // Mark repayment as paid
    public function mark_as_paid($repayment_id) {
        return $this->db
            ->where('id', $repayment_id)
            ->update('repayments', [
                'paid_at' => date('Y-m-d H:i:s'),
                'status' => 'paid'
            ]);
    }

    // Check if repayment belongs to user
    public function is_owned_by_user($repayment_id, $user_id) {
        return $this->db
            ->from('repayments r')
            ->join('loans l', 'l.id = r.loan_id')
            ->where('r.id', $repayment_id)
            ->where('l.user_id', $user_id)
            ->count_all_results() > 0;
    }

    // Get pending repayments for customer
    public function get_pending($user_id) {
        return $this->db
            ->select('r.*, l.amount as loan_amount')
            ->from('repayments r')
            ->join('loans l', 'l.id = r.loan_id')
            ->where('l.user_id', $user_id)
            ->where('r.status', 'pending')
            ->get()
            ->result();
    }
}
?>