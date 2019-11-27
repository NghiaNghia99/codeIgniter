<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class PaperController extends MY_Controller
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
        $this->load->model('language');
        $this->load->model('conferencesession');
        $this->load->model('conferenceelement');
        $this->load->model('conferenceregistration');
        $this->load->model('conferenceabstract');
        $this->load->model('conferencepermission');
        $this->load->model('keywordblacklist');
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->library('pagination');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->session->set_userdata('active_top_header', 'content');
            $this->data['active_top_header'] = $this->session->active_top_header;
            $this->session->set_userdata('active_content_sidebar', 'Papers');
            $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
            $this->session->unset_userdata('show_alt_category_item');
            $this->session->unset_userdata('get_alt_category_id');
            $this->session->unset_userdata('get_alt_subcategory_id');
            $this->session->unset_userdata('get_category_id');
            $this->session->unset_userdata('get_subcategory_id');
        } else {
            $this->redirectAfterLogin();
        }
    }

    public function getList()
    {
        $this->session->set_userdata('active_content_sidebar', 'Papers');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;
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
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4)-1) * $limit_per_page)  : 0;

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

        $postList = count($this->paper->getPostsByUser($this->user->id));

        if ($postList > 0) {
            $posts['results'] = $this->paper->sortPostByUserPagination($this->user->id, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('auth/content/papers');
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
        $this->data['posts'] = $posts;
        $this->data['bodyClass'] = 'object-list';

        $this->auth_page = 'paper_list';
        $this->auth_content_layout();
    }

    public function getPaper($id)
    {
        $post = $this->paper->get_info($id);
        if (!empty($post)){
            $this->data['alt_category'] = $this->paper->getAltCategory($id);
            $this->data['post'] = $this->paper->get($id);

            $listConference = $this->conference->getConferenceByPost('paper', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->auth_page = 'paper_page';
            $this->auth_content_layout();
        }
        else{
            redirect(base_url('404_override'));
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

    public function getEditPaper($id)
    {
        $post = $this->paper->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            $this->form_validation->set_rules('title', 'title', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('caption', 'caption', 'trim|required|max_length[3000]');
            $this->form_validation->set_rules('category', 'main field of research', 'trim|required');
            $this->form_validation->set_rules('subcategory', 'main research topic', 'trim|required');
            $this->form_validation->set_rules('co_authors', 'co-author', 'max_length[1000]');
            $this->form_validation->set_rules('additional_information', 'additional information', 'max_length[3000]');

            $altCategory1 = $this->input->post('alt_category');
            $altSubCategory1 = $this->input->post('alt_subcategory');
            if ($this->input->post('check_terms') != 1) {
                $altCategory1 = '';
                $altSubCategory1 = '';
            } else {
                $this->form_validation->set_rules('alt_subcategory', 'alternative research topic',
                  'callback_check_category_duplicate|callback_check_subcategory');
            }
            if ($this->form_validation->run()) {
                $sharePublic = 0;
                if ($this->input->post('sharePublic') == 1) {
                    $sharePublic = 1;
                }
                $data = array(
                  'coAuthors' => $this->input->post('co_authors'),
                  'paperTitle' => $this->input->post('title'),
                  'paperAffiliation' => $this->input->post('affiliation'),
                  'furtherReading' => $this->input->post('further_reading'),
                  'description' => $this->input->post('additional_information'),
                  'caption' => $this->input->post('caption'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'altCategory1' => $altCategory1,
                  'altSubCategory1' => $altSubCategory1,
                  'public' => $sharePublic
                );
                $this->paper->update($post['id'], $data);
                redirect('auth/content/paper/' . $post['id']);
            }
            $this->data['categories'] = array(
              $this->useraccount->getCategories(),
              $this->useraccount->getSubCategories()
            );
            if (isset($_SESSION['get_alt_category_id'])) {
                $this->data['altCategoryID'] = $this->session->get_alt_category_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_alt_subcategory_id'])) {
                $this->data['altSubCategoryID'] = $this->session->get_alt_subcategory_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_category_id'])) {
                $this->data['categoryID'] = $this->session->get_category_id;
            }
            if (isset($_SESSION['get_subcategory_id'])) {
                $this->data['subCategoryID'] = $this->session->get_subcategory_id;
            }
            $this->data['post'] = $post;
            $this->data['checkLinkToConference'] = $this->conferenceelement->checkExist($id, 'paper');
            $this->auth_page = 'edit_paper';
            $this->auth_content_layout();
        }
    }

    public function getRequestDoiPaper($id)
    {
        $post = $this->paper->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            $this->session->set_userdata('post_type_doi', 'paper');
            $this->data['post'] = $post;
            $this->auth_page = 'request_doi_paper';
            $this->auth_content_layout();
        }
    }

    public function check_subMainCategory()
    {
        $category = $this->input->post('category');
        $subCategory = $this->input->post('subcategory');
        $this->session->set_userdata('get_category_id', $category);
        $this->session->set_userdata('get_subcategory_id', $subCategory);
        if (!empty($category) && empty($subCategory)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please choose main research topic');
            return false;
        }
        return true;
    }

    public function check_cid()
    {
        $cid = $this->input->post('cid');
        if (!$this->cid->check_cid_exists($cid)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please enter a valid Conference ID');
            $this->session->set_userdata('link_to_conference', $cid);
            return false;
        }
        return true;
    }

    public function uploadPapers()
    {
        $this->session->set_userdata('active_content_sidebar', 'Paper');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;

        if (empty($this->session->keyword_blacklist)){
            $this->form_validation->set_rules('title', 'title', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('caption', 'caption', 'trim|required|max_length[3000]');
            $this->form_validation->set_rules('category', 'main field of research', 'trim|required');
            $this->form_validation->set_rules('subcategory', 'main research topic',
              'trim|required|callback_check_subMainCategory');
            $this->form_validation->set_rules('co_authors', 'co-author', 'max_length[1000]');
            $this->form_validation->set_rules('additional_information', 'additional information', 'max_length[3000]');
            if ($this->input->post('check_link_to_conference') == 1) {
                $this->form_validation->set_rules('cid', 'CID', 'callback_check_cid');
            }

            $altCategory1 = $this->input->post('alt_category');
            $altSubCategory1 = $this->input->post('alt_subcategory');
            if ($this->input->post('check_terms') != 1) {
                $altCategory1 = '';
                $altSubCategory1 = '';
            } else {
                $this->form_validation->set_rules('alt_subcategory', 'alternative research topic',
                  'callback_check_category_duplicate|callback_check_subcategory');
            }

            if ($this->form_validation->run()) {
                $dataCheckKeyWorkBlackList = array(
                  $this->input->post('title'),
                  $this->input->post('co_authors'),
                  $this->input->post('affiliation'),
                  $this->input->post('further_reading'),
                  $this->input->post('caption')
                );
                $resultCheckKeyWorkBlackList = $this->keywordblacklist->checkKeyWorkBackList($dataCheckKeyWorkBlackList);
                if ($resultCheckKeyWorkBlackList){
                    $username = $this->user->firstName . ' ' . $this->user->lastName;
                    $this->sendMailViolationsReport('Blacklist Hit: '.$resultCheckKeyWorkBlackList.', User: '.$username, $this->user->email);
                    $this->session->set_userdata('keyword_blacklist', true);

                    redirect(base_url('auth/content/paper/upload'));
                }
                $sharePublic = 0;
                if ($this->input->post('sharePublic') == 1){
                    $sharePublic = 1;
                }
                $data = array(
                  'idAuthor' => $this->user->id,
                  'coAuthors' => $this->input->post('co_authors'),
                  'paperTitle' => $this->input->post('title'),
                  'paperAffiliation' => $this->input->post('affiliation'),
                  'furtherReading' => $this->input->post('further_reading'),
                  'description' => '',
                  'caption' => $this->input->post('caption'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'altCategory1' => $altCategory1,
                  'altSubCategory1' => $altSubCategory1,
                  'path' => '',
                  'ext' => '',
                  'filesize' => $this->input->post('get-file-size'),
                  'filename_original' => $this->input->post('get-file-name'),
                  'language' => $this->input->post('language'),
                  'views' => '0',
                  'dateOfUpload' => time(),
                  'public' => $sharePublic
                );

                $newID = $this->paper->create($data);
                if ($newID) {
                    $userID = $this->user->id;

                    $this->makeUserDir($userID);
                    $this->makeObjectDir($userID, 'papers');

                    $config['upload_path'] = FCPATH . './uploads/userfiles/' . $this->user->id . '/papers/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 50000;
                    $config['overwrite'] = true;
                    $config['file_name'] = $newID;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $dataUpdate = array(
                          'path' => '/uploads/userfiles/' . $this->user->id . '/papers/' . $newID,
                          'ext' => strtolower(pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION))
                        );

                        if ($this->paper->update($newID, $dataUpdate)){
                            $fileName = FCPATH . 'uploads/userfiles/'. $userID .'/papers/'. $this->upload->data('file_name') .'[0]';
                            $newImage = FCPATH . 'uploads/userfiles/'. $userID .'/papers/'. $newID .'.jpg';
                            $convert = $this->config->config['convert'];
                            exec("$convert $fileName $newImage");

                            $new_post = array(
                              'thumbnail' => base_url('uploads/userfiles/'. $userID .'/papers/'. $newID .'.jpg'),
                              'title' => $data['paperTitle'],
                              'date' => $data['dateOfUpload']
                            );

                            if (!empty($this->session->upload_paper)) {
                                $uploadArr = $this->session->upload_paper;
                                array_push($uploadArr, $new_post);
                            } else {
                                $uploadArr = array();
                                array_push($uploadArr, $new_post);
                            }
                            $this->session->set_userdata('upload_paper', $uploadArr);

                            if ($this->input->post('check_link_to_conference') == 1){
                                $dataElement = array(
                                  'CID' => $this->input->post('cid'),
                                  'type' => 'paper',
                                  'elementID' => $newID,
                                  'approved' => 1,
                                  'session' => $this->input->post('session')
                                );

                                $confTitle = $this->conference->get_info_binary('CID', $this->input->post('cid'))->confTitle;
                                $username = $this->user->firstName . ' ' . $this->user->lastName;

                                if ($this->conferenceelement->create($dataElement)) {
                                    $this->sendMailLinkToConference($this->user->email, $confTitle, $username, $this->input->post('title'));
                                }
                            }
                            if ($this->input->post('registerDOI') == 1) {
                                $this->session->set_userdata('post_type_doi', 'paper');
                                $this->requestDoi($newID);
                            }
                            $this->session->unset_userdata('link_to_conference');
                            redirect('auth/content/paper/upload');
                        }
                    }
                    else{
                        $this->paper->delete($newID);
                        $this->session->set_flashdata('upload_post_msg', $this->upload->display_errors());
                    }
                } else {
                    $this->session->set_flashdata('upload_post_msg', $this->upload->display_errors());
                }
            }
            $this->data['languages'] = $this->language->getLanguages();
            $this->data['cid'] = $this->cid->getCid();
            $this->data['categories'] = array(
              $this->useraccount->getCategories(),
              $this->useraccount->getSubCategories()
            );
            if (isset($_SESSION['get_alt_category_id'])) {
                $this->data['altCategoryID'] = $this->session->get_alt_category_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_alt_subcategory_id'])) {
                $this->data['altSubCategoryID'] = $this->session->get_alt_subcategory_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_category_id'])) {
                $this->data['categoryID'] = $this->session->get_category_id;
            }
            if (isset($_SESSION['get_subcategory_id'])) {
                $this->data['subCategoryID'] = $this->session->get_subcategory_id;
            }
            if (!empty($this->session->link_to_conference)){
                $sessions = $this->conferencesession->getConferenceSessionByCID($this->session->link_to_conference);
                $this->data['sessions'] = $sessions;
            }
        }

        $this->auth_page = 'upload_papers_old';
        $this->auth_content_layout();
        $this->session->unset_userdata('keyword_blacklist');
    }

    public function upload()
    {
        $this->session->set_userdata('active_content_sidebar', 'Paper');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;

        if (empty($this->session->keyword_blacklist)){
            $this->data['languages'] = $this->language->getLanguages();
            $this->data['cid'] = $this->cid->getCid();
            $this->data['categories'] = array(
              $this->useraccount->getCategories(),
              $this->useraccount->getSubCategories()
            );
            if (isset($_SESSION['get_alt_category_id'])) {
                $this->data['altCategoryID'] = $this->session->get_alt_category_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_alt_subcategory_id'])) {
                $this->data['altSubCategoryID'] = $this->session->get_alt_subcategory_id;
                $this->session->set_userdata('show_alt_category_item', 'show');
            }
            if (isset($_SESSION['get_category_id'])) {
                $this->data['categoryID'] = $this->session->get_category_id;
            }
            if (isset($_SESSION['get_subcategory_id'])) {
                $this->data['subCategoryID'] = $this->session->get_subcategory_id;
            }
            if (!empty($this->session->link_to_conference)) {
                $sessions = $this->conferencesession->getConferenceSessionByCID($this->session->link_to_conference);
                $this->data['sessions'] = $sessions;
            }
        }

        $this->auth_page = 'upload_papers';
        $this->auth_content_layout();
        $this->session->unset_userdata('keyword_blacklist');
    }

    public function uploadEvent()
    {
        $dataCheckKeyWorkBlackList = array(
          $this->input->post('title'),
          $this->input->post('coAuthors'),
          $this->input->post('affiliation'),
          $this->input->post('furtherReading'),
          $this->input->post('caption')
        );
        $resultCheckKeyWorkBlackList = $this->keywordblacklist->checkKeyWorkBackList($dataCheckKeyWorkBlackList);
        if ($resultCheckKeyWorkBlackList){
            $username = $this->user->firstName . ' ' . $this->user->lastName;
            $this->sendMailViolationsReport('Blacklist Hit: '.$resultCheckKeyWorkBlackList.', User: '.$username, $this->user->email);
            $this->session->set_userdata('keyword_blacklist', true);

            redirect(base_url('auth/content/paper/upload'));
        }
        $sharePublic = 0;
        if ($this->input->post('sharePublic') == 1){
            $sharePublic = 1;
        }
        $data = array(
          'idAuthor' => $this->userID,
          'coAuthors' => $this->input->post('coAuthors'),
          'paperTitle' => $this->input->post('title'),
          'paperAffiliation' => $this->input->post('affiliation'),
          'furtherReading' => $this->input->post('furtherReading'),
          'description' => '',
          'caption' => $this->input->post('caption'),
          'category' => $this->input->post('category'),
          'subcategory' => $this->input->post('subCategory'),
          'altCategory1' => $this->input->post('altCategory'),
          'altSubCategory1' => $this->input->post('altSubCategory'),
          'path' => '',
          'ext' => '',
          'filesize' => $this->input->post('fileSize'),
          'filename_original' => $this->input->post('fileName'),
          'language' => $this->input->post('language'),
          'views' => '0',
          'dateOfUpload' => time(),
          'public' => $sharePublic
        );

        $newID = $this->paper->create($data);
        if ($newID) {
            $this->makeUserDir($this->userID);
            $this->makeObjectDir($this->userID, 'papers');

            $ext = strtolower(pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION));
            $fileName = FCPATH . './uploads/userfiles/' . $this->userID . '/papers/' . $newID . '.' . $ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $fileName)) {
                $dataUpdate = array(
                  'path' => '/uploads/userfiles/' . $this->userID . '/papers/' . $newID,
                  'ext' => $ext
                );

                if ($this->paper->update($newID, $dataUpdate)){
                    $fileName = $fileName .'[0]';
                    $newImage = FCPATH . 'uploads/userfiles/'. $this->userID .'/papers/'. $newID .'.jpg';
                    $convert = $this->config->config['convert'];
                    exec("$convert $fileName $newImage");

                    $new_post = array(
                      'thumbnail' => base_url('uploads/userfiles/'. $this->userID .'/papers/'. $newID .'.jpg'),
                      'title' => $data['paperTitle'],
                      'date' => $data['dateOfUpload']
                    );

                    if (!empty($this->session->upload_paper)) {
                        $uploadArr = $this->session->upload_paper;
                        array_push($uploadArr, $new_post);
                    } else {
                        $uploadArr = array();
                        array_push($uploadArr, $new_post);
                    }
                    $this->session->set_userdata('upload_paper', $uploadArr);

                    if ($this->input->post('check_link_to_conference') == 1){
                        $dataElement = array(
                          'CID' => $this->input->post('CID'),
                          'type' => 'paper',
                          'elementID' => $newID,
                          'approved' => 1,
                          'session' => $this->input->post('session')
                        );

                        $conference = $this->conference->get_info_binary('CID', $this->input->post('CID'));
                        $confTitle = $conference->confTitle;
                        $hostConference = $this->useraccount->get_info($conference->userID);
                        $hostName = $hostConference->firstName . ' ' . $hostConference->lastName;
                        $username = $this->user->firstName . ' ' . $this->user->lastName;

                        if ($this->conferenceelement->create($dataElement)) {
                            $this->sendMailLinkToConference($this->user->email, $confTitle, $username, $newID,
                              $this->input->post('title'), 'paper');
                            $this->sendMailContributionToHostConference($hostConference->email, $hostName,
                              $newID, $this->input->post('title'), 'paper');
                        }
                    }
                    if ($this->input->post('registerDOI') == 1) {
                        $this->session->set_userdata('post_type_doi', 'paper');
                        $this->requestDoi($newID);
                    }
                    $this->session->unset_userdata('link_to_conference');
                }
            }
            else{
                $this->paper->delete($newID);
                $this->session->set_flashdata('upload_post_msg', 'Error!');
            }
        } else {
            $this->session->set_flashdata('upload_post_msg', 'Error!');
        }
    }

    public function checkDelete($id)
    {
        $post = $this->paper->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            if (empty($post['doi'])) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    public function delete($id)
    {
        $post = $this->paper->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            if ($this->paper->delete($id)) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }

}