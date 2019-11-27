<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Abstracttool extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'conference_abstractsubmissiontool';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * @param $cid
     * @return bool
     */
    function checkAbstractConferenceActive($cid)
    {
        $abstract = $this->get_info_binary('CID', $cid);
        if (!empty($abstract)){
            $start_date = $abstract->abstractSubmissionStart;
            $end_date = $abstract->abstractSubmissionEnd;
            $today = time();
            if ($start_date <= $today && $today <= $end_date) {
                return true;
            }
        }
        return false;
    }

}