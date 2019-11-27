<?php
/**
 * Created by PhpStorm.
 * User: loiptx
 * Date: 6/4/2019
 * Time: 5:49 PM
 */

class LanguageLoader
{
    public function initialize()
    {
        $ci =& get_instance();
        $ci->load->helper('language');

        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->lang->load('content', $ci->session->userdata('site_lang'));
        } else {
            $ci->lang->load('content', 'english');
        }
    }
}