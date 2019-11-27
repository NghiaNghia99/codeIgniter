<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class ConferenceAbstract extends MY_Model
{

    protected $table = 'conference_abstracts';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * @param $cid
     * @return mixed
     */
    function getAbstractByCID($cid)
    {
        $result = '';
        $query = $this->db->select('conference_abstracts.*, useraccounts.lastName as lastName, useraccounts.firstName as firstName, useraccounts.affiliation as affiliation, useraccounts.email as email')
          ->from('conference_abstracts')
          ->where('conference_abstracts.CID', $cid)
          ->join('useraccounts', 'useraccounts.id = conference_abstracts.userID')
          ->get();
        $abstractList = $query->result();
        if (!empty($abstractList)) {
            $result = '<table id="table_approve_element" class="display table-custom">';
            $result .= '<thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Title</th>
                  <th class="type">Type</th>
                  <th class="d-none">Co-Authors</th>
                  <th class="d-none">Affiliations</th>
                  <th class="d-none">Abstract Text</th>
                  <th class="d-none">Email</th>
                  <th>Reject</th>
                  <th style="color: transparent;">Edit Abstract Type</th>
                </tr>
                </thead>';
            $result .= '<tbody>';
            foreach ($abstractList as $abstract) {
                $type = 'Talk';
                if ($abstract->poster == 1){
                    $type = 'Poster';
                }
                $result .= '<tr>';
                $result .= '
                <td data-id="' . $abstract->ID . '" class="show-abstract-detail">
                    ' . $abstract->firstName . '
                  </td>';
                $result .= '
                  <td data-id="' . $abstract->ID . '" class="show-abstract-detail">
                    ' . $abstract->lastName . '
                  </td>';
                $result .= '
                  <td data-id="' . $abstract->ID . '" class="show-abstract-detail">
                    ' . $abstract->title . '
                  </td>';
                    $result .= '
                    <td data-id="' . $abstract->ID . '" class="show-abstract-detail">'. $type .'</td>';
                $result .= '
                  <td class="d-none">
                    ' . $abstract->coAuthors . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $abstract->affiliations . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $abstract->text . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $abstract->email . '
                  </td>';
                $result .= '
                  <td class="icon-remove-custom">
                    <span data-id="' . $abstract->ID . '" class="icon-cancel btn-remove-abstract"></span>
                  </td>';
                $result .= '
                  <td class="icon-edit-custom">
                    <span data-id="' . $abstract->ID . '" 
                    data-type="'. $type .'"  
                    data-first-name="'. $abstract->firstName .'"
                     data-last-name="'. $abstract->lastName .'"
                      data-title="'. $abstract->title .'"
                    class="icon-edit btn-edit-abstract"></span>
                  </td>';
                $result .= '</tr>';
            }
            $result .= '</tbody>';
            $result .= '</table>';
        }

        return $result;
    }

    /**
     * @param $cid
     * @param $userID
     * @return mixed
     */
    function getByCidAndUser($cid, $userID)
    {
        $query = $this->db->select('conferences.*, useraccounts.*')
          ->from('conference_abstracts')
          ->where('conference_abstracts.CID', $cid)
          ->where('conference_abstracts.userID', $userID)
          ->join('useraccounts', 'useraccounts.id = conference_abstracts.userID')
          ->join('conferences', 'BINARY conferences.CID = conference_abstracts.CID')
          ->get();

        return $query->row();
    }
}