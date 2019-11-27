<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Movie extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'moviesdb';

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

    /**
     * @param bool $id
     * @return mixed
     */
    public function get($id = false)
    {
        if ($id === false) {
            $query = $this->db->select(
              'moviesdb.*, 
                useraccounts.id as id_user, 
                useraccounts.firstName, 
                useraccounts.lastName, 
                useraccounts.email, 
                categories.name as category_name, 
                subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'moviesdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            useraccounts.email, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('moviesdb')
          ->where('moviesdb.id', $id)
          ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
          ->join('categories', 'categories.id = moviesdb.category')
          ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
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
              ->from('moviesdb')
              ->join('categories', 'categories.id = moviesdb.altCategory1')
              ->join('subcategories', 'subcategories.id = moviesdb.altSubCategory1')
              ->get();
            return $query->result_array();
        }

        $query = $this->db->select(
          'categories.name as alt_category_name, 
            subcategories.name as alt_subcategory_name')
          ->from('moviesdb')
          ->where('moviesdb.id', $id)
          ->join('categories', 'categories.id = moviesdb.altCategory1')
          ->join('subcategories', 'subcategories.id = moviesdb.altSubCategory1')
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
        if ($userID) {
            $query = $this->db->query('
                SELECT moviesdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = ' . $userID . ') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = ' . $userID . ') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = ' . $userID . ') 
                AND moviesdb.status = 1
                LIMIT ' . $limit . ' OFFSET ' . $start . '
            ');
        } else {
            $query = $this->db->select(
              'moviesdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->where('moviesdb.status', 1)
              ->where('moviesdb.public', 1)
              ->limit($limit, $start)
              ->get();
        }

        return $query->result_array();
    }

    public function getFull($userID = false)
    {
        if ($userID) {
            $query = $this->db->query('
                SELECT moviesdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = ' . $userID . ') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = ' . $userID . ') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = ' . $userID . ') 
                AND moviesdb.status = 1
            ');
        } else {
            $query = $this->db->select(
              'moviesdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->where('moviesdb.status', 1)
              ->where('moviesdb.public', 1)
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
          'moviesdb.*, 
            useraccounts.id as id_user, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('moviesdb')
          ->where('idAuthor', $userID)
          ->where('status', 1)
          ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
          ->join('categories', 'categories.id = moviesdb.category')
          ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
          ->order_by('dateOfUpload', 'DESC')
          ->limit($limit)
          ->get();

        return $query->result_array();
    }

    /**
     * @param $id_user
     * @return mixed
     */
    public function getVideosByUser($id_user)
    {
        $query = $this->db->select(
          'moviesdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
          ->from('moviesdb')
          ->where('idAuthor', $id_user)
          ->where('status', 1)
          ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
          ->join('categories', 'categories.id = moviesdb.category')
          ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
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
        if ($userID) {
            $query = $this->db->query('
                SELECT moviesdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = ' . $userID . ') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = ' . $userID . ') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = ' . $userID . ') 
                AND moviesdb.status = 1
                AND (moviesdb.title LIKE "%' . $key . '%" 
                 OR categories.name LIKE "%' . $key . '%"
                  OR subcategories.name LIKE "%' . $key . '%"
                   OR useraccounts.firstName LIKE "%' . $key . '%"
                    OR useraccounts.lastName LIKE "%' . $key . '%")
            ');
        } else {
            $query = $this->db->select(
              'moviesdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->where('moviesdb.status', 1)
              ->where('moviesdb.public', 1)
              ->like('title', $key)
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
        if ($userID) {
            $query = $this->db->query('
                SELECT moviesdb.*,useraccounts.id AS id_user, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = ' . $userID . ') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = ' . $userID . ') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = ' . $userID . ') 
                AND moviesdb.status = 1
                AND (moviesdb.title LIKE "%' . $key . '%" 
                 OR categories.name LIKE "%' . $key . '%"
                  OR subcategories.name LIKE "%' . $key . '%"
                   OR useraccounts.firstName LIKE "%' . $key . '%"
                    OR useraccounts.lastName LIKE "%' . $key . '%")
                ORDER BY ' . $nameCol . ' ' . $direction . '
                LIMIT ' . $limit . ' OFFSET ' . $start . '
            ');
        } else {
            $query = $this->db->select(
              'moviesdb.*,
            useraccounts.id as id_user,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->where('moviesdb.status', 1)
              ->where('moviesdb.public', 1)
              ->like('title', $key)
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
        if ($userID) {
            $query = $this->db->query('
                SELECT moviesdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = ' . $userID . ') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = ' . $userID . ') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = ' . $userID . ') 
                AND moviesdb.status = 1 
                AND moviesdb.category = ' . $idCate . ' 
                AND moviesdb.subcategory = ' . $idSubCate . '
                ORDER BY ' . $nameCol . ' ' . $direction . '
                LIMIT ' . $limit . ' OFFSET ' . $start . '
            ');
        } else {
            $query = $this->db->select(
              'moviesdb.*,
            useraccounts.firstName,
            useraccounts.lastName,
            categories.id as category_id,
            categories.name as category_name,
            subcategories.id as subcategory_id,
            subcategories.name as subcategory_name')
              ->from('moviesdb')
              ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
              ->join('categories', 'categories.id = moviesdb.category')
              ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
              ->where('moviesdb.category', $idCate)
              ->where('moviesdb.subcategory', $idSubCate)
              ->where('moviesdb.status', 1)
              ->where('moviesdb.public', 1)
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
        $query = $this->db->select('moviesdb.*, categories.name as category_name, subcategories.name as subcategory_name')
          ->from('moviesdb')
          ->where('moviesdb.idAuthor', $userID)
          ->where('moviesdb.status', 1)
          ->join('categories', 'categories.id = moviesdb.category')
          ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
          ->order_by($nameCol, $direction)
          ->limit($limit, $start)
          ->get();

        return $query->result();
    }

    function videosQueue($userID)
    {
        $this->db->where('idAuthor', $userID);
        $this->db->order_by("dateOfUpload", "desc");
        $query = $this->db->get($this->table);

        return $query->result();
    }

    function videosQueuePagination($userID, $limit, $start)
    {
        $query = $this->db->select('*')
          ->from('moviesdb')
          ->where('moviesdb.idAuthor', $userID)
          ->order_by("dateOfUpload", "desc")
          ->limit($limit, $start)
          ->get();

        return $query->result();
    }
}
