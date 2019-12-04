<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prefs extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->model('admin/preferences_model');
        $this->lang->load('admin/preferences');
        $this->load->library('template');
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_preferences'), 'admin/prefs');
        /* Load */
        $this->load->config('common/dp_config');
         /* COMMON :: ADMIN & PUBLIC */
            /* Load */
            $this->load->database();
                
            /* Data */
            $this->data['lang'] = element($this->config->item('language'), $this->config->item('language_abbr'));
            $this->data['charset'] = $this->config->item('charset');
            $this->data['frameworks_dir'] = $this->config->item('frameworks_dir');
            $this->data['plugins_dir'] = $this->config->item('plugins_dir');
            $this->data['avatar_dir'] = $this->config->item('avatar_dir');
    
            /* Any mobile device (phones or tablets) */
            if ($this->mobile_detect->isMobile())
            {
                $this->data['mobile'] = TRUE;
    
                if ($this->mobile_detect->isiOS()){
                    $this->data['ios'] = TRUE;
                    $this->data['android'] = FALSE;
                }
                elseif ($this->mobile_detect->isAndroidOS())
                {
                    $this->data['ios'] = FALSE;
                    $this->data['android'] = TRUE;
                }
                else
                {
                    $this->data['ios'] = FALSE;
                    $this->data['android'] = FALSE;
                }
    
                if ($this->mobile_detect->getBrowsers('IE')){
                    $this->data['mobile_ie'] = TRUE;
                }
                else
                {
                    $this->data['mobile_ie'] = FALSE;
                }
            }
            else
            {
                $this->data['mobile'] = FALSE;
                $this->data['ios'] = FALSE;
                $this->data['android'] = FALSE;
                $this->data['mobile_ie'] = FALSE;
            }
    }


	public function index()
	{

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_preferences'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Load Template */
            $this->template->admin_render('admin/prefs/index', $this->data);
        }
	}


	public function interfaces($type = NULL)
	{
                 
        /* Title Page */
        $this->page_title->push(lang('menu_preferences'), lang('menu_interfaces'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(2, lang('menu_interfaces'), 'admin/prefs/interfaces/admin');

        if ($type == 'admin')
        {
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(3, lang('menu_int_admin'), 'admin/prefs/interfaces/admin');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Validate form input */
            $this->form_validation->set_rules('user_panel', 'lang:prefs_user_panel', 'required|is_numeric');
            $this->form_validation->set_rules('sidebar_form', 'lang:prefs_sidebar_form', 'required|is_numeric');
            $this->form_validation->set_rules('messages_menu', 'lang:prefs_messages_menu', 'required|is_numeric');
            $this->form_validation->set_rules('notifications_menu', 'lang:prefs_notifications_menu', 'required|is_numeric');
            $this->form_validation->set_rules('tasks_menu', 'lang:prefs_tasks_menu', 'required|is_numeric');
            $this->form_validation->set_rules('user_menu', 'lang:prefs_user_menu', 'required|is_numeric');
            $this->form_validation->set_rules('ctrl_sidebar', 'lang:prefs_ctrl_sidebar', 'required|is_numeric');
            $this->form_validation->set_rules('transition_page', 'lang:prefs_transition_page', 'required|is_numeric');

            /* Data */
            $this->data['message_admin']        = (validation_errors()) ? validation_errors() : NULL;
            $this->data['admin_pref_interface'] = $this->preferences_model->get_interface('admin_preferences');

            if ($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'user_panel'         => (bool) $this->input->post('user_panel'),
                    'sidebar_form'       => (bool) $this->input->post('sidebar_form'),
                    'messages_menu'      => (bool) $this->input->post('messages_menu'),
                    'notifications_menu' => (bool) $this->input->post('notifications_menu'),
                    'tasks_menu'         => (bool) $this->input->post('tasks_menu'),
                    'user_menu'          => (bool) $this->input->post('user_menu'),
                    'ctrl_sidebar'       => (bool) $this->input->post('ctrl_sidebar'),
                    'transition_page'    => (bool) $this->input->post('transition_page')
                );

                $this->preferences_model->update_interfaces('admin_preferences', $data);

                redirect('admin/prefs/interfaces/admin', 'refresh');
            }
            else
            {
                /* Load Template */
                $this->template->admin_render('admin/prefs/interfaces/admin', $this->data);
            }
        }
        elseif ($type == 'public')
        {
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(3, lang('menu_int_public'), 'admin/prefs/interfaces/public');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Validate form input */
            $this->form_validation->set_rules('transition_page', 'lang:prefs_transition_page', 'required|is_numeric');

            /* Data */
            $this->data['message_public']        = (validation_errors()) ? validation_errors() : NULL;
            $this->data['public_pref_interface'] = $this->preferences_model->get_interface('public_preferences');

            if ($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'transition_page' => (bool) $this->input->post('transition_page')
                );

                $this->preferences_model->update_interfaces('public_preferences', $data);

                redirect('admin/prefs/interfaces/public', 'refresh');
            }
            else
            {
                /* Load Template */
                $this->template->admin_render('admin/prefs/interfaces/public', $this->data);
            }
        }
        else
        {
            redirect('admin', 'refresh');
        }
	}


	public function reset_interfaces_admin()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
        else
        {
            $data = array(
                'user_panel'         => '0',
                'sidebar_form'       => '0',
                'messages_menu'      => '0',
                'notifications_menu' => '0',
                'tasks_menu'         => '0',
                'user_menu'          => '1',
                'ctrl_sidebar'       => '0',
                'transition_page'    => '0'
            );

            $this->preferences_model->update_interfaces('admin_preferences', $data);

            redirect('admin/prefs/interfaces/admin', 'refresh');
        }
	}


	public function reset_interfaces_public()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
        else
        {
            $data = array(
                'transition_page' => '0'
            );

            $this->preferences_model->update_interfaces('public_preferences', $data);

            redirect('admin/prefs/interfaces/public', 'refresh');
        }
	}
}
