<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Poster extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'posterdb';

    /**
     * Poster constructor.
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
              'posterdb.*, 
                useraccounts.id as id_user, 
                useraccounts.firstName, 
                useraccounts.lastName, 
                useraccounts.email, 
                categories.name as category_name, 
                subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'posterdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            useraccounts.email, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('posterdb')
          ->where('posterdb.id', $id)
          ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
          ->join('categories', 'categories.id = posterdb.category')
          ->join('subcategories', 'subcategories.id = posterdb.subcategory')
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
              ->from('posterdb')
              ->join('categories', 'categories.id = posterdb.altCategory1')
              ->join('subcategories', 'subcategories.id = posterdb.altSubCategory1')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'categories.name as alt_category_name, 
            subcategories.name as alt_subcategory_name')
          ->from('posterdb')
          ->where('posterdb.id', $id)
          ->join('categories', 'categories.id = posterdb.altCategory1')
          ->join('subcategories', 'subcategories.id = posterdb.altSubCategory1')
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
                SELECT posterdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "poster") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "poster") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) OR posterdb.idAuthor = '.$userID.') 
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select(
              'posterdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.public', 1)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result_array();
    }

    public function getFull($userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT posterdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "poster") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "poster") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) OR posterdb.idAuthor = '.$userID.') 
            ');
        }
        else{
            $query = $this->db->select(
              'posterdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.public', 1)
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
          'posterdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('posterdb')
          ->where('idAuthor', $userID)
          ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
          ->join('categories', 'categories.id = posterdb.category')
          ->join('subcategories', 'subcategories.id = posterdb.subcategory')
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
          'posterdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('posterdb')
          ->where('idAuthor', $id_user)
          ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
          ->join('categories', 'categories.id = posterdb.category')
          ->join('subcategories', 'subcategories.id = posterdb.subcategory')
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
                SELECT posterdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) OR posterdb.idAuthor = '.$userID.') 
                AND (posterdb.posterTitle LIKE "%'.$key.'%" 
                 OR categories.name LIKE "%' . $key . '%"
                  OR subcategories.name LIKE "%' . $key . '%"
                   OR useraccounts.firstName LIKE "%' . $key . '%"
                    OR useraccounts.lastName LIKE "%' . $key . '%")
            ');
        }
        else{
            $query = $this->db->select(
              'posterdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.public', 1)
              ->like('posterTitle', $key)
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
                SELECT posterdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) OR posterdb.idAuthor = '.$userID.') 
                AND (posterdb.posterTitle LIKE "%'.$key.'%" 
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
              'posterdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.public', 1)
              ->like('posterTitle', $key)
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
                SELECT posterdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "poster") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "poster") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) OR posterdb.idAuthor = '.$userID.') 
                AND posterdb.category = '.$idCate.' 
                AND posterdb.subcategory = '.$idSubCate.'
                ORDER BY '.$nameCol.' '.$direction.'
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select(
              'posterdb.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.category', $idCate)
              ->where('posterdb.subcategory', $idSubCate)
              ->where('posterdb.public', 1)
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
        $query = $this->db->select('posterdb.*, categories.name as category_name, subcategories.name as subcategory_name')
          ->from('posterdb')
          ->where('posterdb.idAuthor', $userID)
          ->join('categories', 'categories.id = posterdb.category')
          ->join('subcategories', 'subcategories.id = posterdb.subcategory')
          ->order_by($nameCol, $direction)
          ->limit($limit, $start)
          ->get();

        return $query->result();
    }
}
