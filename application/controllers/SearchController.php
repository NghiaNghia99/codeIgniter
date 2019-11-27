<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class SearchController extends MY_Controller
{

    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category');
        $this->load->model('useraccount');
        $this->load->model('movie');
        $this->load->model('paper');
        $this->load->model('poster');
        $this->load->model('presentation');
        $this->load->model('cid');
        $this->load->model('conference');
        $this->conference_session = $this->load->model('conferencesession');
        $this->conference_element = $this->load->model('conferenceelement');
        $this->conference_registration = $this->load->model('conferenceregistration');
        $this->conference_abstract = $this->load->model('conferenceabstract');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->library('pagination');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        }
    }

    public function keySearch(){
        $this->session->unset_userdata('keySearch');
        $key = $this->input->post('key');
        $this->session->set_userdata('keySearch', $key);
        redirect(base_url('search/conference'));
    }

    public function searchVideo()
    {
        $key = false;
        if (isset($this->session->keySearch)){
            $key = $this->session->keySearch;
        }
        else{
            redirect();
        }

        if (isset($_SESSION['active_sort_search'])) {
            $active_sort = $this->session->active_sort_search;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort_search', 'Max');
        }
        $this->session->set_userdata('post_type_search', 'videos');

        $videos = array();

        $limit_per_page = 6;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

        $totalVideo = $this->movie->countResultSearch($key, $this->userID);
        $totalPaper = $this->paper->countResultSearch($key, $this->userID);
        $totalPoster = $this->poster->countResultSearch($key, $this->userID);
        $totalPresentation = $this->presentation->countResultSearch($key, $this->userID);
        $totalConference = $this->conference->countResultSearch($key, $this->userID);

        if ($totalVideo > 0) {
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

            $videos['results'] = $this->movie->searchPagination($key, $this->userID, $limit_per_page, $start_index, $colName, $direction);

            $config['base_url'] = base_url('search/video');
            $config['total_rows'] = $totalVideo;
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

            $videos["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = $key;
        $this->data['videos'] = $videos;
        $this->data['active_sort'] = $active_sort;
        $this->data['postType'] = $this->session->post_type_search;
        $this->data['bodyClass'] = 'search-page';

        $this->page = 'search';
        $this->layout();
    }

    public function searchPresentation()
    {
        $key = false;
        if (isset($this->session->keySearch)){
            $key = $this->session->keySearch;
        }
        else{
            redirect();
        }

        if (isset($_SESSION['active_sort_search'])) {
            $active_sort = $this->session->active_sort_search;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort_search', 'Max');
        }
        $this->session->set_userdata('post_type_search', 'presentations');

        $presentations = array();

        $limit_per_page = 6;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

        $totalVideo = $this->movie->countResultSearch($key, $this->userID);
        $totalPaper = $this->paper->countResultSearch($key, $this->userID);
        $totalPoster = $this->poster->countResultSearch($key, $this->userID);
        $totalPresentation = $this->presentation->countResultSearch($key, $this->userID);
        $totalConference = $this->conference->countResultSearch($key, $this->userID);

        if ($totalPresentation > 0) {
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
            $presentations['results'] = $this->presentation->searchPagination($key, $this->userID, $limit_per_page, $start_index, $colName, $direction);

            $config['base_url'] = base_url('search/presentation');
            $config['total_rows'] = $totalPresentation;
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

            $presentations["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = $key;
        $this->data['presentations'] = $presentations;
        $this->data['active_sort'] = $active_sort;
        $this->data['postType'] = $this->session->post_type_search;
        $this->data['bodyClass'] = 'search-page';

        $this->page = 'search';
        $this->layout();
    }

    public function searchPoster()
    {
        $key = false;
        if (isset($this->session->keySearch)){
            $key = $this->session->keySearch;
        }
        else{
            redirect();
        }

        if (isset($_SESSION['active_sort_search'])) {
            $active_sort = $this->session->active_sort_search;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort_search', 'Max');
        }
        $this->session->set_userdata('post_type_search', 'posters');

        $posters = array();

        $limit_per_page = 6;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

        $totalVideo = $this->movie->countResultSearch($key, $this->userID);
        $totalPaper = $this->paper->countResultSearch($key, $this->userID);
        $totalPoster = $this->poster->countResultSearch($key, $this->userID);
        $totalPresentation = $this->presentation->countResultSearch($key, $this->userID);
        $totalConference = $this->conference->countResultSearch($key, $this->userID);

        if ($totalPoster > 0) {
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
            $posters['results'] = $this->poster->searchPagination($key, $this->userID, $limit_per_page, $start_index, $colName, $direction);

            $config['base_url'] = base_url('search/poster');
            $config['total_rows'] = $totalPoster;
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

            $posters["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = $key;
        $this->data['posters'] = $posters;
        $this->data['active_sort'] = $active_sort;
        $this->data['postType'] = $this->session->post_type_search;
        $this->data['bodyClass'] = 'search-page';

        $this->page = 'search';
        $this->layout();
    }

    public function searchPaper()
    {
        $key = false;
        if (isset($this->session->keySearch)){
            $key = $this->session->keySearch;
        }
        else{
            redirect();
        }

        if (isset($_SESSION['active_sort_search'])) {
            $active_sort = $this->session->active_sort_search;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort_search', 'Max');
        }
        $this->session->set_userdata('post_type_search', 'papers');

        $papers = array();

        $limit_per_page = 6;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

        $totalVideo = $this->movie->countResultSearch($key, $this->userID);
        $totalPaper = $this->paper->countResultSearch($key, $this->userID);
        $totalPoster = $this->poster->countResultSearch($key, $this->userID);
        $totalPresentation = $this->presentation->countResultSearch($key, $this->userID);
        $totalConference = $this->conference->countResultSearch($key, $this->userID);

        if ($totalPaper > 0) {
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
            $papers['results'] = $this->paper->searchPagination($key, $this->userID, $limit_per_page, $start_index, $colName, $direction);

            $config['base_url'] = base_url('search/paper');
            $config['total_rows'] = $totalPaper;
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

            $papers["links"] = $this->pagination->create_links();
        }

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = $key;
        $this->data['papers'] = $papers;
        $this->data['active_sort'] = $active_sort;
        $this->data['postType'] = $this->session->post_type_search;
        $this->data['bodyClass'] = 'search-page';

        $this->page = 'search';
        $this->layout();
    }

    public function searchConference()
    {
        $key = false;
        if (isset($this->session->keySearch)){
            $key = $this->session->keySearch;
        }
        else{
            redirect();
        }

        if (isset($_SESSION['active_sort_search'])) {
            $active_sort = $this->session->active_sort_search;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort_search', 'Max');
        }
        $this->session->set_userdata('post_type_search', 'conferences');

        $conferences = array();

        $limit_per_page = 6;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(3)) ? (($this->uri->segment(3)-1) * $limit_per_page)  : 0;

        $totalVideo = $this->movie->countResultSearch($key, $this->userID);
        $totalPaper = $this->paper->countResultSearch($key, $this->userID);
        $totalPoster = $this->poster->countResultSearch($key, $this->userID);
        $totalPresentation = $this->presentation->countResultSearch($key, $this->userID);
        $totalConference = $this->conference->countResultSearch($key, $this->userID);

        if ($totalConference > 0) {
            if ($active_sort == 'Max' || $active_sort == 'Min') {
                $direction = $this->getViewsSort($active_sort);
                $colName = 'views';
            } elseif ($active_sort == 'Youngest' || $active_sort == 'Oldest') {
                $direction = $this->getDateSort($active_sort);
                $colName = 'dateOfUpload';
            } else {
                $direction = $this->getAlphaSort($active_sort);
                $colName = 'confTitle';
            }
            $conferences['results'] = $this->conference->searchPagination($key, $this->userID, $limit_per_page, $start_index, $colName, $direction);

            $config['base_url'] = base_url('search/conference');
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

        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['key'] = $key;
        $this->data['conferences'] = $conferences;
        $this->data['active_sort'] = $active_sort;
        $this->data['postType'] = $this->session->post_type_search;
        $this->data['bodyClass'] = 'search-page';

        $this->page = 'search';
        $this->layout();
    }
}
