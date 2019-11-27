<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 25-Apr-19
 * Time: 16:08
 */

class ObjectPageController extends MY_Controller
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
        $this->load->model('conferencesession');
        $this->load->model('conferenceelement');
        $this->load->model('conferenceregistration');
        $this->load->model('conferenceabstract');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
        }else {
            $this->redirectAfterLogin();
        }
    }

    public function objectRequestDoi($id)
    {
        $this->requestDoi($id);
    }

    public function check_cid_link()
    {
        $cid = $this->input->post('cid');
        if (!$this->cid->check_cid_exists($cid)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please enter a valid Conference ID to link to');
            return false;
        }
        return true;
    }

    public function getSessionConference()
    {
        $cid = $this->input->post('cid');
        $postID = $this->input->post('postID');
        $postType= $this->input->post('postType');
        $results = array();
        $status = 'fail';
        if (!empty($cid) && !empty($postID) && !empty($postType)){
            if ($this->cid->check_cid_exists($cid)) {
                $where = array(
                  'CID' => $cid,
                  'type' => $postType,
                  'elementID' => $postID
                );
                $element = $this->conferenceelement->check_exists($where);
                $sessions = $this->conferencesession->getConferenceSessionByCID($cid);
                if (empty($element) && !empty($sessions)) {
                    foreach ($sessions as $session) {
                        $item = '<option value="' . $session['ID'] . '">' . $session['name'] . '</option>';
                        array_push($results, $item);
                    }
                    $status = 'success';
                }
                else{
                    $status = 'connected';
                }
            }
        }

        echo json_encode(array('status' => $status, 'content' => $results));
    }

    public function getSessionConferenceUploadContent()
    {
        $cid = $this->input->post('cid');
        $results = array();
        $status = 'fail';
        if (!empty($cid)){
            if ($this->cid->check_cid_exists($cid)) {
                $sessions = $this->conferencesession->getConferenceSessionByCID($cid);
                if (!empty($sessions)) {
                    foreach ($sessions as $session) {
                        $item = '<option value="' . $session['ID'] . '">' . $session['name'] . '</option>';
                        array_push($results, $item);
                    }
                    $status = 'success';
                }
            }
        }

        echo json_encode(array('status' => $status, 'content' => $results));
    }


    public function check_conference_element()
    {
        $element = $this->conferenceelement->get_info_binary_3('CID', $this->input->post('cid'), 'type', $this->session->post_type_link_to_conference, 'elementID', $this->input->post('postID'));
        if (!empty($element)) {
            $this->form_validation->set_message(__FUNCTION__,
              'This ' .
              $this->session->post_type_link_to_conference .
              ' is already connected with that conference');
            return false;
        }
        return true;
    }

    public function getLinkToConferenceVideo($id)
    {
        $this->session->set_userdata('active_top_header', 'content');
        $this->data['active_top_header'] = $this->session->active_top_header;
        $this->session->set_userdata('active_content_sidebar', 'Videos');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
        $post = $this->movie->get($id);
        if (!empty($post)) {
            $this->session->set_userdata('post_type_link_to_conference', 'video');
            if ($this->checkAuthor($post['idAuthor'])) {
                $this->data['cid'] = $this->cid->getCid();
                $this->data['post'] = $post;
                $this->auth_page = 'link_to_conference';
                $this->auth_content_layout();
            }
        }
    }

    public function getLinkToConferencePresentation($id)
    {
        $this->session->set_userdata('active_top_header', 'content');
        $this->data['active_top_header'] = $this->session->active_top_header;
        $this->session->set_userdata('active_content_sidebar', 'Presentations');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
        $post = $this->presentation->get($id);
        if (!empty($post)) {
            $this->session->set_userdata('post_type_link_to_conference', 'presentation');
            if ($this->checkAuthor($post['idAuthor'])) {
                $this->data['cid'] = $this->cid->getCid();
                $this->data['post'] = $post;
                $this->auth_page = 'link_to_conference_presentation';
                $this->auth_content_layout();
            }
        }
    }

    public function getLinkToConferencePoster($id)
    {
        $this->session->set_userdata('active_top_header', 'content');
        $this->data['active_top_header'] = $this->session->active_top_header;
        $this->session->set_userdata('active_content_sidebar', 'Posters');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
        $post = $this->poster->get($id);
        if (!empty($post)) {
            $this->session->set_userdata('post_type_link_to_conference', 'poster');
            if ($this->checkAuthor($post['idAuthor'])) {
                $this->data['cid'] = $this->cid->getCid();
                $this->data['post'] = $post;
                $this->auth_page = 'link_to_conference_poster';
                $this->auth_content_layout();
            }
        }
    }

    public function getLinkToConferencePaper($id)
    {
        $this->session->set_userdata('active_top_header', 'content');
        $this->data['active_top_header'] = $this->session->active_top_header;
        $this->session->set_userdata('active_content_sidebar', 'Papers');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
        $post = $this->paper->get($id);
        if (!empty($post)) {
            $this->session->set_userdata('post_type_link_to_conference', 'paper');
            if ($this->checkAuthor($post['idAuthor'])) {
                $this->data['cid'] = $this->cid->getCid();
                $this->data['post'] = $post;
                $this->auth_page = 'link_to_conference_paper';
                $this->auth_content_layout();
            }
        }
    }

    public function report($postType, $postID)
    {
        $this->form_validation->set_rules('report_item', '', 'required',
          array(
            'required' => 'Please choose one option.'
          ));

        $postTitle = '';
        if ($this->form_validation->run()) {
            $report = $this->input->post('report_item');

            if ($postType == 'video') {
                $postTitle = $this->movie->get_info($postID)->title;
            } elseif ($postType == 'presentation') {
                $postTitle = $this->presentation->get_info($postID)->presTitle;
            } elseif ($postType == 'poster') {
                $postTitle = $this->poster->get_info($postID)->posterTitle;
            } elseif ($postType == 'paper') {
                $postTitle = $this->paper->get_info($postID)->paperTitle;
            }

            $this->sendMailReport($postType, $postID, $report, $postTitle);
            $this->page = 'report_success';
            $this->layout();
        }
        $this->data['postID'] = $postID;
        $this->data['postType'] = $postType;
        $this->page = 'report';
        $this->layout();
    }

    public function linkToConference()
    {
        $cid = $this->input->post('cid');
        $sessionID = $this->input->post('sessionID');
        $postType = $this->input->post('postType');
        $postID = $this->input->post('postID');
        $sharePublic = $this->input->post('sharePublic');
        $status = 'fail';
        $msg = '';

        $checkCID = $this->cid->check_cid_exists($cid);
        if ($checkCID) {
            $element = $this->conferenceelement->get_info_binary_3('CID', $cid, 'type', $postType, 'elementID', $postID);
            if (empty($element)) {
                $data = array(
                  'CID' => $cid,
                  'type' => $postType,
                  'elementID' => $postID,
                  'approved' => 1,
                  'session' => $sessionID
                );

                $conference = $this->conference->get_info_binary('CID', $cid);
                $confTitle = $conference->confTitle;
                $hostConference = $this->useraccount->get_info($conference->userID);
                $hostName = $hostConference->firstName . ' ' . $hostConference->lastName;
                $username = $this->user->firstName . ' ' . $this->user->lastName;
                if ($postType == 'video') {
                    $postTitle = $this->movie->get_info($postID)->title;
                    $this->movie->update($postID, array('public' => $sharePublic));
                } elseif ($postType == 'presentation') {
                    $postTitle = $this->presentation->get_info($postID)->presTitle;
                    $this->presentation->update($postID, array('public' => $sharePublic));
                } elseif ($postType == 'poster') {
                    $postTitle = $this->poster->get_info($postID)->posterTitle;
                    $this->poster->update($postID, array('public' => $sharePublic));
                } else {
                    $postTitle = $this->paper->get_info($postID)->paperTitle;
                    $this->paper->update($postID, array('public' => $sharePublic));
                }

                if ($this->conferenceelement->create($data)) {
                    $this->sendMailLinkToConference($this->user->email, $confTitle, $username, $postID, $postTitle, $postType);
                    $this->sendMailContributionToHostConference($hostConference->email, $hostName,
                      $postID, $postTitle, $postType);
                    $status = 'success';
                    $msg = 'Successful link';
                }
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function uploadContent()
    {
        $status = 'fail';
        $msg = '';
        if (!empty($this->user)) {
            $cid = $this->input->post('cid');
            if ($this->cid->check_cid_exists($cid)) {
                $this->session->set_userdata('link_to_conference', $cid);
                $status = 'success';
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }
}