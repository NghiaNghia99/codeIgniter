<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 25-Apr-19
 * Time: 09:14
 */

class MY_Model extends CI_Model
{

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @param $data
     * @return bool
     */
    function create($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    function update($id, $data)
    {
        if (!$id) {
            return false;
        }
        $where = array();
        $where['id'] = $id;
        return $this->update_rule($where, $data);
    }

    /**
     * @param $where
     * @param $data
     * @return bool
     */
    function update_rule($where, $data)
    {
        if (!$where) {
            return false;
        }
        $this->db->where($where);
        if ($this->db->update($this->table, $data)) {
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    function delete($id)
    {
        if (!$id) {
            return false;
        }
        if (is_numeric($id)) {
            $where = array('id' => $id);
        } else {
            $where = "id IN (" . $id . ") ";
        }
        return $this->del_rule($where);
    }

    /**
     * @param $where
     * @return bool
     */
    function del_rule($where)
    {
        if (!$where) {
            return false;
        }
        $this->db->where($where);
        if ($this->db->delete($this->table)) {
            return true;
        }
        return false;
    }

    /**
     * @param $where
     * @return bool
     */
    function del_all($where)
    {
        if (!$where) {
            return false;
        }
        $this->db->where_in($this->key, $where);
        $this->db->delete($this->table);

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    function get_info($id)
    {
        if (!$id) {
            return false;
        }
        $where = array();
        $where['id'] = $id;
        return $this->get_info_rule($where);
    }

    /**
     * @param array $where
     * @return bool
     */
    function get_info_rule($where = array())
    {
        $this->db->where($where);
        $query = $this->db->get($this->table);
        if ($query->num_rows()) {
            return $query->row();
        }
        return false;
    }

    function get_info_binary($col = false, $value = false)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY '.$col.' = "'.$value.'"');
        if ($query->num_rows()) {
            return $query->row();
        }
        return false;
    }

    function get_info_binary_2($col1 = false, $value1 = false, $col2 = false, $value2 = false)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY '.$col1.' = "'.$value1.'" AND '.$col2.' = "'.$value2.'"');
        if ($query->num_rows()) {
            return $query->row();
        }
        return false;
    }

    function get_info_binary_3($col1 = false, $value1 = false, $col2 = false, $value2 = false, $col3 = false, $value3 = false)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY '.$col1.' = "'.$value1.'" AND '.$col2.' = "'.$value2.'" AND '.$col3.' = "'.$value3.'"');
        if ($query->num_rows()) {
            return $query->row();
        }
        return false;
    }

    function get_all_binary($col = false, $value = false)
    {
        $query = $this->db->query('SELECT * FROM '. $this->table .' WHERE BINARY '.$col.' = "'.$value.'"');
        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }

    function get_all_binary_2($col1 = false, $value1 = false, $col2 = false, $value2 = false)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY '.$col1.' = "'.$value1.'" AND '.$col2.' = "'.$value2.'"');
        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }

    function get_all_binary_3_custom($col1 = false, $value1 = false, $col2 = false, $value2 = false, $col3 = false, $value3 = false)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY '.$col1.' = "'.$value1.'" AND '.$col2.' != "'.$value2.'" AND '.$col3.' != "'.$value3.'"');
        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }


    /**
     * @return bool
     */
    function get_all()
    {
        $query = $this->db->get($this->table);
        if ($query->num_rows()) {
            $query = $this->db->get($this->table);
            return $query->result();
        }
        return false;
    }

    /**
     * @return bool
     */
    function get_all_desc($where = false)
    {
        if ($where){
            $this->db->where($where);
            $query = $this->db->get($this->table);
            if ($query->num_rows()) {
                $this->db->where($where);
                $this->db->order_by("dateOfUpload", "desc");
                $query = $this->db->get($this->table);
                return $query->result();
            }
        }
        else{
            $query = $this->db->get($this->table);
            if ($query->num_rows()) {
                $this->db->order_by("dateOfUpload", "desc");
                $query = $this->db->get($this->table);
                return $query->result();
            }
        }
        return false;
    }


    /**
     * @param array $where
     * @return bool
     */
    function get_all_rule($where = array())
    {
        $this->db->where($where);
        $query = $this->db->get($this->table);
        if ($query->num_rows()) {
            return $query->result();
        }
        return false;
    }

    /**
     * @param array $input
     * @return mixed
     */
    function get_total($input = array())
    {
        $this->get_list_set_input($input);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    /**
     * @param array $input
     * @return mixed
     */
    function get_list($input = array())
    {
        $this->get_list_set_input($input);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * @param $input
     */
    protected function get_list_set_input($input)
    {
        if (isset($input['select'])) {
            $this->db->select($input['select']);
        }

        if ((isset($input['where'])) && $input['where']) {
            $this->db->where($input['where']);
        }
        if (isset($input['order'][0]) && isset($input['order'][1])) {
            $this->db->order_by($input['order'][0], $input['order'][1]);
        } else {
            $this->db->order_by('id', 'desc');
        }

        if (isset($input['limit'][0]) && isset($input['limit'][1])) {
            $this->db->limit($input['limit'][0], $input['limit'][1]);
        }

    }

    /**
     * @param array $where
     * @return bool
     */
    function check_exists($where = array())
    {
        $this->db->where($where);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $cid
     * @return bool
     */
    function check_cid_exists($cid)
    {
        $query = $this->db->query('
            SELECT * FROM '. $this->table .' 
            WHERE BINARY cid = "'.$cid.'"');
        if ($query->num_rows()) {
            return $query->row();
        }
        return false;
    }

    function check_pid_exists($identifierPID)
    {
        $where = array('identifierPID' => $identifierPID);
        $this->db->where($where);
        $query = $this->db->get($this->table);

        if ($query->num_rows() == 0 || ($query->num_rows() > 0 && strcmp($identifierPID, $query->row()->identifierPID) != 0)) {
            return false;
        } else {
            return true;
        }
    }

    function get_last_record_id()
    {
        $last = $this->db->order_by('id', "desc")
          ->limit(1)
          ->get($this->table)
          ->row();

        return $last->id;
    }

    function get_first_record_id()
    {
        $first = $this->db->order_by('id', "asc")
          ->limit(1)
          ->get($this->table)
          ->row();

        return $first->id;
    }

    function get_rule_first_record_id($where = array())
    {
        $first = $this->db->where($where)
          ->order_by('id', "asc")
          ->limit(1)
          ->get($this->table)
          ->row();

        return $first->id;
    }

    function get_rule_second_record_id($where = array())
    {
        $second = $this->db->where($where)
          ->order_by('id', "asc")
          ->limit(1, 1)
          ->get($this->table)
          ->row();

        return $second->id;
    }
}