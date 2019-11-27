<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Registrationtool extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'conference_registrationtool';

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
    function checkRegistrationConferenceActive($cid)
    {
        $registration = $this->get_info_binary('CID', $cid);
        if (!empty($registration)){
            $start_date = $registration->registrationStart;
            $end_date = $registration->registrationEnd;
            $today = time();
            if ($start_date <= $today && $today <= $end_date) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $cid
     * @return mixed
     */
//    function getRegistrationByCID($cid)
//    {
//        $query = $this->db->select('conference_registrations.*, useraccounts.lastName as lastName, useraccounts.firstName as firstName, useraccounts.affiliation as affiliation')
//          ->from('conference_registrations')
//          ->where('conference_registrations.CID', $cid)
//          ->join('useraccounts', 'useraccounts.id = conference_registrations.userID')
//          ->get();
//
//        return $query->result();
//    }
}