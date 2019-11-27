<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

require FCPATH . '/vendor/autoload.php';

use PayPal\Api\Sale;

class ConferenceRegistration extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'conference_registrations';

    /**
     * ConferenceRegistration constructor.
     */
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
    function getRegistrationByCID($cid)
    {
        $registrationTool = $this->registrationtool->get_info_binary('CID', $cid);

        $result = '';
        $query = $this->db->query('
            SELECT conference_registrations.*, useraccounts.lastName as lastName, useraccounts.firstName as firstName, useraccounts.affiliation as affiliation, useraccounts.email as email
            FROM conference_registrations
            JOIN useraccounts
            ON conference_registrations.userID = useraccounts.id
            WHERE BINARY conference_registrations.CID = "'. $cid .'"
            ');
        $registrationList = $query->result();
        if (!empty($registrationList) && !empty($registrationTool)) {
            $result = '<table id="table_registration" class="display table-custom">';
            $result .= '<thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th class="affiliation">Affiliation</th>
                  <th>Contribution(s)</th>
                  <th class="d-none">Presentation</th>
                  <th class="d-none">Poster</th>';
            if (!empty($registrationTool->registerForDinner)) {
                $result .= '<th>Dinner</th>';
            }
            $result .= '     
                  <th class="d-none">Receipt Name</th>
                  <th class="d-none">Receipt Street</th>
                  <th class="d-none">Receipt Postal Code</th>
                  <th class="d-none">Receipt City</th>
                  <th class="d-none">Receipt State</th>
                  <th class="d-none">Receipt Country</th>
                  <th class="d-none">Additional Info</th>
                  <th class="d-none">Email</th>';
            if (!empty($registrationTool->optionalCheckbox1)) {
                $result .= '<th class="d-none">'. $registrationTool->optionalCheckbox1 .'</th>';
            }
            if (!empty($registrationTool->optionalCheckbox2)) {
                $result .= '<th class="d-none">'. $registrationTool->optionalCheckbox2 .'</th>';
            }
            $result .= '
                  <th class="d-none">Registrationdate</th>
                  <th class="status">Status</th>
                  <th class="reject">Reject</th>
                  <th>Remind</th>
                </tr>
                </thead>';
            $result .= '<tbody>';
            foreach ($registrationList as $registration) {
                $optionalCheckbox1 = 'No';
                $optionalCheckbox2 = 'No';
                $result .= '<tr>';
                $result .= '
                <td data-id="' . $registration->ID . '" class="show-registration-detail">
                    ' . $registration->firstName . '
                  </td>';
                $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                    ' . $registration->lastName . '
                  </td>';
                $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                    ' . $registration->affiliation . '
                  </td>';
                if ($registration->holdPresentation == 1 || $registration->presentPoster == 1) {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <span class="status yes">
                        Yes
                      </span>
                  </td>';
                } else {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <span class="status no">
                        No
                      </span>
                  </td>';
                }
                if ($registration->holdPresentation == 1) {
                    $result .= '
                  <td class="d-none">
                      <span class="status yes">
                        Yes
                      </span>
                  </td>';
                } else {
                    $result .= '
                  <td class="d-none">
                      <span class="status no">
                        No
                      </span>
                  </td>';
                }
                if ($registration->presentPoster == 1) {
                    $result .= '
                  <td class="d-none">
                      <span class="status yes">
                        Yes
                      </span>
                  </td>';
                } else {
                    $result .= '
                  <td class="d-none">
                      <span class="status no">
                        No
                      </span>
                  </td>';
                }
                if (!empty($registrationTool->registerForDinner)){
                    if ($registration->attendConfDinner == 1) {
                        $result .= '
                      <td data-id="' . $registration->ID . '" class="show-registration-detail">
                          <span class="status yes">
                            Yes
                          </span> 
                      </td>';
                        } else {
                            $result .= '
                      <td data-id="' . $registration->ID . '" class="show-registration-detail">
                          <span class="status no">
                            No
                          </span>
                      </td>';
                    }
                }
                $result .= '
                  <td class="d-none">
                    ' . $registration->recName . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->recStreet . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->recPostalCode . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->recCity . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->recState . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->recCountry . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->additionalInfo . '
                  </td>';
                $result .= '
                  <td class="d-none">
                    ' . $registration->email . '
                  </td>';
                if (!empty($registrationTool->optionalCheckbox1)) {
                    if (!empty($registration->optionalCheckbox1)){
                        $optionalCheckbox1 ='Yes';
                    }
                    $result .= '
                  <td class="d-none">
                    ' . $optionalCheckbox1 . '
                  </td>';
                }
                if (!empty($registrationTool->optionalCheckbox2)) {
                    if (!empty($registration->optionalCheckbox2)){
                        $optionalCheckbox2 ='Yes';
                    }
                    $result .= '
                  <td class="d-none">
                    ' . $optionalCheckbox2 . '
                  </td>';
                }
                $result .= '
                  <td class="d-none">
                    ' . $registration->dateOfRegistration . '
                  </td>';
                if ($registration->status == 'Free') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status free">
                        Free
                      </div>
                  </td>';
                } elseif ($registration->status == 'Unpaid') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status not-paid">
                        Unpaid
                      </div>
                  </td>';
                } elseif ($registration->status == 'completed') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status paid">
                        Paid
                      </div>
                  </td>';
                } elseif ($registration->status == 'pending' || $registration->status == 'unclaimed') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status pending">
                        Pending
                      </div>
                  </td>';
                } elseif ($registration->status == 'refunded') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status refund">
                        Refunded
                      </div>
                  </td>';
                } elseif ($registration->status == 'denied') {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status deny">
                        Refunded
                      </div>
                  </td>';
                } else {
                    $result .= '
                  <td data-id="' . $registration->ID . '" class="show-registration-detail">
                      <div class="brand status deny">
                        Others
                      </div>
                  </td>';
                }
                $result .= '
                  <td class="icon-remove-custom">
                    <span data-id="' . $registration->ID . '" class="icon-cancel btn-remove-registration"></span>
                  </td>';
                if ($registration->status == 'Unpaid') {
                    if (!$this->session->tempdata('remind_registration')) {
                        $result .= '
                          <td>
                            <div class="btn-custom btn-border green btn-remind">
                              <a data-id="' . $registration->ID . '" class="add-spinner btn-remind-registration">Remind</a>
                            </div>
                          </td>';
                    } else {
                        $result .= '
                          <td>
                            <div class="btn-custom btn-border green btn-remind label">
                              <a>Sent</a>
                            </div>
                          </td>';
                    }
                } else {
                    $result .= '
                  <td>
                  </td>';
                }
                $result .= '</tr>';
            }
            $result .= '</tbody>';
            $result .= '</table>';
        }

        return $result;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    function attendedConferences($user_id)
    {
        $query = $this->db->query('
            SELECT CD.*
            FROM conference_registrations
            LEFT JOIN (SELECT conferences.id as id, conferences.CID, conferences.confTitle as confTitle, conferences.confLocation as confLocation, conferences.startDate as startDate, conferences.endDate as endDate, conferences.fee as fee,
                                    useraccounts.firstName,
                                    useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name
                        FROM conferences
                        JOIN useraccounts
                        ON conferences.userID = useraccounts.id
                        JOIN categories
                        ON conferences.category = categories.id
                        JOIN subcategories
                        ON conferences.subcategory = subcategories.id) AS CD
            ON BINARY conference_registrations.CID = CD.CID
            WHERE conference_registrations.userID = ' . $user_id);

        return $query->result();
    }

    /**
     * @param $user_id
     * @param $limit
     * @param $start
     * @param $nameCol
     * @param $direction
     * @return mixed
     */
    function sortAttendedConferencesPagination($user_id, $limit, $start, $nameCol, $direction)
    {
        $query = $this->db->query('
            SELECT CD.*, conference_registrations.status
            FROM conference_registrations
            LEFT JOIN (SELECT conferences.id as id, conferences.CID, conferences.confTitle as confTitle, 
                                conferences.views, conferences.userID as userID, 
                                conferences.filenameBanner_original as filenameBanner_original, 
                                conferences.confLocation as confLocation, conferences.startDate as startDate, 
                                conferences.endDate as endDate, conferences.fee as fee, useraccounts.firstName, 
                                useraccounts.lastName, categories.name as category_name, subcategories.name as subcategory_name
                        FROM conferences
                        JOIN useraccounts
                        ON conferences.userID = useraccounts.id
                        JOIN categories
                        ON conferences.category = categories.id
                        JOIN subcategories
                        ON conferences.subcategory = subcategories.id) AS CD
            ON BINARY conference_registrations.CID = CD.CID
            WHERE conference_registrations.userID = ' . $user_id . '
            ORDER BY '.$nameCol.' '.$direction.'
            LIMIT '.$limit.' OFFSET '.$start.'
            ');

        return $query->result();
    }

    /**
     * @param $cid
     * @return mixed
     */
    function getUserParticipationByConference($cid)
    {
        $query = $this->db->select('useraccounts.*, conference_registrations.publishName')
          ->from('conference_registrations')
          ->where('conference_registrations.CID', $cid)
          ->join('useraccounts', 'useraccounts.id = conference_registrations.userID')
          ->get();

        return $query->result();
    }

    /**
     * @param $cid
     * @param $userID
     * @return mixed
     */
    function getByCidAndUser($cid, $userID)
    {
        $query = $this->db->select('conference_registrations.saleID, conference_registrations.status as payment_status, conferences.*, useraccounts.*')
          ->from('conference_registrations')
          ->where('conference_registrations.CID', $cid)
          ->where('conference_registrations.userID', $userID)
          ->join('useraccounts', 'useraccounts.id = conference_registrations.userID')
          ->join('conferences', 'BINARY conferences.CID = conference_registrations.CID')
          ->get();

        return $query->row();
    }
}