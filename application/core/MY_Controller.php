<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:04
 */

require FCPATH . '/vendor/autoload.php';

use PayPal\Api\Sale;

class MY_Controller extends CI_Controller
{

    /**
     * @var array
     */
    protected $data = array();
    protected $userID = false;
    protected $OPapiKey = false;
    protected $user;

    /**
     * MY_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
         /* COMMON :: ADMIN & PUBLIC */
        /* Load */
        $this->load->database();
        /*
         * Load languages
        * */
        $this->load->helper('language');
        $this->lang->load("content", "english");
        /*
         * Load default models
        * */
        $this->load->model('project');
        $this->load->model('category');
        $this->load->model('useraccount');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->model('movie');
        $this->load->model('paper');
        $this->load->model('poster');
        $this->load->model('presentation');
        $this->load->model('conferenceregistration');

        if (!empty($this->session->login)) {
            $this->user = $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')));
            $this->userID = $this->user->id;
            $this->OPapiKey = 'apikey:' . $this->user->api_key;
            if ($this->user->emailApproved != 1) {
                $this->session->set_userdata('waitForApprove', true);
            } else {
                $this->session->unset_userdata('waitForApprove');
            }
        }
    }


    function getApiContext($enableSandbox = false)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
          new \PayPal\Auth\OAuthTokenCredential(
            $this->config->config['clientID'],     // ClientID
            $this->config->config['clientSecret']      // ClientSecret
          )
        );
        $apiContext->setConfig(array(
          'mode' => $enableSandbox ? 'sandbox' : 'live'
        ));

        return $apiContext;
    }

    function getSaleDetail($saleID)
    {
        $sale = Sale::get($saleID, $this->getApiContext(true));
        if (!empty($sale)) {
            return $sale;
        }
        return false;
    }

    public function redirectAfterLogin()
    {
        $current_url = current_url();
        $login_url = base_url('login');

        if ($current_url != $login_url) {
            $this->session->set_userdata('login_redirect', $current_url);
        }
        redirect($login_url);
    }

    public function makeUserDir($userID)
    {
        $userDir = FCPATH . 'uploads/userfiles/' . $userID;
        if (!(is_dir($userDir) OR is_file($userDir) OR is_link($userDir))) {
            $oldmask = umask(0);
            mkdir($userDir, 0777);
            umask($oldmask);
        }
    }

    public function makeObjectDir($userID, $objectType)
    {
        $objectDir = FCPATH . 'uploads/userfiles/' . $userID . '/' . $objectType;
        if (!(is_dir($objectDir) OR is_file($objectDir) OR is_link($objectDir))) {
            $oldmask = umask(0);
            mkdir($objectDir, 0777);
            umask($oldmask);
        }
    }

    /**
     * @param $post_id
     * @return bool
     */
    public function checkAuthor($post_id)
    {
        if (!empty($this->session->login) && $this->useraccount->get_info_rule(array('email' => $this->session->userdata('login')))->id == $post_id) {
            return true;
        }
        return false;
    }


    /**
     * @param bool $userID
     * @return array
     */
    public function getCategoryMenu($userID = false)
    {
        $categories = $this->category->get($userID);
        $categories = array('categories' => $categories, 'counts' => $this->session->userdata('count_item_by_subcate'));
        return $categories;
    }

    /**
     *
     */
    public function layout()
    {
        $this->session->unset_userdata('auth_page', 'auth-page');
        $this->template['header'] = $this->load->view('templates/header', $this->data, true);
        $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
        $this->template['menu_category'] = $this->load->view('templates/menu_category',
          $this->getCategoryMenu($this->userID), true);
        $this->template['page'] = $this->load->view('pages/' . $this->page, $this->data, true);
        $this->load->view('templates/master', $this->template);
    }

    /**
     *
     */
    public function layout_invoice()
    {
        $this->session->unset_userdata('auth_page', 'auth-page');
        $this->template['page'] = $this->load->view('pages/' . $this->page, $this->data, true);
        $this->load->view('templates/master', $this->template);
    }

    /**
     *
     */
    public function auth_profile_layout()
    {
        if (isset($_SESSION['login'])) {
            $this->session->set_userdata('auth_page', 'auth-page');
            $this->template['header'] = $this->load->view('templates/header', $this->data, true);
            $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
            $this->template['menu_category'] = $this->load->view('templates/menu_category',
              $this->getCategoryMenu($this->userID),
              true);
            $this->template['auth_top_header'] = $this->load->view('templates/auth_top_header', $this->data, true);
            $this->template['auth_profile_sidebar'] = $this->load->view('templates/auth_profile_sidebar', $this->data,
              true);

            $this->template['auth_page'] = $this->load->view('auth_pages/' . $this->auth_page, $this->data, true);
            $this->load->view('templates/master', $this->template);
        } else {
            redirect('login');
        }
    }

    /**
     *
     */
    public function auth_content_layout()
    {
        if (isset($_SESSION['login'])) {
            $this->session->set_userdata('auth_page', 'auth-page');
            $this->template['header'] = $this->load->view('templates/header', $this->data, true);
            $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
            $this->template['menu_category'] = $this->load->view('templates/menu_category',
              $this->getCategoryMenu($this->userID),
              true);
            $this->template['auth_top_header'] = $this->load->view('templates/auth_top_header', $this->data, true);
            $this->template['auth_content_sidebar'] = $this->load->view('templates/auth_content_sidebar', $this->data,
              true);
            $this->template['auth_page'] = $this->load->view('auth_pages/' . $this->auth_page, $this->data, true);
            $this->load->view('templates/master', $this->template);
        } else {
            redirect('login');
        }
    }

    /**
     *
     */
    public function auth_conference_layout()
    {
        if (isset($_SESSION['login'])) {
            $this->session->set_userdata('auth_page', 'auth-page');
            $this->template['header'] = $this->load->view('templates/header', $this->data, true);
            $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
            $this->template['menu_category'] = $this->load->view('templates/menu_category',
              $this->getCategoryMenu($this->userID),
              true);
            $this->template['auth_top_header'] = $this->load->view('templates/auth_top_header', $this->data, true);
            $this->template['auth_conference_sidebar'] = $this->load->view('templates/auth_conference_sidebar',
              $this->data, true);
            $this->template['auth_page'] = $this->load->view('auth_pages/' . $this->auth_page, $this->data, true);
            $this->load->view('templates/master', $this->template);
        } else {
            redirect('login');
        }
    }

    public function auth_postpox_layout()
    {
        if (isset($_SESSION['login'])) {
            $this->session->set_userdata('auth_page', 'auth-page');
            $this->template['header'] = $this->load->view('templates/header', $this->data, true);
            $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
            $this->template['menu_category'] = $this->load->view('templates/menu_category',
              $this->getCategoryMenu($this->userID),
              true);
            $this->template['auth_top_header'] = $this->load->view('templates/auth_top_header', $this->data, true);
            $this->template['auth_page'] = $this->load->view('auth_pages/' . $this->auth_page, $this->data, true);
            $this->load->view('templates/master', $this->template);
        } else {
            redirect('login');
        }
    }

    public function getListProject()
    {
        $info = $this->project->get_list_project(array('idUser' => $this->userID, 'status' => 'paid'));
        $infoMemberships = $this->membership->get_list_project(array('idUser' => $this->userID));
        if (!$info) {
            $info = array();
        }
        if (!empty($infoMemberships)) {
            foreach ($infoMemberships as $variable => $value) {
                if ($value->host != 1) {
                    array_push($info, $value);
                }
            }
        }
        $listProject = array('listProject' => $info);
        return $listProject;
    }

    public function getMembershipProjectList()
    {
        $info = $this->project->get_list_project(array('idUser' => $this->userID, 'status' => 'paid'));
        $infoMemberships = $this->membership->get_list_project(array('idUser' => $this->userID));
        if (!$info) {
            $info = array();
        }
        if (!empty($infoMemberships)) {
            foreach ($infoMemberships as $variable => $value) {
                if ($value->host != 1) {
                    array_push($info, $value);
                }
            }
        }
        return $info;

    }

    public function auth_project_layout()
    {

        if (isset($_SESSION['login'])) {

            $this->session->set_userdata('auth_page', 'auth-page');
            $this->template['header'] = $this->load->view('templates/header', $this->data, true);
            $this->template['footer'] = $this->load->view('templates/footer', $this->data, true);
            $this->template['menu_category'] = $this->load->view('templates/menu_category',
              $this->getCategoryMenu($this->userID),
              true);
            $this->template['auth_top_header'] = $this->load->view('templates/auth_top_header', $this->data, true);
            $this->template['auth_project_sidebar'] = $this->load->view('templates/auth_project_sidebar',
              $this->getListProject(), true);
            $this->template['auth_page'] = $this->load->view('auth_pages/' . $this->auth_page, $this->data, true);
            $this->load->view('templates/master', $this->template);
        } else {
            redirect('login');
        }
    }

    /**
     * @param $active_view_sort
     * @return string
     */
    public function getViewsSort($active_view_sort)
    {
        if ($active_view_sort == "Max") {
            return 'DESC';
        }
        return 'ASC';
    }

    /**
     * @param $active_date_sort
     * @return string
     */
    public function getDateSort($active_date_sort)
    {
        if ($active_date_sort == "Youngest") {
            return 'ASC';
        }
        return 'DESC';
    }

    /**
     * @param $active_alpha_sort
     * @return string
     */
    public function getAlphaSort($active_alpha_sort)
    {
        if ($active_alpha_sort == "A-Z") {
            return 'ASC';
        }
        return 'DESC';
    }

    /**
     * @param $to
     * @param $code
     */
    public function sendMailActive($to, $code)
    {
        $subject = 'Welcome to Science Media - The OpenAccess Platform';

        $message = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<!-- NAME: 1 COLUMN -->
		<!--[if gte mso 15]>
		<xml>
			<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ScienceMedia</title>

    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
		}
		.templateContainer{
			max-width:600px !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#FAFAFA;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email\'s preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email\'s preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email\'s preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email\'s header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email\'s header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email\'s header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email\'s body area.
	*/
		#templateBody{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email\'s body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email\'s body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email\'s footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email\'s footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email\'s footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionTopContent,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email\'s preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}</style></head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
						<!--[if gte mso 9]>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
						<tr>
						<td align="center" valign="top" width="600" style="width:600px;">
						<![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">

                            Please complete your registration
                        </td>
                    </tr>
                </tbody></table>

                <table class="mcnTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="197">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top">


                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td style="padding:9px" class="mcnImageBlockInner" valign="top">
                    <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">


                                        <img alt="" src="https://gallery.mailchimp.com/5f0d0cedfec4dc6594c11823e/images/83bc5d56-d4c1-47b3-b6b8-1ccd1fe5cebc.png" style="max-width:288px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="288">


                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EAEAEA;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                            <h1><br>
Thank you for your registration at ScienceMedia</h1>

<p>Now that you\'ve registered an account, we need to check, if the email address you entered really belongs to you. Please click the following button:<br>
<br>
&nbsp;</p>

                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 25px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " title="Activate Account" href="' . base_url('register/active-account/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Activate Account</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                            <br>
You will be redirected to our website and will be able to login with your email address and password.<br>
<br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EAEAEA;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                            <div style="text-align: center;"><strong>What\'s next?</strong></div>

                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnImageGroupBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnImageGroupBlockOuter">

            <tr>
                <td style="padding:9px" class="mcnImageGroupBlockInner" valign="top">

                    <table class="mcnImageGroupContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="273">
                            <tbody><tr>
                                <td class="mcnImageGroupContent" style="padding-left: 9px; padding-top: 0; padding-bottom: 0;" valign="top">


                                        <img alt="" src="https://gallery.mailchimp.com/5f0d0cedfec4dc6594c11823e/images/21745eab-ca93-4a43-b45d-1d75cb1acb93.gif" style="max-width:800px; padding-bottom: 0;" class="mcnImage" width="264">


                                </td>
                            </tr>
                        </tbody></table>

                    <table class="mcnImageGroupContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="273">
                            <tbody><tr>
                                <td class="mcnImageGroupContent" style="padding-right: 9px; padding-top: 0; padding-bottom: 0;" valign="top">


                                        <img alt="" src="https://gallery.mailchimp.com/5f0d0cedfec4dc6594c11823e/images/de09e8b1-dd4d-47af-bde5-a5d313d98c0d.gif" style="max-width:800px; padding-bottom: 0;" class="mcnImage" width="264">


                                </td>
                            </tr>
                        </tbody></table>

                </td>
            </tr>

    </tbody>
</table><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="282">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">

                            <div style="text-align: justify;"><span style="font-size:12px"><strong>Upload your work and digital content</strong></span></div>

<div style="text-align: justify;"><span style="font-size:12px">As a member of the ScienceMedia Network you can upload and share your scientific work with the scientific community. The specifically designed platform allows you to describe your work and research connected with the uploaded content.</span></div>

                        </td>
                    </tr>
                </tbody></table>

                <table class="mcnTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="282">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top">

                            <div style="text-align: justify;"><span style="font-size:12px"><strong>Share your digital content in your work</strong></span></div>

<div style="text-align: justify;"><span style="font-size:12px">Use QR-codes and DOI references in order to give your audience a quick access to your OpenAcess research. Enhance your printed manuscripts and posters by a link to your digital content and profile within the ScienceMedia Network. </span></div>

                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter"><table class="mcnFollowBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td style="padding:9px" class="mcnFollowBlockInner" align="center" valign="top">
                <table class="mcnFollowContentContainer" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <td style="padding-left:9px;padding-right:9px;" align="center">
            <table style="min-width:100%;" class="mcnFollowContent" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td style="padding-top:9px; padding-right:9px; padding-left:9px;" align="center" valign="top">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                    <!--[if mso]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="https://twitter.com/SMNGmbH" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-twitter-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="http://www.sciencemedia.org" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="mailto:info@science-media.org" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-forwardtofriend-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                    <!--[if mso]>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EEEEEE;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                            <strong>Contact us:</strong><br>
<br>
SMN ScienceMedia Network GmbH<br>
Maienb&uuml;hlstr. 10<br>
79677 Wembach<br>
Germany<br>
<br>
info@science-media.org<br>
www.science-media.org<br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						<!--[if gte mso 9]>
						</td>
						</tr>
						</table>
						<![endif]-->
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>';

        $this->sendMail($to, $subject, utf8_decode($message), false);
    }

    /**
     * @param $email
     * @param $username
     * @param $code
     */
    public function sendMailRequestApproveToHost($email, $username, $code)
    {
        $subject = 'New User with non-conform e-mail';

        $text = '<h1>A new user has registered</h1><br/>
									Name: ' . $username . '<br/>
									E-Mail: ' . $email . '<br/><br/><br/>
						<h1>Manual activation</h1><br/>
						This user is using a non-conform e-mail address. Please click here to activate manually:<br/><br/><br/>
											<table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 25px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " title="Activate Account" href="' . base_url('register/approved-account/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Activate Account</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br/><br/><br/>';

        $message = utf8_decode($this->standardMail($text, $email));

        $to = $this->config->config['email_admin'];

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailAcceptedToUser($to)
    {
        $subject = 'Account approved';

        $text = '
        <p>Your registration on <a href="' . base_url() . '">www.science-media.org</a> is approved.</p>
        <p>You are now able to upload content to your account on <a href="' . base_url() . '">www.science-media.org</a></p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailRemindActive($to, $username)
    {
        $subject = 'Remind to activate account';

        $text = '
        <p>Hi ' . $username . ',</p>
        <p>This is just a reminder that you has received an Active Email from Science Media and you need to activate it to use your account.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    /**
     * @param $to
     * @param $code
     */
    public function sendMailForgotPassword($to, $code)
    {
        $subject = 'Password recovery';

        $text = '
        <p>Please click here to reset your password.</p>
        <table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 10px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " title="Activate Account" href="' . base_url('forgot-password/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Reset password</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br><br><br>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    /**
     * @param $to
     * @param $fullName
     */
    public function sendMailFiftyViews($to, $fullName)
    {
        $subject = 'Congratulations! Your writing got more than 50 views!';

        $text = '
        <p>Congratulations!</p>
        <p>We are happy to inform <b>' . $fullName . '</b> that your writing got more than 50 views.</p>
        <p>You did a great job! Best wish for your writing in the future.</p><br>
        <div>Best regards,</div>
        <div>Science Media Team</div>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    /**
     * @param $comment
     */
    public function sendMailTellUs($comment)
    {
        $to = $this->config->config['email_admin'];

        $subject = 'New Comment Received';

        $text = '
        <p>Below is the feedback has got from the user:</p>
        <p> ' . $comment . '</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    /**
     * @param $postType
     * @param $postID
     * @param $report
     * @param $postTitle
     */
    public function sendMailReport($postType, $postID, $report, $postTitle)
    {
        $to = $this->config->config['email_admin'];

        $subject = 'Reported Content Object';

        $text = '<p>Content Object named: <b>' . $postTitle . '</b> has been reported with reason "' . $report . '"</p>' .
          '<p>Link: ' . base_url($postType . '/' . $postID) . '</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailInviteCoAuthor($to, $code, $username, $confTitle, $permissionsList)
    {
        $subject = 'Invitation to you to join the conference "' . $confTitle . '" as co-editor';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>You were added as co-author for the conference from the Conference Host "' . $confTitle . '". You are able to edit the following sections of the conference: </p>';
        $text .= $permissionsList;
        $text .= '<p>You should click on button "Accept" on email to accept the invitation.</p>';
        $text .= '
        <table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 10px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " href="' . base_url('auth/invite-co-author/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Accept</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br><br><br>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailInviteCoAuthorNotActivated($to, $code, $username, $confTitle, $permissionsList)
    {
        $subject = 'Invitation to you to join the conference "' . $confTitle . '" as co-editor';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>You were added as co-author for the conference from the Conference Host "' . $confTitle . '". You are able to edit the following sections of the conference: </p>';
        $text .= $permissionsList;
        $text .= '<p>Please click on button "Accept" to activate your account and get permission to access into conference "' . $confTitle . '". </p>';
        $text .= '
        <table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 10px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " href="' . base_url('auth/invite-co-author/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Accept</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br><br><br>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailInviteCoAuthorNoSMN($to, $code, $username, $confTitle, $permissionsList)
    {
        $subject = 'Invitation to you to join the conference "' . $confTitle . '" as co-editor';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>You were added as co-author for the conference from the Conference Host "' . $confTitle . '". You are able to edit the following sections of the conference: </p>';
        $text .= $permissionsList;
        $text .= '<p>Please click on button "Accept" and change password (if you have no SMN acc before) to get permission to access into conference "' . $confTitle . '". </p>';
        $text .= '
        <table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: Arial; font-size: 20px; padding: 10px;" class="mcnButtonContent" align="center" valign="middle">
                                <a class="mcnButton " href="' . base_url('auth/invite-co-author/' . $code) . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Accept</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br><br><br>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailInviteMemberProject($to, $code, $username)
    {
        $subject = 'Invitation to you to join the member of project';

        $message = '<p>Dear ' . $username . ',</p>';
        $message .= '
        <a style="margin-right: 20px" href="' . base_url('auth/invite-co-author/' . $code) . '">Accept </a>
        ';

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailUpdatePermissionCoAuthor($to, $username, $confTitle, $permissionsList)
    {
        $subject = 'Your permission in conference "' . $confTitle . '" has been updated';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>Now, you are able to edit the following sections of the conference: </p>';
        $text .= $permissionsList;
        $text .= '<p>If have any question please contact the host.</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailDeleteCoAuthor($to, $username, $confTitle)
    {
        $subject = 'All your permission in conference "' . $confTitle . '" has been revoked';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>We\'re sorry to inform you that all your rights in the "' . $confTitle . '" conference revoked. You now cannot access and edit anything in this conference. Please contact the host of the conference for more information.</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailRegisterConference($to, $confTitle, $confID)
    {
        $subject = $confTitle . ': Conference registration';

        $text = '
        <p>Hereby we confirm that your registration for the conference/workshop "' . $confTitle . '" was successful. If you have any further questions, please contact the conference/workshop host.</p>
        <p>If you want to submit an abstract now, <a href="' . base_url('abstract/' . $confID) . '">please click here.</a></p>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailRegisterConferenceUnpaid($to, $confTitle, $confID)
    {
        $subject = $confTitle . ': Conference registration';

        $text = '
        <p>Hereby we confirm that your registration for the conference/workshop "' . $confTitle . '" was successful but you have not paid yet. If you have any further questions, please contact the conference/workshop host.</p>
        <p>If you want to submit an abstract now, <a href="' . base_url('abstract/' . $confID) . '">please click here.</a></p>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailRegisterConferencePaid($to, $confTitle, $confID)
    {
        $subject = $confTitle . ': Conference registration';

        $text = '
        <p>Hereby we confirm that your registration for the conference/workshop "' . $confTitle . '" was successful. Your payment is being processed by PayPal. If you have any further questions, please contact the conference/workshop host.</p>
        <p>If you want to submit an abstract now, <a href="' . base_url('abstract/' . $confID) . '">please click here.</a></p>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailAbstractConference($to, $confTitle)
    {
        $subject = $confTitle . ': Abstract submission';

        $text = '
        <p>Hereby we confirm that your abstract submission for the conference/workshop "' . $confTitle . '" was successful. If you have any further questions, please contact the conference/workshop host.</p>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailReject($to, $confTitle, $reason, $type, $username)
    {
        $subject = 'Rejected the abstract for conference "' . $confTitle . '"';
        $text = '<p>Dear ' . $username . ', </p>';
        if ($type == 'registration') {
            $subject = 'Rejected the registration for conference "' . $confTitle . '"';
            $text .= '<p>The registration you submitted to us has been rejected by the following reason: </p>';
        } else {
            $text .= '<p>The abstract you submitted to us has been rejected by the following reason: </p>';
        }

        $text .= '<p>' . $reason . '</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailRemind($to, $confTitle, $username)
    {
        $subject = $confTitle . ': Reminder payment';

        $text = '
        <p>Hi ' . $username . ',</p>
        <p>You registered for the conference "' . $confTitle . '". This is to inform you that according to our records we did not receive your payment of the conference fee, yet.  Please pay your conference fee according to the described procedures.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailLinkToConference($to, $confTitle, $username, $postID, $postTitle, $postType)
    {
        $subject = 'Connected content object with conference successfully';

        $text = '
        <p>Dear ' . $username . ',</p>
        <p>A ' . $postType . ' "' . $postTitle . '" is now connected with the conference "' . $confTitle . '".</p>
        <p>Click <a href="' . base_url($postType . '/' . $postID) . '">here</a> to view uploaded content.</p>
        <br>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailContributionToHostConference($to, $username, $postID, $postTitle, $postType)
    {
        $subject = 'A new ' . $postType . ' has been linked to your conference';

        $text = '
        <p>Dear ' . $username . ',</p>
        <p>A new ' . $postType . ' has been uploaded with the title "' . $postTitle . '".</p>
        <p>Please confirm that this contribution belongs to your conference via the manage conference button on your conference page.</p>
        <p>Click <a href="' . base_url($postType . '/' . $postID) . '">here</a> to view uploaded content.</p>
        <br>
        <p>Your ScienceMedia-Team</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailUpdateSessionElement($to, $confTitle, $username, $postTitle, $sessionName1, $sessionName2)
    {
        $subject = 'Change session for Content object';

        $text = '
        <p>Dear ' . $username . ',</p>
        <p>The host of conference "' . $confTitle . '" has changed session for your content object "' . $postTitle . '" from "' . $sessionName1 . '" to "' . $sessionName2 . '". If have any question please contact the host.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailUpdateTypeAbstract($to, $confTitle, $username, $abstractTitle, $type, $newType)
    {
        $subject = 'Change type for abstract';

        $text = '
        <p>Dear ' . $username . ',</p>
        <p>The host of conference "' . $confTitle . '" has changed type for your abstract "' . $abstractTitle . '" from "' . $type . '" to "' . $newType . '". If have any question please contact the host.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailDeleteLinkToConference($to, $confTitle, $username, $postTitle)
    {
        $subject = 'Delete the reference of the content object';

        $text = '
        <p>Dear ' . $username . ',</p>
        <p>The host of the conference "' . $confTitle . '" has removed the reference of your uploaded contribution "' . $postTitle . '" to this conference, because the object does not belong to the conference or is inadequate. If you have any questions please contact the host of the conference.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailInvoice($to, $username, $attach)
    {
        $subject = 'Send invoice';

        $text = '<p>Dear ' . $username . ',</p>
        <p>Please see attached invoice.</p>
        <p>It is a pleasure serving you.</p>
        ';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, $attach);
    }

    public function sendMailViolationsReport($text, $contentinfo)
    {
        $to = $this->config->config['email_admin'];

        $subject = 'Upload prevented by keyword blacklist';

        $message = utf8_decode($this->standardMail($text, $contentinfo));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailAddMember($to, $username, $projectTitle, $role)
    {
        $subject = 'Invitation to you to join the project "' . $projectTitle . '"';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>You were added as ' . $role . ' for the project from the project host "' . $projectTitle . '".</p>';

        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }

    public function sendMailAddAssign($to, $username, $workPackageTitle, $workPackageType, $type, $url)
    {
        $subject = 'Invitation to you to join the ' . $workPackageType . ' "' . $workPackageTitle . '"';

        $text = '<p>Dear ' . $username . ',</p>';
        $text .= '<p>You were added as ' . $type . ' for the ' . $workPackageType . ' "' . $workPackageTitle . '"' . ' from the project host.</p>';
        $text .= '<br>
        <table class="mcnButtonBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody class="mcnButtonBlockOuter">
                <tr>
                    <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" class="mcnButtonBlockInner" align="center" valign="top">
                        <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border: 3px solid #C1D105;border-radius: 5px;background-color: #C1D105;" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="font-family: Arial; font-size: 20px; padding: 10px;" class="mcnButtonContent" align="center" valign="middle">
                                        <a class="mcnButton " href="' . $url . '" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">View detail</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br>
        ';
        $message = utf8_decode($this->standardMail($text, ''));

        $this->sendMail($to, $subject, $message, false);
    }


    function standardMail($text, $contentinfo)
    {
        $result = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<!-- NAME: 1 COLUMN -->
		<!--[if gte mso 15]>
		<xml>
			<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ScienceMedia</title>

    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
		}
		.templateContainer{
			max-width:600px !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#FAFAFA;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email\'s preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email\'s preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email\'s preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email\'s header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email\'s header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email\'s header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email\'s body area.
	*/
		#templateBody{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email\'s body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email\'s body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email\'s footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email\'s footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email\'s footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionTopContent,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email\'s preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}</style></head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
						<!--[if gte mso 9]>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
						<tr>
						<td align="center" valign="top" width="600" style="width:600px;">
						<![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">

                            ' . $contentinfo . '
                        </td>
                    </tr>
                </tbody></table>

                <table class="mcnTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="197">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top">


                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td style="padding:9px" class="mcnImageBlockInner" valign="top">
                    <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">


                                        <img alt="" src="https://gallery.mailchimp.com/5f0d0cedfec4dc6594c11823e/images/83bc5d56-d4c1-47b3-b6b8-1ccd1fe5cebc.png" style="max-width:288px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="288">


                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EAEAEA;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">
						' . $text . '
	                    </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table>
</td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter"><table class="mcnFollowBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td style="padding:9px" class="mcnFollowBlockInner" align="center" valign="top">
                <table class="mcnFollowContentContainer" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <td style="padding-left:9px;padding-right:9px;" align="center">
            <table style="min-width:100%;" class="mcnFollowContent" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td style="padding-top:9px; padding-right:9px; padding-left:9px;" align="center" valign="top">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                    <!--[if mso]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="https://twitter.com/SMNGmbH" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-twitter-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="http://www.sciencemedia.org" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->


                                            <table style="display:inline;" align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer" valign="top">
                                                        <table class="mcnFollowContentItem" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody><tr>
                                                                <td style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;" align="left" valign="middle">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>

                                                                                <td class="mcnFollowIconContent" align="center" valign="middle" width="24">
                                                                                    <a href="mailto:info@science-media.org" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-forwardtofriend-48.png" style="display:block;" class="" height="24" width="24"></a>
                                                                                </td>


                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                    <!--[if mso]>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EEEEEE;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table><table class="mcnTextBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top">

                <table style="min-width:100%;" class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>

                        <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                            <strong>Contact us:</strong><br>
<br>
SMN ScienceMedia Network GmbH<br>
Maienb&uuml;hlstr. 10<br>
79677 Wembach<br>
Germany<br>
<br>
info@science-media.org<br>
www.science-media.org<br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						<!--[if gte mso 9]>
						</td>
						</tr>
						</table>
						<![endif]-->
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>';

        return $result;
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param bool $attach
     */
    public function sendMail($to, $subject, $message, $attach = false)
    {

        $this->load->library('email');
        $config = $this->config->config;
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->from('account-verification-noreply@science-media.org', 'Science Media');
        $this->email->to($to);

        $this->email->subject($subject);

        $this->email->message($message);

        if (!empty($attach)) {
            $this->email->attach($attach);
        }

        try {
            $this->email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //TASK

    public function GetUrlTask($idProject = null, $idTask = null)
    {
        $url = $this->config->config['api_url'];
        if ($idProject != null) {
            $url = $url . "projects/" . $idProject . "/work_packages";
        } else {
            $url = $url . "work_packages/" . $idTask;
        }
        if ($idProject == null && $idTask == null) {
            $url = $url . "projects";
        }
        return $url;
    }

    public function GetUrlMember($idMember = null)
    {
        $url = $this->config->config['api_url'];
        if ($idMember != null) {
            $url = $url . "users/" . $idMember;
        } else {
            $url = $url . "users?pageSize=500";
        }
        return $url;
    }

    public function CurlSetup($url, $method = null, $dataArray = null, $apiKeyAdmin = false)
    {
        $api_key = $this->OPapiKey;
        if ($apiKeyAdmin) {
            $api_key = $this->config->config['api_key'];
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key);
        $header = array();
        $header[] = 'Content-Type: application/json; charset=utf-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        if ($method == "get") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }
        if ($method == "post") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataArray));
        }
        if ($method == "delete") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        if ($method == "patch") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataArray));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function CurlSetupDownloadFile($url, $fileName = false, $dir_path = false, $apiKeyAdmin = false)
    {
        $api_key = $this->OPapiKey;
        if ($apiKeyAdmin) {
            $api_key = $this->config->config['api_key'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        $file_path = $dir_path . $fileName;

        $fp = fopen($file_path, 'w+');
        fwrite($fp, $result);
        fclose($fp);
    }

    function build_data_files($boundary, $fields, $files)
    {
        $data = '';
        $eol = "\r\n";

        $delimiter = '-------------' . $boundary;

        foreach ($fields as $name => $content) {
            $data .= "--" . $delimiter . $eol
              . 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
              . json_encode($content) . $eol;
        }


        foreach ($files as $name => $content) {
            $data .= "--" . $delimiter . $eol
              . 'Content-Disposition: form-data; name="file"; filename="' . $name . '"' . $eol
              //. 'Content-Type: image/png'.$eol
              . 'Content-Transfer-Encoding: binary' . $eol;

            $data .= $eol;
            $data .= $content . $eol;
        }
        $data .= "--" . $delimiter . "--" . $eol;


        return $data;
    }

    public function CurlSetupFile($url, $dataArray = null, $apiKeyAdmin = false)
    {
        $api_key = $this->OPapiKey;
        if ($apiKeyAdmin) {
            $api_key = $this->config->config['api_key'];
        }
        $fields = array("metadata" => $dataArray);

        $files = array();
        foreach ($_FILES as $f) {
            $files[$f['name']] = file_get_contents(realpath($f['tmp_name']));
        }

        $curl = curl_init();

        $boundary = uniqid();
        $delimiter = '-------------' . $boundary;

        $post_data = $this->build_data_files($boundary, $fields, $files);


        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
            //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $post_data,
          CURLOPT_HTTPHEADER => array(
              //"Authorization: Bearer $TOKEN",
            "Content-Type: multipart/form-data; boundary=" . $delimiter,
            "Content-Length: " . strlen($post_data)

          ),
        ));
        curl_setopt($curl, CURLOPT_USERPWD, $api_key);
//
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function GetlockVersion($id)
    {
        $url = $this->GetUrlTask(null, $id);
        $response = $this->CurlSetup($url);
        $response = json_decode($response);
        $lockVersion = $response->lockVersion;
        if (strlen($lockVersion) == 1) {
            $lockVersion = substr($lockVersion, -1);
        } else {
            if (strlen($lockVersion) == 2) {
                $lockVersion = substr($lockVersion, -2, 2);
            } else {
                if (strlen($lockVersion) == 3) {
                    $lockVersion = substr($lockVersion, -3, 3);
                }
            }
        }
        return $lockVersion;
    }


    public function GetDataArray(
      $raw = null,
      $subject = null,
      $startDate = null,
      $dueDate = null,
      $estimatedTime = null,
      $percentageDone = null,
      $priority = null,
      $category = null,
      $version = null,
      $assignee = null,
      $attachFile = null,
      $accountable = null,
      $type = null,
      $storyPoints = null,
      $remainingTime = null,
      $dateMileStone = null,
      $parentID = null
    ) {
        $dataArray = [];
        $dataArray = array(
          'description' =>
            array(
              'format' => 'textile',
              'raw' => $raw,
            ),
          'subject' => $subject,
          '_links' =>
            array(
              'type' =>
                array(
                  'href' => '/api/v3/types/' . $type,
                ),
            )
        );
        if ($startDate != null) {
            $startDate = date("Y-m-d", strtotime($startDate));
            $dataArray['startDate'] = $startDate;
        }
        if ($dueDate != null) {
            $dueDate = date("Y-m-d", strtotime($dueDate));
            $dataArray['dueDate'] = $dueDate;
        }
        if ($dateMileStone != null) {
            $dateMileStone = date("Y-m-d", strtotime($dateMileStone));
            $dataArray['date'] = $dateMileStone;
        }
        if ($estimatedTime) {
            if ($estimatedTime < 24) {
                $resultEstimatedTime = "PT" . $estimatedTime . "H";
            } else {
                if ($estimatedTime >= 24) {
                    $hourEstimated = $estimatedTime % 24;
                    $dayEstimated = ($estimatedTime - $hourEstimated) / 24;
                    if ($hourEstimated == 0) {
                        $resultEstimatedTime = "P" . $dayEstimated . "D";
                    } else {
                        if ($hourEstimated != 0) {
                            $resultEstimatedTime = "P" . $dayEstimated . "DT" . $hourEstimated . "H";
                        }
                    }
                }
            }
            $dataArray['estimatedTime'] = $resultEstimatedTime;
        }
        if ($remainingTime) {
            if ($remainingTime < 24) {
                $resultremainingTime = "PT" . $remainingTime . "H";
            } else {
                if ($remainingTime >= 24) {
                    $hourremainingTime = $remainingTime % 24;
                    $dayremainingTime = ($remainingTime - $hourremainingTime) / 24;
                    if ($hourremainingTime == 0) {
                        $resultremainingTime = "P" . $dayremainingTime . "D";
                    } else {
                        if ($hourremainingTime != 0) {
                            $resultremainingTime = "P" . $dayremainingTime . "DT" . $hourremainingTime . "H";
                        }
                    }
                }
            }
            $dataArray['remainingTime'] = $resultremainingTime;
        }
        if ($storyPoints) {
            $dataArray['storyPoints'] = $storyPoints;
        }
        if ($percentageDone) {
            $dataArray['percentageDone'] = $percentageDone;
        }
        if ($priority) {
            $dataArray['_links']['priority']['href'] = '/api/v3/priorities/' . $priority;
        }
        if ($category) {
            $dataArray['_links']['category']['href'] = $category;
        }
        if ($version) {
            $dataArray['_links']['version']['href'] = $version;
        }
        if ($assignee) {
            $dataArray['_links']['assignee']['href'] = '/api/v3/users/' . $assignee;
        }
        if ($attachFile) {
            $dataArray['_links']['downloadLocation']['href'] = $attachFile;
        }
        if ($accountable) {
            $dataArray['responsible']['href'] = '/api/v3/users/' . $accountable;
        }
        if ($parentID) {
            $dataArray['_links']['parent']['href'] = "/api/v3/work_packages/$parentID";
        }
        return $dataArray;
    }

    public function getDataUpdateTask(
      $lockVersion,
      $raw,
      $startDate = null,
      $dueDate = null,
      $estimatedTime,
      $percentageDone,
      $priority,
      $category,
      $version,
      $assignee,
      $attachFile,
      $accountable
    ) {
        if ($startDate != null && $dueDate != null) {
            $dataArray = array(
              'description' =>
                array(
                  'format' => 'textile',
                  'raw' => $raw,
                ),
              'lockVersion' => $lockVersion,
              'startDate' => $startDate,
              'dueDate' => $dueDate,
              'estimatedTime' => $estimatedTime,
              'percentageDone' => $percentageDone,
              '_links' =>
                array(
                  'type' =>
                    array(
                      'href' => '/api/v3/types/1',
                      'title' => 'Task',
                    ),
                  'priority' =>
                    array(
                      'href' => '/api/v3/priorities/' . $priority,
                    ),
                  'category' =>
                    array(
                      'name' => $category,
                    ),
                  'version' =>
                    array(
                      'name' => $version,
                    ),
                  'assignee' =>
                    array(
                      'href' => '/api/v3/users/' . $assignee,
                    ),
                  'downloadLocation' =>
                    array(
                      'href' => $attachFile,
                    ),
                ),
              'responsible' =>
                array(
                  'href' => '/api/v3/users/' . $accountable,
                ),
            );
        } else {
            if ($startDate == null && $dueDate != null) {
                $dataArray = array(
                  'description' =>
                    array(
                      'format' => 'textile',
                      'raw' => $raw,
                    ),
                  'lockVersion' => $lockVersion,
                  'dueDate' => $dueDate,
                  'estimatedTime' => $estimatedTime,
                  'percentageDone' => $percentageDone,
                  '_links' =>
                    array(
                      'type' =>
                        array(
                          'href' => '/api/v3/types/1',
                          'title' => 'Task',
                        ),
                      'priority' =>
                        array(
                          'href' => '/api/v3/priorities/' . $priority,
                        ),
                      'category' =>
                        array(
                          'name' => $category,
                        ),
                      'version' =>
                        array(
                          'name' => $version,
                        ),
                      'assignee' =>
                        array(
                          'href' => '/api/v3/users/' . $assignee,
                        ),
                      'downloadLocation' =>
                        array(
                          'href' => $attachFile,
                        ),
                    ),
                  'responsible' =>
                    array(
                      'href' => '/api/v3/users/' . $accountable,
                    ),
                );
            } else {
                if ($startDate != null && $dueDate == null) {
                    array(
                      'description' =>
                        array(
                          'format' => 'textile',
                          'raw' => $raw,
                        ),
                      'lockVersion' => $lockVersion,
                      'startDate' => $startDate,
                      'estimatedTime' => $estimatedTime,
                      'percentageDone' => $percentageDone,
                      '_links' =>
                        array(
                          'type' =>
                            array(
                              'href' => '/api/v3/types/1',
                              'title' => 'Task',
                            ),
                          'priority' =>
                            array(
                              'href' => '/api/v3/priorities/' . $priority,
                            ),
                          'category' =>
                            array(
                              'name' => $category,
                            ),
                          'version' =>
                            array(
                              'name' => $version,
                            ),
                          'assignee' =>
                            array(
                              'href' => '/api/v3/users/' . $assignee,
                            ),
                          'downloadLocation' =>
                            array(
                              'href' => $attachFile,
                            ),
                        ),
                      'responsible' =>
                        array(
                          'href' => '/api/v3/users/' . $accountable,
                        ),
                    );

                } else {
                    if ($startDate == null && $dueDate == null) {
                        $dataArray = array(
                          'description' =>
                            array(
                              'format' => 'textile',
                              'raw' => $raw,
                            ),
                          'lockVersion' => $lockVersion,
                          'estimatedTime' => $estimatedTime,
                          'percentageDone' => $percentageDone,
                          '_links' =>
                            array(
                              'type' =>
                                array(
                                  'href' => '/api/v3/types/1',
                                  'title' => 'Task',
                                ),
                              'priority' =>
                                array(
                                  'href' => '/api/v3/priorities/' . $priority,
                                ),
                              'category' =>
                                array(
                                  'name' => $category,
                                ),
                              'version' =>
                                array(
                                  'name' => $version,
                                ),
                              'assignee' =>
                                array(
                                  'href' => '/api/v3/users/' . $assignee,
                                ),
                              'downloadLocation' =>
                                array(
                                  'href' => $attachFile,
                                ),
                            ),
                          'responsible' =>
                            array(
                              'href' => '/api/v3/users/' . $accountable,
                            ),
                        );

                    }
                }
            }
        }
        return $dataArray;

    }

    public function changeTitle($str)
    {
        $str = $this->stripSpecial($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
        return $str;
    }

    public function stripSpecial($str)
    {
        $arr = array(",", "$", "!", "?", "&", "'", '"', "+");
        $str = str_replace($arr, "", $str);
        $str = trim($str);
        while (strpos($str, "  ") > 0) {
            $str = str_replace("  ", " ", $str);
        }
        $str = str_replace("+", "-", $str);
        $str = str_replace("*", "-", $str);
        $str = str_replace("'", "-", $str);
        $str = str_replace("/", "-", $str);
        $str = str_replace(":", "-", $str);
        $str = str_replace("_", "-", $str);
        $str = str_replace(".", "-", $str);
        $str = str_replace(" ", "-", $str);
        $str = str_replace("!", "-", $str);
        $str = str_replace("@", "-", $str);
        $str = str_replace("#", "-", $str);
        $str = str_replace("$", "-", $str);
        $str = str_replace("%", "-", $str);
        $str = str_replace("^", "-", $str);
        $str = str_replace("&", "-", $str);
        $str = str_replace("*", "-", $str);
        $str = str_replace("(", "-", $str);
        $str = str_replace(")", "-", $str);
        $str = str_replace("{", "-", $str);
        $str = str_replace("}", "-", $str);
        $str = str_replace("[", "-", $str);
        $str = str_replace("]", "-", $str);
        $str = str_replace("|", "-", $str);
        $str = str_replace("\"", "-", $str);
        $str = str_replace("'", "-", $str);
        $str = str_replace(";", "-", $str);
        $str = str_replace("<", "-", $str);
        $str = str_replace(">", "-", $str);
        $str = str_replace(",", "-", $str);
        $str = str_replace("?", "-", $str);
        return $str;
    }

    public function requestDoi($id)
    {
        if (isset($_SESSION['post_type_doi'])) {
            $post_type = $this->session->post_type_doi;
            $post = null;
            if ($post_type == 'video') {
                $post = $this->movie->get($id);
                if (!empty($post)) {
                    $title = $post['title'];
                }
            } elseif ($post_type == 'presentation') {
                $post = $this->presentation->get($id);
                if (!empty($post)) {
                    $title = $post['presTitle'];
                }
            } elseif ($post_type == 'poster') {
                $post = $this->poster->get($id);
                if (!empty($post)) {
                    $title = $post['posterTitle'];
                }
            } elseif ($post_type == 'paper') {
                $post = $this->paper->get($id);
                if (!empty($post)) {
                    $title = $post['paperTitle'];
                }
            }

            if (!empty($post)) {
                $documentAffiliation = "SMN - The ScienceMedia Network";
                $documentID = $post['id'];
                $idAuthor = $post['idAuthor'];
                $coAuthors = $post['coAuthors'];
                $furtherReading = $post['furtherReading'];
                $caption = $post['caption'];
                $category = $post['category_name'];
                $subcategory = $post['subcategory_name'];
                $altCategory = $post['altCategory1'];
                $altSubcategory = $post['altSubCategory1'];
                $veterinary = $post['veterinary'];
                $altVeterinary = $post['altVeterinary'];
                $dateOfUpload = $post['dateOfUpload'];
                $views = $post['views'];
                $path = $post['path'];
                $doiYear = $post['doiYear'];
                $language = $post['language'];

                if ($doiYear == "0") {
                    $doiYear = date("Y");
                }
                if ($language == "") {
                    $language = "eng";
                }

                $url = base_url($post_type . '/' . $id);

                $doi = $this->config->config['doiPrefix'] . $doiYear . '/' . $post_type . ':' . $id;

                $path = substr($path, 1);

                $title = str_replace("&", "and", $title);
                $caption = str_replace("&", "and", $caption);

                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                $xml .= '<resource xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://datacite.org/schema/kernel-4" xsi:schemaLocation="http://datacite.org/schema/kernel-4 http://schema.datacite.org/meta/kernel-4/metadata.xsd">';
                $xml .= '<identifier identifierType="DOI">' . $this->config->config['doiPrefix'] . $doiYear . '/' . $post_type . ':' . $id . '</identifier>';
                $xml .= '<creators>';
                $xml .= '<creator>';
                $xml .= '<creatorName>' . $post['lastName'] . ', ' . $post['firstName'] . '</creatorName>';
                $xml .= '</creator>';
                $xml .= '</creators>';
                $xml .= '<titles>';
                $xml .= '<title>' . $title . '</title>';
                $xml .= '</titles>';
                $xml .= '<publisher>' . $documentAffiliation . '</publisher>';
                $xml .= '<publicationYear>' . $doiYear . '</publicationYear>';
                $xml .= '<subjects>';
                $xml .= '<subject>' . $category . '</subject>';
                $xml .= '<subject>' . $subcategory . '</subject>';

                if ($altCategory != "") {
                    $xml .= '<subject>' . $altCategory . '</subject>';
                }

                if ($altSubcategory != "") {
                    $xml .= '<subject>' . $altSubcategory . '</subject>';
                }

                $xml .= '</subjects>';

                $xml .= '<language>' . $language . '</language>';

                if ($post_type == "video") {
                    $xml .= '<resourceType resourceTypeGeneral="Audiovisual">video</resourceType>';
                }

                if ($post_type == "poster") {
                    $xml .= '<resourceType resourceTypeGeneral="Audiovisual">poster</resourceType>';
                }

                if ($post_type == "presentation") {
                    $xml .= '<resourceType resourceTypeGeneral="Audiovisual">presentation</resourceType>';
                }

                if ($post_type == "paper") {
                    $xml .= '<resourceType resourceTypeGeneral="Text">paper</resourceType>';
                }

                $xml .= '<descriptions>';
                $xml .= '<description descriptionType="Abstract">' . $caption . '</description>';
                $xml .= '</descriptions>';

                $xml .= '</resource>';

// Uploading the Metadata XML
                $uri = $this->config->config['datacite_uri'] . "/metadata";
                $response = \Httpful\Request::post($uri)
                  ->authenticateWith($this->config->config['datacite_clientID'],
                    $this->config->config['datacite_password'])
                  ->body($xml)
                  ->sendsXml()
                  ->send();

                $responsecode = substr($response, 0, 2);

                if ($responsecode == "OK") {
                    $uri = $this->config->config['datacite_uri'] . "/doi";
                    $body = "doi=" . $doi . "\nurl=" . $url;
                    $response = \Httpful\Request::post($uri)
                      ->authenticateWith($this->config->config['datacite_clientID'],
                        $this->config->config['datacite_password'])
                      ->addHeader('Content-Type', 'text/plain;charset=UTF-8')
                      ->body($body)
                      ->send();

                    if ($response == "OK") {
                        $data = array(
                          'doi' => $doi,
                          'doiYear' => $doiYear
                        );
                        if ($post_type == "video") {
                            $this->movie->update($id, $data);
                        } elseif ($post_type == "presentation") {
                            $this->presentation->update($id, $data);
                        } elseif ($post_type == "poster") {
                            $this->poster->update($id, $data);
                        } else {
                            $this->paper->update($id, $data);
                        }
                        redirect(base_url('auth/content/' . $post_type . '/request-doi/' . $id));

                    } else {
                        echo "We encountered a problem, so we can not register your DOI. Please contact us.";
                        echo "<br>";
                        echo "Error Code: " . $response;
                        echo "<br>";
                        echo $url;
                    }

                } else {
                    echo "There is a problem with the Metadata, so we can not register your DOI. Please contact us.";
                    echo "<br>";
                    echo "Error Code: " . $response;
                }

                echo '</div>
                    <div class="panel-footer">
                      <a class="btn btn-login btn_SM" href="javascript:history.back()">back</a>
                    </div>
                    </div>
                    </div>';

            }

        }
    }

    function updatePaymentStatusByUser($userID, $apiContext)
    {

        $where = array(
          'userID' => $userID,
          'status !=' => 'Denied',
          'status !=' => 'Refunded'
        );
        $registrationList = $this->conferenceregistration->get_all_rule($where);

        if (!empty($registrationList)) {
            foreach ($registrationList as $registration) {
                if (!empty($registration->saleID)) {
                    $sale = Sale::get($registration->saleID, $apiContext);
                    $newStatus = $sale->state;
                    if ($registration->status != $newStatus) {
                        if ($newStatus == 'denied') {
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                              $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been denied by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                                  'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        } elseif ($newStatus == 'refunded' || $newStatus == 'returned') {
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                              $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been refunded by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                                  'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        } else {
                            $this->conferenceregistration->update($registration->ID, array('status' => $newStatus));
                        }
                    }
                }
            }
        }
    }

    function updatePaymentStatusByCid($CID, $apiContext)
    {
        $registrationList = $this->conferenceregistration->get_all_binary_3_custom('CID', $CID, 'status', 'Denied',
          'status', 'Refunded');

        if (!empty($registrationList)) {
            foreach ($registrationList as $registration) {
                if (!empty($registration->saleID)) {
                    $sale = Sale::get($registration->saleID, $apiContext);
                    $newStatus = $sale->state;
                    if ($registration->status != $newStatus) {
                        if ($newStatus == 'denied') {
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                              $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been denied by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                                  'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        } elseif ($newStatus == 'refunded' || $newStatus == 'returned') {
                            $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                              $registration->userID);
                            if ($this->conferenceregistration->delete($registration->ID)) {
                                $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                                $reason = 'Your payment has been refunded by the host via PayPal';
                                $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                                  'registration',
                                  $username);
                                $this->session->unset_tempdata('remind_registration');
                            }
                        } else {
                            $this->conferenceregistration->update($registration->ID, array('status' => $newStatus));
                        }
                    }
                }
            }
        }
    }

    function updatePaymentStatusBySaleID($saleID, $apiContext)
    {

        $where = array(
          'saleID' => $saleID,
          'status !=' => 'Denied',
          'status !=' => 'Refunded'
        );
        $registration = $this->conferenceregistration->get_info_rule($where);

        if (!empty($registration)) {
            if (!empty($registration->saleID)) {
                $sale = Sale::get($registration->saleID, $apiContext);
                $newStatus = $sale->state;
                if ($registration->status != $newStatus) {
                    if ($newStatus == 'denied') {
                        $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                          $registration->userID);
                        if ($this->conferenceregistration->delete($registration->ID)) {
                            $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                            $reason = 'Your payment has been denied by the host via PayPal';
                            $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                              'registration',
                              $username);
                            $this->session->unset_tempdata('remind_registration');
                        }
                    } elseif ($newStatus == 'refunded' || $newStatus == 'returned') {
                        $registrationInfo = $this->conferenceregistration->getByCidAndUser($registration->CID,
                          $registration->userID);
                        if ($this->conferenceregistration->delete($registration->ID)) {
                            $username = $registrationInfo->firstName . ' ' . $registrationInfo->lastName;
                            $reason = 'Your payment has been refunded by the host via PayPal';
                            $this->sendMailReject($registrationInfo->email, $registrationInfo->confTitle, $reason,
                              'registration',
                              $username);
                            $this->session->unset_tempdata('remind_registration');
                        }
                    } else {
                        $this->conferenceregistration->update($registration->ID, array('status' => $newStatus));
                    }
                }
            }
        }
    }

    function countTime($time)
    {
        $result = null;

        $time = time() - strtotime($time);
        if ($time < 60) {
            $result = 'a few seconds ago';
        } elseif (60 <= $time && $time < 60 * 60) {
            $result = floor($time / 60) . ' minutes ago';
        } elseif (60 * 60 <= $time && $time < 60 * 60 * 24) {
            $result = floor($time / 60 / 60) . ' hours ago';
        } elseif (60 * 60 * 24 <= $time && $time < 60 * 60 * 24 * 30) {
            $result = floor($time / 60 / 60 / 24) . ' days ago';
        } elseif (60 * 60 * 24 * 30 <= $time && $time < 60 * 60 * 24 * 30 * 12) {
            $result = floor($time / 60 / 60 / 24 / 30) . ' months ago';
        } else {
            $result = floor($time / 60 / 60 / 24 / 30 / 12) . ' years ago';
        }

        return $result;
    }
}

// Admin
class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load */
            $this->load->config('admin/dp_config');
            $this->load->library(['admin/breadcrumbs', 'admin/page_title']);
            $this->load->model('admin/core_model');
            $this->load->helper('menu');
            $this->lang->load(['admin/main_header', 'admin/main_sidebar', 'admin/footer', 'admin/actions']);

            /* Load library function  */
            $this->breadcrumbs->unshift(0, $this->lang->line('menu_dashboard'), 'admin/dashboard');

            /* Data */
            $this->data['title'] = $this->config->item('title');
            $this->data['title_lg'] = $this->config->item('title_lg');
            $this->data['title_mini'] = $this->config->item('title_mini');
            $this->data['admin_prefs'] = $this->prefs_model->admin_prefs();
            $this->data['user_login'] = $this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);

            if ($this->router->fetch_class() == 'dashboard')
            {
                $this->data['dashboard_alert_file_install'] = $this->core_model->get_file_install();
                $this->data['header_alert_file_install'] = NULL;
            }
            else
            {
                $this->data['dashboard_alert_file_install'] = NULL;
                $this->data['header_alert_file_install'] = NULL; /* << A MODIFIER !!! */
            }
        }
    }
}


class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->data['admin_link'] = TRUE;
        }
        else
        {
            $this->data['admin_link'] = FALSE;
        }

        if ($this->ion_auth->logged_in())
        {
            $this->data['logout_link'] = TRUE;
        }
        else
        {
            $this->data['logout_link'] = FALSE;
        }
	}
}
