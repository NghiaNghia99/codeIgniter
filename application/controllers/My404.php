<?php

class My404 extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
//        $this->output->set_status_header('404');
        $this->session->set_userdata('payment_error_404', '404');
        $this->data['bodyClass'] = 'payment-error-404';
        $this->page = 'err404';
        $this->layout();
    }
}