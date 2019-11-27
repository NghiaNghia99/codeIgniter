<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Subcategory extends MY_Model
{
    protected $table = 'subcategories';

    public function __construct()
    {
        $this->load->database();
    }
}