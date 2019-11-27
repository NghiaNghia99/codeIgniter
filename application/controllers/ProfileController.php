<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class ProfileController extends MY_Controller
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
        $this->load->helper('url_helper', 'form', 'date', 'url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->session->set_userdata('active_top_header', 'profile');
            $this->data['active_top_header'] = $this->session->active_top_header;
            $this->session->set_userdata('active_profile_sidebar', 'Show profile');
            $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
            $this->session->unset_userdata('get_category_id');
            $this->session->unset_userdata('get_subcategory_id');
        } else {
            $this->redirectAfterLogin();
        }
    }

    public function getProfile()
    {
        $this->session->set_userdata('active_profile_sidebar', 'Show profile');
        $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
        $this->data['user'] = array(
          $this->user,
          $this->category->getCategory($this->user->category, $this->user->subcategory)
        );
        $this->auth_page = 'profile';
        $this->auth_profile_layout();
    }

    public function check_subcategory()
    {
        $category = $this->input->post('category');
        $sub_category = $this->input->post('subcategory');
        if (!empty($category) && empty($sub_category)) {
            $this->form_validation->set_message(__FUNCTION__, 'Please choose research topic');
            $this->session->set_userdata('get_category_id', $category);
            $this->session->set_userdata('get_subcategory_id', $sub_category);
            return false;
        }
        return true;
    }

    public function check_affiliation(){
        $affiliation = $this->input->post('affiliation');
        $user = $this->useraccount->get_info($this->user->id);
        $users = $this->useraccount->get_all_rule(array('affiliation' => $affiliation));
        if (!empty($users)){
            foreach ($users as $u){
                if ($u->id != $user->id){
                    $this->form_validation->set_message(__FUNCTION__, 'This affiliation already exists');
                    return false;
                }
            }
        }
        return true;
    }

    public function updateProfile()
    {
        $this->session->set_userdata('active_profile_sidebar', 'Profile information');
        $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|min_length[2]|max_length[30]',
          array(
            'min_length' => 'Please enter a valid %s',
            'max_length' => 'Please enter a valid %s',
          ));
        $this->form_validation->set_rules('affiliation', 'affiliation', 'trim|required');
        $this->form_validation->set_rules('subcategory', '', 'callback_check_subcategory');
        if ($this->form_validation->run()) {
            $data = array(
              'firstName' => $this->input->post('first_name'),
              'lastName' => $this->input->post('last_name'),
              'affiliation' => $this->input->post('affiliation'),
              'category' => $this->input->post('category'),
              'subcategory' => $this->input->post('subcategory'),
              'department' => $this->input->post('department'),
              'position' => $this->input->post('position'),
              'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'postalCode' => $this->input->post('postalCode'),
                'country' => $this->input->post('country'),
            );

            $this->useraccount->update($this->user->id, $data);
            redirect('auth/profile/update-profile');
        }

        $this->data['categories'] = array($this->useraccount->getCategories(), $this->useraccount->getSubCategories());
        $this->data['user'] = array(
          $this->user,
          $this->category->getCategory($this->user->category, $this->user->subcategory)
        );
        $this->session->set_userdata('get_category_id', $this->input->post('category'));
        $this->session->set_userdata('get_subcategory_id', $this->input->post('subcategory'));
        $this->data['categoryID'] = $this->session->get_category_id;
        $this->data['subCategoryID'] = $this->session->get_subcategory_id;
        $this->auth_page = 'update_profile';
        $this->auth_profile_layout();
    }

    public function getUpdateAvatar(){
        $this->session->set_userdata('active_profile_sidebar', 'Add/Change picture');
        $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
        $file_name = 'profilePhoto.jpg';
        $this->data['file_name'] = $file_name;
        $this->data['user'] = $this->user;
        $this->auth_page = 'update_avatar';
        $this->auth_profile_layout();
    }

    public function updateAvatar()
    {
        $this->session->set_userdata('active_profile_sidebar', 'Add/Change picture');
        $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
        $file_name = 'profilePhoto.jpg';
        $config['upload_path'] =  FCPATH . '/uploads/userfiles/' . $this->user->id . '/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 2000;
        $config['overwrite'] = true;
        $config['file_name'] = $file_name;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('avatar')){
            $fileName = FCPATH . '/uploads/userfiles/' . $this->user->id . '/' . 'profilePhoto.jpg';
            $convert = $this->config->config['convert'];
            exec("$convert $fileName -auto-orient -background \"#FFFFFF\" -flatten $fileName");

            $this->session->set_flashdata( 'upload_avatar_msg', 'Profile photo has been uploaded successfully!');
        }
        else{
            $this->session->set_flashdata( 'upload_avatar_msg', $this->upload->display_errors() );
        }

        $this->data['file_name'] = $file_name;
        $this->data['user'] = $this->user;
        $this->auth_page = 'update_avatar';
        $this->auth_profile_layout();
    }

    public function changePassword()
    {
        $this->session->unset_userdata('change_password');
        $this->session->set_userdata('active_profile_sidebar', 'Change password');
        $this->data['active_profile_sidebar'] = $this->session->active_profile_sidebar;
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
            $data = array(
              'password' => md5($this->input->post('password')),
            );

            if ($this->useraccount->update($this->user->id, $data)){
                $this->session->set_flashdata('change_password_msg', 'Password changed successfully!');
            }
            else{
                $this->session->set_flashdata('change_password_msg', 'Password change failed');
            }
        }
        $this->auth_page = 'change_password';
        $this->auth_profile_layout();
    }
}