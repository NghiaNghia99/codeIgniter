<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Videoqueue extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'videoqueue';

    /**
     * Movie constructor.
     */
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
}