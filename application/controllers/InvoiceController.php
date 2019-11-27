<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:04
 */

require FCPATH  . '/vendor/autoload.php';

class InvoiceController extends MY_Controller
{

    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category');
        $this->load->model('subcategory');
        $this->load->model('useraccount');
        $this->load->model('reminder');
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
        $this->load->model('conferencepermission');
        $this->load->model('registrationtool');
        $this->load->model('abstracttool');
        $this->load->model('invoice');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->library('pagination');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->session->set_userdata('active_top_header', 'postbox');
            $this->data['active_top_header'] = $this->session->active_top_header;
        } else {
            redirect(base_url('login'));
        }
    }

    public function Invoice()
    {
        $this->data['invoice'] = $this->invoice->getInvoiceByUser($this->user->id);

        $this->auth_page = 'invoice';
        $this->auth_postpox_layout();
    }
}