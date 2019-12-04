<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_license'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->load->library('template');
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_license'), 'admin/license');
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
			redirect('auth', 'refresh');
		}
        else
        {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Load Template */
            $this->template->admin_render('admin/license/index', $this->data);
        }
	}
}
