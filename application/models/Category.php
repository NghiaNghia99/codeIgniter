<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Category extends MY_Model
{
    protected $table = 'categories';

    public function __construct()
    {
        $this->load->database();
    }

    public function get($userID = false)
    {
        $this->session->unset_userdata('count_item_by_subcate');

        $query = $this->db->get($this->table);

        $categories = array();
        $count_item_by_subcate = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $this->db->select("*");
                $this->db->from("subcategories");
                $this->db->where("parent_id", $row->id);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    $row->children = $query->result();
                    foreach ($row->children as $item) {
                        $count = $this->countCategoryItem($item->parent_id, $item->id, $userID);
                        $count_item = array(
                            'id_subcatetegory' => $item->id,
                            'count' => $count
                        );
                        array_push($count_item_by_subcate, $count_item);
                    }
                }
                array_push($categories, $row);
            }
            $this->session->set_userdata('count_item_by_subcate', $count_item_by_subcate);
        }
        return $categories;
    }

    public function getCategory($idCate = false, $idSubCate = false)
    {

        $category = $this->db->get_where('categories', array('id' => $idCate))->row_array();
        $sub_category = $this->db->get_where('subcategories', array('id' => $idSubCate))->row_array();

        $category_arr = array($category, $sub_category);

        return $category_arr;
    }

    public function getSubCategories($idCategory)
    {

        $query = $this->db->get_where('subcategories', array('parent_id' => $idCategory));

        return $query->result_array();
    }

    public function countCategoryItem($idCate = false, $idSubCate = false, $userID = false)
    {

        $categoryVideo = count($this->getCategoryVideo($idCate, $idSubCate, $userID));
        $categoryPaper = count($this->getCategoryPaper($idCate, $idSubCate, $userID));
        $categoryPoster = count($this->getCategoryPoster($idCate, $idSubCate, $userID));
        $categoryPresentation = count($this->getCategoryPresentation($idCate, $idSubCate, $userID));
        $categoryConference = count($this->getCategoryConference($idCate, $idSubCate, $userID));

        $categories = array();
        $categories['Video'] = $categoryVideo;
        $categories['Paper'] = $categoryPaper;
        $categories['Poster'] = $categoryPoster;
        $categories['Presentation'] = $categoryPresentation;
        $categories['Conference'] = $categoryConference;
        $categories['Total'] = $categoryVideo + $categoryPaper + $categoryPoster + $categoryPresentation + $categoryConference;

        return $categories;
    }

//    public function getCategoryVideo($idCate = false, $idSubCate = false)
//    {
//        $query = $this->db->select(
//            'moviesdb.*,
//            useraccounts.firstName,
//            useraccounts.lastName,
//            categories.id as category_id,
//            categories.name as category_name,
//            subcategories.id as subcategory_id,
//            subcategories.name as subcategory_name')
//            ->from('moviesdb')
//            ->where('moviesdb.category', $idCate)
//            ->where('moviesdb.subcategory', $idSubCate)
//            ->where('moviesdb.status', 1)
//            ->join('useraccounts', 'useraccounts.id = moviesdb.idAuthor')
//            ->join('categories', 'categories.id = moviesdb.category')
//            ->join('subcategories', 'subcategories.id = moviesdb.subcategory')
//            ->get();
//
//        return $query->result_array();
//    }

    public function getCategoryVideo($idCate = false, $idSubCate = false, $userID = false)
    {
        if ($userID){
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
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) OR moviesdb.idAuthor = '.$userID.') 
                AND moviesdb.status = 1 
                AND moviesdb.category = '.$idCate.' 
                AND moviesdb.subcategory = '.$idSubCate.'
            ');
        }
        else{
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
              ->get();
        }

        return $query->result_array();
    }

    public function getCategoryPaper($idCate = false, $idSubCate = false, $userID = false)
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
                AND paperdb.category = '.$idCate.' 
                AND paperdb.subcategory = '.$idSubCate.'
            ');
        }
        else{
            $query = $this->db->select(
              'paperdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('paperdb')
              ->join('useraccounts', 'useraccounts.id = paperdb.idAuthor')
              ->join('categories', 'categories.id = paperdb.category')
              ->join('subcategories', 'subcategories.id = paperdb.subcategory')
              ->where('paperdb.category', $idCate)
              ->where('paperdb.subcategory', $idSubCate)
              ->where('paperdb.public', 1)
              ->get();
        }

        return $query->result_array();
    }

    public function getCategoryPoster($idCate = false, $idSubCate = false, $userID = false)
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
                AND posterdb.category = '.$idCate.' 
                AND posterdb.subcategory = '.$idSubCate.'
            ');
        }
        else{
            $query = $this->db->select(
              'posterdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('posterdb')
              ->join('useraccounts', 'useraccounts.id = posterdb.idAuthor')
              ->join('categories', 'categories.id = posterdb.category')
              ->join('subcategories', 'subcategories.id = posterdb.subcategory')
              ->where('posterdb.category', $idCate)
              ->where('posterdb.subcategory', $idSubCate)
              ->where('posterdb.public', 1)
              ->get();
        }

        return $query->result_array();
    }

    public function getCategoryPresentation($idCate = false, $idSubCate = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN categories
                ON presentationdb.category = categories.id
                JOIN subcategories
                ON presentationdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_registrations 
                                  WHERE userID = '.$userID.') AS CR 
                            ON BINARY CE.CID=CR.CID
                            WHERE CE.type = "video") AS CRE
                ON presentationdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                            FROM conference_elements AS CE 
                            JOIN (SELECT * 
                                  FROM conference_permissions 
                                  WHERE userID = '.$userID.') AS CP 
                            ON BINARY CE.CID=CP.CID
                            WHERE CE.type = "video") AS CPE
                ON presentationdb.id = CPE.elementID
                WHERE ((((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND presentationdb.public = 0) OR presentationdb.public = 1) OR presentationdb.idAuthor = '.$userID.') 
                AND presentationdb.category = '.$idCate.' 
                AND presentationdb.subcategory = '.$idSubCate.'
            ');
        }
        else{
            $query = $this->db->select(
              'presentationdb.*, 
            useraccounts.firstName, 
            useraccounts.lastName, 
            categories.name as category_name, 
            subcategories.name as subcategory_name')
              ->from('presentationdb')
              ->join('useraccounts', 'useraccounts.id = presentationdb.idAuthor')
              ->join('categories', 'categories.id = presentationdb.category')
              ->join('subcategories', 'subcategories.id = presentationdb.subcategory')
              ->where('presentationdb.category', $idCate)
              ->where('presentationdb.subcategory', $idSubCate)
              ->where('presentationdb.public', 1)
              ->get();
        }

        return $query->result_array();
    }

    public function getCategoryConference($idCate = false, $idSubCate = false, $userID = false)
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
              AND ((
                   select COUNT(*) from conference_registrations
                 JOIN conferences ON BINARY conferences.CID = conference_registrations.CID
                  where conference_registrations.userID = '.$userID.' > 0 )
                  OR (
                   select COUNT(*) from conference_permissions
                 JOIN conferences ON conferences.id = conference_permissions.confID
                  where conference_permissions.userID = '.$userID.' and conference_permissions.status = "Accept" > 0
                  ))')
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
              ->get();
        }

        return $query->result_array();
    }

    public function getCategoryAvailableConference($idCate = false, $userID = false)
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
              ->get();
        }

        return $query->result_array();
    }

    public function countPostByUser($id_user, $userID)
    {

        $postVideo = count($this->getPostVideoByUser($id_user, $userID));
        $postPaper = count($this->getPostPaperByUser($id_user, $userID));
        $postPoster = count($this->getPostPosterByUser($id_user, $userID));
        $postPresentation = count($this->getPostPresentationByUser($id_user, $userID));
        $postConference = count($this->getPostConferenceByUser($id_user, $userID));

        $posts = array();
        $posts['Video'] = $postVideo;
        $posts['Paper'] = $postPaper;
        $posts['Poster'] = $postPoster;
        $posts['Presentation'] = $postPresentation;
        $posts['Conference'] = $postConference;

        return $posts;
    }

    public function getPostVideoByUser($id_user, $userLogin = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) 
                AND moviesdb.idAuthor = '.$id_user.' 
                AND moviesdb.status = 1
            ');
        }
        else{
            $query = $this->db->query('
                SELECT moviesdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                WHERE moviesdb.idAuthor = "'. $id_user .'" AND moviesdb.status = 1 AND moviesdb.public = 1
            ');
        }
        return $query->result_array();
    }

    public function getPostPaperByUser($id_user, $userLogin = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "paper") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "paper") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) 
                AND paperdb.idAuthor = '.$id_user.' 
            ');
        }
        else{
            $query = $this->db->query('
                SELECT paperdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                WHERE paperdb.idAuthor = "'. $id_user .'" AND paperdb.public = 1
            ');
        }
        return $query->result_array();
    }

    public function getPostPosterByUser($id_user, $userLogin = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "poster") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "poster") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) 
                AND posterdb.idAuthor = '.$id_user.' 
            ');
        }
        else{
            $query = $this->db->query('
                SELECT posterdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                WHERE posterdb.idAuthor = "'. $id_user .'" AND posterdb.public = 1
            ');
        }
        return $query->result_array();
    }

    public function getPostPresentationByUser($id_user, $userLogin = false)
    {
        if ($userLogin){
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN categories
                ON presentationdb.category = categories.id
                JOIN subcategories
                ON presentationdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_registrations 
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "presentation") AS CRE
                ON presentationdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "presentation") AS CPE
                ON presentationdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND presentationdb.public = 0) OR presentationdb.public = 1) 
                AND presentationdb.idAuthor = '.$id_user.' 
            ');
        }
        else{
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN categories
                ON presentationdb.category = categories.id
                JOIN subcategories
                ON presentationdb.subcategory = subcategories.id
                WHERE presentationdb.idAuthor = "'. $id_user .'" AND presentationdb.public = 1
            ');
        }
        return $query->result_array();
    }

    public function getPostConferenceByUser($id_user, $userLogin = false)
    {
        if ($userLogin){
            $query = $this->db->query('
                SELECT conferences.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM conferences 
                JOIN useraccounts
                ON conferences.userID = useraccounts.id
                JOIN categories
                ON conferences.category = categories.id
                JOIN subcategories
                ON conferences.subcategory = subcategories.id
                LEFT JOIN (SELECT conference_registrations.CID 
                           FROM conference_registrations 
                           WHERE userID = '.$userLogin.') AS CR
                ON BINARY conferences.CID=CR.CID
                LEFT JOIN (SELECT conference_permissions.CID 
                           FROM conference_permissions 
                           WHERE userID = '.$userLogin.') AS CP
                ON BINARY conferences.CID=CP.CID
                WHERE (((CR.CID IS NOT NULL OR CP.CID IS NOT NULL) AND conferences.allowClosedAccess = 1) OR conferences.allowClosedAccess = 0)
                AND conferences.userID = '.$id_user.'
            ');
        }
        else{
            $query = $this->db->select('conferences.*, categories.name AS category_name, subcategories.name AS subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'conferences.userID = useraccounts.id')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.userID', $id_user)
              ->where('conferences.allowClosedAccess', 0)
              ->get();
        }
        return $query->result_array();
    }

    public function getPostVideoByUserPagination($id_user, $userLogin = false, $limit = false, $start = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "video") AS CRE
                ON moviesdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "video") AS CPE
                ON moviesdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND moviesdb.public = 0) OR moviesdb.public = 1) 
                AND moviesdb.idAuthor = '.$id_user.' 
                AND moviesdb.status = 1
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->query('
                SELECT moviesdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN categories
                ON moviesdb.category = categories.id
                JOIN subcategories
                ON moviesdb.subcategory = subcategories.id
                WHERE moviesdb.idAuthor = "'. $id_user .'" AND moviesdb.status = 1 AND moviesdb.public = 1
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        return $query->result_array();
    }

    public function getPostPaperByUserPagination($id_user, $userLogin = false, $limit = false, $start = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "paper") AS CRE
                ON paperdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "paper") AS CPE
                ON paperdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND paperdb.public = 0) OR paperdb.public = 1) 
                AND paperdb.idAuthor = '.$id_user.' 
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->query('
                SELECT paperdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN categories
                ON paperdb.category = categories.id
                JOIN subcategories
                ON paperdb.subcategory = subcategories.id
                WHERE paperdb.idAuthor = "'. $id_user .'" AND paperdb.public = 1
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        return $query->result_array();
    }

    public function getPostPosterByUserPagination($id_user, $userLogin = false, $limit = false, $start = false)
    {
        if ($userLogin){
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
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "poster") AS CRE
                ON posterdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "poster") AS CPE
                ON posterdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND posterdb.public = 0) OR posterdb.public = 1) 
                AND posterdb.idAuthor = '.$id_user.' 
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->query('
                SELECT posterdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN categories
                ON posterdb.category = categories.id
                JOIN subcategories
                ON posterdb.subcategory = subcategories.id
                WHERE posterdb.idAuthor = "'. $id_user .'" AND posterdb.public = 1
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        return $query->result_array();
    }

    public function getPostPresentationByUserPagination($id_user, $userLogin = false, $limit = false, $start = false)
    {
        if ($userLogin){
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN categories
                ON presentationdb.category = categories.id
                JOIN subcategories
                ON presentationdb.subcategory = subcategories.id
                LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_registrations 
                                                     WHERE userID = '.$userLogin.') AS CR 
                                               ON BINARY CE.CID=CR.CID
                                               WHERE CE.type = "presentation") AS CRE
                ON presentationdb.id = CRE.elementID
                LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                                               FROM conference_elements AS CE 
                                               JOIN (SELECT * 
                                                     FROM conference_permissions 
                                                     WHERE userID = '.$userLogin.' AND status = "Accept") AS CP 
                                               ON BINARY CE.CID=CP.CID
                                               WHERE CE.type = "presentation") AS CPE
                ON presentationdb.id = CPE.elementID
                WHERE (((CRE.elementID IS NOT NULL OR CPE.elementID IS NOT NULL) AND presentationdb.public = 0) OR presentationdb.public = 1) 
                AND presentationdb.idAuthor = '.$id_user.' 
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN categories
                ON presentationdb.category = categories.id
                JOIN subcategories
                ON presentationdb.subcategory = subcategories.id
                WHERE presentationdb.idAuthor = "'. $id_user .'" AND presentationdb.public = 1
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        return $query->result_array();
    }

    public function getPostConferenceByUserPagination($id_user, $userLogin = false, $limit = false, $start = false)
    {
        if ($userLogin){
            $query = $this->db->query('
                SELECT conferences.*, useraccounts.firstName, useraccounts.lastName, categories.name AS category_name, subcategories.name AS subcategory_name 
                FROM conferences 
                JOIN useraccounts
                ON conferences.userID = useraccounts.id
                JOIN categories
                ON conferences.category = categories.id
                JOIN subcategories
                ON conferences.subcategory = subcategories.id
                LEFT JOIN (SELECT conference_registrations.CID 
                           FROM conference_registrations 
                           WHERE userID = '.$userLogin.') AS CR
                ON BINARY conferences.CID=CR.CID
                LEFT JOIN (SELECT conference_permissions.CID 
                           FROM conference_permissions 
                           WHERE userID = '.$userLogin.') AS CP
                ON BINARY conferences.CID=CP.CID
                WHERE (((CR.CID IS NOT NULL OR CP.CID IS NOT NULL) AND conferences.allowClosedAccess = 1) OR conferences.allowClosedAccess = 0)
                AND conferences.userID = '.$id_user.'
                LIMIT '.$limit.' OFFSET '.$start.'
            ');
        }
        else{
            $query = $this->db->select('conferences.*, categories.name AS category_name, subcategories.name AS subcategory_name')
              ->from('conferences')
              ->join('useraccounts', 'conferences.userID = useraccounts.id')
              ->join('categories', 'categories.id = conferences.category')
              ->join('subcategories', 'subcategories.id = conferences.subcategory')
              ->where('conferences.userID', $id_user)
              ->where('conferences.allowClosedAccess', 0)
              ->limit($limit, $start)
              ->get();
        }
        return $query->result_array();
    }

    public function countPostByCID($CID, $userID)
    {
        $postVideo = count($this->getElementVideoByCID($CID, $userID));
        $postPaper = count($this->getElementPaperByCID($CID, $userID));
        $postPoster = count($this->getElementPosterByCID($CID, $userID));
        $postPresentation = count($this->getElementPresentationByCID($CID, $userID));

        $posts = array();
        $posts['Video'] = $postVideo;
        $posts['Presentation'] = $postPresentation;
        $posts['Poster'] = $postPoster;
        $posts['Paper'] = $postPaper;

        return $posts;
    }

    public function getElementVideoByCID($CID = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT moviesdb.*, useraccounts.firstName, useraccounts.lastName, CEV.name AS sessionName
                    FROM moviesdb 
                    JOIN useraccounts
                    ON moviesdb.idAuthor = useraccounts.id
                    JOIN (SELECT CE.elementID, CE.session, CS.name
                          FROM conference_elements AS CE
                          JOIN conference_sessions AS CS
                          ON CE.session = CS.ID
                          WHERE CE.type = "video"
                         ) AS CEV
                	  ON moviesdb.id = CEV.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_registrations 
                                     WHERE userID = '.$userID.') AS CR 
                               ON BINARY CE.CID=CR.CID
                               WHERE CE.type = "video" AND BINARY CE.CID = "'.$CID.'") AS CRE
                    ON moviesdb.id = CRE.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_permissions 
                                     WHERE userID = '.$userID.' AND status = "Accept") AS CP 
                               ON BINARY CE.CID=CP.CID
                               WHERE CE.type = "video" AND BINARY CE.CID = "'.$CID.'") AS CPE
                    ON moviesdb.id = CPE.elementID
                    WHERE (CRE.CID IS NOT NULL OR CPE.CID IS NOT NULL)
                    AND moviesdb.status = 1 
            ');
        }
        else{
            $query = $this->db->query('
                SELECT moviesdb.*, CEV.name AS sessionName, useraccounts.firstName, useraccounts.lastName
                FROM moviesdb 
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                JOIN (SELECT CE.elementID, CE.session, CS.name
                      FROM conference_elements AS CE
                      JOIN conference_sessions AS CS
                      ON CE.session = CS.ID
                      WHERE CE.type = "video" AND BINARY CE.CID = "'.$CID.'"
                     ) AS CEV
                ON moviesdb.id = CEV.elementID
                WHERE moviesdb.status = 1 AND moviesdb.public = 1
            ');
        }

        return $query->result_array();
    }

    public function getElementPaperByCID($CID = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT paperdb.*, useraccounts.firstName, useraccounts.lastName, CEV.name AS sessionName
                    FROM paperdb 
                    JOIN useraccounts
                    ON paperdb.idAuthor = useraccounts.id
                    JOIN (SELECT CE.elementID, CE.session, CS.name
                          FROM conference_elements AS CE
                          JOIN conference_sessions AS CS
                          ON CE.session = CS.ID
                          WHERE CE.type = "paper"
                         ) AS CEV
                	ON paperdb.id = CEV.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_registrations 
                                     WHERE userID = '.$userID.') AS CR 
                               ON BINARY CE.CID=CR.CID
                               WHERE CE.type = "paper" AND BINARY CE.CID = "'.$CID.'") AS CRE
                    ON paperdb.id = CRE.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_permissions 
                                     WHERE userID = '.$userID.' AND status = "Accept") AS CP 
                               ON BINARY CE.CID=CP.CID
                               WHERE CE.type = "paper" AND BINARY CE.CID = "'.$CID.'") AS CPE
                    ON paperdb.id = CPE.elementID
                    WHERE (CRE.CID IS NOT NULL OR CPE.CID IS NOT NULL)
            ');
        }
        else{
            $query = $this->db->query('
                SELECT paperdb.*, CEV.name AS sessionName, useraccounts.firstName, useraccounts.lastName
                FROM paperdb 
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                JOIN (SELECT CE.elementID, CE.session, CS.name
                      FROM conference_elements AS CE
                      JOIN conference_sessions AS CS
                      ON CE.session = CS.ID
                      WHERE CE.type = "paper" AND BINARY CE.CID = "'.$CID.'"
                     ) AS CEV
                ON paperdb.id = CEV.elementID
                WHERE paperdb.public = 1
            ');
        }

        return $query->result_array();
    }

    public function getElementPosterByCID($CID = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT posterdb.*, useraccounts.firstName, useraccounts.lastName, CEV.name AS sessionName
                    FROM posterdb 
                    JOIN useraccounts
                    ON posterdb.idAuthor = useraccounts.id
                    JOIN (SELECT CE.elementID, CE.session, CS.name
                          FROM conference_elements AS CE
                          JOIN conference_sessions AS CS
                          ON CE.session = CS.ID
                          WHERE CE.type = "poster"
                         ) AS CEV
                	  ON posterdb.id = CEV.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_registrations 
                                     WHERE userID = '.$userID.') AS CR 
                               ON BINARY CE.CID=CR.CID
                               WHERE CE.type = "poster" AND BINARY CE.CID = "'.$CID.'") AS CRE
                    ON posterdb.id = CRE.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_permissions 
                                     WHERE userID = '.$userID.' AND status = "Accept") AS CP 
                               ON BINARY CE.CID=CP.CID
                               WHERE CE.type = "poster" AND BINARY CE.CID = "'.$CID.'") AS CPE
                    ON posterdb.id = CPE.elementID
                    WHERE (CRE.CID IS NOT NULL OR CPE.CID IS NOT NULL)
            ');
        }
        else{
            $query = $this->db->query('
                SELECT posterdb.*, CEV.name AS sessionName, useraccounts.firstName, useraccounts.lastName
                FROM posterdb 
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                JOIN (SELECT CE.elementID, CE.session, CS.name
                      FROM conference_elements AS CE
                      JOIN conference_sessions AS CS
                      ON CE.session = CS.ID
                      WHERE CE.type = "poster" AND BINARY CE.CID = "'.$CID.'"
                     ) AS CEV
                ON posterdb.id = CEV.elementID
                WHERE posterdb.public = 1
            ');
        }

        return $query->result_array();
    }

    public function getElementPresentationByCID($CID = false, $userID = false)
    {
        if ($userID){
            $query = $this->db->query('
                SELECT presentationdb.*, useraccounts.firstName, useraccounts.lastName, CEV.name AS sessionName
                    FROM presentationdb 
                    JOIN useraccounts
                    ON presentationdb.idAuthor = useraccounts.id
                    JOIN (SELECT CE.elementID, CE.session, CS.name
                          FROM conference_elements AS CE
                          JOIN conference_sessions AS CS
                          ON CE.session = CS.ID
                          WHERE CE.type = "presentation"
                         ) AS CEV
                	  ON presentationdb.id = CEV.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CR.CID 
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_registrations 
                                     WHERE userID = '.$userID.') AS CR 
                               ON BINARY CE.CID=CR.CID
                               WHERE CE.type = "presentation" AND BINARY CE.CID = "'.$CID.'") AS CRE
                    ON presentationdb.id = CRE.elementID
                    LEFT JOIN (SELECT CE.type, CE.elementID, CP.CID 
                               FROM conference_elements AS CE 
                               JOIN (SELECT * 
                                     FROM conference_permissions 
                                     WHERE userID = '.$userID.' AND status = "Accept") AS CP 
                               ON BINARY CE.CID=CP.CID
                               WHERE CE.type = "presentation" AND BINARY CE.CID = "'.$CID.'") AS CPE
                    ON presentationdb.id = CPE.elementID
                    WHERE (CRE.CID IS NOT NULL OR CPE.CID IS NOT NULL)
            ');
        }
        else{
            $query = $this->db->query('
                SELECT presentationdb.*, CEV.name AS sessionName, useraccounts.firstName, useraccounts.lastName
                FROM presentationdb 
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                JOIN (SELECT CE.elementID, CE.session, CS.name
                      FROM conference_elements AS CE
                      JOIN conference_sessions AS CS
                      ON CE.session = CS.ID
                      WHERE CE.type = "presentation" AND BINARY CE.CID = "'.$CID.'"
                     ) AS CEV
                ON presentationdb.id = CEV.elementID
                WHERE presentationdb.public = 1
            ');
        }

        return $query->result_array();
    }

    public function getPostByCid($type, $CID, $userID)
    {
        if ($type == 'video') {
            return $this->getElementVideoByCID($CID, $userID);
        } elseif ($type == 'poster') {
            return $this->getElementPosterByCID($CID, $userID);
        } elseif ($type == 'paper') {
            return $this->getElementPaperByCID($CID, $userID);
        } elseif ($type == 'presentation') {
            return $this->getElementPresentationByCID($CID, $userID);
        }
    }
}