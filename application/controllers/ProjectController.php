<?php

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

class ProjectController extends MY_Controller
{

    protected $user;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('project');
        $this->load->model('membership');
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
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->session->set_userdata('active_top_header', 'project');
            $this->data['active_top_header'] = $this->session->active_top_header;
            $this->session->set_userdata('active_project_sidebar', 'Demo project');
            $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
            $this->session->unset_userdata('conferenceInfo');
        } else {
            $this->redirectAfterLogin();
        }
        if (empty($this->session->formatGanttChart)){
            $this->session->set_userdata('formatGanttChart', 'month');
        }
    }

    public function projectList()
    {
        $this->deleteProjectUnpaid();
//		$listProject = $this->getListProject();
        $listProject = $this->getMembershipProjectList();
        $this->data['listProject'] = $listProject;
        $this->session->set_userdata('active_project_sidebar', 'Project List');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_list';
        $this->auth_project_layout();
    }

    public function projectInfoOrderPid($identifier)
    {
        $this->session->set_userdata('active_project_sidebar', 'Project info order pid');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $pid = $this->project->get_info_rule(array('identifierPID' => $identifier));
        if (!empty($pid)) {
            if ($pid->status == 'paid') {
                redirect(base_url('auth/project/' . $identifier . '/work-package/'));
            }
            $this->data['pid'] = $pid;
            $this->data['identifier'] = $identifier;
            $this->auth_page = 'project_info_order_pid';
            $this->auth_project_layout();
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function payProject()
    {
        if (empty($_POST['pid']) || empty($this->session->pid)) {
            throw new Exception('This script should not be called directly, expected post data');
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
// Set some example data for the payment.
        $currency = $this->config->config['currency'];
        $invoiceNumber = uniqid();
        $amount = new Amount();

        $name = $this->input->post('pid');

        $amountPayable = (int)$this->config->config['pid_fee'];
        $tax = (int)$this->config->config['tax_percent'] / 100 * $amountPayable;
        $total = $amountPayable + $tax;
        $returnUrl = base_url('auth/project/work-package/order-pid/checkout/response');
        $cancelUrl = base_url('auth/project');

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
          ->setDescription('PID - Project Identification')
          ->setInvoiceNumber($invoiceNumber);

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
            redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
//            throw new Exception('Unable to create link for payment');
        }
        header('location:' . $payment->getApprovalLink());
        exit(1);
    }

    public function responsePayProject()
    {
        if (empty($_GET['paymentId']) || empty($_GET['PayerID']) || empty($this->session->pid)) {
            redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
        }
        $pidItem = $this->project->get_info_rule(array('pid' => $this->session->pid));
        if (!empty($pidItem)) {
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
                        $invoiceNumber = $payment->transactions[0]->invoice_number;
                        $subTotal = $payment->transactions[0]->amount->details->subtotal;
                        $tax = $payment->transactions[0]->amount->details->tax;
                        $total = $payment->transactions[0]->amount->total;
                        $transactionID = $payment->transactions[0]->related_resources[0]->sale->id;
                        $dataInvoice = array(
                          'invoiceID' => $invoiceNumber,
                          'userID' => $this->user->id,
                          'PID' => $pidItem->pid,
                          'transactionID' => $transactionID,
                          'subTotal' => $subTotal,
                          'tax' => $tax,
                          'paymentAmount' => $total,
                          'paymentStatus' => $payment->getState()
                        );

                        $emailSendInvoice = $this->project->convertInvoiceToPdf($this->userID, $pidItem->pid,
                          $invoiceNumber, $subTotal, $tax, $total, date('F dS, Y', time()));
                        if (!empty($emailSendInvoice)) {
                            $username = $pidItem->contactFirstName . ' ' . $pidItem->contactLastName;
                            $invoiceFile = FCPATH . 'uploads/userfiles/' . $this->userID . '/invoices/' . $invoiceNumber . '.pdf';
                            if (!empty($invoiceFile)) {
                                $this->invoice->create($dataInvoice);
                                $this->sendMailInvoice($emailSendInvoice, $username, $invoiceFile);
                            }
                        }

                        $runCMD = $this->config->config['run_CMD'];
                        $runCMDProject = '' . $runCMD . ' "Project.create(identifier: \'' . $pidItem->identifierPID . '\', name: \'' . $pidItem->pid . '\');"';
                        exec($runCMDProject);

                        $this->project->update_rule(array('pid' => $pidItem->pid), array('status' => 'paid'));
                        $this->session->unset_userdata('pid');
                        $this->session->set_userdata('new_project', 'paid');
                        redirect(base_url('auth/project/' . $pidItem->identifierPID . '/work-package/'));
                    } else {
                        redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
                    }
                } catch (Exception $e) {
                    redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
                }
            } catch (Exception $e) {
                redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
            }
        } else {
            redirect(base_url('auth/project/work-package/order-pid/checkout/error'));
        }
    }

    public function deleteProjectUnpaid()
    {
        if (!empty($this->session->pid)) {
            $this->project->del_rule(array('pid' => $this->session->pid));
            $this->session->unset_userdata('pid');
            return true;
        }
    }

    public function checkoutProjectError()
    {
        if ($this->deleteProjectUnpaid()) {
            $this->session->set_userdata('payment_error_404', 'orderPID');
            $this->data['bodyClass'] = 'payment-error-404';
            $this->page = 'err404';
            $this->layout();
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function checkProjectPermission($identifier){
        if (!$this->membership->checkMember($this->userID, $identifier) &&
          !$this->project->checkHost($this->userID, $identifier)){
            return false;
        }
        return true;
    }

    public function workPackage($identifier)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        if (isset($this->session->new_project)){
            $project = $this->config->config['api_url'] . "projects/" . $identifier;
            $project = $this->CurlSetup($project, "get");
            $project = json_decode($project);
            if (!empty($project->id)) {
                $runCMD = $this->config->config['run_CMD'];

                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Not Started\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Work in Progress\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Draft\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'First Revision\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Second Revision\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Third Revision\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Approved\', status: \'open\');"';
                exec($runCMDVersion);
                $runCMDVersion = '' . $runCMD . ' "Version.create(project_id: \'' . $project->id . '\', name: \'Closed/Completed\', status: \'open\');"';
                exec($runCMDVersion);

                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Document\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Report\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Demonstrator\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Pilot\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Prototype\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Plan Designs\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Websites\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Patents filing\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Press & Media Action\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Meeting\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Videos\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Software\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Technical Diagram\');"';
                exec($runCMDCategory);
                $runCMDCategory = '' . $runCMD . ' "Category.create(project_id: \'' . $project->id . '\', name: \'Other\');"';
                exec($runCMDCategory);

                $this->session->unset_userdata('new_project');
            }
        }
        if ($this->input->post('seclect-sort-second')) {
            $sortFirst = $this->input->post('seclect-sort-first');
            $sortSecond = $this->input->post('seclect-sort-second');
            $sortThird = $this->input->post('seclect-sort-third');
            $checksortFirst = $this->input->post('check-sort-first');
            $checksortSecond = $this->input->post('check-sort-second');
            $checksortThird = $this->input->post('check-sort-third');
        }
        if ($this->input->get('offset')) {
            $offset = $this->input->get('offset');
            if ($this->input->get('sort')) {
                $this->data['sort'] = $this->input->get('sort');
                $this->data['ordinary'] = $this->input->get('ordinary');
                $sort = $this->input->get('sort');
                if ($this->input->get('ordinary') == "asc") {
                    $url = $this->GetUrlTask($identifier) . "?offset=" . $offset . '&sortBy=[[%20"' . $sort . '",%20"asc"]]';

                } else {
                    $url = $this->GetUrlTask($identifier) . "?offset=" . $offset . '&sortBy=[[%20"' . $sort . '",%20"desc"]]';
                }
            } elseif (!$this->input->get('sort') && $this->input->post('seclect-sort-second')) {
                $url = $this->GetUrlTask($identifier) . "?offset=" . $offset . '&sortBy=[["' . $sortFirst . '","' . $checksortFirst . '"],["' . $sortSecond . '","' . $checksortSecond . '"],["' . $sortThird . '","' . $checksortThird . '"]]';
            } else {
                $url = $this->GetUrlTask($identifier) . "?offset=" . $offset . '&sortBy=[[%20"startDate",%20"asc"]]';
            }
        } else {
            if ($this->input->get('sort')) {
                $sort = $this->input->get('sort');
                $this->data['ordinary'] = $this->input->get('ordinary');
                $this->data['sort'] = $sort;
                if ($this->input->get('ordinary') == "asc") {
                    $url = $this->GetUrlTask($identifier) . '?sortBy=[["' . $sort . '",%20"asc"]]';
                } else {
                    $url = $this->GetUrlTask($identifier) . '?sortBy=[["' . $sort . '",%20"desc"]]';
                }

            } elseif (!$this->input->get('sort') && $this->input->post('seclect-sort-second')) {
                $url = $this->GetUrlTask($identifier) . '?sortBy=[["' . $sortFirst . '","' . $checksortFirst . '"],["' . $sortSecond . '","' . $checksortSecond . '"],["' . $sortThird . '","' . $checksortThird . '"]]';
            } else {
                $url = $this->GetUrlTask($identifier) . '?sortBy=[[%20"startDate",%20"asc"]]';
            }
        }
        if ($this->input->post('statusFilter')) {
            if ($this->input->post('statusFilter') == "=") {
                if ($this->input->post('statusTask')) {
                    $valuesFilter = '&filters=[{"status":{"operator":"=","values":["';
                    foreach ($_POST['statusTask'] as $variable => $value) {
                        $valuesFilter = $valuesFilter . $value . '","';
                    }
                    $valuesFilter = $valuesFilter . ']}}]';
                    $valuesFilter = str_replace(",\"]}}]", "]}}]", $valuesFilter);
                } else {
                    $valuesFilter = "";
                }
            } elseif ($this->input->post('statusFilter') == "!") {
                $valuesFilter = '&filters=[{"status":{"operator":"!","values":["';
                if ($this->input->post('statusTask')) {
                    foreach ($_POST['statusTask'] as $variable => $value) {
                        $valuesFilter = $valuesFilter . $value . '","';
                    }
                    $valuesFilter = $valuesFilter . ']}}]';
                    $valuesFilter = str_replace(",\"]}}]", "]}}]", $valuesFilter);
                } else {
                    $valuesFilter = "";
                }
            } elseif ($this->input->post('statusFilter') == "o") {
                $valuesFilter = '&filters=[{"status":{"operator":"o","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            } elseif ($this->input->post('statusFilter') == "*") {
                $valuesFilter = '&filters=[{"status":{"operator":"*","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            } elseif ($this->input->post('statusFilter') == "c") {
                $valuesFilter = '&filters=[{"status":{"operator":"c","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            }
            if ($this->input->post('filter-text')) {
                $filterText = $this->input->post('filter-text');
                if ($this->input->post('statusTask')) {
                    $valuesFilter = str_replace("]}}]", "]}}", $valuesFilter);
                    $valuesFilter = $valuesFilter . ',{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
                } else {
                    $valuesFilter = '&filters=[{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
                }
            }
            if ($this->input->get('offset')) {
                $cutOffset = "offset=" . $offset . "&";
                $url = str_replace($cutOffset, "", $url);
                $url = $url . $valuesFilter;
            } else {
                $url = $url . $valuesFilter;
            }
        }
        if (!$this->input->post('statusFilter') && $this->input->post('filter-text')) {
            $filterText = $this->input->post('filter-text');
            $valuesFilter = '&filters=[{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
            if ($this->input->get('offset')) {
                $cutOffset = "offset=" . $offset . "&";
                $url = str_replace($cutOffset, "", $url);
                $url = $url . $valuesFilter;
            } else {
                $url = $url . $valuesFilter;
            }
        }
        if ($this->input->get('sf')) {
            if (!$this->input->post('statusFilter') && !$this->input->post('filter-text')) {
                $sf = $this->input->get('sf');
                $url = $this->session->userdata('urlTask');
                $backSf = $this->session->userdata('backSf');
                $searchSf = "&offset=" . $backSf;
                $url = str_replace($searchSf, "", $url);
                $url = $url . "&offset=" . $sf;
            }
        }
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $this->data['list_task'] = $elements;
        }

        $urlGetMember = $this->GetUrlMember();
        $responseGetMember = $this->CurlSetup($urlGetMember, "get");
        $responseGetMember = json_decode($responseGetMember);
        $members = null;
        if (!empty($responseGetMember->_embedded->elements)) {
            $members = $responseGetMember->_embedded->elements;
            $this->data['list_member'] = $members;
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships?pageSize=500";
        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);

        if (!empty($responseMemberships->_embedded)) {
            $memberships = $responseMemberships->_embedded->elements;
            if ($responseMemberships->total > 500) {
                $urlMemberships2 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=2";
                $responseMemberships2 = $this->CurlSetup($urlMemberships2, "get");
                $responseMemberships2 = json_decode($responseMemberships2);
                $elementsMemberships2 = $responseMemberships2->_embedded->elements;
                foreach ($elementsMemberships2 as $valueOffset2) {
                    array_push($memberships, $valueOffset2);
                }
                if ($responseMemberships->total > 1000) {
                    $urlMemberships3 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=3";
                    $responseMemberships3 = $this->CurlSetup($urlMemberships3, "get");
                    $responseMemberships3 = json_decode($responseMemberships3);
                    $elementsMemberships3 = $responseMemberships3->_embedded->elements;
                    foreach ($elementsMemberships3 as $valueOffset3) {
                        array_push($memberships, $valueOffset3);
                    }
                }
            }
            $this->data['list_memberships'] = $memberships;
        }

        $urlProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $project = $this->CurlSetup($urlProject, "get");
        $project = json_decode($project);
        $linkProject = null;
        if (!empty($project->id)) {
            $this->data['projectID'] = $project->id;

            $urlCategories = $this->config->config['api_url'] . 'projects/' . $project->id . '/categories';
            $responseCategories = $this->CurlSetup($urlCategories, "get");
            $responseCategories = json_decode($responseCategories);
            $categoriesArr = array();
            if ($responseCategories->count > 0){
                foreach ($responseCategories->_embedded->elements as $key => $category){
                    $item = array(
                      'name' => $category->name,
                      'href' =>$category->_links->self->href
                    );
                    array_push($categoriesArr, $item);
                }
            }

            $this->data['categoriesArr'] = $categoriesArr;

            $urlVersions = $this->config->config['api_url'] . 'projects/' . $project->id . '/versions';
            $responseVersions = $this->CurlSetup($urlVersions, "get");
            $responseVersions = json_decode($responseVersions);
            $versionsArr = array();
            if ($responseVersions->count > 0){
                foreach ($responseVersions->_embedded->elements as $key => $version){
                    $item = array(
                      'name' => $version->name,
                      'href' =>$version->_links->self->href
                    );
                    array_push($versionsArr, $item);
                }
            }

            $this->data['versionsArr'] = $versionsArr;
        }

        $this->session->set_userdata('response', $response);
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->data['identifier'] = $identifier;
        $this->session->set_userdata('urlTask', $url);
        if ($this->input->get('sf')) {
            if (!$this->input->post('statusFilter') && !$this->input->post('filter-text')) {
                $this->session->set_userdata('backSf', $sf);
            }
        }

//        $this->data['responseTask'] = $response;
        $this->data['api_key'] = $this->OPapiKey;
        $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
        $this->auth_page = 'project_work_package';
        $this->auth_project_layout();
    }

    public function newTask($identifier, $type)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $url = $this->GetUrlMember();
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $this->data['list_member'] = $elements;
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships?pageSize=500";
        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);

        if (!empty($responseMemberships->_embedded)) {
            $elementsMemberships = $responseMemberships->_embedded->elements;
            if ($responseMemberships->total > 500) {
                $urlMemberships2 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=2";
                $responseMemberships2 = $this->CurlSetup($urlMemberships2, "get");
                $responseMemberships2 = json_decode($responseMemberships2);
                $elementsMemberships2 = $responseMemberships2->_embedded->elements;
                foreach ($elementsMemberships2 as $valueOffset2) {
                    array_push($elementsMemberships, $valueOffset2);
                }
                if ($responseMemberships->total > 1000) {
                    $urlMemberships3 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=3";
                    $responseMemberships3 = $this->CurlSetup($urlMemberships3, "get");
                    $responseMemberships3 = json_decode($responseMemberships3);
                    $elementsMemberships3 = $responseMemberships3->_embedded->elements;
                    foreach ($elementsMemberships3 as $valueOffset3) {
                        array_push($elementsMemberships, $valueOffset3);
                    }
                }
            }

            $this->data['list_memberships'] = $elementsMemberships;
        }

        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;

            $urlCategories = $this->config->config['api_url'] . 'projects/' . $idProject->id . '/categories';
            $responseCategories = $this->CurlSetup($urlCategories, "get");
            $responseCategories = json_decode($responseCategories);
            $categoriesArr = array();
            if ($responseCategories->count > 0){
                foreach ($responseCategories->_embedded->elements as $key => $category){
                    $item = array(
                      'name' => $category->name,
                      'href' =>$category->_links->self->href
                    );
                    array_push($categoriesArr, $item);
                }
            }

            $this->data['categoriesArr'] = $categoriesArr;

            $urlVersions = $this->config->config['api_url'] . 'projects/' . $idProject->id . '/versions';
            $responseVersions = $this->CurlSetup($urlVersions, "get");
            $responseVersions = json_decode($responseVersions);
            $versionsArr = array();
            if ($responseVersions->count > 0){
                foreach ($responseVersions->_embedded->elements as $key => $version){
                    $item = array(
                      'name' => $version->name,
                      'href' =>$version->_links->self->href
                    );
                    array_push($versionsArr, $item);
                }
            }

            $this->data['versionsArr'] = $versionsArr;
        }

        $this->form_validation->set_rules('subject', '', 'trim|required');
        $this->form_validation->set_rules('percentageDone', '', 'trim|required');
        if ($this->form_validation->run()) {
            $subject = $this->input->post('subject');
            $remainingTime = $this->input->post('remaining-hours');
            $storyPoints = null;
            $raw = strip_tags($this->input->post('description_document'));
            $assignee = $this->input->post('assignee');
            $estimatedTime = $this->input->post('estimatedTime');
            $startDate = $this->input->post('startDate');
            if ($startDate != null) {
                $startDate = date("Y-m-d", strtotime($startDate));
            }
            $dueDate = $this->input->post('endDate');
            if ($dueDate != null) {
                $dueDate = date("Y-m-d", strtotime($dueDate));
            }
            $dateMileStone = $this->input->post('dateMileStone');
            if ($dateMileStone != null) {
                $dateMileStone = date("Y-m-d", strtotime($dateMileStone));
            }
            $version = $this->input->post('version');
            $percentageDone = $this->input->post('percentageDone');
            $priority = $this->input->post('priority');
            $category = $this->input->post('category');
            $attachFile = $this->input->post('attachFile');
            $accountable = $this->input->post('accountable');

            $dataArray = $this->GetDataArray($raw, $subject, $startDate, $dueDate, $estimatedTime, $percentageDone,
              $priority, $category, $version, $assignee, $attachFile, $accountable, $type, $storyPoints, $remainingTime,
              $dateMileStone);
            $url = $this->GetUrlTask($identifier);
            $response = $this->CurlSetup($url, "post", $dataArray);
            $response = json_decode($response);

            if (!empty($response->id)){
                $urlAddAttachment = $this->config->config['api_url'] . "work_packages/" . $response->id . "/attachments";
                $data = array(
                  'fileName' => $_FILES['file']['name']
                );
                $this->CurlSetupFile($urlAddAttachment, $data);

                $workPackageTitle = $response->subject;
                if ($type == 1){
                    $workPackageType = 'Task';
                }
                elseif ($type == 2){
                    $workPackageType = 'Milestone';
                }
                elseif ($type == 3){
                    $workPackageType = 'Phase';
                }
                elseif ($type == 4){
                    $workPackageType = 'Feature';
                }
                elseif ($type == 5){
                    $workPackageType = 'Epic';
                }
                elseif ($type == 6){
                    $workPackageType = 'User story';
                }
                elseif ($type == 7){
                    $workPackageType = 'Bug';
                }
                if (!empty($response->_links->assignee->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $assignee));
                    $email = $user->email;
                    $username = $response->_links->assignee->title;
                    $type = 'Assignee';
                    $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                    $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                }
                if (!empty($response->_links->responsible->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $accountable));
                    $email = $user->email;
                    $username = $response->_links->responsible->title;
                    $type = 'Accountable';
                    $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                    $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                }
            }

            redirect(base_url('auth/project/' . $identifier . '/work-package/'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
        $this->data['identifier'] = $identifier;
        $this->data['type'] = $type;
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_work_package_new_task';
        $this->auth_project_layout();
    }

    public function updateTask($idProject, $idTask)
    {
        $nameProject = $this->input->post('nameProject');
        $url = $this->GetUrlTask(null, $idTask);
        $lockVersion = $this->GetlockVersion($idTask);
        $dataArray = array(
          'subject' => $nameProject,
          'lockVersion' => $lockVersion
        );
        $response = $this->CurlSetup($url, "patch", $dataArray);

        redirect(base_url('auth/project/' . $idProject . '/work-package/'));
    }

    public function editTask($identifier, $idTask)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $url = $this->GetUrlTask(null, $idTask);

        $responseTask = $this->CurlSetup($url, "get");
        $responseTask = json_decode($responseTask);

        $checkChildren = false;
        if (!empty($responseTask->_links->children)){
            $checkChildren = true;
            $this->data['checkChildren'] = $checkChildren;
        }

        if ($this->input->post('priority')) {
            $lockVersion = $this->GetlockVersion($idTask);
            $raw = strip_tags($this->input->post('description'));
            $subject = strip_tags($this->input->post('subject'));
            $dataArray = array(
              'subject' => $subject,
              'description' =>
                array(
                  'format' => 'textile',
                  'raw' => $raw,
                ),
              'lockVersion' => $lockVersion
            );
            $startDate = $this->input->post('startDate');
            if ($startDate != null) {
                $startDate = date("Y-m-d", strtotime($startDate));
                $dataArray['startDate'] = $startDate;
            }
            $dueDate = $this->input->post('endDate');
            if ($dueDate != null) {
                $dueDate = date("Y-m-d", strtotime($dueDate));
                $dataArray['dueDate'] = $dueDate;
            }

            $dateMileStone = $this->input->post('dateMileStone');
            if ($dateMileStone != null) {
                $dateMileStone = date("Y-m-d", strtotime($dateMileStone));
                $dataArray['date'] = $dateMileStone;
            }

            if (!$checkChildren){
                $estimatedTime = $this->input->post('estimated-time');
                if ($estimatedTime) {
                    if ($estimatedTime < 24) {
                        $resultEstimatedTime = "PT" . $estimatedTime . "H";
                    } else {
                        if ($estimatedTime >= 24) {
                            $hourEstimated = $estimatedTime % 24;
                            $dayEstimated = ($estimatedTime - $hourEstimated) / 24;
                            if ($hourEstimated == 0) {
                                $resultEstimatedTime = "P" . $dayEstimated . "D";
                            } else {
                                if ($hourEstimated != 0) {
                                    $resultEstimatedTime = "P" . $dayEstimated . "DT" . $hourEstimated . "H";
                                }
                            }
                        }
                    }
                    $dataArray['estimatedTime'] = $resultEstimatedTime;
                }
                else{
                    $dataArray['estimatedTime'] = 'PT0S';
                }
                $remainingTime = $this->input->post('remaining-hours');
                if ($remainingTime) {
                    if ($remainingTime < 24) {
                        $resultRemainingTime = "PT" . $remainingTime . "H";
                    } else {
                        if ($remainingTime >= 24) {
                            $hourEstimated = $remainingTime % 24;
                            $dayEstimated = ($remainingTime - $hourEstimated) / 24;
                            if ($hourEstimated == 0) {
                                $resultRemainingTime = "P" . $dayEstimated . "D";
                            } else {
                                if ($hourEstimated != 0) {
                                    $resultRemainingTime = "P" . $dayEstimated . "DT" . $hourEstimated . "H";
                                }
                            }
                        }
                    }
                    $dataArray['remainingTime'] = $resultRemainingTime;
                }
                else{
                    $dataArray['remainingTime'] = 'PT0S';
                }
            }

            $storyPoints = null;
            if ($storyPoints) {
                $dataArray['storyPoints'] = $storyPoints;
            }
            else{
                $dataArray['storyPoints'] = null;
            }
            $percentageDone = $this->input->post('percentageDone');
            if ($percentageDone) {
                $dataArray['percentageDone'] = $percentageDone;
            }
            $priority = $this->input->post('priority');
            if ($priority) {
                $dataArray['_links']['priority']['href'] = '/api/v3/priorities/' . $priority;
            }
            $category = $this->input->post('category');
            if ($category) {
                $dataArray['_links']['category']['href'] = $category;
            }
            $version = $this->input->post('version');
            if ($version) {
                $dataArray['_links']['version']['href'] = $version;
            }
            $assignee = $this->input->post('assignee');
            if ($assignee) {
                $dataArray['_links']['assignee']['href'] = '/api/v3/users/' . $assignee;
            }
            $attachFile = $this->input->post('attachFile');
            if ($attachFile) {
                $dataArray['_links']['downloadLocation']['href'] = $attachFile;
            }
            $accountable = $this->input->post('accountable');
            if ($accountable) {
                $dataArray['responsible']['href'] = '/api/v3/users/' . $accountable;
            }

            $url = $this->GetUrlTask(null, $idTask);
            $response = $this->CurlSetup($url, "patch", $dataArray);
            $response = json_decode($response);
            if (!empty($_FILES['file']['name'])){
                $urlAddAttachment = $this->config->config['api_url'] . "work_packages/" . $idTask . "/attachments";
                $data = array(
                  'fileName' => $_FILES['file']['name']
                );
                $this->CurlSetupFile($urlAddAttachment, $data);
            }
            if (!empty($response->_type) && $response->_type != 'Error'){
                $workPackageTitle = $response->subject;
                $type = $this->input->post('type-id');
                if ($type == 1){
                    $workPackageType = 'Task';
                }
                elseif ($type == 2){
                    $workPackageType = 'Milestone';
                }
                elseif ($type == 3){
                    $workPackageType = 'Phase';
                }
                elseif ($type == 4){
                    $workPackageType = 'Feature';
                }
                elseif ($type == 5){
                    $workPackageType = 'Epic';
                }
                elseif ($type == 6){
                    $workPackageType = 'User story';
                }
                elseif ($type == 7){
                    $workPackageType = 'Bug';
                }
                if (!empty($response->_links->assignee->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $assignee));
                    $email = $user->email;
                    if (!empty($responseTask->_embedded->assignee->id)){
                        if ($responseTask->_embedded->assignee->id != $assignee){
                            $username = $response->_links->assignee->title;
                            $type = 'Assignee';
                            $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                            $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                        }
                    }
                    else{
                        $username = $response->_links->assignee->title;
                        $type = 'Assignee';
                        $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                        $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                    }
                }
                if (!empty($response->_links->responsible->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $accountable));
                    $email = $user->email;
                    if (!empty($responseTask->_embedded->responsible->id)){
                        if ($responseTask->_embedded->responsible->id != $accountable){
                            $username = $response->_links->responsible->title;
                            $type = 'Accountable';
                            $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                            $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                        }
                    }
                    else{
                        $username = $response->_links->responsible->title;
                        $type = 'Accountable';
                        $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                        $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                    }
                }
            }

            redirect(base_url('auth/project/' . $identifier . '/work-package/edit/' . $idTask . ''));
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships?pageSize=500";
        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);

        if (!empty($responseMemberships->_embedded)) {
            $elementsMemberships = $responseMemberships->_embedded->elements;
            if ($responseMemberships->total > 500) {
                $urlMemberships2 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=2";
                $responseMemberships2 = $this->CurlSetup($urlMemberships2, "get");
                $responseMemberships2 = json_decode($responseMemberships2);
                $elementsMemberships2 = $responseMemberships2->_embedded->elements;
                foreach ($elementsMemberships2 as $valueOffset2) {
                    array_push($elementsMemberships, $valueOffset2);
                }
                if ($responseMemberships->total > 1000) {
                    $urlMemberships3 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=3";
                    $responseMemberships3 = $this->CurlSetup($urlMemberships3, "get");
                    $responseMemberships3 = json_decode($responseMemberships3);
                    $elementsMemberships3 = $responseMemberships3->_embedded->elements;
                    foreach ($elementsMemberships3 as $valueOffset3) {
                        array_push($elementsMemberships, $valueOffset3);
                    }
                }
            }

            $this->data['list_memberships'] = $elementsMemberships;
        }
        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;

            $urlCategories = $this->config->config['api_url'] . 'projects/' . $idProject->id . '/categories';
            $responseCategories = $this->CurlSetup($urlCategories, "get");
            $responseCategories = json_decode($responseCategories);
            $categoriesArr = array();
            if ($responseCategories->count > 0){
                foreach ($responseCategories->_embedded->elements as $key => $category){
                    $item = array(
                      'name' => $category->name,
                      'href' =>$category->_links->self->href
                    );
                    array_push($categoriesArr, $item);
                }
            }

            $this->data['categoriesArr'] = $categoriesArr;

            $urlVersions = $this->config->config['api_url'] . 'projects/' . $idProject->id . '/versions';
            $responseVersions = $this->CurlSetup($urlVersions, "get");
            $responseVersions = json_decode($responseVersions);
            $versionsArr = array();
            if ($responseVersions->count > 0){
                foreach ($responseVersions->_embedded->elements as $key => $version){
                    $item = array(
                      'name' => $version->name,
                      'href' =>$version->_links->self->href
                    );
                    array_push($versionsArr, $item);
                }
            }

            $this->data['versionsArr'] = $versionsArr;
        }
        $listProject = $this->getListProject();

        $url = $this->GetUrlMember();
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        $elements = null;
        if (!empty($response->_embedded->elements)) {
            $elements = $response->_embedded->elements;
            $this->data['list_member'] = $elements;
        }

        $urlActivity = $this->GetUrlTask(null, $idTask) . '/activities';
        $responseActivity = $this->CurlSetup($urlActivity, "get");
        $responseActivity = json_decode($responseActivity);

        $this->session->set_userdata('listProject', $listProject);
        if (!empty($responseTask)){
            $this->session->set_userdata('responseTask', $responseTask);
        }
        else{
            redirect(base_url('404_override'));
        }
        $this->data['identifier'] = $identifier;

        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->data['idTask'] = $idTask;

        $activities = array();
        if (!empty($elements) && !empty($responseActivity->_embedded->elements)){
            foreach ($responseActivity->_embedded->elements as $variable => $value) {
                $activity = array();
                $details = array();
                $dateCurrent = null;
                $activity['comment'] = null;
                if (!empty($value->comment->html)){
                    $activity['comment'] = $value->comment->html;
                }
                $activity['createdAt'] = $value->createdAt;
                foreach ($elements as $key => $user) {
                    if ($user->_links->self->href == $value->_links->user->href) {
                        $activity['user']['href'] = $value->_links->user->href;
                        $activity['user']['name'] = $user->name;
                        $activity['user']['id'] = $this->useraccount->get_info_rule(array('user_op_ID' => $user->id))->id;
                    }
                }
                foreach ($value->details as $detail => $content) {
                    array_push($details, $content->html);
                }
                $activity['detail'] = $details;
                array_push($activities, $activity);
            }
        }
        $relations = array();
        if (!empty($responseTask->_links->children)) {
            foreach ($responseTask->_links->children as $variableChild => $valueChild) {
                $url = str_replace("/api/v3/", "", $valueChild->href);
                $url = $this->config->config['api_url'] . $url;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $this->OPapiKey);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $responseChild = curl_exec($ch);
                curl_close($ch);

                $responseChild = json_decode($responseChild);
                array_push($relations, $responseChild);
            }
        }

        $watchers = array();
        $checkWatched = null;
        if (!empty($responseTask->_embedded->watchers->_embedded->elements)){
            foreach ($responseTask->_embedded->watchers->_embedded->elements as $key => $watcher){
                $watcher = array(
                  'name' => $watcher->name,
                  'id' => $watcher->id,
                  'userSmnID' => $this->useraccount->get_info_rule(array('user_op_ID' => $watcher->id))->id
                );
                if ($watcher['userSmnID'] == $this->userID){
                    $checkWatched = $watcher['id'];
                }
                array_push($watchers, $watcher);
            }
        }

        $url = $this->config->config['api_url'] . "work_packages/" . $idTask . '/attachments';
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded->elements)){
            $attachmentList = array();
            foreach ($response->_embedded->elements as $key => $element) {
                $attachment = array(
                  'id' => $element->id,
                  'fileName' => $element->fileName,
                  'link' => 'http://pm.web.beesightsoft.com/attachments/' . $element->id . '/' . $element->fileName,
                  'author' => $element->_links->author->title,
                  'countTime' => $this->countTime($element->createdAt),
                  'createdAt' => $element->createdAt
                );
                array_push($attachmentList, $attachment);
            }
            $this->data['attachmentList'] = $attachmentList;
        }

        $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
        $this->data['checkWatched'] = $checkWatched;
        $this->data['watchers'] = $watchers;
        $this->data['relations'] = $relations;
        $this->data['api_key'] = $this->OPapiKey;
        $this->data['activities'] = $activities;
        $this->data['identifier'] = $identifier;
        $this->auth_page = 'project_calendar_task_detail';
        $this->auth_project_layout();
    }

    public function getContent($type, $idTask){
        $url = $this->GetUrlTask(null, $idTask);
        $responseTask = $this->CurlSetup($url, "get");
        $responseTask = json_decode($responseTask);

        if ($type == 'activities'){
            $urlMember = $this->GetUrlMember();
            $response = $this->CurlSetup($urlMember, "get");
            $response = json_decode($response);
            $elements = null;
            if (!empty($response->_embedded->elements)) {
                $elements = $response->_embedded->elements;
            }

            $urlActivity = $this->GetUrlTask(null, $idTask) . '/activities';
            $responseActivity = $this->CurlSetup($urlActivity, "get");
            $responseActivity = json_decode($responseActivity);
            $activities = array();
            if (!empty($elements) && !empty($responseActivity->_embedded->elements)){
                foreach ($responseActivity->_embedded->elements as $variable => $value) {
                    $activity = array();
                    $details = array();
                    $dateCurrent = null;
                    $activity['comment'] = null;
                    if (!empty($value->comment->html)){
                        $activity['comment'] = $value->comment->html;
                    }
                    $activity['createdAt'] = $value->createdAt;
                    foreach ($elements as $key => $user) {
                        if ($user->_links->self->href == $value->_links->user->href) {
                            $activity['user']['href'] = $value->_links->user->href;
                            $activity['user']['name'] = $user->name;
                            $activity['user']['id'] = $this->useraccount->get_info_rule(array('user_op_ID' => $user->id))->id;
                        }
                    }
                    foreach ($value->details as $detail => $content) {
                        array_push($details, $content->html);
                    }
                    $activity['detail'] = $details;
                    array_push($activities, $activity);
                }
            }
            if (!empty($activities) && !empty($responseTask)){
                $dateCurrent = null;
                $index = 1;
                $activity = '';
                foreach ($activities as $key => $value) {
                    if (!empty($value['user'])) {
                        $avatar_jpg = 'uploads/userfiles/' . $value['user']['id'] . '/profilePhoto.jpg';
                        if (file_exists($avatar_jpg)) {
                            $avatar = $avatar_jpg . '?' . time();
                        } else {
                            $avatar = 'assets/images/img-avatar-default.png';
                        }
                        if ($index == 1){
                            $activity .= '<div class="block-activity">' .
                              '<div class="block-date">
                                '.
                              date_format(date_create($value['createdAt']), "F j, Y") .'
                            </div>
                            <div class="block-info-activity d-flex">
                                <div class="block-img">
                                    <img src="'.base_url($avatar).'" alt=""/>
                                </div>
                                <div class="block-info">
                                    <div class="author">
                                        '.$responseTask->_embedded->author->name.'
                                    </div>
                                    <div class="time-publishing">
                                        created on '.
                              date_format(date_create($value['createdAt']), "m/d/Y h:i A") . '
                                    </div>
                                </div>
                            </div>
                            <div class="block-detail">
                                <div class="title-activity">'.$value['comment'].'</div>
                            </div>
                        </div>';
                        } else {
                            $activity .= '<div class="block-activity">';
                            if (date_format(date_create($value['createdAt']), "dmY") != $dateCurrent){
                                $activity .= '<div class="block-date">' . date_format(date_create($value['createdAt']), "F j, Y") .'
                                </div>';
                            }
                            $activity .= '<div class="block-info-activity d-flex">
                                <div class="block-img">
                                    <img src="'.base_url($avatar) .'" alt=""/>
                                </div>
                                <div class="block-info">
                                    <div class="author">'.$value['user']['name'].'</div>
                                    <div class="time-publishing">
                                        updated on '.date_format(date_create($value['createdAt']), "m/d/Y h:i A").'
                                    </div>
                                </div>
                            </div>
                            <div class="block-detail">
                                <div class="title-activity">'.$value['comment'].'</div>
                                <div class="description-activity">
                                    <ul>';
                            foreach ($value['detail'] as $detail => $content) {
                                $activity .= '<li>' . $content . '</li>';
                            }
                            $activity .= '</ul>
                                </div>
                            </div>
                        </div>';
                        }
                    }
                    $dateCurrent = date_format(date_create($value['createdAt']), "dmY");
                    $index++;
                }
            }

            echo json_encode($activity);
        }
        elseif ($type == 'relations'){
            $relations = array();
            if (!empty($responseTask->_links->children)) {
                foreach ($responseTask->_links->children as $variableChild => $valueChild) {
                    $url = str_replace("/api/v3/", "", $valueChild->href);
                    $url = $this->config->config['api_url'] . $url;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_USERPWD, $this->OPapiKey);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    $responseChild = curl_exec($ch);
                    curl_close($ch);

                    $responseChild = json_decode($responseChild);
                    array_push($relations, $responseChild);
                }
            }

            if (!empty($relations)){
                $result = '';
                foreach ($relations as $key => $relation){
                    $result .= '<tr>
                    <td class="ordinal-number" id="ordinal-number">
                        <a href="'. base_url('auth/project/'.$responseTask->_embedded->project->identifier.'/work-package/edit/' . $relation->id) .'">'.$relation->id.'</a>
                    </td>
                    <td class="">
                      <button class="btn btn-sm dropdown-toggle btn-action btn-update-type-relation" type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"
                              data-id="'.$relation->_embedded->type->id.'">
                          '.$relation->_embedded->type->name.'
                      </button>
                      <div class="dropdown-menu" x-placement="top-start"
                           style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(719px, 521px, 0px);">
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="1">Task</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="2">Milestone</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="3">Phase</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="5">Epic</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="6">User story</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                           data-work_packageID="'.$relation->id.'" data-id="7">Bug</a>
                      </div>
                    </td>
                    <td>
                        '.$relation->subject.'
                    </td>
                    <td class="">
                      <button class="btn btn-sm dropdown-toggle btn-action btn-update-status-relation" type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"
                              data-id="'.$relation->_embedded->status->id.'">
                          '.$relation->_embedded->status->name.'
                      </button>
                      <div class="dropdown-menu" x-placement="top-start"
                           style="position: absolute; transform: translate3d(1007px, 521px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="1">New</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="7">In progress</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="17">Need Review</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="18">ReOpen</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="16">Done</a>
                        <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                           data-work_packageID="'.$relation->id.'" data-id="13">Closed</a>
                      </div>
                    </td>
                  </tr>';
                }
                echo $result;
            }
        }
        elseif ($type == 'watches'){
            $watchers = array();
            $checkWatched = null;
            if (!empty($responseTask->_embedded->watchers->_embedded->elements)){
                foreach ($responseTask->_embedded->watchers->_embedded->elements as $key => $watcher){
                    $watcher = array(
                      'name' => $watcher->name,
                      'id' => $watcher->id,
                      'userSmnID' => $this->useraccount->get_info_rule(array('user_op_ID' => $watcher->id))->id
                    );
                    if ($watcher['userSmnID'] == $this->userID){
                        $checkWatched = $watcher['id'];
                    }
                    array_push($watchers, $watcher);
                }
            }

            if (!empty($watchers)){
                $result = '';
                foreach ($watchers as $key => $watcher){
                    $avatar_jpg = 'uploads/userfiles/' . $watcher['userSmnID'] . '/profilePhoto.jpg';
                    if (file_exists($avatar_jpg)) {
                        $avatar = $avatar_jpg . '?' . time();
                    } else {
                        $avatar = 'assets/images/img-avatar-default.png';
                    }
                    $result .= '<div class="block-info-activity d-flex tab-watches" id="watcher_'.$watcher['id'].'">
                    <div class="block-img">
                      <img src="'.base_url($avatar).'" alt="">
                    </div>
                    <div class="block-info">
                      <div class="author">'.$watcher['name'].'</div>
                    </div>
                  </div>';
                }
                echo $result;
            }
        }
    }

    public function copyTask($identifier, $idTask)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $url = $this->GetUrlMember();
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $this->data['list_member'] = $elements;
        }

        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships";
        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);
        if (!empty($responseMemberships->_embedded)) {
            $elementsMemberships = $responseMemberships->_embedded->elements;
            $this->data['list_memberships'] = $elementsMemberships;
        }

        $listProject = $this->getListProject();

        $url = $this->GetUrlTask(null, $idTask);

        $responseTask = $this->CurlSetup($url, "get");
        $responseTask = json_decode($responseTask);
        $this->session->set_userdata('listProject', $listProject);
        $this->session->set_userdata('responseTask', $responseTask);
        $this->data['identifier'] = $identifier;
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['identifier'] = $identifier;
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_work_package_copy_task';
        $this->auth_project_layout();

    }

    public function createChild($identifier, $idTask, $type = 1)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $url = $this->GetUrlMember();
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $this->data['list_member'] = $elements;
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships";
        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);
        if (!empty($responseMemberships->_embedded)) {
            $elementsMemberships = $responseMemberships->_embedded->elements;
            $this->data['list_memberships'] = $elementsMemberships;
        }

        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;
        }

        $this->form_validation->set_rules('subject', '', 'trim|required');
        $this->form_validation->set_rules('percentageDone', '', 'trim|required');
        if ($this->form_validation->run()) {
            $subject = $this->input->post('subject');
            $remainingTime = $this->input->post('remaining-hours');
            $storyPoints = null;
            $parentID = $idTask;
            $raw = strip_tags($this->input->post('description_document'));
            $assignee = $this->input->post('assignee');
            $estimatedTime = $this->input->post('estimatedTime');
            $startDate = $this->input->post('startDate');
            if ($startDate != null) {
                $startDate = date("Y-m-d", strtotime($startDate));
            }
            $dueDate = $this->input->post('endDate');
            if ($dueDate != null) {
                $dueDate = date("Y-m-d", strtotime($dueDate));
            }
            $dateMileStone = $this->input->post('dateMileStone');
            if ($dateMileStone != null) {
                $dateMileStone = date("Y-m-d", strtotime($dateMileStone));
            }
            $version = $this->input->post('version');
            $percentageDone = $this->input->post('percentageDone');
            $priority = $this->input->post('priority');
            $category = $this->input->post('category');
            $attachFile = $this->input->post('attachFile');
            $accountable = $this->input->post('accountable');
            $dataArray = $this->GetDataArray($raw, $subject, $startDate, $dueDate, $estimatedTime, $percentageDone,
              $priority, $category, $version, $assignee, $attachFile, $accountable, $type, $storyPoints, $remainingTime,
              $dateMileStone, $parentID);
            $url = $this->GetUrlTask($identifier);
            $response = $this->CurlSetup($url, "post", $dataArray);
            $response = json_decode($response);

            if (!empty($response->id)){
                $urlAddAttachment = $this->config->config['api_url'] . "work_packages/" . $response->id . "/attachments";
                $data = array(
                  'fileName' => $_FILES['file']['name']
                );
                $this->CurlSetupFile($urlAddAttachment, $data);
            }
            redirect(base_url('auth/project/' . $identifier . '/work-package/'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
        $this->data['identifier'] = $identifier;
        $this->data['type'] = $type;
        $this->data['idTask'] = $idTask;
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_work_package_create_child';
        $this->auth_project_layout();
    }

    public function deleteTask($idProject, $idTask)
    {
        $url = $this->GetUrlTask(null, $idTask);
        $response = $this->CurlSetup($url, "delete");
        redirect(base_url('auth/project/' . $idProject . '/work-package/'));

    }

    public function workPackageMove($idProject, $idTask)
    {
        $listProject = $this->getListProject();
        $url = $this->GetUrlTask(null, $idTask);
        $responseTask = $this->CurlSetup($url, "get");
        $responseTask = json_decode($responseTask);
        $this->session->set_userdata('listProject', $listProject);
        $this->session->set_userdata('responseTask', $responseTask);
        $this->data['idProject'] = $idProject;
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_work_package_move';
        $this->auth_project_layout();
    }

    public function logUnitCosts($identifier)
    {
        $this->session->set_userdata('active_project_sidebar', 'Work Package');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_work_package_log_unit_costs';
        $this->data['identifier'] = $identifier;
        $this->auth_project_layout();
    }

    public function check_pid_order()
    {
        $pid = $this->input->post('pid');
        $identifier = $this->changeTitle($pid);
        $identifier = $this->stripSpecial($identifier);
        $where = array('identifierPID' => $identifier);
        $pid_item = $this->project->get_info_rule($where);
        if ($this->project->check_pid_exists($identifier)) {
            $this->form_validation->set_message(__FUNCTION__,
              'Sorry, identifier is already taken. Please enter a different PID.');
            return false;
        }
        return true;
    }

    public function orderPID($id = 1)
    {
        $this->deleteProjectUnpaid();
        $user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        $this->form_validation->set_rules('pid', '', 'trim|required|callback_check_pid_order');
        $this->form_validation->set_rules('contactFirstName', 'contact first name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
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

        if ($this->form_validation->run()) {
            $pid = $this->input->post('pid');
            $identifier = $this->changeTitle($pid);
            $identifier = $this->stripSpecial($identifier);

            $data = array(
              'pid' => $pid,
              'idUser' => $user->id,
              'identifierPID' => $identifier,
              'contactFirstName' => $this->input->post('contactFirstName'),
              'contactLastName' => $this->input->post('contactLastName'),
              'contactEMail' => $this->input->post('contactEMail'),
              'billingAffiliation' => $this->input->post('billingAffiliation'),
              'billingStreet' => $this->input->post('billingStreet'),
              'billingStreetNr' => $this->input->post('billingStreetNr'),
              'billingCity' => $this->input->post('billingCity'),
              'billingPostalCode' => $this->input->post('billingPostalCode'),
              'billingCountry' => $this->input->post('billingCountry'),
              'billingState' => $this->input->post('billingState')
            );

            if ($this->project->create($data)) {
                $this->session->set_userdata('pid', $pid);
                redirect(base_url('/auth/project/' . $identifier . '/project-info-order-pid'));
            }
        }
        $this->data['active_project_sidebar'] = 'OrderPID';
        $this->data['idProject'] = $id;
        $this->auth_page = 'order_pid';
        $this->auth_project_layout();
    }

    public function documents($identifier)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Documents');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;

        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $url = $this->config->config['api_url'] . "documents";
            $response = $this->CurlSetup($url, "get");
            $response = json_decode($response);
            $linkProject = '/api/v3/projects/' . $idProject->id;
            $documents = array();
            foreach ($response->_embedded->elements as $key => $value) {
                if ($value->_links->project->href == $linkProject) {
                    $document = array(
                      'id' => $value->id,
                      'href' => $value->_links->project->href,
                      'title' => $value->title,
                      'createdAt' => $value->createdAt,
                      'description' => $value->description->html
                    );
                    array_push($documents, $document);
                }
            }
            $this->data['identifier'] = $identifier;
            $this->data['documents'] = $documents;
            $this->auth_page = 'project_document';
            $this->auth_project_layout();
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function addDocument($identifier = 1)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Documents');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;

        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->form_validation->set_rules('title', 'title', 'required');
            if ($this->form_validation->run()) {
                $title = $this->input->post('title');
                $category = 11;
                $description = $this->input->post('description_document');
                $runCMD = $this->config->config['run_CMD'];
                $runCMD = '' . $runCMD . ' "Document.create(title: \'' . $title . '\', category_id: ' . $category . ',project_id:' . $idProject->id . ',description: \'' . $description . '\');"';
                exec($runCMD);

                if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                    $url = $this->config->config['api_url'] . "documents";
                    $response = $this->CurlSetup($url, "get");
                    $response = json_decode($response);
                    $linkProject = '/api/v3/projects/' . $idProject->id;
                    $documentID = null;
                    foreach ($response->_embedded->elements as $key => $value) {
                        if ($value->_links->project->href == $linkProject) {
                            $documentID = $value->id;
                        }
                    }
                    if (!empty($documentID)) {
                        $urlAddAttachment = $this->config->config['api_url'] . "documents/" . $documentID . "/attachments";
                        $data = array(
                          'fileName' => $_FILES['file']["name"]
                        );
                        $this->CurlSetupFile($urlAddAttachment, $data);
                    }
                }

                redirect(base_url('auth/project/' . $identifier . '/documents'));
            }
            $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
            $this->data['identifier'] = $identifier;
            $this->auth_page = 'project_document_add';
            $this->auth_project_layout();
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function documentEdit($identifier, $id)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Documents');
        $this->data['identifier'] = $identifier;

        $this->form_validation->set_rules('title', 'title', 'required');
        if ($this->form_validation->run()) {
            $title = $this->input->post('title');
            $category = 11;
            $description = $this->input->post('description_document');
            $runCMD = $this->config->config['run_CMD'];
            $runCMD = '' . $runCMD . ' "Document.update(' . $id . ' ,{ title: \'' . $title . '\', category_id: ' . $category . ',description: \'' . $description . '\'});"';
            exec($runCMD);

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $urlAddAttachment = $this->config->config['api_url'] . "documents/" . $id . "/attachments";
                $data = array(
                  'fileName' => $_FILES['file']["name"]
                );
                $this->CurlSetupFile($urlAddAttachment, $data);
            }

            redirect(base_url('auth/project/' . $identifier . '/document-detail/' . $id));
        }

        $url = $this->config->config['api_url'] . "documents/" . $id;
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        $attachmentList = array();
        foreach ($response->_embedded->attachments->_embedded->elements as $key => $element) {
            $attachment = array(
              'id' => $element->id,
              'fileName' => $element->fileName,
              'link' => 'http://pm.web.beesightsoft.com/attachments/' . $element->id . '/' . $element->fileName,
              'author' => $element->_links->author->title,
              'countTime' => $this->countTime($element->createdAt),
              'createdAt' => $element->createdAt
            );
            array_push($attachmentList, $attachment);
        }

        $this->data['username'] = $this->user->firstName . ' ' . $this->user->lastName;
        $this->data['documentID'] = $id;
        $this->data['attachmentList'] = $attachmentList;
        $this->data['title'] = $response->title;
        $this->data['description'] = $response->description->html;
        $this->data['createdAt'] = $response->createdAt;
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_document_edit';
        $this->auth_project_layout();
    }

    public function documentDetail($identifier, $id)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $this->session->set_userdata('active_project_sidebar', 'Documents');
        $this->data['identifier'] = $identifier;

        $url = $this->config->config['api_url'] . "documents/" . $id;
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        $attachmentList = array();

        foreach ($response->_embedded->attachments->_embedded->elements as $key => $element) {
            $attachment = array(
              'id' => $element->id,
              'fileName' => $element->fileName,
              'link' => 'http://pm.web.beesightsoft.com/attachments/' . $element->id . '/' . $element->fileName,
              'author' => $element->_links->author->title,
              'countTime' => $this->countTime($element->createdAt),
              'createdAt' => $element->createdAt
            );
            array_push($attachmentList, $attachment);
        }

        $this->data['documentID'] = $id;
        $this->data['attachmentList'] = $attachmentList;
        $this->data['title'] = $response->title;
        $this->data['description'] = $response->description->html;
        $this->data['createdAt'] = $response->createdAt;
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->auth_page = 'project_document_detail';
        $this->auth_project_layout();
    }

    public function getAttachment($attachmentID){
        $url = $this->config->config['api_url'] . "attachments/" . $attachmentID;
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);

        if (!empty($response)){
            $this->makeObjectDir($this->userID, 'attachment');

            $files = glob(FCPATH . 'uploads/userfiles/' . $this->userID . '/attachment/*' );
            if(is_file($files[0])){
                unlink($files[0]);
            }

            $dir_path = FCPATH . 'uploads/userfiles/' . $this->userID . '/attachment/';

            $urlAttachment = 'http://pm.web.beesightsoft.com/' . $response->_links->downloadLocation->href;
            $this->CurlSetupDownloadFile($urlAttachment, $response->fileName, $dir_path);

            redirect(base_url('/uploads/userfiles/' . $this->userID . '/attachment/' . $response->fileName));
        }
        else{
            redirect(base_url('404_override'));
        }
    }

    public function calendar($identifier)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $url = $this->GetUrlTask($identifier);
        if ($this->input->post('statusFilter')) {
            if ($this->input->post('statusFilter') == "=") {
                if ($this->input->post('statusTask')) {
                    $valuesFilter = '&filters=[{"status":{"operator":"=","values":["';
                    foreach ($_POST['statusTask'] as $variable => $value) {
                        $valuesFilter = $valuesFilter . $value . '","';
                    }
                    $valuesFilter = $valuesFilter . ']}}]';
                    $valuesFilter = str_replace(",\"]}}]", "]}}]", $valuesFilter);
                } else {
                    $valuesFilter = "";
                }
            } elseif ($this->input->post('statusFilter') == "!") {
                $valuesFilter = '&filters=[{"status":{"operator":"!","values":["';
                if ($this->input->post('statusTask')) {
                    foreach ($_POST['statusTask'] as $variable => $value) {
                        $valuesFilter = $valuesFilter . $value . '","';
                    }
                    $valuesFilter = $valuesFilter . ']}}]';
                    $valuesFilter = str_replace(",\"]}}]", "]}}]", $valuesFilter);
                } else {
                    $valuesFilter = "";
                }
            } elseif ($this->input->post('statusFilter') == "o") {
                $valuesFilter = '&filters=[{"status":{"operator":"o","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            } elseif ($this->input->post('statusFilter') == "*") {
                $valuesFilter = '&filters=[{"status":{"operator":"*","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            } elseif ($this->input->post('statusFilter') == "c") {
                $valuesFilter = '&filters=[{"status":{"operator":"c","values":["1","7","17","18","16","13","3","2","5","4","6","8","9"]}}]';
            }
            if ($this->input->post('filter-text')) {
                $filterText = $this->input->post('filter-text');
                if ($this->input->post('statusTask')) {
                    $valuesFilter = str_replace("]}}]", "]}}", $valuesFilter);
                    $valuesFilter = $valuesFilter . ',{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
                } else {
                    $valuesFilter = '&filters=[{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
                }
            }
            $url = $this->GetUrlTask($identifier) . $valuesFilter;
            $url = str_replace("&", "?", $url);
            $url = $url . "&sortBy=[[%20\"startDate\",%20\"asc\"]]";

        } elseif ($this->input->post('filter-text') && !$this->input->post('statusFilter')) {
            $filterText = $this->input->post('filter-text');
            $valuesFilter = '?filters=[{"search":{"operator":"**","values":["' . $filterText . '"]}}]';
            $url = $url . $valuesFilter . "&sortBy=[[%20\"startDate\",%20\"asc\"]]";
        } else {
            $url = $url . '?sortBy=[[%20"startDate",%20"asc"]]';
        }
        $url1 = $url . '&pageSize=500';
        $response = $this->CurlSetup($url1, "get");
        $response = json_decode($response);
        if ($response->total > 500){
            $url2 = $url . '&pageSize=500&offset=2';
            $response = $this->CurlSetup($url2, "get");
            $response = json_decode($response);
            if ($response->total > 1000){
                $url3 = $url . '&pageSize=500&offset=3';
                $response = $this->CurlSetup($url3, "get");
                $response = json_decode($response);
            }
        }
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $this->data['list_project'] = $elements;
        }
        $this->session->set_userdata('active_project_sidebar', 'Calendar');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->data['identifier'] = $identifier;
        $this->auth_page = 'project_calendar';
        $this->auth_project_layout();
    }

    public function taskDetailCalendar($id = 1)
    {
        $url = $this->GetUrlTask($id);
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        $elements = $response->_embedded->elements;
        $this->session->set_userdata('active_project_sidebar', 'Calendar');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->data['list_project'] = $elements;//array('a' => array(1, 2, 3), 'b'=> array('Yes!', 'No','Maybe'), 'c' => array('foo'=>57, 'bar'=>123));
        $this->data['idProject'] = $id;
        $this->auth_page = 'project_calendar_task_detail';
        $this->auth_project_layout();
    }

    public function member($identifier)
    {
        if (!$this->checkProjectPermission($identifier)){
            redirect(base_url('404_override'));
        }
        $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);
        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;
        }

        $urlMemberships = $this->config->config['api_url'] . "memberships?pageSize=500";
        if (isset($_POST['sharePublic'])) {
            $roles_ids = $_POST['sharePublic'];
            $role_id = "";
            foreach ($roles_ids as $variable => $value) {
                $role_id = $role_id . $value . ",";
            }
            $role_id = $role_id . ")))";
            $role_id = str_replace(",)))", "", $role_id);
            $id_memberships = $_POST['id-membership'];
            $id_user = $_POST['id-user'];
            $runCMD = $this->config->config['run_CMD'];
            $runCMD = '' . $runCMD . ' "Member.update(' . $id_memberships . ', {role_ids: [' . $role_id . '], user_id: ' . $id_user . '});"';
            // Member.update(45, {role_ids: [3], user_id: 17});
            exec($runCMD);
            redirect(base_url('/auth/project/' . $identifier . '/member'));
        }

        $responseMemberships = $this->CurlSetup($urlMemberships, "get");
        $responseMemberships = json_decode($responseMemberships);
        if (!empty($responseMemberships->_embedded)) {
            $elementsMemberships = $responseMemberships->_embedded->elements;

            if ($responseMemberships->total > 500) {
                $urlMemberships2 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=2";
                $responseMemberships2 = $this->CurlSetup($urlMemberships2, "get");
                $responseMemberships2 = json_decode($responseMemberships2);
                $elementsMemberships2 = $responseMemberships2->_embedded->elements;
                foreach ($elementsMemberships2 as $valueOffset2) {
                    array_push($elementsMemberships, $valueOffset2);
                }
                if ($responseMemberships->total > 1000) {
                    $urlMemberships3 = $this->config->config['api_url'] . "memberships?pageSize=500&offset=3";
                    $responseMemberships3 = $this->CurlSetup($urlMemberships3, "get");
                    $responseMemberships3 = json_decode($responseMemberships3);
                    $elementsMemberships3 = $responseMemberships3->_embedded->elements;
                    foreach ($elementsMemberships3 as $valueOffset3) {
                        array_push($elementsMemberships, $valueOffset3);
                    }
                }
            }
            $this->data['list_memberships'] = $elementsMemberships;
            $this->data['response'] = $responseMemberships;
        }
        $adminProject = $this->project->get_info_rule(array('identifierPID' => $identifier));
        if ($adminProject->idUser == $this->user->id) {
            $this->data['adminProject'] = $adminProject->idUser;
        }
        $url = $this->GetUrlMember();
        $response = $this->CurlSetup($url, "get");
        $response = json_decode($response);
        if (!empty($response->_embedded)) {
            $elements = $response->_embedded->elements;
            $nameUser = $this->user->firstName;
            $nameUser = $nameUser . " " . $this->user->lastName;
            $this->data['nameUser'] = $nameUser;
            $this->data['list_member'] = $elements;
        }
        $this->session->set_userdata('active_project_sidebar', 'Member');
        $this->data['active_project_sidebar'] = $this->session->active_project_sidebar;
        $this->data['identifier'] = $identifier;
        $this->auth_page = 'project_member';
        $this->auth_project_layout();
    }

    public function addMember($identifier)
    {
        $idProject = $this->config->config['api_url'] . "projects/" . $identifier;
        $idProject = $this->CurlSetup($idProject, "get");
        $idProject = json_decode($idProject);

        if (!empty($idProject->id)) {
            $this->data['idProject'] = $idProject->id;
        }
        $urlMemberships = $this->config->config['api_url'] . "memberships?pageSize=500";
        if (isset($_POST['add-member'])) {
            $addMember = $_POST['add-member'];
            $rolesMember = $_POST['roles-member'];
            $dataArray = array(
              'project' =>
                array(
                  'href' => '/api/v3/projects/' . $idProject->id,
                ),
              'principal' =>
                array(
                  'href' => '/api/v3/users/' . $addMember,
                ),
              'roles' =>
                array(
                  0 =>
                    array(
                      'href' => '/api/v3/roles/' . $rolesMember,
                    ),
                ),
            );
            $identifierPID = $identifier;
            $opprojectUserID = $addMember;
            $pidRecord = $this->project->get_list_project(array('identifierPID' => $identifierPID));
            $pid = $pidRecord[0]->pid;
            $pidUser = $pidRecord[0]->idUser;
            $urlUser = $this->config->config['api_url'] . "users/" . $addMember;
            $responseInfoUser = $this->CurlSetup($urlUser, "get");
            $responseInfoUser = json_decode($responseInfoUser);
            $firstName = $responseInfoUser->firstName;
            $lastName = $responseInfoUser->lastName;
            $email = $responseInfoUser->login;
            $user = $this->useraccount->get_info_rule(array('email' => $email));
            $idUser = $user->id;
            $data = array(
              'opprojectUserID' => $opprojectUserID,
              'idUser' => $idUser,
              'identifierPID' => $identifierPID,
              'pid' => $pid,
              'firstName' => $firstName,
              'lastName' => $lastName,
              'email' => $email
            );
            if ($idUser != $pidUser) {
                $data['host'] = "0";
            } else {
                $data['host'] = "1";
            }
            $this->membership->create($data);
            $response = $this->CurlSetup($urlMemberships, "post", $dataArray);
            $response = json_decode($response);
            if ($response->_type != 'Error') {
                $username = $firstName . ' ' . $lastName;
                if ($rolesMember == 8){
                    $role = 'Qa';
                }
                elseif ($rolesMember == 3){
                    $role = 'Project admin';
                }
                elseif ($rolesMember == 5){
                    $role = 'Internship';
                }
                elseif ($rolesMember == 4){
                    $role = 'Member';
                }
                elseif ($rolesMember == 7){
                    $role = 'Developer';
                }
                $this->sendMailAddMember($email, $username, $idProject->name, $role);
            }
            redirect(base_url('/auth/project/' . $identifier . '/member'));
        }
    }

    public function deleteMember($identifier, $id_memberships, $idUser)
    {
        $urlUser = $this->config->config['api_url'] . "users/" . $idUser;
        $responseInfoUser = $this->CurlSetup($urlUser, "get");
        $responseInfoUser = json_decode($responseInfoUser);
        $dataUserDelete = array(
          'identifierPID' => $identifier,
          'idUser' => $idUser
        );
        $runCMD = $this->config->config['run_CMD'];
        $runCMD = '' . $runCMD . ' "Member.delete(' . $id_memberships . ');"';
        exec($runCMD);
        $this->membership->del_rule($dataUserDelete);
        redirect(base_url('auth/project/' . $identifier . '/member/'));
    }

    public function addContent()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $work_packageID = $this->input->post('work_packageID');
        $type = $this->input->post('type');
        $status = $this->input->post('status');
        $identifier = $this->input->post('identifier');
        $subject = $this->input->post('subject');
        $check = 'success';
        if ($name == 'activities') {

            $data = array(
              'comment' => array(
                'raw' => $value
              )
            );

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url . '/' . $name, "post", $data);
        } elseif ($name == 'createNewChild') {
            $dataArray = array(
              'subject' => $subject,
              '_links' =>
                array(
                  'type' =>
                    array(
                      'href' => '/api/v3/types/' . $type,
                    ),
                  'status' =>
                    array(
                      'href' => '/api/v3/statuses/' . $status,
                    )
                )
            );
            $dataArray['_links']['parent']['href'] = "/api/v3/work_packages/$work_packageID";
            $url = $this->GetUrlTask($identifier);
            $response = $this->CurlSetup($url, "post", $dataArray);
        } elseif ($name == 'createTask') {
            $dataArray = array(
              'subject' => $subject,
              '_links' =>
                array(
                  'type' =>
                    array(
                      'href' => '/api/v3/types/' . $type,
                    ),
                  'status' =>
                    array(
                      'href' => '/api/v3/statuses/' . $status,
                    )
                ),
              'startDate' => date("Y-m-d")
            );
            $url = $this->GetUrlTask($identifier);
            $response = $this->CurlSetup($url, "post", $dataArray);
        } elseif ($name == 'watchers') {
            $data = array(
              'user' => array(
                'href' => "/api/v3/users/" . $this->user->user_op_ID
              )
            );

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url . '/' . $name, "post", $data);
        }

        $response = json_decode($response);
        if ($response->_type == 'Error') {
            $msg = $response->message;
            $check = 'fail';
        } else {
            $msg = 'Successful';
            if ($name == 'watchers'){
                $msg = 'Add watcher successfully';
            }
        }

        echo json_encode(array('status' => $check, 'msg' => $msg));
    }

    public function updateContent()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $work_packageID = $this->input->post('work_packageID');
        $identifier = $this->input->post('identifier');
        $status = 'success';
        $response = null;

        $lockVersion = $this->GetlockVersion($work_packageID);
        $dataArray = array(
          'lockVersion' => $lockVersion
        );
        if ($name == 'type') {
            $dataArray['_links']['type']['href'] = '/api/v3/types/' . $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        } elseif ($name == 'status') {
            $dataArray['_links']['status']['href'] = '/api/v3/statuses/' . $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'description'){
            $dataArray['description']['raw'] =  $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'assignee'){
            $dataArray['_links']['assignee']['href'] = '/api/v3/users/' . $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'accountable'){
            $dataArray['responsible']['href'] = '/api/v3/users/' . $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'estimatedTime'){
            if (!empty($value)){
                if ($value < 24) {
                    $resultEstimatedTime = "PT" . $value . "H";
                } else {
                    $hourEstimated = $value % 24;
                    $dayEstimated = ($value - $hourEstimated) / 24;
                    if ($hourEstimated == 0) {
                        $resultEstimatedTime = "P" . $dayEstimated . "D";
                    } else {
                        $resultEstimatedTime = "P" . $dayEstimated . "DT" . $hourEstimated . "H";
                    }
                }

                $dataArray['estimatedTime'] = $resultEstimatedTime;
            }
            else{
                $dataArray['estimatedTime'] = 'PT0S';
            }

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'remainingTime'){
            if (!empty($value)){
                if ($value < 24) {
                    $resultRemainingTime = "PT" . $value . "H";
                } else {
                    $hourEstimated = $value % 24;
                    $dayEstimated = ($value - $hourEstimated) / 24;
                    if ($hourEstimated == 0) {
                        $resultRemainingTime = "P" . $dayEstimated . "D";
                    } else {
                        $resultRemainingTime = "P" . $dayEstimated . "DT" . $hourEstimated . "H";
                    }
                }

                $dataArray['remainingTime'] = $resultRemainingTime;
            }
            else{
                $dataArray['remainingTime'] = 'PT0S';
            }

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'storyPoints'){
            $dataArray['storyPoints'] = $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'startDate'){
            $startDate = date("Y-m-d", strtotime($value));
            $dataArray['startDate'] = $startDate;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'dueDate'){
            $dueDate = date("Y-m-d", strtotime($value));
            $dataArray['dueDate'] = $dueDate;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'date'){
            $date = date("Y-m-d", strtotime($value));
            $dataArray['date'] = $date;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'percentageDone'){
            $dataArray['percentageDone'] = $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'priority'){
            $dataArray['_links']['priority']['href'] = '/api/v3/priorities/' . $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'version'){
            $dataArray['_links']['version']['href'] = $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }
        elseif ($name == 'category'){
            $dataArray['_links']['category']['href'] = $value;

            $url = $this->GetUrlTask(null, $work_packageID);
            $response = $this->CurlSetup($url, "patch", $dataArray);
        }


        $response = json_decode($response);
        if ($response->_type == 'Error') {
            $msg = $response->message;
            $status = 'fail';
        } else {
            $msg = 'Successful update.';
            if ($name == 'assignee'){
                $workPackageTitle = $response->subject;
                $type = substr($response->_links->type->href, 14, 1);
                if ($type == 1){
                    $workPackageType = 'Task';
                }
                elseif ($type == 2){
                    $workPackageType = 'Milestone';
                }
                elseif ($type == 3){
                    $workPackageType = 'Phase';
                }
                elseif ($type == 4){
                    $workPackageType = 'Feature';
                }
                elseif ($type == 5){
                    $workPackageType = 'Epic';
                }
                elseif ($type == 6){
                    $workPackageType = 'User story';
                }
                elseif ($type == 7){
                    $workPackageType = 'Bug';
                }
                if (!empty($response->_links->assignee->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $value));
                    $email = $user->email;
                    $username = $response->_links->assignee->title;
                    $type = 'Assignee';
                    $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                    $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);

                    $msg = $username;
                }
            }
            elseif ($name == 'accountable'){
                $workPackageTitle = $response->subject;
                $type = substr($response->_links->type->href, 14, 1);
                if ($type == 1){
                    $workPackageType = 'Task';
                }
                elseif ($type == 2){
                    $workPackageType = 'Milestone';
                }
                elseif ($type == 3){
                    $workPackageType = 'Phase';
                }
                elseif ($type == 4){
                    $workPackageType = 'Feature';
                }
                elseif ($type == 5){
                    $workPackageType = 'Epic';
                }
                elseif ($type == 6){
                    $workPackageType = 'User story';
                }
                elseif ($type == 7){
                    $workPackageType = 'Bug';
                }
                if (!empty($response->_links->responsible->href)){
                    $user = $this->useraccount->get_info_rule(array('user_op_ID' => $value));
                    $email = $user->email;
                    $username = $response->_links->responsible->title;
                    $type = 'Accountable';
                    $url = base_url('auth/project/work-package/detail/'.$user->id . '/' .$identifier.'/' . $response->id);
                    $this->sendMailAddAssign($email, $username, $workPackageTitle, $workPackageType, $type, $url);
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function uploadAttachment($id){
        $status = 'success';
        $response = null;

        $urlAddAttachment = $this->config->config['api_url'] . "work_packages/" . $id . "/attachments";
        $data = array(
          'fileName' => $_FILES['file']['name']
        );
        $response = $this->CurlSetupFile($urlAddAttachment, $data);

        $response = json_decode($response);
        if ($response->_type == 'Error') {
            $msg = $response->message;
            $status = 'fail';
        }
        else{
            $msg = $response->id;
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function deleteContent()
    {
        $name = $this->input->post('name');
        $attachmentID = $this->input->post('attachmentID');
        $work_packageID = $this->input->post('work_packageID');
        $userID = $this->input->post('userID');
        $status = 'success';
        $response = null;

        if ($name == 'attachments') {
            $url = $this->config->config['api_url'] . $name . '/' . $attachmentID;
            $response = $this->CurlSetup($url, "delete");
        }
        elseif ($name == 'watchers'){
            $url = $this->config->config['api_url'] . 'work_packages/' . $work_packageID . '/' . $name . '/' . $userID;
            $response = $this->CurlSetup($url, "delete");
        }

        $response = json_decode($response);
        if (!empty($response) && $response->_type == 'Error') {
            $msg = $response->message;
            $status = 'fail';
        } else {
            $msg = 'Deleted successfully';
            if ($name == 'watchers'){
                $msg = 'Remove watcher successfully';
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function documentDelete()
    {
        $documentID = $this->input->post('documentID');

        $runCMD = $this->config->config['run_CMD'];
        $runCMD = '' . $runCMD . ' "Document.delete(' . $documentID . ');"';
        exec($runCMD);

        $status = 'success';
        $msg = '';
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function changeFormatGanttChart($formatRequest){
        if ($formatRequest == 'day'){
            $this->session->set_userdata('formatGanttChart', 'day');
        }
        else{
            $this->session->set_userdata('formatGanttChart', 'month');
        }
    }
}
