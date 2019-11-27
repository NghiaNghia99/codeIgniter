<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class SortController extends MY_Controller
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
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        }
    }

    public function updateSortSearch($active_sort_search)
    {
        $this->session->set_userdata('active_sort_search', $active_sort_search);
    }

    public function updateSort($active_sort)
    {
        $this->session->set_userdata('active_sort', $active_sort);
    }

    public function updatePostType($type)
    {
        $this->session->set_userdata('post_type', $type);
    }

    public function updatePostTypeSearch($type_search)
    {
        $this->session->set_userdata('post_type_search', $type_search);
    }

    public function updateContributionType($type)
    {
        $this->session->set_userdata('contribution_type', $type);
    }

    public function updateSummaryType($type)
    {
        $this->session->set_userdata('summary_type', $type);
    }
}