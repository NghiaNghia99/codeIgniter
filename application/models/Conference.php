<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Conference extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'conferences';

    /**
     * Conference constructor.
     */
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * @param bool $id
     * @return mixed
     */
    public function get($id = false)
    {
        if ($id === false) {
            $query = $this->db->select(
              'conferences.*, 
                useraccounts.id as id_user, 
                useraccounts.firstName, 
                useraccounts.lastName, 
                useraccounts.affiliation, 
                categories.name as category_name, subcategories.name as subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'conferences.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            useraccounts.affiliation, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('conferences')
          ->where('conferences.id', $id)
          ->join('useraccounts', 'useraccounts.id = conferences.userID')
          ->join('categories', 'categories.id = conferences.category')
          ->join('subcategories', 'subcategories.id = conferences.subcategory')
          ->get();
        return $query->row_array();
    }

    /**
     * @param bool $id
     * @return mixed
     */
    public function getAltCategory($id = false)
    {
        if ($id === false) {
            $query = $this->db->select(
              'categories.name as alt_category_name, 
                subcategories.name as alt_subcategory_name')
              ->from('conferences')
              ->join('categories', 'categories.id = conferences.altCategory1')
              ->join('subcategories', 'subcategories.id = conferences.altSubCategory1')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'categories.name as alt_category_name, 
            subcategories.name as alt_subcategory_name')
          ->from('conferences')
          ->where('conferences.id', $id)
          ->join('categories', 'categories.id = conferences.altCategory1')
          ->join('subcategories', 'subcategories.id = conferences.altSubCategory1')
          ->get();
        return $query->row_array();
    }


    function checkConferenceActive($id)
    {
        $conference = $this->get_info($id);
        $start_date = $conference->startDate - 24 * 60 * 60;
        $end_date = $conference->endDate - 24 * 60 * 60;
        $today = time();
        if ($start_date < $today && $today < $end_date ) {
            return 'opening';
        }
        elseif ($end_date < $today){
            return 'closed';
        }
        return false;
    }

    /**
     * @param $id_user
     * @return mixed
     */
    function getConferencesByUser($id_user)
    {
        $query = $this->db->get_where($this->table, array('userID' => $id_user));
        return $query->result_array();
    }

    public function search($key, $userID)
    {
        if ($userID){
            $query = $this->db->select(
              'conferences.*,
            useraccounts.id as id_user, 
            useraccounts.firstName as firstName, 
            useraccounts.lastName as lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.status = "active" AND conferences.allowClosedAccess !=', 1)
              ->like('conferences.confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->or_where('conferences.status = "active" AND conferences.allowClosedAccess = 1 
              AND (
                   (select COUNT(*) from conference_registrations
                 JOIN conferences ON BINARY conferences.CID = conference_registrations.CID
                  where conference_registrations.userID = '.$userID.' > 0 )
                  OR
                   (select COUNT(*) from conference_permissions
                 JOIN conferences ON conferences.id = conference_permissions.confID
                  where conference_permissions.userID = '.$userID.' and conference_permissions.status = "Accept" > 0 )
                  )')
              ->like('conferences.confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->get();
        }
        else{
            $query = $this->db->select(
              'conferences.*,
            useraccounts.id as id_user, 
            useraccounts.firstName as firstName, 
            useraccounts.lastName as lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.allowClosedAccess !=', 1)
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->like('confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->get();
        }

        return $query->result_array();
    }


    public function countResultSearch($key, $userID)
    {
        return count($this->search($key, $userID));
    }


    /**
     * @param $key
     * @param $userID
     * @param $limit
     * @param $start
     * @param $nameCol
     * @param $direction
     * @return mixed
     */
    function searchPagination($key, $userID, $limit, $start, $nameCol, $direction)
    {
        if ($userID){
            $query = $this->db->select(
              'conferences.*,
            useraccounts.id as id_user, 
            useraccounts.firstName as firstName, 
            useraccounts.lastName as lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.status = "active" AND conferences.allowClosedAccess !=', 1)
              ->like('conferences.confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->or_where('conferences.status = "active" AND conferences.allowClosedAccess = 1 
              AND (
                   (select COUNT(*) from conference_registrations
                 JOIN conferences ON BINARY conferences.CID = conference_registrations.CID
                  where conference_registrations.userID = '.$userID.' > 0 )
                  OR
                   (select COUNT(*) from conference_permissions
                 JOIN conferences ON conferences.id = conference_permissions.confID
                  where conference_permissions.userID = '.$userID.' and conference_permissions.status = "Accept" > 0 )
                  )')
              ->like('conferences.confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }
        else{
            $query = $this->db->select(
              'conferences.*,
            useraccounts.id as id_user, 
            useraccounts.firstName as firstName, 
            useraccounts.lastName as lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.allowClosedAccess !=', 1)
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->like('confTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->or_like('conferences.CID', $key)
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }

    public function sortCategoryPagination($idCate, $idSubCate, $userID , $limit, $start, $nameCol, $direction)
    {
        if ($userID){
            $query = $this->db->select(
              'conferences.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.name as category_name,
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.category = '.$idCate.' AND conferences.subcategory = '.$idSubCate.' AND conferences.status = "active" AND conferences.allowClosedAccess != 1')
              ->or_where('conferences.category = '.$idCate.' AND conferences.subcategory = '.$idSubCate.' AND conferences.status = "active" AND conferences.allowClosedAccess = 1 
              AND (
                   (select COUNT(*) from conference_registrations
                 JOIN conferences ON BINARY conferences.CID = conference_registrations.CID
                  where conference_registrations.userID = '.$userID.' > 0 )
                  OR
                   (select COUNT(*) from conference_permissions
                 JOIN conferences ON conferences.id = conference_permissions.confID
                  where conference_permissions.userID = '.$userID.' and conference_permissions.status = "Accept" > 0 )
                  )')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }
        else{
            $query = $this->db->select(
              'conferences.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.name as category_name,
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.category', $idCate)
              ->where('conferences.subcategory', $idSubCate)
              ->where('conferences.status', 'active')
              ->where('conferences.allowClosedAccess !=', 1)
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }

    public function sortCategoryAvailableConferencePagination($idCate, $userID , $limit, $start, $nameCol, $direction)
    {
        $now = time();
        if ($userID){
            $query = $this->db->select(
              'conferences.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.name as category_name,
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.category = '.$idCate.'
                AND conferences.status = "active" 
                AND  conferences.startDate < '.$now.'
                AND  conferences.endDate > '.$now.'
                AND conferences.allowClosedAccess != 1')
              ->or_where('conferences.category = '.$idCate.' 
                AND conferences.status = "active" 
                AND  conferences.startDate < '.$now.'
                AND  conferences.endDate > '.$now.'
                AND conferences.allowClosedAccess = 1 
                AND ((
                   select COUNT(*) from conference_registrations
                 JOIN conferences ON BINARY conferences.CID = conference_registrations.CID
                  where conference_registrations.userID = '.$userID.' > 0 )
                  OR (
                   select COUNT(*) from conference_permissions
                 JOIN conferences ON conferences.id = conference_permissions.confID
                  where conference_permissions.userID = '.$userID.' and conference_permissions.status = "Accept" > 0
                  ))')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }
        else{
            $query = $this->db->select(
              'conferences.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.name as category_name,
            subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.category', $idCate)
              ->where('conferences.status = "active" 
                AND  conferences.startDate < '.$now.'
                AND  conferences.endDate > '.$now)
              ->where('conferences.allowClosedAccess !=', 1)
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }


    /**
     * @param $userID
     * @param $closed
     * @return mixed
     */
    function getPostByUserPagination($userID, $closed)
    {
        $now = time();
        if ($closed) {
            $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.endDate <', $now)
              ->where('conference_permissions.userID', $userID)
              ->where('conference_permissions.status', 'Accept')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->join('conference_permissions', 'conference_permissions.confID = conferences.id')
              ->get();
        } else {
            $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.endDate >=', $now)
              ->where('conference_permissions.userID', $userID)
              ->where('conference_permissions.status', 'Accept')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->join('conference_permissions', 'conference_permissions.confID = conferences.id')
              ->get();
        }

        return $query->result();
    }


    /**
     * @param $userID
     * @param $closed
     * @param $limit
     * @param $start
     * @param $nameCol
     * @param $direction
     * @return mixed
     */
    function sortPostByUserPagination($userID, $closed, $limit, $start, $nameCol, $direction)
    {
        $now = time();
        if ($closed) {
            $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.endDate <', $now)
              ->where('conference_permissions.userID', $userID)
              ->where('conference_permissions.status', 'Accept')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->join('conference_permissions', 'conference_permissions.confID = conferences.id')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        } else {
            $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
              ->from('conferences')
              ->where('conferences.status', 'active')
              ->where('conferences.endDate >=', $now)
              ->where('conference_permissions.userID', $userID)
              ->where('conference_permissions.status', 'Accept')
              ->join('useraccounts', 'useraccounts.id = conferences.userID')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->join('conference_permissions', 'conference_permissions.confID = conferences.id')
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }

    /**
     * @param $userID
     * @return mixed
     */
    function getPostDefaultByUser($userID)
    {
        $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
          ->from('conferences')
          ->where('conferences.userID', $userID)
          ->where('conferences.status', 'paid')
          ->join('useraccounts', 'useraccounts.id = conferences.userID')
          ->join('categories', 'categories.id = conferences.category')
          ->join('subcategories', 'subcategories.id = conferences.subcategory')
          ->get();

        return $query->result();
    }

    /**
     * @param $userID
     * @param $limit
     * @param $start
     * @return mixed
     */
    function getPostDefaultByUserPagination($userID, $limit, $start)
    {
        $query = $this->db->select('conferences.*,
            useraccounts.firstName,
            useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name')
          ->from('conferences')
          ->where('conferences.userID', $userID)
          ->where('conferences.status', 'paid')
          ->join('useraccounts', 'useraccounts.id = conferences.userID')
          ->join('categories', 'categories.id = conferences.category')
          ->join('subcategories', 'subcategories.id = conferences.subcategory')
          ->limit($limit, $start)
          ->get();

        return $query->result();
    }

    public function getConferenceByPost($postType, $postID){
        $query = $this->db->query('
        SELECT conferences.id, conferences.CID
        FROM '.$this->table.'
        JOIN (SELECT CID
                FROM conference_elements
                WHERE type = "'.$postType.'" AND elementID = '.$postID.') AS CE
        ON BINARY conferences.CID = CE.CID
        ');

        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }
}
