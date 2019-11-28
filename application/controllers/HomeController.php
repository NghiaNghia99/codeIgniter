<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:04
 */

class HomeController extends MY_Controller
{
    protected $user;
    public function __construct()
    {
        parent::__construct();

        /*
         * Load languages
         * */
        $this->load->helper('language');
        $this->lang->load("content","english");
        /*
         * Load models
         * */
        $this->load->model('category');
        $this->load->model('useraccount');
        $this->load->model('movie');
        $this->load->model('paper');
        $this->load->model('poster');
        $this->load->model('presentation');
        $this->load->model('cid');
        $this->load->model('conference');
        $this->load->model('conferencesession');
        $this->load->model('conferenceelement');
        $this->load->model('conferenceregistration');
        $this->load->model('conferenceabstract');
        $this->load->model('registrationtool');
        $this->load->model('abstracttool');
        $this->load->model('conferencepermission');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('pagination');
        
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        }
    }

    public function index(){
        /*
         * Load data
         * */
        $this->data['countVideos'] = count($this->movie->getFull($this->userID));
        $this->data['movies'] = $this->movie->getLimit($this->userID, 8, 0);
        $this->data['countPapers'] = count($this->paper->getFull($this->userID));
        $this->data['papers'] = $this->paper->getLimit($this->userID, 8, 0);
        $this->data['countPosters'] = count($this->poster->getFull($this->userID));
        $this->data['posters'] = $this->poster->getLimit($this->userID, 8, 0);
        $this->data['countPresentations'] = count($this->presentation->getFull($this->userID));
        $this->data['presentations'] = $this->presentation->getLimit($this->userID, 8, 0);
        $this->data['bodyClass'] = 'home-page';
        $this->page = 'home';
        $this->layout();
    }

    public function getPresentationsLimit(){
        $start = $this->input->get('start');
        $posts = $this->presentation->getLimit($this->userID, 8, $start);
        $results = array();
        if (!empty($posts)){
            foreach ($posts as $post){
                $item = '';
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/presentations/' . $post['id'] . '.jpg');

                $item .= '<div class="col-md-3">';
                $item .= '<div class="post-item-custom post-item-home">';
                $item .= '<div class="front-item">';
                $item .= '<div class="post-item-custom-img">';
                $item .= '<img src="'. $banner_file .'" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content">';
                $item .= '<div class="post-item-custom-content-title">'. $post['presTitle'] .'</div>';
                $item .= '<div class="post-item-custom-content-desc cate-desc ">';
                $item .= $post['category_name'] . ' (' . $post['subcategory_name'] . ')';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author d-flex align-items-center">';
                $item .= '<div class="post-item-custom-content-author-avatar">';
                $item .= '<img src="' . base_url($avatar) . '" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author-name">';
                $item .= $post['firstName'] . ' ' . $post['lastName'];
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-detail block-white back-item">';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Date of upload:</div>';
                if (!empty($post['dateOfUpload'])){
                    $item .= '<div>' . date('d.m.Y', $post['dateOfUpload']) . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Co-author:</div>';
                if (!empty($post['coAuthors'])){
                    $item .= '<div>' . $post['coAuthors'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Abstract:</div>';
                if (!empty($post['caption'])){
                    $item .= '<div>' . $post['caption'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                if (isset($_SESSION['login'])) {
                    $item .= '<input type="hidden" value="'. $post['idAuthor'] .'">';
                }
                $item .= '<div class="btn-custom btn-border green">';
                $item .= '<a href="'. base_url('presentation/' . $post['id']) .'">View more</a>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';

                array_push($results, $item);
            }
            echo json_encode($results);
        }
        else{
            echo json_encode(false);
        }
    }

    public function getVideosLimit(){
        $start = $this->input->get('start');
        $posts = $this->movie->getLimit($this->userID, 8, $start);
        $results = array();
        if (!empty($posts)){
            foreach ($posts as $post){
                $item = '';
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '.jpg');

                $item .= '<div class="col-md-3">';
                $item .= '<div class="post-item-custom post-item-home">';
                $item .= '<div class="front-item">';
                $item .= '<div class="post-item-custom-img">';
                $item .= '<img src="'. $banner_file .'" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content">';
                $item .= '<div class="post-item-custom-content-title">'. $post['title'] .'</div>';
                $item .= '<div class="post-item-custom-content-desc cate-desc ">';
                $item .= $post['category_name'] . ' (' . $post['subcategory_name'] . ')';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author d-flex align-items-center">';
                $item .= '<div class="post-item-custom-content-author-avatar">';
                $item .= '<img src="' . base_url($avatar) . '" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author-name">';
                $item .= $post['firstName'] . ' ' . $post['lastName'];
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-detail block-white back-item">';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Date of upload:</div>';
                if (!empty($post['dateOfUpload'])){
                    $item .= '<div>' . date('d.m.Y', $post['dateOfUpload']) . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Co-author:</div>';
                if (!empty($post['coAuthors'])){
                    $item .= '<div>' . $post['coAuthors'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Caption:</div>';
                if (!empty($post['caption'])){
                    $item .= '<div>' . $post['caption'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                if (isset($_SESSION['login'])) {
                    $item .= '<input type="hidden" value="'. $post['idAuthor'] .'">';
                }
                $item .= '<div class="btn-custom btn-border green">';
                $item .= '<a href="'. base_url('video/' . $post['id']) .'">View more</a>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';

                array_push($results, $item);
            }
            echo json_encode($results);
        }
        else{
            echo json_encode(false);
        }
    }

    public function getPapersLimit(){
        $start = $this->input->get('start');
        $posts = $this->paper->getLimit($this->userID, 8, $start);
        $results = array();
        if (!empty($posts)){
            foreach ($posts as $post){
                $item = '';
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/papers/' . $post['id'] . '.jpg');

                $item .= '<div class="col-md-3">';
                $item .= '<div class="post-item-custom post-item-home">';
                $item .= '<div class="front-item">';
                $item .= '<div class="post-item-custom-img">';
                $item .= '<img src="'. $banner_file .'" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content">';
                $item .= '<div class="post-item-custom-content-title">'. $post['paperTitle'] .'</div>';
                $item .= '<div class="post-item-custom-content-desc cate-desc ">';
                $item .= $post['category_name'] . ' (' . $post['subcategory_name'] . ')';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author d-flex align-items-center">';
                $item .= '<div class="post-item-custom-content-author-avatar">';
                $item .= '<img src="' . base_url($avatar) . '" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author-name">';
                $item .= $post['firstName'] . ' ' . $post['lastName'];
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-detail block-white back-item">';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Date of upload:</div>';
                if (!empty($post['dateOfUpload'])){
                    $item .= '<div>' . date('d.m.Y', $post['dateOfUpload']) . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Co-author:</div>';
                if (!empty($post['coAuthors'])){
                    $item .= '<div>' . $post['coAuthors'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Abstract:</div>';
                if (!empty($post['caption'])){
                    $item .= '<div>' . $post['caption'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                if (isset($_SESSION['login'])) {
                    $item .= '<input type="hidden" value="'. $post['idAuthor'] .'">';
                }
                $item .= '<div class="btn-custom btn-border green">';
                $item .= '<a href="'. base_url('paper/' . $post['id']) .'">View more</a>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';

                array_push($results, $item);
            }
            echo json_encode($results);
        }
        else{
            echo json_encode(false);
        }
    }

    public function getPostersLimit(){
        $start = $this->input->get('start');
        $posts = $this->poster->getLimit($this->userID, 8, $start);
        $results = array();
        if (!empty($posts)){
            foreach ($posts as $post){
                $item = '';
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/posters/' . $post['id'] . '.jpg');

                $item .= '<div class="col-md-3">';
                $item .= '<div class="post-item-custom post-item-home">';
                $item .= '<div class="front-item">';
                $item .= '<div class="post-item-custom-img">';
                $item .= '<img src="'. $banner_file .'" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content">';
                $item .= '<div class="post-item-custom-content-title">'. $post['posterTitle'] .'</div>';
                $item .= '<div class="post-item-custom-content-desc cate-desc ">';
                $item .= $post['category_name'] . ' (' . $post['subcategory_name'] . ')';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author d-flex align-items-center">';
                $item .= '<div class="post-item-custom-content-author-avatar">';
                $item .= '<img src="' . base_url($avatar) . '" alt="">';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-content-author-name">';
                $item .= $post['firstName'] . ' ' . $post['lastName'];
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '<div class="post-item-custom-detail block-white back-item">';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Date of upload:</div>';
                if (!empty($post['dateOfUpload'])){
                    $item .= '<div>' . date('d.m.Y', $post['dateOfUpload']) . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Co-author:</div>';
                if (!empty($post['coAuthors'])){
                    $item .= '<div>' . $post['coAuthors'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                $item .= '<div class="item">';
                $item .= '<div class="item-label">Abstract:</div>';
                if (!empty($post['caption'])){
                    $item .= '<div>' . $post['caption'] . '</div>';
                }
                else{
                    $item .= '<div>Empty</div>';
                }
                $item .= '</div>';
                if (isset($_SESSION['login'])) {
                    $item .= '<input type="hidden" value="'. $post['idAuthor'] .'">';
                }
                $item .= '<div class="btn-custom btn-border green">';
                $item .= '<a href="'. base_url('poster/' . $post['id']) .'">View more</a>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';

                array_push($results, $item);
            }
            echo json_encode($results);
        }
        else{
            echo json_encode(false);
        }
    }

    public function removeSessionPostType(){
        if (isset($_SESSION['post_type'])){
            $this->session->unset_userdata('post_type');
        }
        if (isset($_SESSION['active_sort'])){
            $this->session->unset_userdata('active_sort');
        }

        if (isset($_SESSION['active_view_sort'])){
            $this->session->unset_userdata('active_view_sort');
        }
        if (isset($_SESSION['active_date_sort'])){
            $this->session->unset_userdata('active_date_sort');
        }
        if (isset($_SESSION['active_alpha_sort'])){
            $this->session->unset_userdata('active_alpha_sort');
        }
    }

    public function removeSessionPostTypeSearch(){
        if (isset($_SESSION['post_type_cate'])){
            $this->session->unset_userdata('post_type_cate');
        }
        if (isset($_SESSION['active_sort_search'])){
            $this->session->unset_userdata('active_sort_search');
        }

        if (isset($_SESSION['active_view_sort_cate'])){
            $this->session->unset_userdata('active_view_sort_cate');
        }
        if (isset($_SESSION['active_date_sort_cate'])){
            $this->session->unset_userdata('active_date_sort_cate');
        }
        if (isset($_SESSION['active_alpha_sort_cate'])){
            $this->session->unset_userdata('active_alpha_sort_cate');
        }
    }

    public function getTermsAndConditions()
    {
        $this->page = 'terms_conditions';
        $this->layout();
    }

    public function getTellUs(){
        $this->session->unset_userdata('tell_us_success');
        $this->form_validation->set_rules('comment-tell-us', 'comment', 'trim|required');
        if ($this->form_validation->run()) {
            $this->sendMailTellUs($this->input->post('comment-tell-us'));
            $this->session->set_userdata('tell_us_success', 'successfully');
            redirect('tell-us/success');
        }
        $this->page = 'tell_us';
        $this->layout();
    }

    public function getTellUsSuccess(){
        if (isset($_SESSION['tell_us_success'])){
            $this->session->unset_userdata('tell_us_success');
            $this->page = 'tell_us_success';
            $this->layout();
        }
        else{
            redirect('tell-us');
        }
    }

    public function getAboutUs(){
        $this->page = 'about_us';
        $this->layout();
    }

    public function getContact(){
        $this->page = 'contact';
        $this->layout();
    }

    public function getPrivacyPolicy(){
        $this->page = 'privacy_policy';
        $this->layout();
    }

    public function getHowItWork(){
        $this->page = 'how_it_work';
        $this->layout();
    }

    public function getDOI(){
        $this->page = 'doi';
        $this->layout();
    }

    public function getCategory($id_Category, $id_subCategory)
    {
        $sub_categories = $this->category->getSubCategories($id_Category);
//        echo '<option value=""></option>';
        foreach ($sub_categories as $sub) {
            if ($id_subCategory > 0 && $id_subCategory == $sub['id']) {
                echo '<option selected value="' . $sub['id'] . '">' . $sub['name'] . '</option>';
            } else {
                echo '<option value="' . $sub['id'] . '">' . $sub['name'] . '</option>';
            }
        }
    }

    public function getSubCategory($id_Category)
    {
        $sub_categories = $this->category->getSubCategories($id_Category);
//        echo '<option value=""></option>';
        foreach ($sub_categories as $sub) {
            echo '<option value="' . $sub['id'] . '">' . $sub['name'] . '</option>';
        }
    }

    public function getSubCategoryConference($id_altCategory, $id_subCategory)
    {
        $sub_categories = $this->category->getSubCategories($id_altCategory);
        foreach ($sub_categories as $sub) {
            if ($sub['id'] != $id_subCategory){
                echo '<option value="' . $sub['id'] . '">' . $sub['name'] . '</option>';
            }
        }
    }

    public function getVideoPage($id)
    {
        $post = $this->movie->get_info($id);
        if (!empty($post)){
            $checkAuthor = false;
            if($this->userID && $post->idAuthor == $this->userID){
                $checkAuthor = true;
            }
            else{
                $post->views++;
                $this->movie->update($id, array('views' => $post->views));
            }
            $this->data['alt_category'] = $this->movie->getAltCategory($id);
            $this->data['post'] = $this->movie->get($id);
            $this->data['checkAuthor'] = $checkAuthor;

            if ($post->views == 50) {
                $user = $this->useraccount->get_info($post->idAuthor);
                $fullName = $user->firstName . ' ' . $user->lastName;
                $this->sendMailFiftyViews($user->email, $fullName);
            }

            $listConference = $this->conference->getConferenceByPost('video', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->page = 'video_page';
            $this->layout();
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function getPosterPage($id)
    {
        $post = $this->poster->get_info($id);
        if (!empty($post)) {
            $checkAuthor = false;
            if ($this->userID && $post->idAuthor == $this->userID) {
                $checkAuthor = true;
            }
            else{
                $post->views++;
                $this->poster->update($id, array('views' => $post->views));
            }
            $this->data['alt_category'] = $this->poster->getAltCategory($id);
            $this->data['post'] = $this->poster->get($id);
            $this->data['checkAuthor'] = $checkAuthor;

            if ($post->views == 50) {
                $user = $this->useraccount->get_info($post->idAuthor);
                $fullName = $user->firstName . ' ' . $user->lastName;
                $this->sendMailFiftyViews($user->email, $fullName);
            }

            $listConference = $this->conference->getConferenceByPost('poster', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->page = 'poster_page';
            $this->layout();
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function getPaperPage($id)
    {
        $post = $this->paper->get_info($id);
        if (!empty($post)) {
            $checkAuthor = false;
            if ($this->userID && $post->idAuthor == $this->userID) {
                $checkAuthor = true;
            }
            else{
                $post->views++;
                $this->paper->update($id, array('views' => $post->views));
            }

            $this->data['alt_category'] = $this->paper->getAltCategory($id);
            $this->data['post'] = $this->paper->get($id);
            $this->data['checkAuthor'] = $checkAuthor;

            if ($post->views == 50) {
                $user = $this->useraccount->get_info($post->idAuthor);
                $fullName = $user->firstName . ' ' . $user->lastName;
                $this->sendMailFiftyViews($user->email, $fullName);
            }

            $listConference = $this->conference->getConferenceByPost('paper', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->page = 'paper_page';
            $this->layout();
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function getPresentationPage($id)
    {
        $post = $this->presentation->get_info($id);
        if (!empty($post)) {
            $checkAuthor = false;
            if ($this->userID && $post->idAuthor == $this->userID) {
                $checkAuthor = true;
            }
            else{
                $post->views++;
                $this->presentation->update($id, array('views' => $post->views));
            }

            $this->data['alt_category'] = $this->presentation->getAltCategory($id);
            $this->data['post'] = $this->presentation->get($id);
            $this->data['checkAuthor'] = $checkAuthor;

            if ($post->views == 50) {
                $user = $this->useraccount->get_info($post->idAuthor);
                $fullName = $user->firstName . ' ' . $user->lastName;
                $this->sendMailFiftyViews($user->email, $fullName);
            }

            $listConference = $this->conference->getConferenceByPost('presentation', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->page = 'presentation_page';
            $this->layout();
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function getConferencePage($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            if (empty($_SESSION['contribution_type'])) {
                $this->session->set_userdata('contribution_type', 'Videos');
            }
            $cid = $conference['CID'];
            $this->session->set_userdata('cid', $cid);
            if (!empty($this->user)){
                $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
                if (!empty($permission)){
                    $this->data['checkHost'] = true;
                }
                else{
                    $conference['views']++;
                    $this->conference->update($id, array('views' => $conference['views']));
                }
                $this->data['registeredUser'] = $this->conferenceregistration->get_info_binary_2('CID', $conference['CID'], 'userID', $this->userID);
            }
            $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
            $this->data['checkRegistrationActive'] = $this->registrationtool->checkRegistrationConferenceActive($cid);
            $this->data['checkAbstractActive'] = $this->abstracttool->checkAbstractConferenceActive($cid);
            $this->data['userParticipation'] = $this->conferenceregistration->getUserParticipationByConference($cid);
            $this->data['count'] = $this->category->countPostByCID($cid, $this->userID);
            $this->data['videos'] = $this->category->getPostByCid('video', $cid, $this->userID);
            $this->data['papers'] = $this->category->getPostByCid('paper', $cid, $this->userID);
            $this->data['posters'] = $this->category->getPostByCid('poster', $cid, $this->userID);
            $this->data['presentations'] = $this->category->getPostByCid('presentation', $cid, $this->userID);
            $this->data['alt_category'] = $this->conference->getAltCategory($id);
            $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
            $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
            $this->data['conference'] = $conference;
            $this->data['countVideo'] = count($this->category->getElementVideoByCID($conference['CID'], $this->userID));
            $this->data['countPaper'] = count($this->category->getElementPaperByCID($conference['CID'], $this->userID));
            $this->data['countPoster'] = count($this->category->getElementPosterByCID($conference['CID'], $this->userID));
            $this->data['countPresentation'] = count($this->category->getElementPresentationByCID($conference['CID'], $this->userID));
            $this->data['postType'] = $this->session->contribution_type;

            $this->page = 'conference_page';
            $this->layout();
        }
    }

//    public function getCategoryPage($idCate, $idSubCate){
//        if (isset($_SESSION['active_sort'])) {
//            $active_sort = $this->session->active_sort;
//        } else {
//            $active_sort = 'Max';
//            $this->session->set_userdata('active_sort', 'Max');
//        }
//        if (empty($_SESSION['post_type'])) {
//            $this->session->set_userdata('post_type', 'videos');
//        }
//
//        $videos = array();
//        $papers = array();
//        $presentations = array();
//        $posters = array();
//        $conferences = array();
//
//        $direction = null;
//        $colName = null;
//        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
//        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
//        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
//        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
//        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));
//
//        if ($totalVideo > 0) {
//            $limit_per_page = 12;
//            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;
//
//            if ($active_sort == 'Max' || $active_sort == 'Min') {
//                $direction = $this->getViewsSort($active_sort);
//                $colName = 'views';
//            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
//                $direction = $this->getDateSort($active_sort);
//                $colName = 'dateOfUpload';
//            } else {
//                $direction = $this->getAlphaSort($active_sort);
//                $colName = 'title';
//            }
//
//            $videos['results'] = $this->movie->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
//              $colName, $direction);
//
//            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
//            $config['total_rows'] = $totalVideo;
//            $config['per_page'] = $limit_per_page;
//            $config["uri_segment"] = 4;
//            $config['use_page_numbers'] = true;
//            $config['num_links'] = 1;
////            $config['page_query_string'] = true;
////            $config['reuse_query_string'] = true;
//            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
//            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
//            $config['first_tag_open'] = '<span class="firstlink">';
//            $config['first_tag_close'] = '</span>';
//            $config['last_tag_open'] = '<span class="lastlink">';
//            $config['last_tag_close'] = '</span>';
//            $config['next_tag_open'] = '<span class="nextlink">';
//            $config['next_tag_close'] = '</span>';
//            $config['prev_tag_open'] = '<span class="prevlink">';
//            $config['prev_tag_close'] = '</span>';
//
//            $this->pagination->initialize($config);
//
//            $videos["links"] = $this->pagination->create_links();
//        }
//        if ($totalPaper > 0) {
//            $limit_per_page = 12;
//            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;
//
//            if ($active_sort == 'Max' || $active_sort == 'Min') {
//                $direction = $this->getViewsSort($active_sort);
//                $colName = 'views';
//            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
//                $direction = $this->getDateSort($active_sort);
//                $colName = 'dateOfUpload';
//            } else {
//                $direction = $this->getAlphaSort($active_sort);
//                $colName = 'paperTitle';
//            }
//
//            $papers['results'] = $this->paper->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
//              $colName, $direction);
//
//            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
//            $config['total_rows'] = $totalPaper;
//            $config['per_page'] = $limit_per_page;
//            $config["uri_segment"] = 4;
//            $config['use_page_numbers'] = true;
//            $config['num_links'] = 1;
////            $config['page_query_string'] = true;
////            $config['reuse_query_string'] = true;
//            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
//            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
//            $config['first_tag_open'] = '<span class="firstlink">';
//            $config['first_tag_close'] = '</span>';
//            $config['last_tag_open'] = '<span class="lastlink">';
//            $config['last_tag_close'] = '</span>';
//            $config['next_tag_open'] = '<span class="nextlink">';
//            $config['next_tag_close'] = '</span>';
//            $config['prev_tag_open'] = '<span class="prevlink">';
//            $config['prev_tag_close'] = '</span>';
//
//            $this->pagination->initialize($config);
//
//            $papers["links"] = $this->pagination->create_links();
//        }
//        if ($totalPoster > 0) {
//            $limit_per_page = 12;
//            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;
//
//            if ($active_sort == 'Max' || $active_sort == 'Min') {
//                $direction = $this->getViewsSort($active_sort);
//                $colName = 'views';
//            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
//                $direction = $this->getDateSort($active_sort);
//                $colName = 'dateOfUpload';
//            } else {
//                $direction = $this->getAlphaSort($active_sort);
//                $colName = 'posterTitle';
//            }
//
//            $posters['results'] = $this->poster->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
//              $colName, $direction);
//
//
//            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
//            $config['total_rows'] = $totalPoster;
//            $config['per_page'] = $limit_per_page;
//            $config["uri_segment"] = 4;
//            $config['use_page_numbers'] = true;
//            $config['num_links'] = 1;
////            $config['page_query_string'] = true;
////            $config['reuse_query_string'] = true;
//            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
//            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
//            $config['first_tag_open'] = '<span class="firstlink">';
//            $config['first_tag_close'] = '</span>';
//            $config['last_tag_open'] = '<span class="lastlink">';
//            $config['last_tag_close'] = '</span>';
//            $config['next_tag_open'] = '<span class="nextlink">';
//            $config['next_tag_close'] = '</span>';
//            $config['prev_tag_open'] = '<span class="prevlink">';
//            $config['prev_tag_close'] = '</span>';
//
//            $this->pagination->initialize($config);
//
//            $posters["links"] = $this->pagination->create_links();
//        }
//        if ($totalPresentation > 0) {
//            $limit_per_page = 12;
//            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;
//
//            if ($active_sort == 'Max' || $active_sort == 'Min') {
//                $direction = $this->getViewsSort($active_sort);
//                $colName = 'views';
//            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
//                $direction = $this->getDateSort($active_sort);
//                $colName = 'dateOfUpload';
//            } else {
//                $direction = $this->getAlphaSort($active_sort);
//                $colName = 'presTitle';
//            }
//
//            $presentations['results'] = $this->presentation->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
//              $colName, $direction);
//
//            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
//            $config['total_rows'] = $totalPresentation;
//            $config['per_page'] = $limit_per_page;
//            $config["uri_segment"] = 4;
//            $config['use_page_numbers'] = true;
//            $config['num_links'] = 1;
//            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
//            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
//            $config['first_tag_open'] = '<span class="firstlink">';
//            $config['first_tag_close'] = '</span>';
//            $config['last_tag_open'] = '<span class="lastlink">';
//            $config['last_tag_close'] = '</span>';
//            $config['next_tag_open'] = '<span class="nextlink">';
//            $config['next_tag_close'] = '</span>';
//            $config['prev_tag_open'] = '<span class="prevlink">';
//            $config['prev_tag_close'] = '</span>';
//
//            $this->pagination->initialize($config);
//
//            $presentations["links"] = $this->pagination->create_links();
//        }
//        if ($totalConference > 0) {
//            $limit_per_page = 8;
//            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;
//
//
//            if ($active_sort == 'Max' || $active_sort == 'Min') {
//                $direction = $this->getViewsSort($active_sort);
//                $colName = 'views';
//            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
//                $direction = $this->getDateSort($active_sort);
//                $colName = 'endDate';
//            } else {
//                $direction = $this->getAlphaSort($active_sort);
//                $colName = 'confTitle';
//            }
//
//            $conferences['results'] = $this->conference->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
//              $colName, $direction);
//
//            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
//            $config['total_rows'] = $totalConference;
//            $config['per_page'] = $limit_per_page;
//            $config["uri_segment"] = 4;
//            $config['use_page_numbers'] = true;
//            $config['num_links'] = 1;
////            $config['page_query_string'] = true;
////            $config['reuse_query_string'] = true;
//            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
//            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
//            $config['first_tag_open'] = '<span class="firstlink">';
//            $config['first_tag_close'] = '</span>';
//            $config['last_tag_open'] = '<span class="lastlink">';
//            $config['last_tag_close'] = '</span>';
//            $config['next_tag_open'] = '<span class="nextlink">';
//            $config['next_tag_close'] = '</span>';
//            $config['prev_tag_open'] = '<span class="prevlink">';
//            $config['prev_tag_close'] = '</span>';
//
//            $this->pagination->initialize($config);
//
//            $conferences["links"] = $this->pagination->create_links();
//        }
//
//        $this->data['countVideo'] = $totalVideo;
//        $this->data['countPaper'] = $totalPaper;
//        $this->data['countPoster'] = $totalPoster;
//        $this->data['countPresentation'] = $totalPresentation;
//        $this->data['countConference'] = $totalConference;
//        $this->data['key'] = 'ABC';
//        $this->data['videos'] = $videos;
//        $this->data['presentations'] = $presentations;
//        $this->data['posters'] = $posters;
//        $this->data['papers'] = $papers;
//        $this->data['conferences'] = $conferences;
//        $this->data['postType'] = $this->session->post_type;
//        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
//        $this->data['bodyClass'] = 'show-category-page';
//        $this->data['active_sort'] = $active_sort;
//
//        $this->page = 'show_category';
//        $this->layout();
//    }

    public function getVideoCategory($idCate, $idSubCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }
        $this->session->set_userdata('post_type', 'videos');

        $videos = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));

        if ($totalVideo > 0) {
            $limit_per_page = 12;
            $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5)-1) * $limit_per_page)  : 0;

            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'dateOfUpload';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'title';
            }

            $videos['results'] = $this->movie->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('show-category/' . $idCate . '/' . $idSubCate);
            $config['total_rows'] = $totalVideo;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $videos["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = 'ABC';
        $this->data['videos'] = $videos;
        $this->data['postType'] = $this->session->post_type;
        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
        $this->data['bodyClass'] = 'show-category-page';
        $this->data['active_sort'] = $active_sort;

        $this->page = 'show_category';
        $this->layout();
    }

    public function getPresentationCategory($idCate, $idSubCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }
        $this->session->set_userdata('post_type', 'presentations');

        $presentations = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));

        if ($totalPresentation > 0) {
            $limit_per_page = 12;
            $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5)-1) * $limit_per_page)  : 0;

            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'dateOfUpload';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'presTitle';
            }

            $presentations['results'] = $this->presentation->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('show-category/presentation/' . $idCate . '/' . $idSubCate);
            $config['total_rows'] = $totalPresentation;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $presentations["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = 'ABC';
        $this->data['presentations'] = $presentations;
        $this->data['postType'] = $this->session->post_type;
        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
        $this->data['bodyClass'] = 'show-category-page';
        $this->data['active_sort'] = $active_sort;

        $this->page = 'show_category';
        $this->layout();
    }

    public function getPosterCategory($idCate, $idSubCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }
        $this->session->set_userdata('post_type', 'posters');

        $posters = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));

        if ($totalPoster > 0) {
            $limit_per_page = 12;
            $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5)-1) * $limit_per_page)  : 0;

            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'dateOfUpload';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'posterTitle';
            }

            $posters['results'] = $this->poster->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);


            $config['base_url'] = base_url('show-category/poster/' . $idCate . '/' . $idSubCate);
            $config['total_rows'] = $totalPoster;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $posters["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = 'ABC';
        $this->data['posters'] = $posters;
        $this->data['postType'] = $this->session->post_type;
        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
        $this->data['bodyClass'] = 'show-category-page';
        $this->data['active_sort'] = $active_sort;

        $this->page = 'show_category';
        $this->layout();
    }

    public function getPaperCategory($idCate, $idSubCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }
        $this->session->set_userdata('post_type', 'papers');

        $papers = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));

        if ($totalPaper > 0) {
            $limit_per_page = 12;
            $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5)-1) * $limit_per_page)  : 0;

            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'dateOfUpload';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'paperTitle';
            }

            $papers['results'] = $this->paper->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('show-category/paper/' . $idCate . '/' . $idSubCate);
            $config['total_rows'] = $totalPaper;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $papers["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = 'ABC';
        $this->data['papers'] = $papers;
        $this->data['postType'] = $this->session->post_type;
        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
        $this->data['bodyClass'] = 'show-category-page';
        $this->data['active_sort'] = $active_sort;

        $this->page = 'show_category';
        $this->layout();
    }

    public function getConferenceCategory($idCate, $idSubCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }
        $this->session->set_userdata('post_type', 'conferences');

        $conferences = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getCategoryVideo($idCate, $idSubCate, $this->userID));
        $totalPaper = count($this->category->getCategoryPaper($idCate, $idSubCate, $this->userID));
        $totalPoster = count($this->category->getCategoryPoster($idCate, $idSubCate, $this->userID));
        $totalPresentation = count($this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID));
        $totalConference = count($this->category->getCategoryConference($idCate, $idSubCate, $this->userID));

        if ($totalConference > 0) {
            $limit_per_page = 8;
            $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5)-1) * $limit_per_page)  : 0;


            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'endDate';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'confTitle';
            }

            $conferences['results'] = $this->conference->sortCategoryPagination($idCate, $idSubCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('show-category/conference/' . $idCate . '/' . $idSubCate);
            $config['total_rows'] = $totalConference;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $conferences["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = 'ABC';
        $this->data['conferences'] = $conferences;
        $this->data['postType'] = $this->session->post_type;
        $this->data['category'] = $this->category->getCategory($idCate, $idSubCate);
        $this->data['bodyClass'] = 'show-category-page';
        $this->data['active_sort'] = $active_sort;

        $this->page = 'show_category';
        $this->layout();
    }

    public function getAvailableConferencePage($idCate){
        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }

        $conferences = array();

        $direction = null;
        $colName = null;
        $totalConference = count($this->category->getCategoryAvailableConference($idCate, $this->userID));

        if ($totalConference > 0) {
            $limit_per_page = 12;
            $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'endDate';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'confTitle';
            }

            $conferences['results'] = $this->conference->sortCategoryAvailableConferencePagination($idCate, $this->userID, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('available-conference/' . $idCate);
            $config['total_rows'] = $totalConference;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $conferences["links"] = $this->pagination->create_links();
        }

        $this->data['countConference'] = $totalConference;
        $this->data['conferences'] = $conferences;
        $this->data['category'] = $this->category->getCategory($idCate, false);
        $this->data['active_sort'] = $active_sort;

        $this->page = 'available_conference';
        $this->layout();
    }

    public function getCategoryVideoPage($idCate, $idSubCate)
    {
        $this->data['posts'] = array(
          $this->category->countCategoryItem($idCate, $idSubCate, $this->userID),
          $this->category->getCategoryVideo($idCate, $idSubCate, $this->userID),
          $this->category->getCategory($idCate, $idSubCate)
        );
        $this->page = 'show_category_video';
        $this->layout();
    }

    public function getCategoryPaperPage($idCate, $idSubCate)
    {
        $this->data['posts'] = array(
          $this->category->countCategoryItem($idCate, $idSubCate, $this->userID),
          $this->category->getCategoryPaper($idCate, $idSubCate, $this->userID),
          $this->category->getCategory($idCate, $idSubCate)
        );
        $this->page = 'show_category_paper';
        $this->layout();
    }

    public function getCategoryPosterPage($idCate, $idSubCate)
    {
        $this->data['posts'] = array(
          $this->category->countCategoryItem($idCate, $idSubCate, $this->userID),
          $this->category->getCategoryPoster($idCate, $idSubCate, $this->userID),
          $this->category->getCategory($idCate, $idSubCate)
        );
        $this->page = 'show_category_poster';
        $this->layout();
    }

    public function getCategoryPresentationPage($idCate, $idSubCate)
    {
        $this->data['posts'] = array(
          $this->category->countCategoryItem($idCate, $idSubCate, $this->userID),
          $this->category->getCategoryPresentation($idCate, $idSubCate, $this->userID),
          $this->category->getCategory($idCate, $idSubCate)
        );
        $this->page = 'show_category_presentation';
        $this->layout();
    }

    public function getCategoryConferencePage($idCate, $idSubCate)
    {
        $this->data['posts'] = array(
          $this->category->countCategoryItem($idCate, $idSubCate, $this->userID),
          $this->category->getCategoryConference($idCate, $idSubCate, $this->userID),
          $this->category->getCategory($idCate, $idSubCate)
        );
        $this->page = 'show_category_conference';
        $this->layout();
    }

}