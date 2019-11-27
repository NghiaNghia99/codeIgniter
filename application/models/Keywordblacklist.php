<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Keywordblacklist extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'keyword_blacklist';

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @param array $contents
     * @return bool
     */
    function checkKeyWorkBackList($contents = array())
    {
        $results = $this->db->get($this->table)->result();
        if (!empty($results)){
            foreach ($results as $row) {
                $blackListHit = 0;
                $keyword = utf8_decode($row->name);
                foreach ($contents as $key => $content){
                    if (strpos(strtolower($content), strtolower($keyword))!== false) {
                        $blackListHit = 1;
                    }
                }
                if ($blackListHit == 1){
                    return $keyword;
                }
            }
        }
        return false;
    }

}