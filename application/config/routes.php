<?php
defined('BASEPATH') OR exit('No direct script access allowed');/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/;
// invoice
$route['auth/invoice'] = 'InvoiceController/Invoice';

//convert video
$route['auth/video/convert'] = 'VideoQueueController';

//project
$route['auth/project/gantt-chart/(:any)'] = 'ProjectController/changeFormatGanttChart/$1';
$route['auth/project/work-package/detail/(:any)/(:any)/(:any)'] = 'AuthController/workPackageDetail/$1/$2/$3';
$route['auth/project/get-content/(:any)/(:any)'] = 'ProjectController/getContent/$1/$2';
$route['auth/project/attachment/(:any)'] = 'ProjectController/getAttachment/$1';
$route['auth/project/delete-content'] = 'ProjectController/deleteContent';
$route['auth/project/upload-attachment/(:any)'] = 'ProjectController/uploadAttachment/$1';
$route['auth/project/update-content'] = 'ProjectController/updateContent';
$route['auth/project/add-content'] = 'ProjectController/addContent';
$route['auth/project/work-package/order-pid/checkout/error'] = 'ProjectController/checkoutProjectError';
$route['auth/project/work-package/order-pid/checkout/response'] = 'ProjectController/responsePayProject';
$route['auth/project/work-package/order-pid/checkout'] = 'ProjectController/payProject';
$route['auth/project/(:any)/member'] = 'ProjectController/member/$1';
$route['auth/project/(:any)/member/add-member'] = 'ProjectController/addMember/$1';
$route['auth/project/(:any)/member/delete/(:any)/users/(:any)'] = 'ProjectController/deleteMember/$1/$2/$3';
$route['auth/project/(:any)/calendar/task-detail'] = 'ProjectController/taskDetailCalendar/$1';
$route['auth/project/(:any)/calendar'] = 'ProjectController/calendar/$1';
$route['auth/project/document/delete'] = 'ProjectController/documentDelete';
$route['auth/project/(:any)/document-edit/(:any)'] = 'ProjectController/documentEdit/$1/$2';
$route['auth/project/(:any)/document-detail/(:any)'] = 'ProjectController/documentDetail/$1/$2';
$route['auth/project/(:any)/add-document'] = 'ProjectController/addDocument/$1';
$route['auth/project/(:any)/documents'] = 'ProjectController/documents/$1';
$route['auth/project/(:any)/work-package/log-unit-costs'] = 'ProjectController/logUnitCosts/$1';
$route['auth/project/(:any)/work-package/move/(:any)'] = 'ProjectController/workPackageMove/$1/$2';
$route['auth/project/(:any)/work-package/new-task/(:any)'] = 'ProjectController/newTask/$1/$2';
$route['auth/project/work-package/save-project'] = 'ProjectController/saveProject';
$route['auth/project/work-package/order-pid'] = 'ProjectController/orderPID';
$route['auth/project/(:any)/work-package/update/(:any)'] = 'ProjectController/updateTask/$1/$2';
$route['auth/project/(:any)/work-package/edit/(:any)'] = 'ProjectController/editTask/$1/$2';
$route['auth/project/(:any)/work-package/delete/(:any)'] = 'ProjectController/deleteTask/$1/$2';
$route['auth/project/(:any)/work-package'] = 'ProjectController/workPackage/$1';
$route['auth/project/(:any)/project-info-order-pid'] = 'ProjectController/projectInfoOrderPid/$1';
$route['auth/project'] = 'ProjectController/projectList';
$route['auth/project/(:any)/work-package/copy-task/(:any)'] = 'ProjectController/copyTask/$1/$2';
$route['auth/project/(:any)/work-package/create-child/(:any)/(:any)'] = 'ProjectController/createChild/$1/$2/$3';
$route['auth/project/work-package'] = 'ProjectController/workPackage';

//restricted access
$route['auth/conference/restricted-access/(:any)'] = 'ConferenceController/Restricted/$1';

//link to conference, session conference
$route['auth/conference/upload-content'] = 'ObjectPageController/uploadContent';
$route['auth/conference/link-to-conference'] = 'ObjectPageController/linkToConference';
$route['auth/conference/get-session-conference/upload-content'] = 'ObjectPageController/getSessionConferenceUploadContent';
$route['auth/conference/get-session-conference'] = 'ObjectPageController/getSessionConference';
$route['auth/conference/get-all-conference'] = 'ObjectPageController/getAllConference';

//abstract conference
$route['auth/conference/abstract/tool'] = 'ConferenceController/abstractTool';
$route['auth/conference/abstract/reject'] = 'ConferenceController/rejectAbstract';
$route['auth/conference/abstract/change-type'] = 'ConferenceController/changeTypeAbstract';
$route['auth/conference/abstract/get/(:any)'] = 'ConferenceController/getAbstractConferenceByID/$1';
$route['conference/abstract/success/(:any)'] = 'ConferenceController/abstractConferenceSuccess/$1';
$route['auth/conference/abstract'] = 'ConferenceController/abstractConference';
$route['abstract/(:any)'] = 'ConferenceController/getAbstractConference/$1';
$route['auth/conference/abstract-conference/(:any)'] = 'ConferenceController/getAbstractList/$1';

//register conference
$route['auth/conference/registration/remind'] = 'ConferenceController/remindRegistration';
$route['auth/conference/registration/reject'] = 'ConferenceController/rejectRegistration';
$route['auth/conference/registration/get/(:any)'] = 'ConferenceController/getRegistrationConferenceByID/$1';
$route['auth/conference/registration/tool'] = 'ConferenceController/registrationTool';
$route['conference/register/success'] = 'ConferenceController/registerConferenceSuccess';
$route['auth/conference/register/check-cid'] = 'ConferenceController/checkCidRegisterConference';
$route['auth/conference/register/set-session-step-2'] = 'ConferenceController/setSessionRegisterStep2';
$route['auth/conference/register/unset-session-step-2'] = 'ConferenceController/unsetSessionRegisterStep2';
$route['auth/conference/register/registration-conference/(:any)'] = 'ConferenceController/getRegistrationConference/$1';
$route['register/conference/(:any)'] = 'ConferenceController/registerConference/$1';

//invite co-author
$route['auth/invite-co-author/active-account-co-author/(:any)'] = 'AuthController/activePermissionCoAuthor/$1';
$route['auth/invite-co-author/update'] = 'ConferenceController/updatePermissionCoAuthor';
$route['auth/invite-co-author/remove'] = 'ConferenceController/removeCoAuthor';
$route['auth/invite-co-author/resend'] = 'ConferenceController/reSendMailInviteCoAuthor';
$route['auth/invite-co-author/(:any)'] = 'AuthController/updateStatusPermission/$1';
$route['auth/invite-co-author'] = 'ConferenceController/getPermissionCoAuthor';
$route['auth/conference/managed/conference-edit/basic-information/check-valid-email-co-author'] = 'ConferenceController/checkValidationEmailCoAuthor';
$route['auth/conference/managed/conference-edit/basic-information/set-permission-co-author'] = 'ConferenceController/setPermissionCoAuthor';
$route['auth/conference/managed/conference-edit/basic-information/check-valid-email-co-author'] = 'ConferenceController/checkValidationEmailCoAuthor';

//edit managed conference
$route['auth/conference/managed/conference-edit/change-cid/(:any)'] = 'ConferenceController/getEditConferenceChangeCid/$1';
$route['auth/conference/managed/conference-edit/file-upload/upload/(:any)/(:any)'] = 'ConferenceController/editConferenceFileUpload/$1/$2';
$route['auth/conference/managed/conference-edit/file-upload/(:any)'] = 'ConferenceController/getEditConferenceFile/$1';
$route['auth/conference/managed/conference-edit/optional-information/(:any)'] = 'ConferenceController/getEditConferenceOptional/$1';
$route['auth/conference/managed/conference-edit/basic-information/update-session'] = 'ConferenceController/updateSessionConferenceBasic';
//$route['auth/conference/managed/conference-edit/basic-information/edit-session'] = 'ConferenceController/editSessionConferenceBasic';
//$route['auth/conference/managed/conference-edit/basic-information/add-session'] = 'ConferenceController/addSessionConferenceBasic';
$route['auth/conference/managed/conference-edit/basic-information/remove-session'] = 'ConferenceController/removeSessionConferenceBasic';
$route['auth/conference/managed/conference-edit/basic-information/edit-category/(:any)'] = 'ConferenceController/editCategoryConferenceBasic/$1';
$route['auth/conference/managed/conference-edit/basic-information/edit/(:any)'] = 'ConferenceController/editConferenceBasic/$1';
$route['auth/conference/managed/conference-edit/basic-information/(:any)'] = 'ConferenceController/getEditConferenceBasic/$1';
$route['auth/conference/managed/conference-edit/(:any)'] = 'ConferenceController/getManagedConferenceEdit/$1';

//managed conference
$route['auth/conference/managed/manage-contribution/approve-element/(:any)'] = 'ConferenceController/approveElement/$1';
$route['auth/conference/managed/manage-contribution/updateSession'] = 'ConferenceController/updateSessionElement';
$route['auth/conference/managed/manage-contribution/delete'] = 'ConferenceController/deleteElement';
$route['auth/conference/managed/manage-contribution/(:any)'] = 'ConferenceController/getManageContribution/$1';
$route['auth/conference/managed/conference-abstracts/(:any)'] = 'ConferenceController/getManagedConferenceAbstracts/$1';
$route['auth/conference/managed/conference-registrations/(:any)'] = 'ConferenceController/getManagedConferenceRegistrations/$1';
$route['auth/conference/managed/conference-contributions/(:any)'] = 'ConferenceController/getManagedConferenceContributions/$1';
$route['auth/conference/conference-page/(:any)'] = 'ConferenceController/getConferencePage/$1';

//attended conference detail
$route['auth/conference/attended/conference-page/(:any)'] = 'ConferenceController/getAttendedConferencePage/$1';

//conference
$route['auth/conference/registration-conference'] = 'ConferenceController/registrationConference';
$route['auth/conference/confirm-pay-cid/change-payment-status'] = 'ConferenceController/updatePaymentStatus';
$route['auth/conference/set-session-cid'] = 'ConferenceController/setSessionCid';
$route['auth/conference/active-cid'] = 'ConferenceController/getActiveCidPage';
$route['auth/conference/confirm-pay-cid'] = 'ConferenceController/confirmPayCid';
//checkout via paypal
$route['auth/conference/registration/checkout/error'] = 'ConferenceController/checkoutPaypalConferenceError';
$route['auth/conference/pay-cid/checkout/error'] = 'ConferenceController/checkoutPaypalError';
$route['auth/conference/registration/checkout/response'] = 'ConferenceController/responsePaypalConference';
$route['auth/conference/pay-cid/checkout/response'] = 'ConferenceController/responsePaypal';
$route['auth/conference/pay-cid/checkout'] = 'ConferenceController/checkoutPaypal';

$route['auth/conference/pay-cid'] = 'ConferenceController/payCid';
$route['auth/conference/order-cid'] = 'ConferenceController/orderCid';
$route['auth/conference/info-cid'] = 'ConferenceController/getInfoCid';
$route['auth/conference/managed-default/(:any)'] = 'ConferenceController/getDefaultManagedConferences';
$route['auth/conference/managed-default'] = 'ConferenceController/getDefaultManagedConferences';
$route['auth/conference/managed-closed/(:any)'] = 'ConferenceController/getClosedManagedConferences';
$route['auth/conference/managed-closed'] = 'ConferenceController/getClosedManagedConferences';
$route['auth/conference/managed/(:any)'] = 'ConferenceController/getManagedConferences';
$route['auth/conference/managed'] = 'ConferenceController/getManagedConferences';
$route['auth/conference/attended/(:any)'] = 'ConferenceController/getAttendedConferences';
$route['auth/conference/attended'] = 'ConferenceController/getAttendedConferences';

//test new upload object via ajax
$route['auth/test/video/upload/event'] = 'VideoController/uploadEvent';
$route['auth/test/video/upload'] = 'VideoController/upload';

$route['auth/test/presentation/upload/event'] = 'PresentationController/uploadEvent';
$route['auth/test/presentation/upload'] = 'PresentationController/upload';

$route['auth/test/paper/upload/event'] = 'PaperController/uploadEvent';
$route['auth/test/paper/upload'] = 'PaperController/upload';

$route['auth/test/poster/upload/event'] = 'PosterController/uploadEvent';
$route['auth/test/poster/upload'] = 'PosterController/upload';


//video
$route['auth/content/video/link-to-conference/(:any)'] = 'ObjectPageController/getLinkToConferenceVideo/$1';
$route['auth/content/video/request-doi/(:any)'] = 'VideoController/getRequestDoiVideo/$1';
$route['auth/content/video/delete/confirm/(:any)'] = 'VideoController/deleteVideo/$1';
$route['auth/content/video/delete/(:any)'] = 'VideoController/checkDeleteVideo/$1';
$route['auth/content/video/edit/(:any)'] = 'VideoController/getEditVideo/$1';
$route['auth/content/video/upload'] = 'VideoController/upload';
$route['auth/content/video/(:any)'] = 'VideoController/getVideo/$1';
$route['auth/content/videos/queue/(:any)'] = 'VideoController/getVideoQueueList';
$route['auth/content/videos/queue'] = 'VideoController/getVideoQueueList';
$route['auth/content/videos/(:any)'] = 'VideoController/getVideoList';
$route['auth/content/videos'] = 'VideoController/getVideoList';

//Presentation
$route['auth/content/presentation/delete/confirm/(:any)'] = 'PresentationController/delete/$1';
$route['auth/content/presentation/delete/(:any)'] = 'PresentationController/checkDelete/$1';
$route['auth/content/presentation/edit/(:any)'] = 'PresentationController/getEditPresentation/$1';
$route['auth/content/presentation/request-doi/(:any)'] = 'PresentationController/getRequestDoiPresentation/$1';
$route['auth/content/presentation/link-to-conference/(:any)'] = 'ObjectPageController/getLinkToConferencePresentation/$1';
$route['auth/content/presentation/upload'] = 'PresentationController/upload';
$route['auth/content/presentation/(:any)'] = 'PresentationController/getPresentation/$1';
$route['auth/content/presentations/(:any)'] = 'PresentationController/getList/$1';
$route['auth/content/presentations'] = 'PresentationController/getList';

//Poster
$route['auth/content/poster/delete/confirm/(:any)'] = 'PosterController/delete/$1';
$route['auth/content/poster/delete/(:any)'] = 'PosterController/checkDelete/$1';
$route['auth/content/poster/edit/(:any)'] = 'PosterController/getEditPoster/$1';
$route['auth/content/poster/request-doi/(:any)'] = 'PosterController/getRequestDoiPoster/$1';
$route['auth/content/poster/link-to-conference/(:any)'] = 'ObjectPageController/getLinkToConferencePoster/$1';
$route['auth/content/poster/upload'] = 'PosterController/upload';
$route['auth/content/poster/(:any)'] = 'PosterController/getPoster/$1';
$route['auth/content/posters/(:any)'] = 'PosterController/getList/$1';
$route['auth/content/posters'] = 'PosterController/getList';

//Paper
$route['auth/content/paper/delete/confirm/(:any)'] = 'PaperController/delete/$1';
$route['auth/content/paper/delete/(:any)'] = 'PaperController/checkDelete/$1';
$route['auth/content/paper/edit/(:any)'] = 'PaperController/getEditPaper/$1';
$route['auth/content/paper/request-doi/(:any)'] = 'PaperController/getRequestDoiPaper/$1';
$route['auth/content/paper/link-to-conference/(:any)'] = 'ObjectPageController/getLinkToConferencePaper/$1';
$route['auth/content/paper/upload'] = 'PaperController/upload';
$route['auth/content/paper/(:any)'] = 'PaperController/getPaper/$1';
$route['auth/content/papers/(:any)'] = 'PaperController/getList/$1';
$route['auth/content/papers'] = 'PaperController/getList';

//profile
$route['auth/profile/change-password'] = 'ProfileController/changePassword';
$route['auth/profile/change-avatar/change'] = 'ProfileController/updateAvatar';
$route['auth/profile/change-avatar'] = 'ProfileController/getUpdateAvatar';
$route['auth/profile/update-profile'] = 'ProfileController/updateProfile';
$route['auth/profile'] = 'ProfileController/getProfile';

$route['summary-profile/video/(:any)/(:any)'] = 'AuthController/getVideoSummaryProfile/$1';
$route['summary-profile/video/(:any)'] = 'AuthController/getVideoSummaryProfile/$1';
$route['summary-profile/paper/(:any)/(:any)'] = 'AuthController/getPaperSummaryProfile/$1';
$route['summary-profile/paper/(:any)'] = 'AuthController/getPaperSummaryProfile/$1';
$route['summary-profile/poster/(:any)/(:any)'] = 'AuthController/getPosterSummaryProfile/$1';
$route['summary-profile/poster/(:any)'] = 'AuthController/getPosterSummaryProfile/$1';
$route['summary-profile/presentation/(:any)/(:any)'] = 'AuthController/getPresentationSummaryProfile/$1';
$route['summary-profile/presentation/(:any)'] = 'AuthController/getPresentationSummaryProfile/$1';
$route['summary-profile/conference/(:any)/(:any)'] = 'AuthController/getConferenceSummaryProfile/$1';
$route['summary-profile/conference/(:any)'] = 'AuthController/getConferenceSummaryProfile/$1';

//Available conferences
$route['available-conference/(:any)/(:any)'] = 'HomeController/getAvailableConferencePage/$1';
$route['available-conference/(:any)'] = 'HomeController/getAvailableConferencePage/$1';

//show posts follow sub category
$route['show-category/video/(:any)/(:any)/(:any)'] = 'HomeController/getVideoCategory/$1/$2';
$route['show-category/video/(:any)/(:any)'] = 'HomeController/getVideoCategory/$1/$2';
$route['show-category/presentation/(:any)/(:any)/(:any)'] = 'HomeController/getPresentationCategory/$1/$2';
$route['show-category/presentation/(:any)/(:any)'] = 'HomeController/getPresentationCategory/$1/$2';
$route['show-category/poster/(:any)/(:any)/(:any)'] = 'HomeController/getPosterCategory/$1/$2';
$route['show-category/poster/(:any)/(:any)'] = 'HomeController/getPosterCategory/$1/$2';
$route['show-category/paper/(:any)/(:any)/(:any)'] = 'HomeController/getPaperCategory/$1/$2';
$route['show-category/paper/(:any)/(:any)'] = 'HomeController/getPaperCategory/$1/$2';
$route['show-category/conference/(:any)/(:any)/(:any)'] = 'HomeController/getConferenceCategory/$1/$2';
$route['show-category/conference/(:any)/(:any)'] = 'HomeController/getConferenceCategory/$1/$2';

//$route['show-category/(:any)/(:any)/(:any)'] = 'HomeController/getCategoryPage/$1/$2';
//$route['show-category/(:any)/(:any)'] = 'HomeController/getCategoryPage/$1/$2';

$route['show-category-video/(:any)/(:any)'] = 'HomeController/getCategoryVideoPage/$1/$2';
$route['show-category-paper/(:any)/(:any)'] = 'HomeController/getCategoryPaperPage/$1/$2';
$route['show-category-poster/(:any)/(:any)'] = 'HomeController/getCategoryPosterPage/$1/$2';
$route['show-category-presentation/(:any)/(:any)'] = 'HomeController/getCategoryPresentationPage/$1/$2';
$route['show-category-conference/(:any)/(:any)'] = 'HomeController/getCategoryConferencePage/$1/$2';

//post detail
$route['video/(:any)'] = 'HomeController/getVideoPage/$1';
$route['poster/(:any)'] = 'HomeController/getPosterPage/$1';
$route['paper/(:any)'] = 'HomeController/getPaperPage/$1';
$route['presentation/(:any)'] = 'HomeController/getPresentationPage/$1';
$route['conference/(:any)'] = 'HomeController/getConferencePage/$1';

//request DOI
$route['auth/content/request-doi/(:any)'] = 'ObjectPageController/objectRequestDoi/$1';

//report
$route['report/(:any)/(:any)'] = 'ObjectPageController/report/$1/$2';

//get sub category follow category
$route['getSubCategoryConference/(:any)/(:any)'] = 'HomeController/getSubCategoryConference/$1/$2';
$route['getCategory/(:any)/(:any)'] = 'HomeController/getCategory/$1/$2';
$route['getSubCategory/(:any)'] = 'HomeController/getSubCategory/$1';

//auth
$route['summary-profile/(:any)'] = 'AuthController/getSummaryProfile/$1';
$route['forgot-password/check-email'] = 'AuthController/checkEmailForgotPassword';
$route['forgot-password/(:any)'] = 'AuthController/forgotPassword/$1';
$route['forgot-password'] = 'AuthController/sendEmailForgotPassword';
$route['logout'] = 'AuthController/logout';
$route['login/error/(:any)'] = 'AuthController/loginAccountError/$1';
$route['login'] = 'AuthController/login';

$route['register'] = 'AuthController/register';
$route['register/check-domain-valid'] = 'AuthController/checkDomainEmailValid';
$route['register/error/(:any)'] = 'AuthController/registerAccountError/$1';
$route['register/active-account/check'] = 'ReminderController/autoCheckStatusUser';
$route['register/active-account/send-again/(:any)'] = 'AuthController/sendMailAgain/$1';
$route['register/active-account/error'] = 'AuthController/activeAccountError';
$route['register/active-account/(:any)'] = 'AuthController/activeAccount/$1';
$route['register/approved-account/(:any)'] = 'AuthController/approvedAccount/$1';
$route['register/check-email/(:any)'] = 'AuthController/checkEmailActive/$1';
$route['register/change-mail-register'] = 'AuthController/changeEmailRegister';
$route['register/getSubCategory/(:any)/(:any)'] = 'HomeController/getSubCategory/$1/$2';

//sort
$route['sort/update/(:any)'] = 'SortController/updateSort/$1';
$route['sort/update-summary-type/(:any)'] = 'SortController/updateSummaryType/$1';
$route['sort/update-post-type/(:any)'] = 'SortController/updatePostType/$1';
$route['sort/update-contribution-type/(:any)'] = 'SortController/updateContributionType/$1';

$route['sort/update-search/(:any)'] = 'SortController/updateSortSearch/$1';
$route['sort/update-post-type-search/(:any)'] = 'SortController/updatePostTypeSearch/$1';

//remove session post_type, sort by
$route['remove-post-type'] = 'HomeController/removeSessionPostType';
$route['remove-post-type-search'] = 'HomeController/removeSessionPostTypeSearch';

//search
$route['search/video/(:any)'] = 'SearchController/searchVideo';
$route['search/video'] = 'SearchController/searchVideo';
$route['search/presentation/(:any)'] = 'SearchController/searchPresentation';
$route['search/presentation'] = 'SearchController/searchPresentation';
$route['search/poster/(:any)'] = 'SearchController/searchPoster';
$route['search/poster'] = 'SearchController/searchPoster';
$route['search/paper/(:any)'] = 'SearchController/searchPaper';
$route['search/paper'] = 'SearchController/searchPaper';
$route['search/conference/(:any)'] = 'SearchController/searchConference';
$route['search/conference'] = 'SearchController/searchConference';

//$route['search/(:any)'] = 'SearchController/search';
//$route['search'] = 'SearchController/search';
$route['key'] = 'SearchController/keySearch';

//static page
$route['terms-and-conditions'] = 'HomeController/getTermsAndConditions';
$route['tell-us/success'] = 'HomeController/getTellUsSuccess';
$route['tell-us'] = 'HomeController/getTellUs';
$route['about-us'] = 'HomeController/getAboutUs';
$route['contact'] = 'HomeController/getContact';
$route['privacy-policy'] = 'HomeController/getPrivacyPolicy';
$route['how-it-work'] = 'HomeController/getHowItWork';
$route['doi'] = 'HomeController/getDOI';

$route['get-presentations-limit'] = 'HomeController/getPresentationsLimit';
$route['get-videos-limit'] = 'HomeController/getVideosLimit';
$route['get-posters-limit'] = 'HomeController/getPostersLimit';
$route['get-papers-limit'] = 'HomeController/getPapersLimit';
// admin
$route['admin'] = 'admin/auth/login';
$route['admin/(:any)'] = 'admin/dashboard/index/$1';
$route['admin/prefs/interfaces/(:any)'] = 'admin/prefs/interfaces/$1';
/*
 * Default
 * */
$route['default_controller'] = 'HomeController';
$route['404_override'] = 'My404/index';
