<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Language extends MY_Model
{

    protected $table = 'languages';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function getLanguages()
    {
        $languages = array();
        $query = $this->db->get($this->table);
        foreach ($query->result() as $row) {
            array_push($languages, $row->name);
        }
        return $languages;
    }
}