<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Conferencesession extends MY_Model
{

    protected $table = 'conference_sessions';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function getConferenceSessionByCID($cid)
    {
        $query = $this->db->query('SELECT * FROM '. $this->table .' WHERE BINARY CID = "'.$cid.'"');
        if ($query->num_rows()) {
            return $query->result_array();
        }
        return false;
    }

}