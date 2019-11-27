<?php

/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 30-May-19
 * Time: 15:15
 */
class ReminderController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('useraccount');
        $this->load->model('reminder');
        $this->load->model('project');
        $this->load->helper('url_helper', 'form', 'date');
        $this->load->library('session');
        $this->load->library('email');
    }

    public function index(){
        $now = time();
        $users = $this->reminder->get();
        if (!empty($users)) {
            foreach ($users as $user) {
                $token = $user->sid;
                $reminder_from = $token + 23 * 60 * 60 + 54 * 60 + 59;
                $reminder_to = $token + 24 * 60 * 60 + 58;
                if ($now > $reminder_from && $now < $reminder_to) {
                    $username = $user->firstName . ' ' . $user->lastName;
                    $this->sendMailRemindActive($user->email, $username);
                }
                $expired = $token + 36 * 60 * 60;
                if ($now > $expired) {
                    $this->reminder->update($user->id, array('sid' => ''));
                }
            }
        }

        $projectUnpaid = $this->project->get_all_rule(array('status' => 'unpaid'));
        if (!empty($projectUnpaid)){
            foreach ($projectUnpaid as $project){
                $this->project->delete($project->id);
            }
        }

        $projectCreated = $this->project->get_all_rule(array('status' => 'created'));
        if (!empty($projectCreated)){
            foreach ($projectCreated as $project){
                $this->project->update($project->id, array('status' => 'unpaid'));
            }
        }
    }
}