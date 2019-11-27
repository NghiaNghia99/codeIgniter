<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class ConferenceElement extends MY_Model
{

    protected $table = 'conference_elements';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function getConferenceElementByCID($cid)
    {
        $query = $this->db->query('SELECT * FROM '. $this->table .' WHERE BINARY CID = "'.$cid.'"');
        if ($query->num_rows()) {
            return $query->result_array();
        }
        return false;
    }

    public function getVideo($id)
    {
        $query = $this->db->query('
        SELECT conference_elements.*, PO.title as title, PO.id as post_id, PO.first_Name, PO.last_Name
        FROM conference_elements
        JOIN (SELECT moviesdb.title as title, moviesdb.id as id, useraccounts.firstName as first_Name, useraccounts.lastName as last_Name
                FROM moviesdb
                JOIN useraccounts
                ON moviesdb.idAuthor = useraccounts.id
                WHERE moviesdb.id = '.$id.') AS PO
        ON conference_elements.elementID = PO.id
        ');
        return $query->row_array();
    }

    public function getPoster($id)
    {
        $query = $this->db->query('
        SELECT conference_elements.*, PO.title as title, PO.id as post_id, PO.first_Name, PO.last_Name
        FROM conference_elements
        JOIN (SELECT posterdb.posterTitle as title, posterdb.id as id, useraccounts.firstName as first_Name, useraccounts.lastName as last_Name
                FROM posterdb
                JOIN useraccounts
                ON posterdb.idAuthor = useraccounts.id
                WHERE posterdb.id = '.$id.') AS PO
        ON conference_elements.elementID = PO.id
        ');
        return $query->row_array();
    }

    public function getPaper($id)
    {
        $query = $this->db->query('
        SELECT conference_elements.*, PO.title as title, PO.id as post_id, PO.first_Name, PO.last_Name
        FROM conference_elements
        JOIN (SELECT paperdb.paperTitle as title, paperdb.id as id, useraccounts.firstName as first_Name, useraccounts.lastName as last_Name
                FROM paperdb
                JOIN useraccounts
                ON paperdb.idAuthor = useraccounts.id
                WHERE paperdb.id = '.$id.') AS PO
        ON conference_elements.elementID = PO.id
        ');
        return $query->row_array();
    }

    public function getPresentation($id)
    {
        $query = $this->db->query('
        SELECT conference_elements.*, PO.title as title, PO.id as post_id, PO.first_Name, PO.last_Name
        FROM conference_elements
        JOIN (SELECT presentationdb.presTitle as title, presentationdb.id as id, useraccounts.firstName as first_Name, useraccounts.lastName as last_Name
                FROM presentationdb
                JOIN useraccounts
                ON presentationdb.idAuthor = useraccounts.id
                WHERE presentationdb.id = '.$id.') AS PO
        ON conference_elements.elementID = PO.id
        ');
        return $query->row_array();
    }

    public function getFullContribution($elements, $sessions){
        $result = '';
        if (!empty($elements)){
            $result = '<table id="table_contributions" class="display table-custom">';
            $result .= '<thead>
                <tr>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Type</th>
                  <th class="type">Session</th>
                  <th>Delete</th>
                </tr>
                </thead>';
            $result .= '<tbody>';
            foreach ($elements as $element) {
                $result .= '<tr>';
                $result .= '
                <td>
                  <a href="' . base_url($element['type'] . '/' . $element['post_id']) . '" class="link" target="_blank">
                    ' . $element['title'] . '
                  </a>
                  </td>';
                $result .= '
                <td>
                    ' . $element['first_Name'] . ' '. $element['last_Name'] . '
                  </td>';
                $result .= '
                <td>
                    ' . $element['type'] . '
                  </td>';
                $result .= '
                  <td>
                      <div class="form-item">
                        <select data-id ="' . $element['ID'] . '" class="input-custom select-custom-none-search select-session-element">';
                foreach ($sessions as $session){
                    if ($session['ID'] == $element['session']){
                        $result .= '
                        <option value="' . $session['ID'] . '" selected >' . $session['name'] . '</option>
                    ';
                    }
                    else{
                        $result .= '
                        <option value="' . $session['ID'] . '">' . $session['name'] . '</option>
                    ';
                    }
                }
                $result .= '
                        </select>
                      </div>
                  </td>';
                $result .= '
                  <td class="icon-remove-custom">
                    <span data-id="' . $element['ID'] . '" data-title="' . $element['title'] . '" class="icon-cancel btn-delete-element"></span>
                  </td>';
                $result .= '</tr>';
            }
            $result .= '</tbody>';
            $result .= '</table>';
        }

        return $result;
    }

    public function checkExist($postID, $postType){
        $query = $this->db->get_where($this->table, array('type' => $postType, 'elementID' => $postID));
        if ($query->num_rows()) {
            return true;
        }
        return false;
    }
}