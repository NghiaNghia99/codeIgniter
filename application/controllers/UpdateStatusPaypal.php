<?php

/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 30-May-19
 * Time: 15:15
 */

require FCPATH  . '/vendor/autoload.php';
use PayPal\Api\Sale;

class UpdateStatusPaypal extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('useraccount');
        $this->load->model('conferenceregistration');
        $this->load->helper('url_helper', 'form', 'date');
        $this->load->library('session');
        $this->load->library('email');
    }

    public function index(){

        $where = array(
          'status !=' => 'Denied',
          'status !=' => 'Refunded'
        );
        $registrations = $this->conferenceregistration->get_all_rule($where);

        if (!empty($registrations)) {
            foreach ($registrations as $registration){
                if (!empty($registration->saleID)) {
                    $sale = Sale::get($registration->saleID, $this->getApiContext(true));
                    $newStatus = $sale->state;
                    if ($registration->status != $newStatus) {
                        if ($newStatus == 'denied'){
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID, $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been denied by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason, 'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        }
                        elseif ($newStatus == 'refunded' || $newStatus == 'returned'){
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID, $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been refunded by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason, 'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        }
                        else{
                            $this->conferenceregistration->update($registration->ID, array('status' => $newStatus));
                        }
                    }
                }
            }
        }
    }
}