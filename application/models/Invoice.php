<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Invoice extends MY_Model
{

    /**
     * @var string
     */
    protected $table = 'invoices';

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url_helper', 'form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function getInvoiceByUser($userID)
    {
        $query = $this->db->get_where($this->table, array('userID' => $userID));
        $invoices = $query->result();
        $result = '<table class="table-custom table-invoice display" id="table_invoice">';
        $result .= '<thead>
						<tr>
							<th>Invoice Number</th>
							<th>CID</th>
							<th>PID</th>
							<th>Actions</th>
							<th></th>
						</tr>
					</thead>';
        $result .= '<tbody>';
        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $result .= '<tr>';
                $result .= '<td>';
                $result .= $invoice->invoiceID;
                $result .= '</td>';
                $result .= '<td>';
                $result .= $invoice->CID;
                $result .= '</td>';
                $result .= '<td>';
                $result .= $invoice->PID;
                $result .= '</td>';
                $result .= '<td>';
                $result .= '<button class="btn-custom btn-border green"><a href="' . base_url('uploads/userfiles/' . $userID . '/invoices/' . $invoice->invoiceID . '.pdf') . '" target="_blank">View detail</a></button>';
                $result .= '</td>';
                $result .= '<td>';
                $result .= '<button class="btn-custom btn-border green"><a href="' . base_url('uploads/userfiles/' . $userID . '/invoices/' . $invoice->invoiceID . '.pdf') . '" download="' . $invoice->invoiceID . '.pdf' . '">Download</a></button>';
                $result .= '</td>';
                $result .= '</tr>';
            }
        } else {
            $result .= '<tr>';
            $result .= '<td>';
            $result .= 'No data';
            $result .= '</td>';
            $result .= '<tr>';
        }
        $result .= '</tbody>';
        $result .= '</table>';

        return $result;
    }
}