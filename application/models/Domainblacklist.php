<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Domainblacklist extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'domain_blacklist';

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @param $email
     * @return bool
     */
    function checkDomainValid($email)
    {
        $checkEmail = true;
        $results = $this->db->get($this->table)->result();
        if (!empty($results)){
            foreach ($results as $row) {
                $regex = '/' . $row->domain . '/';
                if (preg_match($regex, $email, $matches) == 1){
                    $checkEmail = false;
                    break;
                }
            }
        }

        return $checkEmail;
    }

}