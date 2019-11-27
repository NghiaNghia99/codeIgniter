<?php
/**
 * Created by PhpStorm.
 * User: PCPV
 * Date: 09/18/2019
 * Time: 02:48 PM
 */

class Pm extends CI_Model
{
    private $db = "";

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('pm', true);
    }

    public function createAPIToken($userId, $token) {
        $this->load->config('config');
        $secretKeyBase = $this->config->config['OP_SECRET_KEY_BASE'];
        $tokenValue = hash('sha256', $token.$secretKeyBase);
        $this->db->insert_batch('tokens', array(
            array(
                'user_id' => $userId,
                'type' => 'Token::Api',
                'value' => $tokenValue,
                'created_on' => date('Y-m-d H:i:s.u')
            )
        ));
    }

    public function getAPITokenList() {
        $query = $this->db->select('*')
            ->from('tokens')
            ->get();
        $data = $query->result();
        return $data;
    }
}