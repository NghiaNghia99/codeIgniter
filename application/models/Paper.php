<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Paper extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'paperdb';

    /**
     * Paper constructor.
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @param bool $id
     * @return mixed
     */
    public function get($id = false)
    {
        if ($id === false) {
            $query = $this->db->select(
              'paperdb.*, 
                useraccounts.id as id_user,
                useraccounts.firstName, 
                useraccounts.lastName, 
                useraccounts.email, 
                categories.name as category_name, 
                subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'paperdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            useraccounts.email, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('paperdb')
          ->where('paperdb.id', $id)
          ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
          ->join('categories', 'categories.id = paperdb.category')
          ->join('subcategories', 'subcategories.id = paperdb.subcategory')
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
              ->from('paperdb')
              ->join('categories', 'categories.id = paperdb.altCategory1')
              ->join('subcategories', 'subcategories.id = paperdb.altSubCategory1')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'categories.name as alt_category_name, 
            subcategories.name as alt_subcategory_name')
          ->from('paperdb')
          ->where('paperdb.id', $id)
          ->join('categories', 'categories.id = paperdb.altCategory1')
          ->join('subcategories', 'subcategories.id = paperdb.altSubCategory1')
          ->get();
        return $query->row_array();
    }

    /**
     * @param $limit
     * @param $userID
     * @param $start
     * @return mixed
     */
    public function getLimit($userID = false, $limit = false, $start = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT paperdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "paper") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "paper") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) OR paperdb.idAuthor = '.$userID.') 
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.public', 1)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result_array();
    }

    public function getFull($userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT paperdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "paper") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "paper") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) OR paperdb.idAuthor = '.$userID.') 
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.public', 1)
              ->get();
        }

        return $query->result_array();
    }

    /**
     * @param $userID
     * @param int $limit
     * @return mixed
     */
    public function getLimitByUser($userID, $limit = 0)
    {
        $query = $this->db->select(
          'paperdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('paperdb')
          ->where('idAuthor', $userID)
          ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
          ->join('categories', 'categories.id = paperdb.category')
          ->join('subcategories', 'subcategories.id = paperdb.subcategory')
          ->order_by('dateOfUpload', 'DESC')
          ->limit($limit)
          ->get();

        return $query->result_array();
    }

    /**
     * @param $id_user
     * @return mixed
     */
    public function getPostsByUser($id_user)
    {
        $query = $this->db->select(
          'paperdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('paperdb')
          ->where('idAuthor', $id_user)
          ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
          ->join('categories', 'categories.id = paperdb.category')
          ->join('subcategories', 'subcategories.id = paperdb.subcategory')
          ->get();
        return $query->result_array();
    }

    /**
     * @param $key
     * @param $userID
     * @return mixed
     */
    function search($key = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT paperdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) OR paperdb.idAuthor = '.$userID.') 
                AND (paperdb.paperTitle LIKE "%'.$key.'%" 
                 OR categories.name LIKE "%' . $key . '%"
                  OR subcategories.name LIKE "%' . $key . '%"
                   OR useraccounts.firstName LIKE "%' . $key . '%"
                    OR useraccounts.lastName LIKE "%' . $key . '%")
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.public', 1)
              ->like('paperTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->get();
        }

        return $query->result();
    }

    /**
     * @param $key
     * @param $userID
     * @return int
     */
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
            $query = $this->db->query('
                SELECT paperdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) OR paperdb.idAuthor = '.$userID.') 
                AND (paperdb.paperTitle LIKE "%'.$key.'%" 
                 OR categories.name LIKE "%' . $key . '%"
                  OR subcategories.name LIKE "%' . $key . '%"
                   OR useraccounts.firstName LIKE "%' . $key . '%"
                    OR useraccounts.lastName LIKE "%' . $key . '%")
                ORDER BY '.$nameCol.' '.$direction.'
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.public', 1)
              ->like('paperTitle', $key)
              ->or_like('categories.name', $key)
              ->or_like('subcategories.name', $key)
              ->or_like('useraccounts.firstName', $key)
              ->or_like('useraccounts.lastName', $key)
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }

    /**
     * @param $idCate
     * @param $idSubCate
     * @param $userID
     * @param $limit
     * @param $start
     * @param $nameCol
     * @param $direction
     * @return mixed
     */
    function sortCategoryPagination($idCate, $idSubCate, $userID, $limit, $start, $nameCol, $direction)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT paperdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "paper") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "paper") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) OR paperdb.idAuthor = '.$userID.') 
                AND paperdb.category = '.$idCate.' 
                AND paperdb.subcategory = '.$idSubCate.'
                ORDER BY '.$nameCol.' '.$direction.'
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.category', $idCate)
              ->where('paperdb.subcategory', $idSubCate)
              ->where('paperdb.public', 1)
              ->order_by($nameCol, $direction)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result();
    }

    /**
     * @param $userID
     * @param $limit
     * @param $start
     * @param $nameCol
     * @param $direction
     * @return mixed
     */
    function sortPostByUserPagination($userID, $limit, $start, $nameCol, $direction)
    {
        $query = $this->db->select('paperdb.*, categories.name as category_name, subcategories.name as subcategory_name')
          ->from('paperdb')
          ->where('paperdb.idAuthor', $userID)
          ->join('categories', 'categories.id = paperdb.category')
          ->join('subcategories', 'subcategories.id = paperdb.subcategory')
          ->order_by($nameCol, $direction)
          ->limit($limit, $start)
          ->get();

        return $query->result();
    }
}
