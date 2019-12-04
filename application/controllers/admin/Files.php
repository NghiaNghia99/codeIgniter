<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_files'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->load->library('template');
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_files'), 'admin/files');
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
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['error'] = NULL;

            /* Load Template */
            $this->template->admin_render('admin/files/index', $this->data);
        }
	}


	public function do_upload()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Conf */
            $config['upload_path']      = './uploads/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']         = 2048;
            $config['max_width']        = 1024;
            $config['max_height']       = 1024;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(2, lang('menu_files'), 'admin/files');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            if ( ! $this->upload->do_upload('userfile'))
            {
                /* Data */
                $this->data['error'] = $this->upload->display_errors();

                /* Load Template */
                $this->template->admin_render('admin/files/index', $this->data);
            }
            else
            {
                /* Data */
                $this->data['upload_data'] = $this->upload->data();

                /* Load Template */
                $this->template->admin_render('admin/files/upload', $this->data);
            }
        }
	}
}
