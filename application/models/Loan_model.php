<?php
class Loan_model extends CI_Model {
    public $db;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    public function apply_loan($data) {
        $data['applied_at'] = date('Y-m-d H:i:s');
        $this->db->insert('loans', $data);
        return $this->db->insert_id();
    }

    public function get_user_loans($user_id) {
        return $this->db->get_where('loans', ['user_id' => $user_id])->result();
    }

    public function get_loan_details($loan_id, $user_id = null) {
        // Base query
        $this->db->select('loans.*, users.username');
        $this->db->from('loans');
        $this->db->join('users', 'users.id = loans.user_id');
        $this->db->where('loans.id', $loan_id);

        // Add user restriction for customer view
        if ($user_id !== null) {
            $this->db->where('loans.user_id', $user_id);
        }

        $loan = $this->db->get()->row();

        if (!$loan) {
            return false;
        }

        // Get associated repayments
        $this->db->select('*');
        $this->db->from('repayments');
        $this->db->where('loan_id', $loan_id);
        $this->db->order_by('due_date', 'ASC');
        $loan->repayments = $this->db->get()->result();

        // Calculate payment summary
        $loan->total_paid = 0;
        $loan->total_pending = 0;
        foreach ($loan->repayments as $repayment) {
            if ($repayment->status === 'paid') {
                $loan->total_paid += $repayment->amount;
            } else {
                $loan->total_pending += $repayment->amount;
            }
        }

        // Calculate progress percentage
        $loan->progress = $loan->amount > 0 ? 
            round(($loan->total_paid / $loan->amount) * 100, 2) : 0;

        return $loan;
    }

    public function get_all_loans($status = null) {
        
        if($status) $this->db->where('status', $status);
        $this->db->select('loans.*, users.username');
        $this->db->from('loans');
        $this->db->join('users', 'users.id = loans.user_id');
        return $this->db->get()->result();
    }

    public function update_status($loan_id, $status) {
        $data=$this->db->where('id', $loan_id)->update('loans', ['status' => $status]);
        if($status === 'approved') $this->_create_repayment_schedule($loan_id);
        return $data;
    }

    private function _create_repayment_schedule($loan_id) {
        $loan = $this->db->get_where('loans', ['id' => $loan_id])->row();
        $installment = $loan->amount / $loan->tenure;
        $due_date = date('Y-m-d', strtotime('+1 month'));
        
        for($i = 0; $i < $loan->tenure; $i++) {
            $this->db->insert('repayments', [
                'loan_id' => $loan_id,
                'amount' => $installment,
                'due_date' => $due_date
            ]);
            $due_date = date('Y-m-d', strtotime($due_date . ' +1 month'));
        }
    }
}
?>