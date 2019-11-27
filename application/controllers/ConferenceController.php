<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

class ConferenceController extends MY_Controller
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
        $this->load->model('domainblacklist');
        $this->load->model('invoice');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->library('pagination');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->session->set_userdata('active_top_header', 'conference');
            $this->data['active_top_header'] = $this->session->active_top_header;
            $this->session->set_userdata('active_conference_sidebar', 'Attended conferences');
            $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
            $this->session->unset_userdata('conferenceInfo');
        } else {
            $this->redirectAfterLogin();
//            redirect(base_url('login'));
        }
    }

    public function getActiveCidPage()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Active CID');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        $this->data['listCid'] = $this->cid->get_all_rule(array('idOfContactSMN' => $this->user->id, 'bezahlt' => 0));
        $this->auth_page = 'active_cid';
        $this->auth_conference_layout();
    }

    public function getAttendedConferences()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Attended conferences');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }

//        $this->updatePaymentStatusByUser($this->user->id, $this->getApiContext(true));

        $posts = array();
        $limit_per_page = 4;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

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


        $attendedConferences = count($this->conferenceregistration->attendedConferences($this->user->id));

        if ($attendedConferences > 0) {
            $permissionArr = $this->conferencepermission->getArrayPermissionByUser($this->user->id);
            $this->data['permissionArr'] = $permissionArr;

            $posts['results'] = $this->conferenceregistration->sortAttendedConferencesPagination($this->user->id,
              $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('auth/conference/attended');
            $config['total_rows'] = $attendedConferences;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<div class="nextlink">';
            $config['next_tag_close'] = '</div>';
            $config['prev_tag_open'] = '<div class="prevlink">';
            $config['prev_tag_close'] = '</div>';

            $this->pagination->initialize($config);

            $posts["links"] = $this->pagination->create_links();
        }

        $this->data['userID'] = $this->user->id;
        $this->data['active_sort'] = $active_sort;
        $this->data['conferences'] = $posts;

        $this->auth_page = 'attended_conference';
        $this->auth_conference_layout();
    }

    public function getManagedConferences()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Managed conferences');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }

        $posts = array();
        $limit_per_page = 4;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

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

        $postList = count($this->conference->getPostByUserPagination($this->user->id, 0));
        if ($postList > 0) {
            $posts['results'] = $this->conference->sortPostByUserPagination($this->user->id, 0, $limit_per_page,
              $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('auth/conference/managed');
            $config['total_rows'] = $postList;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<div class="nextlink">';
            $config['next_tag_close'] = '</div>';
            $config['prev_tag_open'] = '<div class="prevlink">';
            $config['prev_tag_close'] = '</div>';

            $this->pagination->initialize($config);

            $posts["links"] = $this->pagination->create_links();
        }

        $this->data['active_sort'] = $active_sort;
        $this->data['userID'] = $this->user->id;
        $this->data['conferences'] = $posts;
        $this->data['bodyClass'] = 'object-list';

        $this->auth_page = 'managed_conference';
        $this->auth_conference_layout();
    }

    public function getClosedManagedConferences()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Managed conferences');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }

        $posts = array();
        $limit_per_page = 4;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

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

        $postList = count($this->conference->getPostByUserPagination($this->user->id, 1));

        if ($postList > 0) {
            $posts['results'] = $this->conference->sortPostByUserPagination($this->user->id, 1, $limit_per_page,
              $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('auth/conference/managed-closed');
            $config['total_rows'] = $postList;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<div class="nextlink">';
            $config['next_tag_close'] = '</div>';
            $config['prev_tag_open'] = '<div class="prevlink">';
            $config['prev_tag_close'] = '</div>';

            $this->pagination->initialize($config);

            $posts["links"] = $this->pagination->create_links();
        }

        $this->data['active_sort'] = $active_sort;
        $this->data['conferences'] = $posts;
        $this->data['userID'] = $this->user->id;
        $this->data['bodyClass'] = 'object-list';

        $this->auth_page = 'closed_managed_conference';
        $this->auth_conference_layout();
    }

    public function getDefaultManagedConferences()
    {

        $this->session->set_userdata('active_conference_sidebar', 'Managed conferences');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        if (isset($_SESSION['active_sort'])) {
            $active_sort = $this->session->active_sort;
        } else {
            $active_sort = 'Max';
            $this->session->set_userdata('active_sort', 'Max');
        }

        $posts = array();
        $limit_per_page = 4;
        $direction = null;
        $colName = null;
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

        $postList = count($this->conference->getPostDefaultByUser($this->user->id));

        if ($postList > 0) {
            $posts['results'] = $this->conference->getPostDefaultByUserPagination($this->user->id, $limit_per_page,
              $start_index);

            $config['base_url'] = base_url('auth/conference/managed-default');
            $config['total_rows'] = $postList;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
            $config['use_page_numbers'] = true;
            $config['num_links'] = 1;
            $config['prev_link'] = '<span class="icon-chevron-circle-left"></span>';
            $config['next_link'] = '<span class="icon-chevron-circle-right"></span>';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
            $config['next_tag_open'] = '<div class="nextlink">';
            $config['next_tag_close'] = '</div>';
            $config['prev_tag_open'] = '<div class="prevlink">';
            $config['prev_tag_close'] = '</div>';

            $this->pagination->initialize($config);

            $posts["links"] = $this->pagination->create_links();
        }

        $this->data['active_sort'] = $active_sort;
        $this->data['conferences'] = $posts;
        $this->data['bodyClass'] = 'object-list';

        $this->auth_page = 'default_managed_conference';
        $this->auth_conference_layout();
    }

    public function getInfoCid()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Info CID service');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        $this->auth_page = 'info_cid';
        $this->auth_conference_layout();
    }

    public function check_cid_order()
    {
        $cid = $this->input->post('cid');
        $cid_item = $this->cid->get_info_binary('cid', $cid);
        if ($this->cid->check_cid_exists($cid) && $cid_item->bezahlt == 0 && $this->checkAuthor($cid_item->idOfContactSMN)) {
            $this->form_validation->set_message(__FUNCTION__,
              'This CID is yours and awaits payment. Do you want to overwrite it with the information in this form?');
            return false;
        } elseif ($this->cid->check_cid_exists($cid)) {
            $this->form_validation->set_message(__FUNCTION__,
              'Sorry, this CID is already taken. Please enter a different CID.');
            return false;
        }
        return true;
    }

    public function check_typeOfConference()
    {

        $typeOfConference = $this->input->post('typeOfConference');
        if (empty($typeOfConference)) {
            $this->form_validation->set_message(__FUNCTION__,
              'The %s field is required.');
            return false;
        }
        $this->session->set_flashdata('get_typeOfConference', $typeOfConference);
        return true;
    }

    public function orderCid()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Order CID');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        $this->form_validation->set_rules('cid', '', 'trim|required|callback_check_cid_order');
        $this->form_validation->set_rules('typeOfConference', 'type of conference',
          'trim|callback_check_typeOfConference');
        $this->form_validation->set_rules('contactFirstName', 'contact first name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s'
          ));
        $this->form_validation->set_rules('contactLastName', 'contact last name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('contactEMail', 'contact email',
          array('trim','required','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));
        $this->form_validation->set_rules('billingAffiliation', 'billing affiliation',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('billingStreet', 'billing street', 'trim|required');
        $this->form_validation->set_rules('billingStreetNr', 'billing street number', 'trim|required');
        $this->form_validation->set_rules('billingCity', 'billing city', 'trim|required');
        $this->form_validation->set_rules('billingPostalCode', 'billing postal code', 'trim|required');
        $this->form_validation->set_rules('billingCountry', 'billing country', 'trim|required');
        $this->form_validation->set_rules('paypalEmail', 'paypal email',
          array('trim','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));

        if ($this->form_validation->run()) {
            $cid = $this->input->post('cid');
            $data = array(
              'cid' => $cid,
              'typeOfConference' => $this->input->post('typeOfConference'),
              'idOfContactSMN' => $this->user->id,
              'contactFirstName' => $this->input->post('contactFirstName'),
              'contactLastName' => $this->input->post('contactLastName'),
              'contactEMail' => $this->input->post('contactEMail'),
              'billingAffiliation' => $this->input->post('billingAffiliation'),
              'billingStreet' => $this->input->post('billingStreet'),
              'billingStreetNr' => $this->input->post('billingStreetNr'),
              'billingCity' => $this->input->post('billingCity'),
              'billingPostalCode' => $this->input->post('billingPostalCode'),
              'billingCountry' => $this->input->post('billingCountry'),
              'billingState' => $this->input->post('billingState'),
              'paypalEmail' => $this->input->post('paypalEmail'),
              'bezahlt' => 0
            );

            if ($this->cid->create($data)) {
                $this->session->set_userdata('cid_info', $data);
                $defaultCategory = $this->category->get_first_record_id();
                $defaultSubCategory = $this->subcategory->get_first_record_id();

                $dataFakeConference = array(
                  'CID' => $cid,
                  'userID' => $this->user->id,
                  'category' => $defaultCategory,
                  'subcategory' => $defaultSubCategory,
                  'views' => 0
                );

//                $lastID = $this->conference->get_last_record_id();
                $confID = $this->conference->create($dataFakeConference);
                if ($confID){
                    $dataPermission = array(
                      'userID' => $this->user->id,
                      'confID' => $confID,
                      'CID' => $cid,
                      'email' => $this->user->email,
                      'editConference' => 1,
                      'editRegistration' => 1,
                      'editAbstracts' => 1,
                      'editRestrict' => 1,
                      'editContributions' => 1,
                      'status' => 'Pending'
                    );

                    $dataSession = array(
                      'CID' => $cid,
                      'name' => 'Main Session'
                    );

                    if ($this->conferencesession->create($dataSession) && $this->conferencepermission->create($dataPermission)) {
                        redirect('auth/conference/pay-cid');
                    }
                }
            }
        }

        $this->auth_page = 'order_cid';
        $this->auth_conference_layout();
    }

    public function payCid()
    {
        $this->session->set_userdata('active_conference_sidebar', 'Order CID');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        $cid = $this->session->cid_info;
        if (empty($cid)) {
            redirect('auth/conference/order-cid');
        }
        $this->data['cid'] = $cid;
        $this->auth_page = 'pay_cid';
        $this->auth_conference_layout();
        $this->session->unset_userdata('cid_info');
    }

    public function checkoutPaypal(){
        if (empty($_POST['item_number'])) {
            redirect(base_url('auth/conference/pay-cid/checkout/error'));
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
// Set some example data for the payment.
        $currency = $this->config->config['currency'];
        $invoiceNumber = uniqid();
        $amount = new Amount();
        if (!empty($_POST['conference_fee']) && !empty($_POST['conference_id']) && !empty($_POST['conference_paypalEmail']) && !empty($_POST['conference_title'])){
            $amountPayable = $_POST['conference_fee'];
            $returnUrl = base_url('auth/conference/registration/checkout/response');
            $cancelUrl = base_url('auth/conference/conference-page/' . $_POST['conference_id']);

            $item1 = new Item();
            $item1->setName($_POST['conference_title'])
              ->setCurrency($currency)
              ->setQuantity(1)
              ->setPrice($amountPayable);

            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            $payee = new Payee();
            $payee->setEmail($_POST['conference_paypalEmail']);

            $amount->setCurrency($currency)
              ->setTotal($amountPayable);
            $transaction = new Transaction();
            $transaction->setAmount($amount)
              ->setItemList($itemList)
              ->setDescription('Register for conference')
              ->setPayee($payee)
              ->setInvoiceNumber($invoiceNumber);
        }
        else{
            $name = 'Order CID';
            $cid = $this->session->order_cid;
            if (!empty($cid)){
                $name = $cid;
            }
            $amountPayable = (int)$this->config->config['cid_fee'];
            $tax = (int)$this->config->config['tax_percent'] / 100 * $amountPayable;
            $total = $amountPayable + $tax;
            $returnUrl = base_url('auth/conference/pay-cid/checkout/response');
            $cancelUrl = base_url('auth/conference/active-cid');

            $item1 = new Item();
            $item1->setName($name)
              ->setCurrency($currency)
              ->setQuantity(1)
              ->setPrice($amountPayable);

            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            $details = new Details();
            $details->setTax($tax)
              ->setSubtotal($amountPayable);

            $amount->setCurrency($currency)
              ->setTotal($total)
              ->setDetails($details);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
              ->setItemList($itemList)
              ->setDescription('CID - Conference Identification')
              ->setInvoiceNumber($invoiceNumber);
        }

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl)
          ->setCancelUrl($cancelUrl);
        $payment = new Payment();
        $payment->setIntent('sale')
          ->setPayer($payer)
          ->setTransactions(array($transaction))
          ->setRedirectUrls($redirectUrls);
        try {
            $payment->create($this->getApiContext(true));
        } catch (Exception $e) {
            redirect(base_url('auth/conference/pay-cid/checkout/error'));
        }
        header('location:' . $payment->getApprovalLink());
        exit(1);
    }

    public function responsePaypal(){
        if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
            redirect(base_url('auth/conference/pay-cid/checkout/error'));
        }
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $this->getApiContext(true));
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        try {
            // Take the payment
            $payment->execute($execution, $this->getApiContext(true));
            try {
                $payment = Payment::get($paymentId, $this->getApiContext(true));
                if ($payment->getState() == 'approved') {
                    $cid = $payment->transactions[0]->item_list->items[0]->name;
                    if (!empty($cid)){
                        $cidItem = $this->cid->get_info_binary('cid', $cid);
                        $conference = $this->conference->get_info_binary('CID', $cid);
                        if (!empty($conference) && !empty($cidItem)){
                            $invoiceNumber = $payment->transactions[0]->invoice_number;
                            $subTotal = $payment->transactions[0]->amount->details->subtotal;
                            $tax = $payment->transactions[0]->amount->details->tax;
                            $total = $payment->transactions[0]->amount->total;
                            $transactionID = $payment->transactions[0]->related_resources[0]->sale->id;
                            $dataInvoice = array(
                              'invoiceID' => $invoiceNumber,
                              'userID' => $this->user->id,
                              'CID' => $cid,
                              'transactionID' => $transactionID,
                              'subTotal' => $subTotal,
                              'tax' => $tax,
                              'paymentAmount' => $total,
                              'paymentStatus' => $payment->getState()
                            );

                            $this->cid->update($cidItem->id, array('bezahlt' => 1));
                            $this->conference->update($conference->id, array('status' => 'paid'));
                            $this->conferencepermission->update_rule(array('confID' => $conference->id), array('status' => 'Accept'));
                            $emailSendInvoice = $this->cid->convertInvoiceToPdf($this->user->id, $cid, $invoiceNumber, $subTotal, $tax, $total, date( 'F dS, Y',time()));
                            if (!empty($emailSendInvoice)){
                                $username = $cidItem->contactFirstName . ' ' . $cidItem->contactLastName;
                                $invoiceFile = FCPATH . 'uploads/userfiles/' . $this->user->id . '/invoices/' . $invoiceNumber . '.pdf';
                                if (!empty($invoiceFile)){
                                    $this->invoice->create($dataInvoice);
                                    $this->sendMailInvoice($emailSendInvoice, $username, $invoiceFile);
                                }
                            }
                        }
                    }
                    redirect(base_url('auth/conference/managed-default'));
                } else {
                    redirect(base_url('auth/conference/pay-cid/checkout/error'));
                }
            } catch (Exception $e) {
                redirect(base_url('auth/conference/pay-cid/checkout/error'));
            }
        } catch (Exception $e) {
            redirect(base_url('auth/conference/pay-cid/checkout/error'));
        }
    }

    public function responsePaypalConference(){
        if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
            throw new Exception('The response is missing the paymentId and PayerID');
        }
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $this->getApiContext(true));
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        try {
            // Take the payment
            $payment->execute($execution, $this->getApiContext(true));
            try {
                $cid = $this->session->order_cid;
                if (!empty($cid)){
                    $conference = $this->conference->get_info_binary('CID', $cid);
                    if (!empty($conference)){
                        $payment = Payment::get($paymentId, $this->getApiContext(true));
                        if ($payment->getState() == 'approved') {
                            // Payment successfully added, redirect to the payment complete page.
                            $saleID = $payment->transactions[0]->related_resources[0]->sale->id;
                            $paymentStatus = $payment->transactions[0]->related_resources[0]->sale->state;
                            $registration = $this->conferenceregistration->get_info_binary_2('CID', $cid, 'userID', $this->user->id);
                            $this->conferenceregistration->update($registration->ID, array('status' => $paymentStatus, 'saleID' => $saleID));

                            redirect(base_url('conference/register/success'));
                        } else {
                            redirect(base_url('auth/conference/attended'));
                        }
                    }
                }
                else{
                    redirect(base_url('auth/conference/registration/checkout/error'));
                }
            } catch (Exception $e) {
                // Failed to retrieve payment from PayPal
                redirect(base_url('auth/conference/registration/checkout/error'));
            }
        } catch (Exception $e) {
            // Failed to take payment
            redirect(base_url('auth/conference/registration/checkout/error'));
        }
    }

    public function confirmPayCid()
    {
        $this->auth_page = 'confirm_pay_cid';
        $this->auth_conference_layout();
    }

    public function setSessionCid()
    {
        $CID = $this->input->post('CID');
        $res = 'fail';
        $this->session->set_userdata('order_cid', $CID);
        if (!empty($_SESSION['order_cid'])){
            $res = 'success';
        }
        echo json_encode($res);
    }

    public function updatePaymentStatus()
    {
        $cid = $this->session->cid_info;
        if (!empty($cid)){
            $conference = $this->conference->get_info_binary('CID', $cid['cid']);
            if (!empty($conference)){
                $cidItem = $this->cid->get_info_binary('cid', $cid['cid']);
                $this->cid->update($cidItem->id, array('bezahlt' => 1));
                $this->conference->update($conference->id, array('status' => 'paid'));
                $this->conferencepermission->update_rule(array('confID' => $conference->id), array('status' => 'Accept'));

                redirect(base_url('auth/conference/managed-default'));
            }
        }
    }

    public function registrationConference()
    {
        $this->data['categories'] = array($this->useraccount->getCategories(), $this->useraccount->getSubCategories());
        $cid = $this->cid->get_info_binary('cid', $this->session->cid_info['cid']);
        if (empty($cid) || $cid->bezahlt != 1) {
            redirect('auth/conference/order-cid');
        }
        $this->form_validation->set_rules('confTitle', '', 'trim|required');
        $this->form_validation->set_rules('confSeries', '', 'trim|required');
        $this->form_validation->set_rules('organizingInstitutions', '', 'trim|required');
        $this->form_validation->set_rules('confLocation', '', 'trim|required');
        $this->form_validation->set_rules('abstract', '', 'trim|required');
        $this->form_validation->set_rules('category', '', 'trim|required');
        $this->form_validation->set_rules('subcategory', '', 'trim|required');
        if ($this->form_validation->run()) {
            $data = array(
              'CID' => $this->input->post('CID'),
              'userID' => $this->user->id,
              'confTitle' => $this->input->post('confTitle'),
              'confSeries' => $this->input->post('confSeries'),
              'organizingInstitutions' => $this->input->post('organizingInstitutions'),
              'confLocation' => $this->input->post('confLocation'),
              'startDate' => $this->input->post('startDate'),
              'endDate' => $this->input->post('endDate'),
              'abstract' => $this->input->post('abstract'),
              'category' => $this->input->post('category'),
              'subcategory' => $this->input->post('subcategory'),
              'altCategory1' => $this->input->post('alt_category'),
              'altSubCategory1' => $this->input->post('alt_subcategory'),
              'views' => 0
            );

            if ($this->conference->create($data)) {
                redirect('auth/conference/managed');
            }
        }
        $this->data['cid'] = $cid;
        $this->auth_page = 'registration_conference';
        $this->auth_conference_layout();
    }

    public function getManagedConferencePage($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            if ($this->checkAuthor($conference['userID'])) {
                $data = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('cid', $conference['CID']);
                $this->session->set_userdata('conference', $data);
                $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['conference'] = $conference;
                $this->data['alt_category'] = $this->conference->getAltCategory($id);
                $this->auth_page = 'conference_page';
                $this->auth_conference_layout();
            }
        }
    }

    public function getAttendedConferencePage($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $saleID = $this->conferenceregistration->get_info_binary_2('CID', $conference['CID'], 'userID', $this->user->id)->saleID;
            if (!empty($saleID)){
                $this->updatePaymentStatusBySaleID($saleID, $this->getApiContext(true));
            }
            if ($this->checkAuthor($conference['userID'])) {
                $data = array(
                  'type' => 'attended',
                  'id' => $id
                );
                $this->session->set_userdata('cid', $conference['CID']);
                $this->session->set_userdata('conference', $data);
                $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['conference'] = $conference;
                $this->data['alt_category'] = $this->conference->getAltCategory($id);
                $this->auth_page = 'conference_page';
                $this->auth_conference_layout();
            }
        }
    }

    public function getConferencePage($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            $registration = $this->conferenceregistration->getByCidAndUser($conference['CID'], $this->userID);
            if (!empty($permission)) {
                $data = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('active_conference_sidebar', 'Conference web preview');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
            } elseif (!empty($registration)) {
                $data = array(
                  'type' => 'attended',
                  'id' => $id
                );
                $this->session->set_userdata('active_conference_sidebar', 'Attended conferences');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
            }
            else{
                redirect('conference/' . $id);
            }
            if (empty($_SESSION['contribution_type'])) {
                $this->session->set_userdata('contribution_type', 'Videos');
            }
            $this->session->set_userdata('cid', $conference['CID']);
            $this->session->set_userdata('conferenceInfo', $data);
            $checkSpamAbstract = false;
            $abstractList = $this->conferenceabstract->get_all_binary_2('CID', $conference['CID'], 'userID', $this->user->id);
            if (!empty($abstractList)) {
                if (count($abstractList) > 9) {
                    $checkSpamAbstract = true;
                }
            }
            $this->data['checkSpamAbstract'] = $checkSpamAbstract;
            $this->data['conferenceInfo'] = $data;
            $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
            $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
            $this->data['checkRegistrationActive'] = $this->registrationtool->checkRegistrationConferenceActive($conference['CID']);
            $registration = $this->conferenceregistration->get_info_binary_2('CID', $conference['CID'], 'userID', $this->user->id);
            if (!empty($registration)){
                $this->data['registeredUser'] = $registration;
                $saleID = $registration->saleID;
                if (!empty($saleID)){
                    $this->updatePaymentStatusBySaleID($saleID, $this->getApiContext(true));
                }
            }
            $this->data['checkAbstractActive'] = $this->abstracttool->checkAbstractConferenceActive($conference['CID']);
            $this->data['userParticipation'] = $this->conferenceregistration->getUserParticipationByConference($conference['CID']);
            $this->data['count'] = $this->category->countPostByCID($conference['CID'], $this->userID);
            $this->data['videos'] = $this->category->getPostByCid('video', $conference['CID'], $this->userID);
            $this->data['papers'] = $this->category->getPostByCid('paper', $conference['CID'], $this->userID);
            $this->data['posters'] = $this->category->getPostByCid('poster', $conference['CID'], $this->userID);
            $this->data['presentations'] = $this->category->getPostByCid('presentation', $conference['CID'], $this->userID);
            $this->data['conference'] = $conference;
            $this->data['alt_category'] = $this->conference->getAltCategory($id);
            $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
            $this->data['countVideo'] = count($this->category->getElementVideoByCID($conference['CID'], $this->userID));
            $this->data['countPaper'] = count($this->category->getElementPaperByCID($conference['CID'], $this->userID));
            $this->data['countPoster'] = count($this->category->getElementPosterByCID($conference['CID'], $this->userID));
            $this->data['countPresentation'] = count($this->category->getElementPresentationByCID($conference['CID'], $this->userID));
            $this->data['postType'] = $this->session->contribution_type;

            $this->auth_page = 'conference_page';
            $this->auth_conference_layout();
        } else {
            redirect();
        }
    }

    public function getManagedConferenceContributions($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            if ($this->checkAuthor($conference['userID'])) {
                $cid = $conference['CID'];
                $this->data['count'] = $this->category->countPostByCID($cid, $this->userID);
                $this->data['videos'] = $this->category->getPostByCid('video', $cid, $this->userID);
                $this->data['papers'] = $this->category->getPostByCid('paper', $cid, $this->userID);
                $this->data['posters'] = $this->category->getPostByCid('poster', $cid, $this->userID);
                $this->data['presentations'] = $this->category->getPostByCid('presentation', $cid, $this->userID);
                $this->auth_page = 'conference_contributions';
                $this->auth_conference_layout();
            }
        }
    }

    public function getManageContribution($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editContributions == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Manage contributions');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $cid = $conference['CID'];
                $elements = array();
                $sessions = $this->conferencesession->getConferenceSessionByCID($cid);
                $elements_db = $this->conferenceelement->getConferenceElementByCID($cid);
                if (!empty($elements_db)){
                    foreach ($elements_db as $element) {
                        switch ($element['type']) {
                            case 'video':
                                array_push($elements, $this->conferenceelement->getVideo($element['elementID']));
                                break;
                            case 'paper':
                                array_push($elements, $this->conferenceelement->getPaper($element['elementID']));
                                break;
                            case 'poster':
                                array_push($elements, $this->conferenceelement->getPoster($element['elementID']));
                                break;
                            case 'presentation':
                                array_push($elements, $this->conferenceelement->getPresentation($element['elementID']));
                                break;
                            default:
                                return false;
                        }
                    }
                }
                $this->data['elements'] = $this->conferenceelement->getFullContribution($elements, $sessions);
                $this->data['conference'] = $conference;

                $this->auth_page = 'manage_contribution';
                $this->auth_conference_layout();
            }else{
                redirect(base_url('404_override'));
            }
        }else{
            redirect(base_url('404_override'));
        }
    }

    public function updateSessionElement()
    {
        $elementID = $this->input->post('elementID');
        $sessionID = $this->input->post('sessionID');
        $status = 'fail';
        $msg = '';

        $element = $this->conferenceelement->get_info($elementID);
        if (!empty($element)) {
            $confTitle = $this->conference->get_info_binary('CID', $element->CID)->confTitle;
            $postType = $element->type;
            $sessionName1 = $this->conferencesession->get_info($element->session)->name;
            $sessionName2 = $this->conferencesession->get_info($sessionID)->name;

            if ($postType == 'video') {
                $post = $this->movie->get($element->elementID);
                $postTitle = $post['title'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } elseif ($postType == 'presentation') {
                $post = $this->presentation->get($element->elementID);
                $postTitle = $post['presTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } elseif ($postType == 'poster') {
                $post = $this->poster->get($element->elementID);
                $postTitle = $post['posterTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } else {
                $post = $this->paper->get($element->elementID);
                $postTitle = $post['paperTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            }

            if ($this->conferenceelement->update($elementID, array('session' => $sessionID))) {
                $this->sendMailUpdateSessionElement($email, $confTitle, $username, $postTitle, $sessionName1,
                  $sessionName2);
                $status = 'success';
                $msg = 'Update successfully';
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function deleteElement()
    {
        $elementID = $this->input->post('elementID');
        $status = 'fail';
        $msg = '';

        $element = $this->conferenceelement->get_info($elementID);
        if (!empty($element)) {
            $confTitle = $this->conference->get_info_binary('CID', $element->CID)->confTitle;
            $postType = $element->type;

            if ($postType == 'video') {
                $post = $this->movie->get($element->elementID);
                $postTitle = $post['title'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } elseif ($postType == 'presentation') {
                $post = $this->presentation->get($element->elementID);
                $postTitle = $post['presTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } elseif ($postType == 'poster') {
                $post = $this->poster->get($element->elementID);
                $postTitle = $post['posterTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            } else {
                $post = $this->paper->get($element->elementID);
                $postTitle = $post['paperTitle'];
                $username = $post['firstName'] . ' ' . $post['lastName'];
                $email = $post['email'];
            }

            if ($this->conferenceelement->delete($elementID)) {
                $this->sendMailDeleteLinkToConference($email, $confTitle, $username, $postTitle);
                $status = 'success';
                $msg = 'Delete successfully';
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function approveElement($cid)
    {
        $elements = $this->conferenceelement->getConferenceElementByCID($cid);
        foreach ($elements as $element) {
            $session = $_POST["session" . $element["ID"]];
            $approved = $_POST["approved" . $element["ID"]];
            if ($approved == "1") {
                $approved = 1;
            } else {
                $approved = 0;
            }
            $data = array(
              'session' => $session,
              'approved' => $approved,
            );
            $this->conferenceelement->update($element["ID"], $data);
        }
    }

    public function getManagedConferenceEdit($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            if ($this->checkAuthor($conference['userID'])) {
                $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['conference'] = $conference;
                $this->data['alt_category'] = $this->conference->getAltCategory($id);
                $this->data['conference'] = $conference;
                $this->auth_page = 'edit_conference';
                $this->auth_conference_layout();
            }
        }
    }

    public function check_subcategory()
    {
        $category = $this->input->post('category');
        $subcategory = $this->input->post('subcategory');
        $altCategory = $this->input->post('alt_category');
        $altSubCategory = $this->input->post('alt_subcategory');
        $this->session->set_userdata('get_alt_category_id', $altCategory);
        $this->session->set_userdata('get_alt_subcategory_id', $altSubCategory);
        $this->session->set_userdata('get_category_id', $category);
        $this->session->set_userdata('get_subcategory_id', $subcategory);
        if (!empty($altCategory) && empty($altSubCategory)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please choose research topic');
            $this->session->set_userdata('show_alt_category_item', 'show');
            return false;
        }

        return true;
    }

    public function check_category_duplicate()
    {
        $category = $this->input->post('category');
        $subcategory = $this->input->post('subcategory');
        $altCategory = $this->input->post('alt_category');
        $altSubCategory = $this->input->post('alt_subcategory');
        $this->session->set_userdata('get_alt_category_id', $altCategory);
        $this->session->set_userdata('get_alt_subcategory_id', $altSubCategory);
        $this->session->set_userdata('get_category_id', $category);
        $this->session->set_userdata('get_subcategory_id', $subcategory);
        if ($altCategory == $category && $subcategory == $altSubCategory) {
            $this->form_validation->set_message(__FUNCTION__, 'Please choose another option');
            $this->session->set_userdata('show_alt_category_item', 'show');
            return false;
        }

        return true;
    }

    public function getEditConferenceBasic($id)
    {
        $conference = $this->conference->get($id);

        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editConference == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Edit conferences page');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
//                $this->form_validation->set_rules('', '', 'trim|required');
//                $this->form_validation->set_rules('category', 'main field of research', 'trim|required');
//                $this->form_validation->set_rules('subcategory', 'main research topic', 'trim|required');
//                $this->form_validation->set_rules('alt_subcategory', 'alternative research topic',
//                  'callback_check_category_duplicate|callback_check_subcategory');

                $checkStatusActive = false;
                if ($conference['status'] == 'active'){
                    $checkStatusActive = true;
                }
                $this->data['sessions'] = $this->conferencesession->getConferenceSessionByCID($conference['CID']);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['checkStatusActive'] = $checkStatusActive;
                $this->data['conference'] = $conference;
                $this->data['categories'] = array(
                  $this->useraccount->getCategories(),
                  $this->useraccount->getSubCategories()
                );
//                if (isset($_SESSION['get_alt_category_id'])) {
//                    $this->data['altCategoryID'] = $this->session->get_alt_category_id;
//                    $this->session->set_userdata('show_alt_category_item', 'show');
//                }
//                if (isset($_SESSION['get_alt_subcategory_id'])) {
//                    $this->data['altSubCategoryID'] = $this->session->get_alt_subcategory_id;
//                    $this->session->set_userdata('show_alt_category_item', 'show');
//                }
//                if (isset($_SESSION['get_category_id'])) {
//                    $this->data['categoryID'] = $this->session->get_category_id;
//                }
//                if (isset($_SESSION['get_subcategory_id'])) {
//                    $this->data['subCategoryID'] = $this->session->get_subcategory_id;
//                }
                $this->data['userID'] = $this->user->id;
                $this->data['coAuthors'] = $this->conferencepermission->getPermissionByConference($id,
                  $this->user->id);
                $this->data['alt_category'] = $this->conference->getAltCategory($id);
                $this->auth_page = 'edit_conference_basic_info';
                $this->auth_conference_layout();
            }
            else{
                redirect(base_url('404_override'));
            }
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function editConferenceBasic($id)
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $msg = '';
        $status = '';
        $conference = $this->conference->get_info($id);
        if (!empty($conference)){
            if ($name == 'fee') {
                if (!empty($value)){
                    $value = str_replace(",", "", $value);
                    $regexFormat = '/^\d{0,5}(\.\d{1,2})?$/';
                    if (preg_match($regexFormat, $value, $matches)) {
                        if ($this->conference->update($id, array($name => $value))) {
                            $status = 'success';
                            $msg = 'price';
                        } else {
                            $status = 'fail';
                        }
                    } else {
                        $msg = 'Please enter a valid price';
                        $status = 'fail';
                    }
                }
                else{
                    if ($this->conference->update($id, array($name => $value))) {
                    $status = 'success';
                    $msg = 'The conference has been updated to free';
                } else {
                    $status = 'fail';
                }
                }
            }
            elseif ($name == 'paypalEmail'){
                $regexFormat = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
                if (preg_match($regexFormat, $value, $matches)) {
                    if ($this->conference->update($id, array($name => $value))) {
                        $status = 'success';
                        $msg = 'email';
                    } else {
                        $status = 'fail';
                    }
                } else {
                    $msg = 'Please enter a valid email';
                    $status = 'fail';
                }
            }
            else {
                if ($this->conference->update($id, array($name => $value))) {
                    $status = 'success';
                } else {
                    $status = 'fail';
                }
            }

            $confUpdated = $this->conference->get_info($id);
            if ($confUpdated->status != 'active'){
                if (!empty($confUpdated->confTitle) && !empty($confUpdated->startDate) && !empty($confUpdated->endDate) && !empty($confUpdated->abstract)){
                    $this->conference->update($id, array('status' => 'active'));
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function editCategoryConferenceBasic($id)
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $conference = $this->conference->get_info($id);
        $status = '';
        $msg = '';
        if (!empty($conference)){
            if ($name == 'category') {
                $subCategory = 'subcategory';
                $idSubCategory = $this->subcategory->get_rule_first_record_id(array('parent_id' => $value));
                if ($conference->altSubCategory1 == $idSubCategory){
                    $idSubCategory = $this->subcategory->get_rule_second_record_id(array('parent_id' => $value));
                    if ($this->conference->update($id, array($name => $value)) && $this->conference->update($id,
                        array($subCategory => $idSubCategory))) {
                        $cate = $this->category->get_info($value)->name;
                        $sub = $this->subcategory->get_info($idSubCategory)->name;
                        $subID = $this->subcategory->get_info($idSubCategory)->id;
                        $msg = array($cate, $sub, $subID);
                        $status = 'success';
                    } else {
                        $msg = '';
                        $status = 'fail';
                    }
                }
                else{
                    if ($this->conference->update($id, array($name => $value)) && $this->conference->update($id,
                        array($subCategory => $idSubCategory))) {
                        $cate = $this->category->get_info($value)->name;
                        $sub = $this->subcategory->get_info($idSubCategory)->name;
                        $subID = $this->subcategory->get_info($idSubCategory)->id;
                        $msg = array($cate, $sub, $subID);
                        $status = 'success';
                    } else {
                        $msg = '';
                        $status = 'fail';
                    }
                }
            } elseif ($name == 'altCategory1') {
                $subCategory = 'altSubCategory1';
                if ($value != '') {
                    $idSubCategory = $this->subcategory->get_rule_first_record_id(array('parent_id' => $value));
                    if ($conference->subcategory == $idSubCategory){
                        $idSubCategory = $this->subcategory->get_rule_second_record_id(array('parent_id' => $value));
                        if ($this->conference->update($id, array($name => $value)) && $this->conference->update($id,
                            array($subCategory => $idSubCategory))) {
                            $cate = $this->category->get_info($value)->name;
                            $sub = $this->subcategory->get_info($idSubCategory)->name;
                            $subID = $this->subcategory->get_info($idSubCategory)->id;
                            $msg = array($cate, $sub, $subID);
                            $status = 'success';
                        } else {
                            $msg = '';
                            $status = 'fail';
                        }
                    }
                    else{
                        if ($this->conference->update($id, array($name => $value)) && $this->conference->update($id,
                            array($subCategory => $idSubCategory))) {
                            $cate = $this->category->get_info($value)->name;
                            $sub = $this->subcategory->get_info($idSubCategory)->name;
                            $subID = $this->subcategory->get_info($idSubCategory)->id;
                            $msg = array($cate, $sub, $subID);
                            $status = 'success';
                        } else {
                            $msg = '';
                            $status = 'fail';
                        }
                    }
                } else {
                    if ($this->conference->update($id, array($name => '')) && $this->conference->update($id,
                        array($subCategory => ''))) {
                        $msg = '';
                        $status = 'success';
                    } else {
                        $msg = '';
                        $status = 'fail';
                    }
                }
            } elseif ($name == 'subcategory') {
                if ($conference->altSubCategory1 == $value){
                    $msg = 'Please choose another option';
                    $status = 'fail';
                }
                else{
                    if ($this->conference->update($id, array($name => $value))) {
                        $sub = $this->subcategory->get_info($value)->name;
                        $subID = $this->subcategory->get_info($value)->id;
                        $msg = array($sub, $subID);
                        $status = 'success';
                    } else {
                        $msg = '';
                        $status = 'fail';
                    }
                }
            } elseif ($name == 'altSubCategory1') {
                if ($conference->subcategory == $value){
                    $msg = 'Please choose another option';
                    $status = 'fail';
                }
                else{
                    if ($this->conference->update($id, array($name => $value))) {
                        $sub = $this->subcategory->get_info($value)->name;
                        $subID = $this->subcategory->get_info($value)->id;
                        $msg = array($sub, $subID);
                        $status = 'success';
                    } else {
                        $msg = '';
                        $status = 'fail';
                    }
                }
            }
        }
        else{
            $msg = '';
            $status = 'fail';
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function removeSessionConferenceBasic()
    {
        $msg = '';
        $status = 'fail';
        $id = $this->input->post('session_id');
        $session = $this->conferencesession->get_info($id);
        if (!empty($session)){
            if (count($this->conferencesession->getConferenceSessionByCID($session->CID)) == 1){
                $msg = 'This conference need at least one session';
            }
            elseif ($this->conferenceelement->check_exists(array('session' => $id))) {
                $msg = 'There are contributions assigned to this session.<br> If you want to delete the session, please use the manage contribution page to assign these contributons to another session first';
            }
            else {
                if ($this->conferencesession->delete($id)) {
                    $status = 'success';
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

//    public function addSessionConferenceBasic()
//    {
//        $session_name = $this->input->post('session_name');
//        $cid = $this->input->post('cid');
//        $data = array(
//          'CID' => $cid,
//          'name' => $session_name
//        );
//        if ($this->conferencesession->create($data)) {
//            $status = 'success';
//        } else {
//            $status = 'fail';
//        }
//
//        echo json_encode($status);
//    }

//    public function editSessionConferenceBasic()
//    {
//        $session_name = $this->input->post('session_name');
//        $id = $this->input->post('id');
//        $data = array(
//          'name' => $session_name
//        );
//        if ($this->conferencesession->update($id, $data)) {
//            $status = 'success';
//        } else {
//            $status = 'fail';
//        }
//
//        echo json_encode($status);
//    }

    public function updateSessionConferenceBasic()
    {
        $cid = $this->input->post('cid');
        $sessionList = $this->input->post('sessionList');
        $sessionList = json_decode($sessionList);
        $status = 'fail';
        foreach ($sessionList as $session){
            if (!empty($session->id)){
                $data = array(
                  'name' => $session->name
                );
                if ($this->conferencesession->update($session->id, $data)) {
                    $status = 'success';
                }
                else{
                    break;
                }
            }
            else{
                $data = array(
                  'CID' => $cid,
                  'name' => $session->name
                );
                if ($this->conferencesession->create($data)) {
                    $status = 'success';
                }
                else{
                    break;
                }
            }
        }

        echo json_encode($status);
    }

    public function checkValidationEmailCoAuthor()
    {
        $email = $this->input->post('email');
        $confID = $this->input->post('confID');
//        $regexFormat = '/^([\w\-]+(?:\.+[\w\-+]+)*){2,}@[a-zA-Z0-9\-]+?\.[a-zA-Z]{2,}$/';
        $regexFormat = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        if (preg_match($regexFormat, $email, $matches)) {
            $checkEmail = $this->domainblacklist->checkDomainValid($email);
            if ($checkEmail){
                if ($this->conferencepermission->check_exists(array('email' => $email, 'confID' => $confID))) {
                    $msg = 'This email already exists';
                    $status = 'fail';
                } else {
                    $msg = '';
                    $status = 'success';
                }
            }
            else{
                $msg = 'Please enter an email that belongs to an institution, university or company';
                $status = 'fail';
            }
        } else {
            $msg = 'Please enter a valid email format';
            $status = 'fail';
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function setPermissionCoAuthor()
    {
        $coAuthors = json_decode($this->input->post('coAuthors'));
        $confID = $this->input->post('confID');
        $msg = '';
        $status = 'success';
        foreach ($coAuthors as $coAuthor) {
            $email = $coAuthor->email;
            $permissions = $coAuthor->permissions;
            $editConference = 0;
            $editRegistration = 0;
            $editAbstracts = 0;
            $editRestrict = 0;
            $editContributions = 0;

            $permissionsList = '<ul>';
            if (in_array('Edit conference page', $permissions)) {
                $editConference = 1;
                $permissionsList .= '<li>Edit conference page</li>';
            }
            if (in_array('Registration', $permissions)) {
                $editRegistration = 1;
                $permissionsList .= '<li>Registration</li>';
            }
            if (in_array('Abstracts', $permissions)) {
                $editAbstracts = 1;
                $permissionsList .= '<li>Abstracts</li>';
            }
            if (in_array('Restricted access', $permissions)) {
                $editRestrict = 1;
                $permissionsList .= '<li>Restricted access</li>';
            }
            if (in_array('Manage contributions', $permissions)) {
                $editContributions = 1;
                $permissionsList .= '<li>Manage contributions</li>';
            }
            $permissionsList .= '</ul>';
            $user = $this->useraccount->get_info_rule(array('email' => $email));
            $conference = $this->conference->get_info($confID);
            if (!empty($conference)){
                if (!empty($user)) {
                    $code = time() . rand(100, 9999);
                    $data = array(
                      'code' => $code,
                      'userID' => $user->id,
                      'confID' => $confID,
                      'CID' => $conference->CID,
                      'email' => $email,
                      'editConference' => $editConference,
                      'editRegistration' => $editRegistration,
                      'editAbstracts' => $editAbstracts,
                      'editRestrict' => $editRestrict,
                      'editContributions' => $editContributions,
                      'status' => 'Pending'
                    );
                    $username = $user->firstName . ' ' . $user->lastName;
                    if ($this->conferencepermission->create($data)) {
                        if ($user->active == 1){
                            $this->sendMailInviteCoAuthor($email, $code, $username, $conference->confTitle, $permissionsList);
                        }
                        else{
                            $this->sendMailInviteCoAuthorNotActivated($email, $code, $username, $conference->confTitle, $permissionsList);
                        }
                    }
                } else {
                    $username = 'Sir/Madam';
                    $code = time() . rand(100, 9999);
                    $data_user = array(
                      'sid' => $code,
                      'firstName' => 'Default',
                      'lastName' => 'User',
                      'email' => $email,
                      'password' => md5(rand(100000, 999999)),
                      'affiliation' => 'Affiliation of ' . $email,
                      'dateOfRegistration' => date('Y-m-d'),
                      'autoCreate' => 1
                    );
                    if ($this->useraccount->create($data_user)) {
                        $user = $this->useraccount->get_info_rule(array('email' => $email));
                        $new_code = $user->sid;
                        $data_reminder = array(
                          'email' => $user->email,
                          'sid' => substr($new_code, 0, 10),
                        );
                        if ($this->reminder->create($data_reminder)) {
                            $data_conf_permission = array(
                              'code' => $code,
                              'userID' => $user->id,
                              'confID' => $confID,
                              'CID' => $conference->CID,
                              'email' => $email,
                              'editConference' => $editConference,
                              'editRegistration' => $editRegistration,
                              'editAbstracts' => $editAbstracts,
                              'editRestrict' => $editRestrict,
                              'editContributions' => $editContributions,
                              'status' => 'Pending'
                            );
                            if ($this->conferencepermission->create($data_conf_permission)) {
                                $this->sendMailInviteCoAuthorNoSMN($email, $code, $username, $conference->confTitle, $permissionsList);
                            }
                        }
                    }
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function reSendMailInviteCoAuthor()
    {
        $id = $this->input->post('id');
        $coAuthor = $this->conferencepermission->get_info($id);
        $user = $this->useraccount->get_info($coAuthor->userID);
        $msg = '';
        $status = 'fail';
        if ($coAuthor) {
            $conference = $this->conference->get_info($coAuthor->confID);
            if (!empty($conference)){
                $code = time() . rand(100, 9999);
                $data = array(
                  'code' => $code
                );
                $permissionsList = '<ul>';
                if ($coAuthor->editConference == 1) {
                    $permissionsList .= '<li>Edit conference page</li>';
                }
                if ($coAuthor->editRegistration == 1) {
                    $permissionsList .= '<li>Registration</li>';
                }
                if ($coAuthor->editAbstracts == 1) {
                    $permissionsList .= '<li>Abstracts</li>';
                }
                if ($coAuthor->editRestrict == 1) {
                    $permissionsList .= '<li>Restricted access</li>';
                }
                if ($coAuthor->editContributions == 1) {
                    $permissionsList .= '<li>Manage contributions</li>';
                }
                $permissionsList .= '</ul>';
                if ($this->conferencepermission->update($id, $data)) {
                    if ($user->active == 1) {
                        $username = $user->firstName . ' ' . $user->lastName;
                        $this->sendMailInviteCoAuthor($coAuthor->email, $code, $username, $conference->confTitle, $permissionsList);
                        $msg = 'Sent successfully';
                        $status = 'success';
                        $this->session->set_tempdata('resend_invite_co_author', 'Sent', 180);
                    } else {
                        $data_reminder = array(
                          'sid' => substr($code, 0, 10),
                        );
                        $data_user = array(
                          'sid' => $code,
                        );
                        if ($this->useraccount->update($coAuthor->userID,
                            $data_user) && $this->reminder->update_rule(array('email' => $coAuthor->email),
                            $data_reminder)) {
                            if ($user->autoCreate == 1){
                                $username = 'Sir/Madam';
                                $this->sendMailInviteCoAuthorNoSMN($coAuthor->email, $code, $username, $conference->confTitle, $permissionsList);
                            }
                            else{
                                $username = $user->firstName . ' ' . $user->lastName;
                                $this->sendMailInviteCoAuthorNotActivated($coAuthor->email, $code, $username, $conference->confTitle, $permissionsList);
                            }
                            $msg = 'Sent successfully';
                            $status = 'success';
                            $this->session->set_tempdata('resend_invite_co_author', 'Sent', 180);
                        }
                    }
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function removeCoAuthor()
    {
        $id = $this->input->post('id');
        $coAuthor = $this->conferencepermission->get_info($id);
        $msg = '';
        $status = 'fail';
        if (!empty($coAuthor)) {
            $conference = $this->conference->get_info($coAuthor->confID);
            $user = $this->useraccount->get_info($coAuthor->userID);
            if (!empty($conference) && !empty($user)){
                $username = $user->firstName . ' ' . $user->lastName;
                if ($this->conferencepermission->delete($id)) {
                    $this->sendMailDeleteCoAuthor($user->email, $username, $conference->confTitle);

                    $msg = 'Sent successfully';
                    $status = 'success';
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function getPermissionCoAuthor()
    {
        $id = $this->input->post('id');
        $coAuthor = $this->conferencepermission->get_info($id);
        $msg = array();
        $status = 'fail';
        if ($coAuthor) {
            if ($coAuthor->editConference) {
                array_push($msg, 'editConference');
            }
            if ($coAuthor->editRegistration) {
                array_push($msg, 'editRegistration');
            }
            if ($coAuthor->editAbstracts) {
                array_push($msg, 'editAbstracts');
            }
            if ($coAuthor->editRestrict) {
                array_push($msg, 'editRestrict');
            }
            if ($coAuthor->editContributions) {
                array_push($msg, 'editContributions');
            }
            $status = 'success';
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function updatePermissionCoAuthor()
    {
        $permissions = $this->input->post('permissions');
        $confPermissionID = $this->input->post('confPermissionID');
        $msg = '';
        $status = '';

        $coAuthor = $this->conferencepermission->get_info($confPermissionID);
        if (!empty($coAuthor)){
            $conference = $this->conference->get_info($coAuthor->confID);
            $user = $this->useraccount->get_info($coAuthor->userID);

            if (!empty($conference) && !empty($user)){
                $editConference = 0;
                $editRegistration = 0;
                $editAbstracts = 0;
                $editRestrict = 0;
                $editContributions = 0;
                $username = $user->firstName . ' ' . $user->lastName;

                $permissionsList = '<ul>';
                if (in_array('Edit conference page', $permissions)) {
                    $editConference = 1;
                    $permissionsList .= '<li>Edit conference page</li>';
                }
                if (in_array('Registration', $permissions)) {
                    $editRegistration = 1;
                    $permissionsList .= '<li>Registration</li>';
                }
                if (in_array('Abstracts', $permissions)) {
                    $editAbstracts = 1;
                    $permissionsList .= '<li>Abstracts</li>';
                }
                if (in_array('Restricted access', $permissions)) {
                    $editRestrict = 1;
                    $permissionsList .= '<li>Restricted access</li>';
                }
                if (in_array('Manage contributions', $permissions)) {
                    $editContributions = 1;
                    $permissionsList .= '<li>Manage contributions</li>';
                }
                $permissionsList .= '</ul>';

                $data = array(
                  'editConference' => $editConference,
                  'editRegistration' => $editRegistration,
                  'editAbstracts' => $editAbstracts,
                  'editRestrict' => $editRestrict,
                  'editContributions' => $editContributions,
                );
                if ($this->conferencepermission->update($confPermissionID, $data)) {
                    $this->sendMailUpdatePermissionCoAuthor($user->email, $username, $conference->confTitle, $permissionsList);
                    $msg = 'Updated successfully';
                    $status = 'success';
                } else {
                    $msg = 'Update unsuccessfully';
                    $status = 'fail';
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function getEditConferenceOptional($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editConference == 1) {
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );

                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $this->session->set_userdata('active_conference_sidebar', 'Edit conferences page');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['conference'] = $conference;
                $this->auth_page = 'edit_conference_optional_info';
                $this->auth_conference_layout();
            }
            else{
                redirect(base_url('404_override'));
            }
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function getEditConferenceFile($id)
    {
        $this->session->set_userdata('active_conference_sidebar', 'Edit conferences page');
        $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;

        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editConference == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Edit conferences page');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $this->data['checkActive'] = $this->conference->checkConferenceActive($id);
                $this->data['conference'] = $conference;
                $this->auth_page = 'edit_conference_file_upload';
                $this->auth_conference_layout();
            }
            else{
                redirect(base_url('404_override'));
            }
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function editConferenceFileUpload($id, $name)
    {
        $conference = $this->conference->get_info($id);
        $status = 'fail';
        $msg = '';
        if (!empty($conference)){
            $userID = $conference->userID;

            $this->makeUserDir($userID);
            $this->makeObjectDir($userID, 'conferences');

            $userConfDir = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id;
            if (!(is_dir($userConfDir) OR is_file($userConfDir) OR is_link($userConfDir))) {
                mkdir($userConfDir, 0777);
            }
            if ($name == 'filenameBanner_original') {
                $file_name = 'ConferenceBanner';

                $config['upload_path'] = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 100000;
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('filenameBanner_original')) {
                    $msg = $this->upload->display_errors();
                    $status = 'fail';
                } else {
                    $fileName = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/' . $this->upload->data('file_name');
                    $convert = $this->config->config['convert'];
                    exec("$convert $fileName -auto-orient $fileName");

                    $this->conference->update($id,
                      array($name => $this->input->post('get-file-name')));
                    $msg = $this->input->post('get-file-name');
                    $status = 'success';
                }
                echo json_encode(array('status' => $status, 'msg' => $msg));
            } elseif ($name == 'filenamePoster_original') {
                $file_name = 'ConferencePoster';

                $config['upload_path'] = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 100000;
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('filenamePoster_original')) {
                    $msg = $this->upload->display_errors();
                    $status = 'fail';
                } else {
                    $this->conference->update($id,
                      array($name => $this->input->post('get-file-name')));
                    $msg = $this->input->post('get-file-name');
                    $status = 'success';
                }

                echo json_encode(array('status' => $status, 'msg' => $msg));
            } elseif ($name == 'filenameProgramme_original') {
                $file_name = 'ConferenceProgramme';

                $config['upload_path'] = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 100000;
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('filenameProgramme_original')) {
                    $msg = $this->upload->display_errors();
                    $status = 'fail';
                } else {
                    $this->conference->update($id,
                      array($name => $this->input->post('get-file-name')));
                    $msg = $this->input->post('get-file-name');
                    $status = 'success';
                }
                echo json_encode(array('status' => $status, 'msg' => $msg));
            } elseif ($name == 'filenameAbstractBook_original') {
                $file_name = 'ConferenceAbstractBook';

                $config['upload_path'] = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 100000;
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('filenameAbstractBook_original')) {
                    $msg = $this->upload->display_errors();
                    $status = 'fail';
                } else {
                    $this->conference->update($id,
                      array($name => $this->input->post('get-file-name')));
                    $msg = $this->input->post('get-file-name');
                    $status = 'success';
                }
                echo json_encode(array('status' => $status, 'msg' => $msg));
            } elseif ($name == 'filenameConfPhoto_original') {
                $file_name = 'ConferencePictureParticipants';

                $config['upload_path'] = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 100000;
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('filenameConfPhoto_original')) {
                    $msg = $this->upload->display_errors();
                    $status = 'fail';
                } else {
                    $fileName = FCPATH . '/uploads/userfiles/' . $userID . '/conferences/' . $id . '/' . $this->upload->data('file_name');
                    $convert = $this->config->config['convert'];
                    exec("$convert $fileName -auto-orient $fileName");

                    $this->conference->update($id,
                      array($name => $this->input->post('get-file-name')));
                    $msg = $this->input->post('get-file-name');
                    $status = 'success';
                }
                echo json_encode(array('status' => $status, 'msg' => $msg));
            }
        }
        else{
            echo json_encode(array('status' => $status, 'msg' => $msg));
        }
    }

    public function check_country()
    {
        $country = $this->input->post('recCountry');
        if (!empty($country)) {
            $this->session->set_flashdata('get_country_name', $country);
        }
    }

    public function registerConference($id)
    {
        $conference = $this->conference->get_info($id);
        if ($conference) {
            $registration = $this->conferenceregistration->get_info_binary_2('CID', $conference->CID, 'userID', $this->userID);
            if ($registration) {
                redirect(base_url('conference/' . $id));
            }
            $this->form_validation->set_rules('recName', 'name', 'trim|required|min_length[2]|max_length[50]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
            $this->form_validation->set_rules('recStreet', 'streetname/number',
              'trim|required|min_length[2]|max_length[50]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
            $this->form_validation->set_rules('recPostalCode', 'postal code',
              'trim|required|min_length[2]|max_length[10]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
            $this->form_validation->set_rules('recState', 'state', 'trim|required|min_length[2]|max_length[30]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
            $this->form_validation->set_rules('recCity', 'city', 'trim|required|min_length[2]|max_length[30]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
//            $this->form_validation->set_rules('recCountry', 'country', 'trim|callback_check_country');
            $this->form_validation->set_rules('additionalInfo', 'information', 'trim|min_length[1]|max_length[4000]',
              array(
                'min_length' => 'Please enter a valid %s',
                'max_length' => 'Please enter a valid %s',
              ));
            if ($this->form_validation->run()) {
                $this->session->unset_userdata('register_conference_step_2');
                $status = 'Free';
                if ($conference->fee != 0) {
                    $status = 'Unpaid';
                }

                $optionalCheckbox1 = $this->input->post('option1');
                if (empty($optionalCheckbox1)){
                    $optionalCheckbox1 = 0;
                }
                $optionalCheckbox2 = $this->input->post('option2');
                if (empty($optionalCheckbox2)){
                    $optionalCheckbox2 = 0;
                }

                $data = array(
                  'CID' => $conference->CID,
                  'userID' => $this->user->id,
                  'recName' => $this->input->post('recName'),
                  'recStreet' => $this->input->post('recStreet'),
                  'recPostalCode' => $this->input->post('recPostalCode'),
                  'recCity' => $this->input->post('recCity'),
                  'recCountry' => $this->input->post('recCountry'),
                  'recState' => $this->input->post('recState'),
                  'additionalInfo' => $this->input->post('additionalInfo'),
                  'attendConfDinner' => $this->input->post('attendConfDinner'),
                  'publishName' => $this->input->post('publishName'),
                  'dateOfRegistration' => date('d.m.Y H:i:s'),
                  'optionalCheckbox1' => $optionalCheckbox1,
                  'optionalCheckbox2' => $optionalCheckbox2,
                  'status' => $status
                );
                if ($this->conferenceregistration->create($data)) {
                    $this->session->set_userdata('cid', $conference->CID);
                    if ($status == 'Free') {
                        $this->sendMailRegisterConference($this->user->email, $conference->confTitle, $conference->id);
                        redirect('conference/register/success');
                    }
                    else {
                        $payLater = $this->input->post('pay_later');
                        if (!empty($payLater)){
                            $this->sendMailRegisterConferenceUnpaid($this->user->email, $conference->confTitle,
                              $conference->id);
                            $this->session->set_userdata('pay_later', 'Pay later');
                            redirect('conference/register/success');
                        }
                        else{
                            $this->sendMailRegisterConferencePaid($this->user->email, $conference->confTitle,
                              $conference->id);
                            $this->session->set_userdata('order_cid', $conference->CID);
                            $this->checkoutPaypal();
                        }
                    }
                }
            }
            $this->data['registrationTool'] = $this->registrationtool->get_info_binary('CID', $conference->CID);
            $this->data['user'] = $this->user;
            $this->data['conference'] = $conference;
            $this->data['list_cid'] = $this->cid->getCid();
            $this->page = 'register_conference';
            $this->layout();
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function setSessionRegisterStep2()
    {
        $this->session->set_userdata('register_conference_step_2', 'true');
    }

    public function unsetSessionRegisterStep2()
    {
        $this->session->unset_userdata('register_conference_step_2');
    }

    public function checkCidRegisterConference()
    {
        $cid = $this->input->post('cid');
        $msg = '';
        $status = 'success';
        if (!$this->cid->check_cid_exists($cid)) {
            $msg = 'Please enter a valid CID';
            $status = 'fail';
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function registerConferenceSuccess()
    {
        if ($this->session->cid) {
            $conference = $this->conference->get_info_binary('CID', $this->session->cid);
            if ($conference) {
                $text = 'You have successfully registered for this conference. You will also receive an email shortly.';
                if (isset($this->session->pay_later)){
                    $text = 'You have registered for this conference but you have not paid yet, the host will regularly send you reminders to pay.';
                    $this->session->unset_userdata('pay_later');
                }
                $this->data['text'] = $text;
                $this->data['conference'] = $conference;
                $this->data['checkAbstractActive'] = $this->abstracttool->checkAbstractConferenceActive($this->session->cid);
                $this->page = 'register_conference_success';
                $this->layout();
            }
        } else {
            redirect();
        }
    }

    public function getAbstractConference($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $checkSpamAbstract = false;
            $abstractList = $this->conferenceabstract->get_all_binary_2('CID', $conference['CID'], 'userID', $this->user->id);
            if (!empty($abstractList)) {
                if (count($abstractList) > 9) {
                    $checkSpamAbstract = true;
                }
            }
            $this->data['checkAbstractActive'] = $this->abstracttool->checkAbstractConferenceActive($conference['CID']);
            $this->data['checkSpamAbstract'] = $checkSpamAbstract;
            $this->data['conference'] = $conference;
            $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
            $this->page = 'abstract_conference';
            $this->layout();
        }
    }

    public function abstractConferenceSuccess($id)
    {
        $this->data['conferenceID'] = $id;
        $this->page = 'abstract_conference_success';
        $this->layout();
    }

    public function getRegistrationConference($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            //update payment status
            $this->updatePaymentStatusByCid($conference['CID'], $this->getApiContext(true));

            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editRegistration == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Registration');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $this->data['conferenceInfo'] = $conferenceInfo;
                $this->data['conference'] = $conference;
                $this->data['registrationList'] = $this->conferenceregistration->getRegistrationByCID($conference['CID']);
                $this->data['registrationTool'] = $this->registrationtool->get_info_binary('CID', $conference['CID']);
                $this->auth_page = 'registration_conference_participant';
                $this->auth_conference_layout();
            }else{
                redirect(base_url('404_override'));
            }

        } else{
            redirect(base_url('404_override'));
        }
    }

    public function getRegistrationConferenceByID($id)
    {
        $registration = $this->conferenceregistration->get_info($id);
        $result = '';
        if (!empty($registration)) {
            $user = $this->useraccount->get_info($registration->userID);
            $registrationTool = $this->registrationtool->get_info_binary('CID', $registration->CID);
            if (!empty($user) && !empty($registrationTool)) {
                $holdPresentation = 'No';
                if ($registration->holdPresentation == 1) {
                    $holdPresentation = 'Yes';
                }
                $presentPoster = 'No';
                if ($registration->presentPoster == 1) {
                    $presentPoster = 'Yes';
                }
                $attendConfDinner = 'No';
                if ($registration->attendConfDinner == 1) {
                    $attendConfDinner = 'Yes';
                }
                $optionalCheckbox1 = 'No';
                if ($registration->optionalCheckbox1 == 1) {
                    $optionalCheckbox1 = 'Yes';
                }
                $optionalCheckbox2 = 'No';
                if ($registration->optionalCheckbox2 == 1) {
                    $optionalCheckbox2 = 'Yes';
                }
                $categoryName = '';
                $subcategoryName = '';
                if (!empty($user->category)) {
                    $categoryName = $this->category->get_info($user->category)->name;
                    $subcategoryName = '(' . $this->subcategory->get_info($user->subcategory)->name . ')';
                }

                $result = '<div class="modal-dialog modal-dialog-centered" role="document">';
                $result .= '<div class="modal-content sm-modal-content">';
                $result .= '<div class="sm-modal-header">';
                $result .= '<h5 class="sm-modal-title">' . $user->firstName . ' ' . $user->lastName . '</h5>';
                $result .= '<div class="sub-title">' . $user->affiliation . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-modal-body">';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Position</div>';
                $result .= '<div class="content-sm-text-item">' . $user->position . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Department</div>';
                $result .= '<div class="content-sm-text-item">' . $user->department . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Field of research</div>';
                $result .= '<div class="content-sm-text-item">' . $categoryName . ' ' . $subcategoryName . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Poster</div>';
                $result .= '<div class="content-sm-text-item">' . $presentPoster . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Presentation</div>';
                $result .= '<div class="content-sm-text-item">' . $holdPresentation . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt Name</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recName . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt Street</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recStreet . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt Postal Code</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recPostalCode . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt City</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recCity . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt State</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recState . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Receipt Country</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->recCountry . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Additional Info</div>';
                $result .= '<div class="content-sm-text-item">' . $registration->additionalInfo . '</div>';
                $result .= '</div>';
                if (!empty($registrationTool->registerForDinner)) {
                    $result .= '<div class="sm-text-item">';
                    $result .= '<div class="title-sm-text-item">Attending conference dinner</div>';
                    $result .= '<div class="content-sm-text-item">' . $attendConfDinner . '</div>';
                    $result .= '</div>';
                }
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">E-Mail</div>';
                $result .= '<div class="content-sm-text-item">' . $user->email . '</div>';
                $result .= '</div>';
                if (!empty($registrationTool->optionalCheckbox1)){
                    $result .= '<div class="sm-text-item">';
                    $result .= '<div class="title-sm-text-item">'. $registrationTool->optionalCheckbox1 .'</div>';
                    $result .= '<div class="content-sm-text-item">' . $optionalCheckbox1 . '</div>';
                    $result .= '</div>';
                }
                if (!empty($registrationTool->optionalCheckbox2)){
                    $result .= '<div class="sm-text-item">';
                    $result .= '<div class="title-sm-text-item">'. $registrationTool->optionalCheckbox2 .'</div>';
                    $result .= '<div class="content-sm-text-item">' . $optionalCheckbox2 . '</div>';
                    $result .= '</div>';
                }
                $result .= '</div>';
                $result .= '<div class="sm-modal-footer">';
                $result .= '<div class="btn-custom btn-bg dark-green btn-close ml-auto" data-dismiss="modal">';
                $result .= '<a>Close</a>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
            }
        }
        echo json_encode($result);
    }

    public function registrationTool()
    {
        $cid = $this->input->post('CID');
        $registrationTool = $this->input->post('registrationTool');
        $status = 'fail';
        $msg = '';
        if ($this->registrationtool->check_cid_exists($cid)) {
            $data = array(
              'registrationStart' => $registrationTool[1],
              'registrationEnd' => $registrationTool[2],
              'registrationText' => $registrationTool[0],
              'registerForDinner' => $registrationTool[3],
              'optionalCheckbox1' => $registrationTool[4],
              'optionalCheckbox2' => $registrationTool[5],
            );
            $registrationtool = $this->registrationtool->get_info_binary('CID', $cid);
            if ($this->registrationtool->update($registrationtool->id, $data)) {
                $status = 'success';
                $this->session->set_tempdata('registration_tool_tab', 'active', 5);
            }
        } else {
            $data = array(
              'CID' => $cid,
              'registrationStart' => $registrationTool[1],
              'registrationEnd' => $registrationTool[2],
              'registrationText' => $registrationTool[0],
              'registerForDinner' => $registrationTool[3],
              'optionalCheckbox1' => $registrationTool[4],
              'optionalCheckbox2' => $registrationTool[5],
            );

            if ($this->registrationtool->create($data)) {
                $status = 'success';
                $this->session->set_tempdata('registration_tool_tab', 'active', 5);
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function rejectRegistration()
    {
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        $status = 'fail';
        $msg = '';
        $registration = $this->conferenceregistration->get_info($id);
        if (!empty($registration)) {
            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
              $registration->userID);
            if (!empty($registrationInfo)){
                if ($registrationInfo->fee != 0 && $registrationInfo->payment_status != 'Unpaid'){
                    $amt = new Amount();
                    $amt->setCurrency($this->config->config['currency'])
                      ->setTotal($registrationInfo->fee);
                    $refundRequest = new RefundRequest();
                    $refundRequest->setAmount($amt);
                    $sale = new Sale();
                    $sale->setId($registrationInfo->saleID);
                    try {
                        $refundedSale = $sale->refundSale($refundRequest, $this->getApiContext(true));
                        if ($refundedSale->state == 'completed' || $refundedSale->state == 'pending'){
                            if ($this->conferenceregistration->delete($id)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason, 'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');

                                $msg = 'refund';
                                $status = 'success';
                            }
                        }
                    } catch (Exception $ex) {
//                        redirect(base_url('auth/conference/registration/checkout/error'));
                    }
                }
                else{
                    if ($this->conferenceregistration->delete($id)) {
                        $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                        $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason, 'registration',
                          $username);
                        $this->session->unset_tempdata('remind_registration');

                        $msg = 'free';
                        $status = 'success';
                    }
                }
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function remindRegistration()
    {
        $id = $this->input->post('id');
        $status = 'fail';
        $msg = '';
        $registration = $this->conferenceregistration->get_info($id);
        if (!empty($registration)) {
            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
              $registration->userID);
            if (!empty($registrationInfo)) {
                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                $this->sendMailRemind($registrationInfo->email, $registrationInfo->confTitle, $username);
                $this->session->set_tempdata('remind_registration', 'Sent', 180);

                $status = 'success';
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function getAbstractList($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editAbstracts == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Abstracts');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $this->data['conferenceInfo'] = $conferenceInfo;
                $this->data['conference'] = $conference;
                $this->data['abstractList'] = $this->conferenceabstract->getAbstractByCID($conference['CID']);
                $this->data['abstractTool'] = $this->abstracttool->get_info_binary('CID', $conference['CID']);

                $this->auth_page = 'abstract';
                $this->auth_conference_layout();
            }else{
                redirect(base_url('404_override'));
            }

        } else{
            redirect(base_url('404_override'));
        }
    }

    public function getAbstractConferenceByID($id)
    {
        $abstract = $this->conferenceabstract->get_info($id);
        $result = '';
        if (!empty($abstract)) {
            $user = $this->useraccount->get_info($abstract->userID);
            if (!empty($user)) {
                $type = 'Talk';

                if ($abstract->poster == 1) {
                    $type = 'Poster';
                }

                $result = '<div class="modal-dialog modal-dialog-centered" role="document">';
                $result .= '<div class="modal-content sm-modal-content">';
                $result .= '<div class="sm-modal-header">';
                $result .= '<h5 class="sm-modal-title">' . $abstract->title . '</h5>';
                $result .= '<div class="sub-title">' . $type . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-modal-body">';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Author</div>';
                $result .= '<div class="content-sm-text-item">' . $user->firstName . ' ' . $user->lastName . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Co-Authors</div>';
                $result .= '<div class="content-sm-text-item">' . $abstract->coAuthors . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Affiliations</div>';
                $result .= '<div class="content-sm-text-item">' . $abstract->affiliations . '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-text-item">';
                $result .= '<div class="title-sm-text-item">Abstract text</div>';
                $result .= '<div class="content-sm-text-item">' . $abstract->text . '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="sm-modal-footer">';
                $result .= '<div class="btn-custom btn-bg dark-green btn-close ml-auto" data-dismiss="modal">';
                $result .= '<a>Close</a>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
            }
        }
        echo json_encode($result);
    }

    public function rejectAbstract()
    {
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        $status = 'fail';
        $msg = '';
        $abstract = $this->conferenceabstract->get_info($id);
        if (!empty($abstract)) {
            $abstractInfo = $this->conferenceabstract->getByCidAndUser($abstract->CID, $abstract->userID);
            if (!empty($abstractInfo) && $this->conferenceabstract->delete($id)) {
                $username = $abstractInfo->firstName . ' ' . $abstractInfo->lastName;
                $this->sendMailReject($abstractInfo->email, $abstractInfo->confTitle, $reason, 'abstract', $username);
                $status = 'success';
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function changeTypeAbstract()
    {
        $id = $this->input->post('id');
        $newType = $this->input->post('type');
        $status = 'fail';
        $msg = '';
        $abstract = $this->conferenceabstract->get_info($id);

        if (!empty($abstract)) {
            $poster = 0;
            $talk = 0;
            $type = 'poster';
            $check = 0;
            if ($newType == 'poster') {
                $poster = 1;
            } else {
                $talk = 1;
            }
            if ($abstract->poster == 1 && $newType == 'talk'){
                $check = 1;
            }
            elseif ($abstract->talk == 1 && $newType == 'poster'){
                $type = 'talk';
                $check = 1;
            }
            if ($check){
                $user = $this->useraccount->get_info($abstract->userID);
                if ($this->conferenceabstract->update($id, array('poster' => $poster, 'talk' => $talk))) {
                    $confTitle = $this->conference->get_info_binary('CID', $abstract->CID)->confTitle;
                    $abstractTitle = $abstract->title;
                    $username = $user->firstName . ' ' . $user->lastName;
                    $this->sendMailUpdateTypeAbstract($user->email, $confTitle, $username, $abstractTitle, $type, $newType);
                    $status = 'success';
                }
            }
            else{
                $status = 'success';
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function abstractTool()
    {
        $cid = $this->input->post('CID');
        $abstractTool = $this->input->post('abstractTool');
        $status = 'fail';
        $msg = '';

        if ($this->abstracttool->check_cid_exists($cid)) {
            $data = array(
              'abstractSubmissionStart' => $abstractTool[0],
              'abstractSubmissionEnd' => $abstractTool[1],
              'abstractSubmissionText' => $abstractTool[2]
            );

            $abstracttool = $this->abstracttool->get_info_binary('CID', $cid);
            if ($this->abstracttool->update($abstracttool->id, $data)) {
                $status = 'success';
                $this->session->set_tempdata('abstract_tool_tab', 'active', 5);
            }
        } else {
            $data = array(
              'CID' => $cid,
              'abstractSubmissionStart' => $abstractTool[0],
              'abstractSubmissionEnd' => $abstractTool[1],
              'abstractSubmissionText' => $abstractTool[2]
            );

            if ($this->abstracttool->create($data)) {
                $status = 'success';
                $this->session->set_tempdata('abstract_tool_tab', 'active', 5);
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function Restricted($id)
    {
        $conference = $this->conference->get($id);
        if (!empty($conference)) {
            $permission = $this->conferencepermission->getPermissionConferenceByUser($id, $this->user->id);
            if (!empty($permission) && $permission->editRestrict == 1) {
                $this->session->set_userdata('active_conference_sidebar', 'Restricted Access');
                $this->data['active_conference_sidebar'] = $this->session->active_conference_sidebar;
                $this->session->set_userdata('permission', $permission);
                $conferenceInfo = array(
                  'type' => 'managed',
                  'id' => $id
                );
                $this->session->set_userdata('conferenceInfo', $conferenceInfo);
                $this->data['conferenceInfo'] = $conferenceInfo;
                if ($this->input->post('restrict') == 1) {
                    if ($this->conference->update($id, array('allowClosedAccess' => 1))) {

                        redirect(base_url('auth/conference/restricted-access/' . $id));
                    }
                }
                $this->data['conference'] = $conference;

                $this->auth_page = 'restricted_access';
                $this->auth_conference_layout();
            }else{
                redirect(base_url('404_override'));
            }

        } else{
            redirect(base_url('404_override'));
        }
    }

    public function abstractConference()
    {
        $cid = $this->input->post('CID');
        $confID = $this->input->post('confID');
        $abstract = $this->input->post('abstract');
        $status = 'fail';
        $msg = '';

        $abstractList = $this->conferenceabstract->get_all_binary_2('CID', $cid, 'userID', $this->user->id);
        if (!empty($abstractList)){
            $count = count($abstractList);
            if ($count < 11) {
                $conference = $this->conference->get_info($confID);
                $data = array(
                  'CID' => $cid,
                  'userID' => $this->user->id,
                  'talk' => $abstract[0],
                  'poster' => $abstract[1],
                  'title' => $abstract[2],
                  'coAuthors' => $abstract[3],
                  'affiliations' => $abstract[4],
                  'text' => $abstract[5],
                  'dateOfSubmission' => time(),
                );

                if ($this->conferenceabstract->create($data)) {
                    $registration = $this->conferenceregistration->get_info_binary_2('CID', $cid, 'userID', $this->user->id);

                    if (!empty($registration)) {
                        $holdPresentation = 0;
                        $presentPoster = 0;
                        if ($abstract[0] == 1) {
                            $holdPresentation = 1;
                        }
                        if ($abstract[1] == 1) {
                            $presentPoster = 1;
                        }
                        $dataRegistration = array(
                          'holdPresentation' => $holdPresentation,
                          'presentPoster' => $presentPoster
                        );
                        $this->conferenceregistration->update($registration->ID, $dataRegistration);
                    }
                    $this->sendMailAbstractConference($this->user->email, $conference->confTitle);
                    $status = 'success';
                }
            }
        }
        else{
            $conference = $this->conference->get_info($confID);
            $data = array(
              'CID' => $cid,
              'userID' => $this->user->id,
              'talk' => $abstract[0],
              'poster' => $abstract[1],
              'title' => $abstract[2],
              'coAuthors' => $abstract[3],
              'affiliations' => $abstract[4],
              'text' => $abstract[5],
              'dateOfSubmission' => time(),
            );

            if ($this->conferenceabstract->create($data)) {
                $registration = $this->conferenceregistration->get_info_binary_2('CID', $cid, 'userID', $this->user->id);

                if (!empty($registration)) {
                    $holdPresentation = 0;
                    $presentPoster = 0;
                    if ($abstract[0] == 1) {
                        $holdPresentation = 1;
                    }
                    if ($abstract[1] == 1) {
                        $presentPoster = 1;
                    }
                    $dataRegistration = array(
                      'holdPresentation' => $holdPresentation,
                      'presentPoster' => $presentPoster
                    );
                    $this->conferenceregistration->update($registration->ID, $dataRegistration);
                }
                $this->sendMailAbstractConference($this->user->email, $conference->confTitle);
                $status = 'success';
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function checkoutPaypalError(){
        $this->session->set_userdata('payment_error_404', 'orderCID');
        $this->data['bodyClass'] = 'payment-error-404';
        $this->page = 'err404';
        $this->layout();
    }

    public function checkoutPaypalConferenceError(){
        $this->session->set_userdata('payment_error_404', 'registerConference');
        $this->data['bodyClass'] = 'payment-error-404';
        $this->page = 'err404';
        $this->layout();
    }
}