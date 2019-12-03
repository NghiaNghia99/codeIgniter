<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
        $this->load->library('template');
    }


	public function index()
	{   
        /* Load */
        $this->load->config('admin/dp_config');
        $this->load->config('common/dp_config');
        /* Valid form */
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
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
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
            $this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
            $this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
            $this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
            $this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
            $this->data['memory_usage']      = $this->dashboard_model->memory_usage();
            $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
            $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);


            // /* TEST */
            // $this->data['url_exist']    = is_url_exist('http://www.domprojects.com');


            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
	}
}
