<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 *  Change current user language
 *
 * Class LangSwitch
 */
class LangSwitch extends CI_Controller
{
    /**
     * LangSwitch constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * Change current language
     *
     * @param string $language
     *  Return specific language
     */
    public function switchLanguage($language = "")
    {
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }
}