<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Reminder extends MY_Model
{

    protected $table = 'reminders';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function get(){
        $query = $this->db->select('reminders.*, useraccounts.firstName, useraccounts.lastName')
          ->from($this->table)
          ->join('useraccounts', 'reminders.email = useraccounts.email', 'left')
          ->where('reminders.sid !=', '')
          ->get();

        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }
}