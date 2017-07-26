<?php


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AllEmail extends CI_Model
{
    public $table = 'all_emails';

    public function allEmails()
    {
        $results = $this->db
            ->get($this->table)->result();

        return $results;
    }

    public function exist($email)
    {
        $item = $this->db->where('email', $email)
            ->get($this->table)->row();

        return $item;
    }

    public function addEmail($email)
    {
        $params = array(
            'email' => $email,
            );
        $this->db->insert($this->table, $params);

        return true;
    }

    public function updateFee($branch_id, $fee)
    {
        if (empty($branch_id)) {
            return;
        }

        $params = [
            'amount' => $fee,
        ];

        $save = $this->db->update($this->table, $params, array('branch_id' => $branch_id));
    }
}
