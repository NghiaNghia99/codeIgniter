<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:04
 */

class AuthController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project');
        $this->load->model('category');
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
        $this->load->model('domainblacklist');
        $this->load->model('pm');
        $this->load->helper('url_helper', 'form', 'date');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('pagination');
        $this->session->unset_userdata('get_category_id');
        $this->session->unset_userdata('get_subcategory_id');
//        $this->session->unset_userdata('summary_type');
    }

    public function check_email()
    {
        $email = $this->input->post('email');
        $where = array('email' => $email);
        $user = $this->useraccount->get_info_rule($where);
        if (!$this->useraccount->check_exists(array('email' => $email))) {
            $this->form_validation->set_message(__FUNCTION__, 'Please enter a registered Email');
            return false;
        } elseif ($user->active != 1) {
            $this->form_validation->set_message(__FUNCTION__, 'Account is not activated');
            return false;
        }
        return true;
    }

    public function check_email_active()
    {
        $email = $this->input->post('email');
        $where = array('email' => $email);
        $user = $this->useraccount->get_info_rule($where);
        if ($user && $user->active != 1) {
            $this->form_validation->set_message(__FUNCTION__, 'Account is not activated');
            return false;
        }
        return true;
    }

    public function check_email_register()
    {
        $email = $this->input->post('email');
        $where = array('email' => $email);
        $user = $this->useraccount->get_info_rule($where);
        if ($this->useraccount->check_exists(array('email' => $email)) && $user->active != 1) {
            redirect('register/error/' . $user->sid);
        } elseif ($this->useraccount->check_exists(array('email' => $email)) && $user->active == 1) {
            $this->form_validation->set_message(__FUNCTION__, 'This email address has already registered');
            return false;
        }
        return true;
    }

    public function sendEmailForgotPassword()
    {
        if ($this->useraccount->userIsLogin()) {
            redirect();
        }
        $email = $this->input->post('email');
        $this->form_validation->set_rules('email', 'email',
          array('trim','required','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));
        if ($this->form_validation->run()) {
            $where = array('email' => $email);
            $user = $this->useraccount->get_info_rule($where);
            if ($user) {
                $code = time() . rand(100, 9999);
                $this->useraccount->update($user->id, array('sid' => $code));
                $this->sendMailForgotPassword($user->email, $code);
                redirect('forgot-password/check-email');
            } else {
                redirect('forgot-password/check-email');
            }
        } else {
            $this->page = 'forgot_password';
            $this->layout();
        }
    }

    public function checkEmailForgotPassword()
    {
        $this->page = 'check_email_forgot_password';
        $this->layout();
    }

    public function forgotPassword($code)
    {
        if ($this->useraccount->userIsLogin()) {
            redirect();
        }
        $where = array('sid' => $code);
        $user = $this->useraccount->get_info_rule($where);
        if (empty($user)) {
            redirect();
        }
        $this->form_validation->set_rules('password', 'password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)'
          ));
        $this->form_validation->set_rules('re_password', 'repeat password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]|matches[password]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'matches' => 'Your password and repeat password do not match.'
          ));
        if ($this->form_validation->run()) {
            $new_password = md5($this->input->post('password'));
            $this->useraccount->update($user->id, array('sid' => '', 'password' => $new_password));
            redirect('login');
        }
        $this->data['user'] = $user;
        $this->page = 'reset_password';
        $this->layout();
    }

    public function check_subcategory()
    {
        $category = $this->input->post('category');
        $sub_category = $this->input->post('subcategory');
        $this->session->set_userdata('get_category_id', $category);
        $this->session->set_userdata('get_subcategory_id', $sub_category);
        if (!empty($category) && empty($sub_category)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please choose research topic');
            return false;
        }
        return true;
    }

    public function check_country()
    {
        $country = $this->input->post('country');
        if (!empty($country)) {
            $this->session->set_flashdata('get_country_name', $country);
        }
    }

    public function checkDomainEmailValid()
    {
        $email = $this->input->post('email');
        $checkEmail = $this->domainblacklist->checkDomainValid($email);

        echo json_encode($checkEmail);
    }

    public function register()
    {
        $this->session->unset_userdata('registration_info');
        if ($this->useraccount->userIsLogin()) {
            redirect();
        }
        $this->data['categories'] = array($this->useraccount->getCategories(), $this->useraccount->getSubCategories());
        $this->form_validation->set_rules('first_name', 'first name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('last_name', 'last name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('email', 'email',
          array('trim','required','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]','callback_check_email_register'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));
        $this->form_validation->set_rules('affiliation', 'affiliation',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('subcategory', '', 'callback_check_subcategory');
        $this->form_validation->set_rules('password', 'password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)'
          ));
        $this->form_validation->set_rules('re_password', 'repeat password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]|matches[password]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'matches' => 'Your password and repeat password do not match.'
          ));
        $this->form_validation->set_rules('check_terms', '', 'required',
          array(
            'required' => 'Please acknowledge the Terms and Conditions'
          ));
        $this->form_validation->set_rules('country', '', 'callback_check_country');

        $check_reCaptcha = false;
        $errMsg_reCaptcha = 'Recaptcha requires verification';
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $secret = $this->config->config['secret_key'];
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                $check_reCaptcha = true;
            } else {
                $errMsg_reCaptcha = 'Error verifying reCAPTCHA, please try again.';
            }
        }
        if ($this->form_validation->run()) {
            if ($check_reCaptcha) {
                $code = time() . rand(100, 9999);
                $email = $this->input->post('email');

                $checkEmail = $this->domainblacklist->checkDomainValid($email);

                if ($checkEmail){
                    $emailApproved = 1;
                }
                else{
                    $emailApproved = time();
                }

                $data = array(
                  'sid' => $code,
                  'firstName' => $this->input->post('first_name'),
                  'lastName' => $this->input->post('last_name'),
                  'email' => $email,
                  'password' => md5($this->input->post('password')),
                  'affiliation' => $this->input->post('affiliation'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'address' => $this->input->post('address'),
                  'postalCode' => $this->input->post('postalCode'),
                  'state' => $this->input->post('state'),
                  'city' => $this->input->post('city'),
                  'country' => $this->input->post('country'),
                  'dateOfRegistration' => time(),
                    'emailApproved' => $emailApproved
                );
                $newId = $this->useraccount->create($data);
                if ($newId) {
                    $user = $this->useraccount->get_info($newId);
                    $data_reminder = array(
                      'email' => $user->email,
                      'sid' => substr($user->sid, 0, 10),
                    );
                    if ($this->reminder->create($data_reminder)) {
                        $registration_info = array(
                          'firstName' => $data['firstName'],
                          'lastName' => $data['lastName'],
                          'email' => $data['email'],
                          'affiliation' => $data['affiliation'],
                          'category' => $data['category'],
                          'subcategory' => $data['subcategory'],
                          'address' => $data['address'],
                          'postalCode' => $data['postalCode'],
                          'state' => $data['state'],
                          'city' => $data['city'],
                          'country' => $data['country'],
                        );
                        $this->session->set_userdata('registration_info', $registration_info);

                        redirect('register/check-email/' . $code);
                    }
                }
            } else {
                $this->session->set_flashdata('errMsg_reCaptcha', $errMsg_reCaptcha);
            }
        }
        $this->session->set_userdata('get_category_id', $this->input->post('category'));
        $this->session->set_userdata('get_subcategory_id', $this->input->post('subcategory'));
        $this->data['categoryID'] = $this->session->get_category_id;
        $this->data['subCategoryID'] = $this->session->get_subcategory_id;
        $this->data['site_key'] = $this->config->config['site_key'];
        $this->page = 'register';
        $this->layout();
    }

    public function changeEmailRegister()
    {
        if ($this->useraccount->userIsLogin()) {
            redirect();
        }
        $this->data['categories'] = array($this->useraccount->getCategories(), $this->useraccount->getSubCategories());
        $this->form_validation->set_rules('first_name', 'first name',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('last_name', 'last name', 'trim|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('email', 'email',
          array('trim','required','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]','callback_check_email_register'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));
        $this->form_validation->set_rules('affiliation', 'affiliation',
          'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('subcategory', '', 'callback_check_subcategory');
        $this->form_validation->set_rules('password', 'password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)'
          ));
        $this->form_validation->set_rules('re_password', 'repeat password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]|matches[password]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'matches' => 'Your password and repeat password do not match.'
          ));
        $this->form_validation->set_rules('check_terms', '', 'required',
          array(
            'required' => 'Please acknowledge the Terms and Conditions'
          ));

        $check_reCaptcha = false;
        $errMsg_reCaptcha = 'Recaptcha requires verification';
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $secret = $this->config->config['secret_key'];
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                $check_reCaptcha = true;
            } else {
                $errMsg_reCaptcha = 'Error verifying reCAPTCHA, please try again.';
            }
        }
        if ($this->form_validation->run()) {
            if ($check_reCaptcha) {
                $code = time() . rand(100, 9999);
                $email = $this->input->post('email');

                $checkEmail = $this->domainblacklist->checkDomainValid($email);

                if ($checkEmail){
                    $emailApproved = 1;
                }
                else{
                    $emailApproved = time();
                }

                $data = array(
                  'sid' => $code,
                  'firstName' => $this->input->post('first_name'),
                  'lastName' => $this->input->post('last_name'),
                  'email' => $email,
                  'password' => md5($this->input->post('password')),
                  'affiliation' => $this->input->post('affiliation'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'address' => $this->input->post('address'),
                  'postalCode' => $this->input->post('postalCode'),
                  'state' => $this->input->post('state'),
                  'city' => $this->input->post('city'),
                  'country' => $this->input->post('country'),
                  'dateOfRegistration' => time(),
                    'emailApproved' => $emailApproved
                );
                if ($this->useraccount->create($data)) {
                    $user = $this->useraccount->get_info_rule(array('email' => $data['email']));
                    $data_reminder = array(
                      'email' => $user->email,
                      'sid' => substr($user->sid, 0, 10),
                    );
                    if ($this->reminder->create($data_reminder)) {
                        $registration_info = array(
                          'firstName' => $data['firstName'],
                          'lastName' => $data['lastName'],
                          'email' => $data['email'],
                          'affiliation' => $data['affiliation'],
                          'category' => $data['category'],
                          'subcategory' => $data['subcategory'],
                          'address' => $this->input->post('address'),
                          'postalCode' => $this->input->post('postalCode'),
                          'state' => $this->input->post('state'),
                          'city' => $this->input->post('city'),
                          'country' => $this->input->post('country'),
                        );
                        $this->session->set_userdata('registration_info', $registration_info);

                        redirect('register/check-email/' . $code);
                    }
                }
            } else {
                $this->session->set_flashdata('errMsg_reCaptcha', $errMsg_reCaptcha);
            }
        }
        if (isset($_SESSION['registration_info'])) {
            $this->data['user'] = $this->session->userdata('registration_info');
        }

        $this->session->set_userdata('get_category_id', $this->input->post('category'));
        $this->session->set_userdata('get_subcategory_id', $this->input->post('subcategory'));
        $this->data['categoryID'] = $this->session->get_category_id;
        $this->data['subCategoryID'] = $this->session->get_subcategory_id;
        $this->data['site_key'] = $this->config->config['site_key'];
        $this->page = 'register';
        $this->layout();
    }

    public function checkEmailActive($code)
    {
        $where = array('sid' => $code);
        $user = $this->useraccount->get_info_rule($where);
        if (empty($user)) {
            redirect();
        }
        $this->sendMailActiveAccount($user->id, $user->email);

        $this->data['user'] = $user;
        $this->page = 'check_email_active';
        $this->layout();
    }

    public function activeAccountError()
    {
        $this->page = 'active_account_error';
        $this->layout();
    }

    public function sendMailAgain($code)
    {
        $where = array('sid' => $code);
        $user = $this->useraccount->get_info_rule($where);
        if (empty($user)) {
            redirect('login');
        }
        $this->sendMailActiveAccount($user->id, $user->email);
        $this->data['user'] = $user;
        $this->page = 'send_mail_again';
        $this->layout();
    }

    public function sendMailActiveAccount($userId, $userEmail)
    {
        $new_code = time() . rand(100, 9999);
        $user = $this->useraccount->get_info($userId);
        if (!empty($user) && $this->useraccount->update($userId,
            array('sid' => $new_code)) && $this->reminder->update_rule(array('email' => $userEmail),
            array('sid' => substr($new_code, 0, 10)))) {
            $this->sendMailActive($userEmail, $new_code);
            if ($user->emailApproved != 1){
                $username = $user->firstName . ' ' . $user->lastName;
                $this->sendMailRequestApproveToHost($userEmail, $username, $user->emailApproved);
            }
        } else {
            redirect(base_url('404_override'));
        }
    }

    public function approvedAccount($code){
        $where = array('emailApproved' => $code);
        $user = $this->useraccount->get_info_rule($where);

        if (empty($user)) {
            redirect(base_url('404_override'));
        }

        if ($this->useraccount->update($user->id, array('emailApproved' => 1))){
            $this->data['status'] = 'success';
            $this->data['message'] = 'You had activated account '. $user->email .' successfully.';

            $this->sendMailAcceptedToUser($user->email);
        }
        else{
            $this->data['status'] = 'fail';
            $this->data['message'] = 'Failed to activate account '. $user->email .'.';
        }
        $this->page = 'approved';
        $this->layout();
    }

    public function activeAccount($code)
    {
        $where = array('sid' => $code);
        $user = $this->useraccount->get_info_rule($where);
        if (empty($user)) {
            redirect(base_url('register/active-account/error'));
        }
        $token = substr($code, 0, 10);
        $expired = $token + 36 * 60 * 60;
        $now = time();
        if ($expired < $now) {
            $this->reminder->update_rule(array('email' => $user->email), array('sid' => ''));
            redirect(base_url('register/active-account/error'));
        }
        $this->useraccount->update($user->id, array('sid' => '', 'active' => '1'));
        $dataUserOpenProject = array(
          "login" => $user->email,
          "email" => $user->email,
          "firstName" => $user->firstName,
          "lastName" => $user->lastName,
          "admin" => true,
          "status" => "active",
          "password" => "@admin123456"
        );

        $OPapiKey = md5($user->email . time() . rand(10000, 99999));
        $url = $this->config->config['api_url'] . "users";
        $response = $this->CurlSetup($url, "post", $dataUserOpenProject, true);

        $response = json_decode($response);
        if ($response->_type != 'Error' && !empty($OPapiKey)) {
            $this->useraccount->update($user->id, array('api_key' => $OPapiKey));
            $this->useraccount->update($user->id, array('user_op_ID' => $response->id));
            $this->pm->createAPIToken($response->id, $OPapiKey);
        }

        $this->reminder->del_rule(array('email' => $user->email));
        $this->session->set_flashdata('flash_message', 'Đăng nhập thành công');
        $this->session->unset_userdata('registration_info');

        $userid = $user->id;

        $userIdDir = FCPATH . 'uploads/userfiles/' . $userid;
        $oldmask = umask(0);
        mkdir($userIdDir, 0777, true);
        umask($oldmask);

        //Videos
        $videoDir = FCPATH . 'uploads/userfiles/' . $userid . '/videos/';
        $oldmask = umask(0);
        mkdir($videoDir, 0777, true);
        umask($oldmask);

        //Posters
        $posterDir = FCPATH . 'uploads/userfiles/' . $userid . '/posters/';
        $oldmask = umask(0);
        mkdir($posterDir, 0777);
        umask($oldmask);

        //Presentations
        $presDir = FCPATH . 'uploads/userfiles/' . $userid . '/presentations/';
        $oldmask = umask(0);
        mkdir($presDir, 0777, true);
        umask($oldmask);

        //Papers
        $paperDir = FCPATH . 'uploads/userfiles/' . $userid . '/papers/';
        $oldmask = umask(0);
        mkdir($paperDir, 0777);
        umask($oldmask);

        //Conferences
        $confDir = FCPATH . 'uploads/userfiles/' . $userid . '/conferences/';
        $oldmask = umask(0);
        mkdir($confDir, 0777, true);
        umask($oldmask);

        //Invoices
        $invoiceDir = FCPATH . 'uploads/userfiles/' . $userid . '/invoices/';
        $oldmask = umask(0);
        mkdir($invoiceDir, 0777);
        umask($oldmask);

        $this->session->set_userdata('login', $user->email);
        redirect('auth/profile');
    }

    public function getVideoSummaryProfile($id_user)
    {
        $summary_type = 'video';

        $checkUser = false;
        if ($id_user == $this->userID) {
            $checkUser = true;
        }

        $user = $this->useraccount->get_info($id_user);

        $videos = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getPostVideoByUser($id_user, $this->userID));
        $totalPaper = count($this->category->getPostPaperByUser($id_user, $this->userID));
        $totalPoster = count($this->category->getPostPosterByUser($id_user, $this->userID));
        $totalPresentation = count($this->category->getPostPresentationByUser($id_user, $this->userID));
        $totalConference = count($this->category->getPostConferenceByUser($id_user, $this->userID));

        $this->data['user'] = array($user, $this->category->getCategory($user->category, $user->subcategory));

        if ($totalVideo > 0) {
            $limit_per_page = 4;
            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

            $videos['results'] = $this->category->getPostVideoByUserPagination($id_user, $this->userID, $limit_per_page,
              $start_index);

            $config['base_url'] = base_url('summary-profile/video/' . $id_user);
            $config['total_rows'] = $totalVideo;
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
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $videos["links"] = $this->pagination->create_links();
        }

        $this->data['summary_type'] = $summary_type;
        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['videos'] = $videos;
        $this->data['checkUser'] = $checkUser;
        $this->page = 'summary_profile';
        $this->layout();
    }

    public function getPaperSummaryProfile($id_user)
    {
        $summary_type = 'paper';

        $checkUser = false;
        if ($id_user == $this->userID) {
            $checkUser = true;
        }

        $user = $this->useraccount->get_info($id_user);

        $papers = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getPostVideoByUser($id_user, $this->userID));
        $totalPaper = count($this->category->getPostPaperByUser($id_user, $this->userID));
        $totalPoster = count($this->category->getPostPosterByUser($id_user, $this->userID));
        $totalPresentation = count($this->category->getPostPresentationByUser($id_user, $this->userID));
        $totalConference = count($this->category->getPostConferenceByUser($id_user, $this->userID));

        $this->data['user'] = array($user, $this->category->getCategory($user->category, $user->subcategory));

        if ($totalPaper > 0) {
            $limit_per_page = 4;
            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

            $papers['results'] = $this->category->getPostPaperByUserPagination($id_user, $this->userID, $limit_per_page,
              $start_index);

            $config['base_url'] = base_url('summary-profile/paper/' . $id_user);
            $config['total_rows'] = $totalPaper;
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
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $papers["links"] = $this->pagination->create_links();
        }

        $this->data['summary_type'] = $summary_type;
        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['papers'] = $papers;
        $this->data['checkUser'] = $checkUser;
        $this->page = 'summary_profile';
        $this->layout();
    }

    public function getPosterSummaryProfile($id_user)
    {
        $summary_type = 'poster';

        $checkUser = false;
        if ($id_user == $this->userID) {
            $checkUser = true;
        }

        $user = $this->useraccount->get_info($id_user);

        $posters = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getPostVideoByUser($id_user, $this->userID));
        $totalPaper = count($this->category->getPostPaperByUser($id_user, $this->userID));
        $totalPoster = count($this->category->getPostPosterByUser($id_user, $this->userID));
        $totalPresentation = count($this->category->getPostPresentationByUser($id_user, $this->userID));
        $totalConference = count($this->category->getPostConferenceByUser($id_user, $this->userID));

        $this->data['user'] = array($user, $this->category->getCategory($user->category, $user->subcategory));

        if ($totalPoster > 0) {
            $limit_per_page = 4;
            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

            $posters['results'] = $this->category->getPostPosterByUserPagination($id_user, $this->userID,
              $limit_per_page, $start_index);

            $config['base_url'] = base_url('summary-profile/poster/' . $id_user);
            $config['total_rows'] = $totalPoster;
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
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $posters["links"] = $this->pagination->create_links();
        }

        $this->data['summary_type'] = $summary_type;
        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['posters'] = $posters;
        $this->data['checkUser'] = $checkUser;
        $this->page = 'summary_profile';
        $this->layout();
    }

    public function getPresentationSummaryProfile($id_user)
    {
        $summary_type = 'presentation';

        $checkUser = false;
        if ($id_user == $this->userID) {
            $checkUser = true;
        }

        $user = $this->useraccount->get_info($id_user);

        $presentations = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getPostVideoByUser($id_user, $this->userID));
        $totalPaper = count($this->category->getPostPaperByUser($id_user, $this->userID));
        $totalPoster = count($this->category->getPostPosterByUser($id_user, $this->userID));
        $totalPresentation = count($this->category->getPostPresentationByUser($id_user, $this->userID));
        $totalConference = count($this->category->getPostConferenceByUser($id_user, $this->userID));

        $this->data['user'] = array($user, $this->category->getCategory($user->category, $user->subcategory));

        if ($totalPresentation > 0) {
            $limit_per_page = 4;
            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

            $presentations['results'] = $this->category->getPostPresentationByUserPagination($id_user, $this->userID,
              $limit_per_page, $start_index);

            $config['base_url'] = base_url('summary-profile/presentation/' . $id_user);
            $config['total_rows'] = $totalPresentation;
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
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $presentations["links"] = $this->pagination->create_links();
        }

        $this->data['summary_type'] = $summary_type;
        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['presentations'] = $presentations;
        $this->data['checkUser'] = $checkUser;
        $this->page = 'summary_profile';
        $this->layout();
    }

    public function getConferenceSummaryProfile($id_user)
    {
        $summary_type = 'conference';

        $checkUser = false;
        if ($id_user == $this->userID) {
            $checkUser = true;
        }

        $user = $this->useraccount->get_info($id_user);

        $conferences = array();

        $direction = null;
        $colName = null;
        $totalVideo = count($this->category->getPostVideoByUser($id_user, $this->userID));
        $totalPaper = count($this->category->getPostPaperByUser($id_user, $this->userID));
        $totalPoster = count($this->category->getPostPosterByUser($id_user, $this->userID));
        $totalPresentation = count($this->category->getPostPresentationByUser($id_user, $this->userID));
        $totalConference = count($this->category->getPostConferenceByUser($id_user, $this->userID));

        $this->data['user'] = array($user, $this->category->getCategory($user->category, $user->subcategory));

        if ($totalConference > 0) {
            $limit_per_page = 4;
            $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

            $conferences['results'] = $this->category->getPostConferenceByUserPagination($id_user, $this->userID,
              $limit_per_page, $start_index);

            $config['base_url'] = base_url('summary-profile/conference/' . $id_user);
            $config['total_rows'] = $totalConference;
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
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $conferences["links"] = $this->pagination->create_links();
        }

        $this->data['summary_type'] = $summary_type;
        $this->data['countVideo'] = $totalVideo;
        $this->data['countPaper'] = $totalPaper;
        $this->data['countPoster'] = $totalPoster;
        $this->data['countPresentation'] = $totalPresentation;
        $this->data['countConference'] = $totalConference;
        $this->data['conferences'] = $conferences;
        $this->data['checkUser'] = $checkUser;
        $this->page = 'summary_profile';
        $this->layout();
    }

    public function check_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password = md5($password);
        $user = $this->useraccount->get_info_rule(array('email' => $email, 'password' => $password));
        if (!$user) {
            $this->form_validation->set_message(__FUNCTION__, 'Please enter a registered Email/ Password');
            return false;
        } elseif ($user->active != 1) {
            redirect('login/error/' . $user->sid);
        }
        return true;
    }

    public function loginAccountError($sid)
    {
        $this->data['sid'] = $sid;
        $this->page = 'login_account_error';
        $this->layout();
    }

    public function registerAccountError($sid)
    {
        $this->data['sid'] = $sid;
        $this->page = 'register_account_error';
        $this->layout();
    }

    public function login()
    {
        if (!empty($this->session->login)) {
            redirect(base_url('auth/profile'));
        }
        $this->session->unset_userdata('registration_info');
        $this->session->unset_userdata('cid_info');
        $this->session->unset_userdata('conference');
        $this->session->unset_userdata('register_conference_step_2');
        $this->session->unset_userdata('permission');

        $this->form_validation->set_rules('email', 'email',
          array('trim','required','regex_match[/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/]'),
          array(
            'regex_match' => 'Please enter a valid %s format'
          ));
        $this->form_validation->set_rules('password', 'password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)'
          ));
        $this->form_validation->set_rules('login', 'Login', 'callback_check_login');

        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $password = md5($password);
            $where = array('email' => $email, 'password' => $password, 'active' => '1');
            $user = $this->useraccount->get_info_rule($where);
            $this->useraccount->update($user->id, array('sid' => ''));

            $this->session->set_userdata('login', $email);
            $this->session->set_flashdata('flash_message', 'Login successful');

            if (isset($_SESSION['login_redirect'])) {
                redirect($this->session->login_redirect);
            }
            redirect('auth/profile');
        }
        $this->page = 'login';
        $this->layout();
    }

    public function logout()
    {
        if ($this->useraccount->userIsLogin()) {
            $this->session->unset_userdata('login');
            $this->session->unset_userdata('login_redirect');
            $this->session->unset_userdata('upload_video');
            $this->session->unset_userdata('upload_presentation');
            $this->session->unset_userdata('upload_poster');
            $this->session->unset_userdata('upload_paper');
            $this->session->unset_userdata('waitForApprove');
        }
        $this->session->set_flashdata('flash_message', 'Logout unsuccessful');
        redirect();
    }

    public function activePermissionCoAuthor($code)
    {
        if ($this->useraccount->userIsLogin()) {
            $this->session->unset_userdata('login');
            $this->session->unset_userdata('cid_info');
            $this->session->unset_userdata('conference');
            $this->session->unset_userdata('waitForApprove');
        }
        $where = array('sid' => $code);
        $user = $this->useraccount->get_info_rule($where);
        if (empty($user)) {
            redirect();
        }
        $this->form_validation->set_rules('password', 'password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)'
          ));
        $this->form_validation->set_rules('re_password', 'repeat password',
          'required|min_length[6]|max_length[30]|regex_match[/^[^\s]+(\s+[^\s]+)*$/]|matches[password]',
          array(
            'min_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'max_length' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'regex_match' => 'Please enter a valid password format ( 6-30 chars and no space for start & end)',
            'matches' => 'Your password and repeat password do not match.'
          ));
        if ($this->form_validation->run()) {
            $passwordOProject = $this->input->post('password');
            $dataUserOpenProject = array(
              "login" => $user->email,
              "email" => $user->email,
              "firstName" => $user->firstName,
              "lastName" => $user->lastName,
              "admin" => true,
              "status" => "active",
              "password" => $passwordOProject
            );

            $OPapiKey = md5($user->email . time() . rand(10000, 99999));
            $url = $this->config->config['api_url'] . "users";
            $response = $this->CurlSetup($url, "post", $dataUserOpenProject, true);

            $response = json_decode($response);
            if ($response->_type != 'Error' && !empty($OPapiKey)) {
                $this->useraccount->update($user->id, array('api_key' => $OPapiKey));
                $this->useraccount->update($user->id, array('user_op_ID' => $response->id));
                $this->pm->createAPIToken($response->id, $OPapiKey);
            }
            $new_password = md5($this->input->post('password'));
            $dataUser = array(
              'sid' => '',
              'password' => $new_password,
              'active' => 1
            );
//            $token = substr($code, 0, 10);
//            $expired = $token + 48 * 60 * 60;
//            $now = time();
//            if ($expired < $now) {
//                $this->useraccount->delete($user->id);
//                redirect();
//            }

            if ($this->useraccount->update($user->id, $dataUser)) {

                $this->reminder->del_rule(array('email' => $user->email));

                $userID = $user->id;

                $userIdDir = FCPATH . 'uploads/userfiles/' . $userID;
                $oldmask = umask(0);
                mkdir($userIdDir, 0777);
                umask($oldmask);

                //Videos
                $videoDir = FCPATH . 'uploads/userfiles/' . $userID . '/videos/';
                $oldmask = umask(0);
                mkdir($videoDir, 0777);
                umask($oldmask);

                //Posters
                $posterDir = FCPATH . 'uploads/userfiles/' . $userID . '/posters/';
                $oldmask = umask(0);
                mkdir($posterDir, 0777);
                umask($oldmask);

                //Presentations
                $presDir = FCPATH . 'uploads/userfiles/' . $userID . '/presentations/';
                $oldmask = umask(0);
                mkdir($presDir, 0777);
                umask($oldmask);

                //Papers
                $paperDir = FCPATH . 'uploads/userfiles/' . $userID . '/papers/';
                $oldmask = umask(0);
                mkdir($paperDir, 0777);
                umask($oldmask);

                //Conferences
                $confDir = FCPATH . 'uploads/userfiles/' . $userID . '/conferences/';
                $oldmask = umask(0);
                mkdir($confDir, 0777);
                umask($oldmask);

                //Invoices
                $invoiceDir = FCPATH . 'uploads/userfiles/' . $userID . '/invoices/';
                $oldmask = umask(0);
                mkdir($invoiceDir, 0777);
                umask($oldmask);

                $coAuthor = $this->conferencepermission->get_info_rule(array('code' => $code));

                if ($coAuthor) {
                    $data = array(
                      'code' => '',
                      'status' => 'Accept'
                    );
                    if ($this->conferencepermission->update($coAuthor->id, $data)) {
                        $this->session->set_userdata('login', $user->email);
                        redirect(base_url('auth/conference/conference-page/' . $coAuthor->confID));
                    }
                }
            }
        }
        $this->data['user'] = $user;
        $this->page = 'reset_password';
        $this->layout();
    }

    public function updateStatusPermission($code)
    {
        $coAuthor = $this->conferencepermission->get_info_rule(array('code' => $code));
        if (!empty($coAuthor)) {
            $user = $this->useraccount->get_info($coAuthor->userID);
            if (!empty($user)) {
                $data = array(
                  'code' => '',
                  'status' => 'Accept'
                );
                if ($user->active == 1) {
                    if ($this->conferencepermission->update($coAuthor->id, $data)) {
                        if ($this->useraccount->userIsLogin()) {
                            $this->session->unset_userdata('login');
                            $this->session->unset_userdata('cid_info');
                            $this->session->unset_userdata('conference');
                            $this->session->unset_userdata('waitForApprove');
                        }
                        $this->session->set_userdata('login', $coAuthor->email);
                        redirect(base_url('auth/conference/conference-page/' . $coAuthor->confID));
                    }
                } else {
                    if ($user->autoCreate == 1) {
                        redirect(base_url('auth/invite-co-author/active-account-co-author/' . $code));
                    } else {
                        if ($this->useraccount->update_rule(array('sid' => $code),
                            array('active' => 1)) && $this->conferencepermission->update($coAuthor->id, $data)) {
                            if ($this->useraccount->userIsLogin()) {
                                $this->session->unset_userdata('login');
                                $this->session->unset_userdata('cid_info');
                                $this->session->unset_userdata('conference');
                                $this->session->unset_userdata('waitForApprove');
                            }
                            $this->session->set_userdata('login', $coAuthor->email);
                            redirect(base_url('auth/conference/conference-page/' . $coAuthor->confID));
                        }
                    }
                }
            }
        }
    }

    public function workPackageDetail($userID, $identifier, $workPackageID){
        $user = $this->useraccount->get_info($userID);
        if (!empty($user)){
            if ($this->useraccount->userIsLogin()) {
                if ($user->email != $this->session->login){
                    $this->session->unset_userdata('login');
                    $this->session->unset_userdata('login_redirect');
                    $this->session->unset_userdata('upload_video');
                    $this->session->unset_userdata('upload_presentation');
                    $this->session->unset_userdata('upload_poster');
                    $this->session->unset_userdata('upload_paper');
                    $this->session->unset_userdata('waitForApprove');

                    $this->session->set_userdata('login', $user->email);
                }
            }
            else{
                $this->session->set_userdata('login', $user->email);
            }

            redirect(base_url('auth/project/' . $identifier . '/work-package/edit/' . $workPackageID));
        }
        else{
            redirect(base_url('404_override'));
        }
    }
}
