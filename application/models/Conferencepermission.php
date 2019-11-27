<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Conferencepermission extends MY_Model
{

    protected $table = 'conference_permissions';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function getPermissionByConference($confID, $hostID){
        $query = $this->db->select('conference_permissions.*, useraccounts.email as email, useraccounts.active as active')
          ->from('conference_permissions')
          ->where('conference_permissions.confID', $confID)
          ->where('conference_permissions.userID !=', $hostID)
          ->join('useraccounts', 'useraccounts.id = conference_permissions.userID')
          ->join('conferences', 'conferences.id = conference_permissions.confID')
          ->get();

        return $query->result();
    }

    function getPermissionConferenceByUser($confID, $userID){
        $query = $this->db->select('conference_permissions.*, useraccounts.email as email, useraccounts.active as active')
          ->from('conference_permissions')
          ->where('conference_permissions.confID', $confID)
          ->where('conference_permissions.userID', $userID)
          ->where('conference_permissions.status', 'Accept')
          ->join('useraccounts', 'useraccounts.id = conference_permissions.userID')
          ->join('conferences', 'conferences.id = conference_permissions.confID')
          ->get();

        return $query->row();
    }

    function getArrayPermissionByUser($userID){
        $permissionArr = array();

        $permissions = $this->db->get_where($this->table, array('conference_permissions.userID' => $userID))->result();

        if (!empty($permissions)){
            foreach ($permissions as $permission){
                array_push($permissionArr, $permission->confID);
            }
        }

        return $permissionArr;
    }

}