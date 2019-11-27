<?php

/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */
class UserAccount extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'useraccounts';

    /**
     * UserAccount constructor.
     */
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function get_user_info($where = array())
    {
        $this->db->where($where);
        $result = $this->db->get($this->table);
        return $result->row();
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function check_login($email, $password)
    {
        $where = array('email' => $email, 'password' => $password, 'active' => '1');
        $this->db->where($where);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function userIsLogin()
    {
        $user_data = $this->session->userdata('login');
        if (!$user_data) {
            return false;
        }
        return true;
    }

    /**
     * @param bool $id
     * @return mixed
     */
    public function get($id = false)
    {
        if ($id === false) {
            $query = $this->db->get($this->table);
            return $query->result();
        }

        $query = $this->db->get_where($this->table, array('id =' => $id));

        return $query->row();
    }

    /**
     * @param bool $id
     * @return mixed
     */
    public function getWithCategory($id = false)
    {
        if ($id === false) {
            $query = $this->db->select(
              'useraccounts.*, 
                categories.name as category_name, 
                subcategories.name as subcategory_name')
              ->from('useraccounts')
              ->join('categories', 'categories.id = useraccounts.category')
              ->join('subcategories', 'subcategories.id = useraccounts.subcategory')
              ->get();
            return $query->result();
        }

        $query = $this->db->select(
          'useraccounts.*, 
                categories.name as category_name, 
                subcategories.name as subcategory_name')
          ->from('useraccounts')
          ->where('useraccounts.id', $id)
          ->join('categories', 'categories.id = useraccounts.category')
          ->join('subcategories', 'subcategories.id = useraccounts.subcategory')
          ->get();

        return $query->row();
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    /**
     * @return mixed
     */
    public function getSubCategories()
    {
        $query = $this->db->get('subcategories');
        return $query->result_array();
    }

}