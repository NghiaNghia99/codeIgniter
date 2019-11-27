<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class VideoController extends MY_Controller
{

    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category');
        $this->load->model('useraccount');
        $this->load->model('movie');
        $this->load->model('videoqueue');
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
        $this->load->model('keywordblacklist');
        $this->load->model('language');
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
            $this->session->set_userdata('active_content_sidebar', 'Videos');
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

    public function getVideoList()
    {
        $this->session->set_userdata('active_content_sidebar', 'Videos');
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
        $start_index = ($this->uri->segment(4)) ? (($this->uri->segment(4) - 1) * $limit_per_page) : 0;

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

        $postList = count($this->movie->getVideosByUser($this->user->id));

        if ($postList > 0) {
            $posts['results'] = $this->movie->sortPostByUserPagination($this->user->id, $limit_per_page, $start_index,
              $colName, $direction);

            $config['base_url'] = base_url('auth/content/videos');
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

        $this->auth_page = 'video_list';
        $this->auth_content_layout();
    }

    public function getVideoQueueList()
    {
        $this->session->set_userdata('active_content_sidebar', 'Videos');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;

        $posts = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(5)) ? (($this->uri->segment(5) - 1) * $limit_per_page) : 0;

        $postList = count($this->movie->videosQueue($this->userID));

        if ($postList > 0) {
            $posts['results'] = $this->movie->videosQueuePagination($this->userID, $limit_per_page, $start_index);

            $config['base_url'] = base_url('auth/content/videos/queue');
            $config['total_rows'] = $postList;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 5;
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

        $this->data['posts'] = $posts;
        $this->data['bodyClass'] = 'object-list';

        $this->auth_page = 'video_queue_list';
        $this->auth_content_layout();
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

    public function uploadVideo()
    {
        $this->session->set_userdata('active_content_sidebar', 'Video');
        $this->data['active_content_sidebar'] = $this->session->active_content_sidebar;

        if (empty($this->session->keyword_blacklist)){
            $this->form_validation->set_rules('video_title', 'title', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('video_caption', 'caption', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('category', 'main field of research', 'trim|required');
            $this->form_validation->set_rules('subcategory', 'main research topic',
              'trim|required|callback_check_subMainCategory');
            $this->form_validation->set_rules('video_co_authors', 'co-author', 'max_length[1000]');
            $this->form_validation->set_rules('video_additional_information', 'additional information', 'max_length[3000]');

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
                  $this->input->post('video_title'),
                  $this->input->post('video_co_authors'),
                  $this->input->post('video_affiliation'),
                  $this->input->post('video_further_reading'),
                  $this->input->post('video_caption'),
                  $this->input->post('video_additional_information')
                );
                $resultCheckKeyWorkBlackList = $this->keywordblacklist->checkKeyWorkBackList($dataCheckKeyWorkBlackList);
                if ($resultCheckKeyWorkBlackList){
                    $username = $this->user->firstName . ' ' . $this->user->lastName;
                    $this->sendMailViolationsReport('Blacklist Hit: '.$resultCheckKeyWorkBlackList.', User: '.$username, $this->user->email);
                    $this->session->set_userdata('keyword_blacklist', true);

                    redirect(base_url('auth/content/video/upload'));
                }
                $doiYear = '';
                $doi = '';
                if ($this->input->post('registerDOI') == 1) {
                    $doiYear = date('Y');
                    $doi = 'requested';
                }
                $sharePublic = 0;
                if ($this->input->post('sharePublic') == 1) {
                    $sharePublic = 1;
                }

                $data = array(
                  'idAuthor' => $this->user->id,
                  'coAuthors' => $this->input->post('video_co_authors'),
                  'title' => $this->input->post('video_title'),
                  'videoAffiliation' => $this->input->post('video_affiliation'),
                  'furtherReading' => $this->input->post('video_further_reading'),
                  'description' => $this->input->post('video_additional_information'),
                  'caption' => $this->input->post('video_caption'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'altCategory1' => $altCategory1,
                  'altSubCategory1' => $altSubCategory1,
                  'path' => '',
                  'ext' => '',
                  'filesize' => $this->input->post('get-file-size'),
                  'filename_original' => $this->input->post('get-file-name'),
                  'status' => 0,
                  'language' => $this->input->post('video_language'),
                  'views' => '0',
                  'dateOfUpload' => time(),
                  'public' => $sharePublic,
                  'doi' => $doi,
                  'doiYear' => $doiYear

                );

                $newID = $this->movie->create($data);
                if ($newID) {
                    $userID = $this->user->id;

                    $this->makeUserDir($userID);
                    $this->makeObjectDir($userID, 'videos');

                    $config['upload_path'] = FCPATH . './uploads/userfiles/' . $this->user->id . '/videos/';
                    $config['allowed_types'] = 'mp4|flv|webm|3gp|wmv|mov|avi|mkv|vob|divx|xvid|ts|m4v|avchd|mpeg';
                    $config['max_size'] = 300000;
                    $config['overwrite'] = true;
                    $config['file_name'] = $newID;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('video')) {

                        $dataUpdate = array(
                          'path' => '/uploads/userfiles/' . $this->user->id . '/videos/' . $newID,
                          'ext' => strtolower(pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION))
                        );

                        if ($this->movie->update($newID, $dataUpdate)) {
                            $fileName = FCPATH . 'uploads/userfiles/' . $userID . '/videos/' . $this->upload->data('file_name');
                            $newImage = FCPATH . 'uploads/userfiles/' . $userID . '/videos/' . $newID . '.jpg';
                            exec("ffmpeg -ss 2 -i $fileName -s 770x400 $newImage");

                            $new_post = array(
                              'thumbnail' => base_url('uploads/userfiles/' . $userID . '/videos/' . $newID . '.jpg'),
                              'title' => $data['title'],
                              'date' => $data['dateOfUpload']
                            );

                            if (!empty($this->session->upload_video)) {
                                $uploadArr = $this->session->upload_video;
                                array_push($uploadArr, $new_post);
                            } else {
                                $uploadArr = array();
                                array_push($uploadArr, $new_post);
                            }
                            $this->session->set_userdata('upload_video', $uploadArr);

                            $dataQueue = array(
                              'author_id' => $userID,
                              'video_id' => $newID,
                              'filesize' => $this->input->post('get-file-size'),
                              'dateOfUpload' => time(),
                              'conversionStarted' => 'false'
                            );

                            $this->videoqueue->create($dataQueue);

                            if ($this->input->post('check_link_to_conference') == 1) {
                                $dataElement = array(
                                  'CID' => $this->input->post('cid'),
                                  'type' => 'video',
                                  'elementID' => $newID,
                                  'approved' => 1,
                                  'session' => $this->input->post('session')
                                );

                                $confTitle = $this->conference->get_info_binary('CID',
                                  $this->input->post('cid'))->confTitle;
                                $username = $this->user->firstName . ' ' . $this->user->lastName;

                                if ($this->conferenceelement->create($dataElement)) {
                                    $this->sendMailLinkToConference($this->user->email, $confTitle, $username,
                                      $this->input->post('video_title'));
                                }
                            }
                            $this->session->unset_userdata('link_to_conference');
                            redirect('auth/content/video/upload');
                        }
                    } else {
                        $this->movie->delete($newID);
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
            if (!empty($this->session->link_to_conference)) {
                $sessions = $this->conferencesession->getConferenceSessionByCID($this->session->link_to_conference);
                $this->data['sessions'] = $sessions;
            }
        }

        $this->auth_page = 'upload_video_old';
        $this->auth_content_layout();
        $this->session->unset_userdata('keyword_blacklist');
    }

    public function upload()
    {
        $this->session->set_userdata('active_content_sidebar', 'Video');
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

        $this->auth_page = 'upload_video';
        $this->auth_content_layout();
        $this->session->unset_userdata('keyword_blacklist');
    }

    function uploadEvent(){
        $dataCheckKeyWorkBlackList = array(
          $this->input->post('title'),
          $this->input->post('coAuthors'),
          $this->input->post('affiliation'),
          $this->input->post('furtherReading'),
          $this->input->post('caption'),
          $this->input->post('description')
        );
        $resultCheckKeyWorkBlackList = $this->keywordblacklist->checkKeyWorkBackList($dataCheckKeyWorkBlackList);
        if ($resultCheckKeyWorkBlackList){
            $username = $this->user->firstName . ' ' . $this->user->lastName;
            $this->sendMailViolationsReport('Blacklist Hit: '.$resultCheckKeyWorkBlackList.', User: '.$username, $this->user->email);
            $this->session->set_userdata('keyword_blacklist', true);

            redirect(base_url('auth/test/video/upload'));
        }
        $doiYear = '';
        $doi = '';
        if ($this->input->post('registerDOI') == 1) {
            $doiYear = date('Y');
            $doi = 'requested';
        }

        $sharePublic = 1;
        if ($this->input->post('sharePublic') != '') {
            $sharePublic = $this->input->post('sharePublic');
        }

        $data = array(
          'idAuthor' => $this->user->id,
          'coAuthors' => $this->input->post('coAuthors'),
          'title' => $this->input->post('title'),
          'videoAffiliation' => $this->input->post('affiliation'),
          'furtherReading' => $this->input->post('furtherReading'),
          'description' => $this->input->post('description'),
          'caption' => $this->input->post('caption'),
          'category' => $this->input->post('category'),
          'subcategory' => $this->input->post('subCategory'),
          'altCategory1' => $this->input->post('altCategory'),
          'altSubCategory1' => $this->input->post('altSubCategory'),
          'path' => '',
          'ext' => '',
          'filesize' => $this->input->post('fileSize'),
          'filename_original' => $this->input->post('fileName'),
          'status' => 0,
          'language' => $this->input->post('language'),
          'views' => '0',
          'dateOfUpload' => time(),
          'public' => $sharePublic,
          'doi' => $doi,
          'doiYear' => $doiYear

        );
        $newID = $this->movie->create($data);
        if ($newID) {
            $this->makeUserDir($this->userID);
            $this->makeObjectDir($this->userID, 'videos');

            $ext = strtolower(pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION));
            $fileName = FCPATH . './uploads/userfiles/' . $this->userID . '/videos/' . $newID . '.' . $ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $fileName)) {

                $dataUpdate = array(
                  'path' => '/uploads/userfiles/' . $this->user->id . '/videos/' . $newID,
                  'ext' => $ext
                );

                if ($this->movie->update($newID, $dataUpdate)) {
                    $newImage = FCPATH . 'uploads/userfiles/' . $this->userID . '/videos/' . $newID . '.jpg';
                    exec("ffmpeg -ss 2 -i $fileName -s 770x400 $newImage");

                    $new_post = array(
                      'thumbnail' => base_url('uploads/userfiles/' . $this->userID . '/videos/' . $newID . '.jpg'),
                      'title' => $data['title'],
                      'date' => $data['dateOfUpload']
                    );

                    if (!empty($this->session->upload_video)) {
                        $uploadArr = $this->session->upload_video;
                        array_push($uploadArr, $new_post);
                    } else {
                        $uploadArr = array();
                        array_push($uploadArr, $new_post);
                    }
                    $this->session->set_userdata('upload_video', $uploadArr);

                    $dataQueue = array(
                      'author_id' => $this->userID,
                      'video_id' => $newID,
                      'filesize' => $this->input->post('fileSize'),
                      'dateOfUpload' => time(),
                      'conversionStarted' => 'false'
                    );

                    $this->videoqueue->create($dataQueue);

                    if ($this->input->post('check_link_to_conference') == 1) {
                        $dataElement = array(
                          'CID' => $this->input->post('CID'),
                          'type' => 'video',
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
                              $this->input->post('title'), 'video');
                            $this->sendMailContributionToHostConference($hostConference->email, $hostName,
                              $newID, $this->input->post('title'), 'video');
                        }
                    }
                    $this->session->unset_userdata('link_to_conference');
                }
            } else {
                $this->movie->delete($newID);
                $this->session->set_flashdata('upload_post_msg', 'Error!');
            }
        } else {
            $this->session->set_flashdata('upload_post_msg', 'Error!');
        }
    }

    public function getVideo($id)
    {
        $post = $this->movie->get_info($id);
        if (!empty($post)) {
            $this->data['alt_category'] = $this->movie->getAltCategory($id);
            $this->data['post'] = $this->movie->get($id);

            $listConference = $this->conference->getConferenceByPost('video', $id);
            if (!empty($listConference)){
                $this->data['listConference'] = $listConference;
            }

            $this->auth_page = 'video_page';
            $this->auth_content_layout();
        } else {
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

    public function getEditVideo($id)
    {
        $post = $this->movie->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            $this->form_validation->set_rules('video_title', 'title', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('video_caption', 'caption', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('category', 'main field of research', 'trim|required');
            $this->form_validation->set_rules('subcategory', 'main research topic', 'trim|required');
            $this->form_validation->set_rules('video_co_authors', 'co-author', 'max_length[1000]');
            $this->form_validation->set_rules('video_additional_information', 'additional information',
              'max_length[3000]');

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
                  'coAuthors' => $this->input->post('video_co_authors'),
                  'title' => $this->input->post('video_title'),
                  'videoAffiliation' => $this->input->post('video_affiliation'),
                  'furtherReading' => $this->input->post('video_further_reading'),
                  'description' => $this->input->post('video_additional_information'),
                  'caption' => $this->input->post('video_caption'),
                  'category' => $this->input->post('category'),
                  'subcategory' => $this->input->post('subcategory'),
                  'altCategory1' => $altCategory1,
                  'altSubCategory1' => $altSubCategory1,
                  'public' => $sharePublic
                );
                $this->movie->update($post['id'], $data);
                redirect('auth/content/video/' . $post['id']);
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
            $this->data['checkLinkToConference'] = $this->conferenceelement->checkExist($id, 'video');
            $this->auth_page = 'edit_video';
            $this->auth_content_layout();
        }
    }

    public function checkDeleteVideo($id)
    {
        $post = $this->movie->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            if (empty($post['doi'])) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    public function deleteVideo($id)
    {
        $post = $this->movie->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            if ($this->movie->delete($id)) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }

    public function getRequestDoiVideo($id)
    {
        $post = $this->movie->get($id);
        if ($this->checkAuthor($post['idAuthor'])) {
            $this->session->set_userdata('post_type_doi', 'video');
            $this->data['post'] = $post;
            $this->auth_page = 'request_doi_video';
            $this->auth_content_layout();
        }
    }
}