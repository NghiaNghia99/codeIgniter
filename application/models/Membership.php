<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 15:08
 */

class Membership extends MY_Model
{

	/**
	 * @var string
	 */
	protected $table = 'project_membership';

	/**
	 * Paper constructor.
	 */
	public function __construct()
	{
		$this->load->database();
	}

	function get_list_project($idUser = array()){
		$this->db->where($idUser);
		$query = $this->db->get($this->table);
		if ($query->num_rows()) {

			return $query->result();
		}
		return false;
	}

	function checkMember($userID, $identifier){
      $where = array('idUser' => $userID, 'identifierPID' => $identifier);
      $this->db->where($where);
      $query = $this->db->get($this->table);
      if ($query->num_rows() > 0) {
          return true;
      }
      return false;
  }

	function convertInvoiceToPdf($userID, $PID, $invoiceNumber, $subTotal, $tax, $total, $date)
	{
		$query = $this->db->query('
            SELECT *
            FROM orderpid
            JOIN useraccounts
            ON orderpid.idUser = useraccounts.id
            WHERE BINARY orderpid.pid = "' . $PID . '"
            ');
		$pid = $query->row();
		if (!empty($pid)){
			$html = '<!doctype html>
                <html lang="en">
                <head>
                  <!-- Required meta tags -->
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                  <title>Science Media</title>
                </head>
                <body style="background-color: #ffffff; margin: 0">
                
                <div class="section-invoice-detail" style="width: 595px; padding: 30px 20px 0 70px;
                      margin: 0 auto;
                      font-size: 14px; line-height: 1.3">';
			$html .= '<div class="block-1" style="margin-bottom: 20px; width: 100%; display: block; overflow: auto;">
                <div class="left" style="width: 64%; float: left;">
                  <div class="customer-item" style="padding-right: 60px; padding-top: 80px;">
                    <div class="customer-name">'. $pid->contactFirstName . ' ' . $pid->contactLastName .'</div>';
			if (!empty($pid->department)){
				$html .= '<div class="customer-department">'. $pid->department .'</div>';
			}
			$html .= '
                    <div class="customer-affiliation">'. $pid->billingAffiliation .'</div>
                    <div class="customer-address" style="padding-top: 10px;">
                      <div class="street-number">
                        <span>'. $pid->billingStreet .'</span> <span>'. $pid->billingStreetNr .'</span>
                      </div>
                      <div class="postal-city">
                        <span>'. $pid->billingPostalCode .'</span> <span>'. $pid->billingCity .'</span>, <span>'. $pid->billingState .'</span>
                      </div>
                      <div class="country">'. $pid->billingCountry .'</div>
                    </div>
                  </div>
                </div>
                <div class="right" style="width: 35%; float: right;">
                  <div class="smn-item">
                    <div class="smn-logo" style="margin-bottom: 15px;">
                      <img style="width: 200px;" src="'. FCPATH . '/assets/images/logo.png' .'" alt="">
                    </div>
                    <div class="smn-info" style="color: #77787a;
                        font-size: 12px;">
                      <div class="detail" style="margin-bottom: 10px;">
                        <div>SMN - ScienceMedia Network GmbH </div>
                        <div>Maienb&#252;hlstra&#223;e 10</div>
                        <div>79677 Wembach </div>
                        <div>info@science-media.org</div>
                      </div>
                      <div class="detail" style="margin-bottom: 10px;">
                        <div>Bank account </div>
                        <div>Deutsche Bank</div>
                        <div>IBAN DE76682700240019549500 </div>
                        <div>BIC DEUTDEDB682</div>
                      </div>
                      <div class="detail" style="margin-bottom: 10px;">
                        <div>VAT ID: DE299859377</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';
			$html .= '';
			$html .= '<div class="block-2">
                <div class="block-2-title" style="font-size: 32px;
                      color: #c1d127;
                      margin-bottom: 20px;">Invoice</div>
                <div class="invoice-number-date" style="margin-bottom: 40px;">
                  <div>Invoice Number: '. $invoiceNumber .' </div>
                  <div>Date: '. $date .'</div>
                </div>
                <div class="cid" style="margin-bottom: 30px;">PID: '. $PID .'</div>
                <div class="payment-info" style="margin-bottom: 30px;">
                  <div style="border-top: 1px solid #465245; padding-left: 250px; padding-right: 175px;">
                    <table style="width: 100%;">
                      <tr>
                        <td style="min-width: 60px;">Sub Total</td>
                        <td style="min-width: 60px; text-align:right">'. $subTotal .'&#8364;</td>
                      </tr>
                      <tr>
                        <td style="min-width: 60px;">VAT (19%)</td>
                        <td style="min-width: 60px; text-align:right">'. $tax .'&#8364;</td>
                      </tr>
                    </table>
                  </div>
                  <div style="border-top: 1px solid #465245; padding-left: 250px; padding-right: 175px;">
                    <table style="width: 100%;">
                      <tr>
                        <td style="min-width: 60px;">Total</td>
                        <td style="min-width: 60px; text-align:right">'. $total .'&#8364;</td>
                      </tr>
                    </table>
                  </div>  
                </div>
                <div class="payment-method" style="margin-bottom: 25px;">Payment method: bank transfer</div>
              </div>';
			$html .= '';
			$html .= '<div class="block-3">
                <div style="margin-bottom: 40px;">Thank you for choosing Science Media Project ID for your project. We are happy to welcoming you back very soon.</div>
                <div style="margin-bottom: 30px;">Your Science Media Team</div>
                <div class="footer-invoice" style="width: 100%">
                  <img style="width: 100%" src="'. FCPATH . '/assets/images/footer_invoice.jpg' .'" alt="">
                </div>
              </div>';
			$html .= '';
			$html .= '</div>
                </body>
                </html>';

			//user
			$userDir = FCPATH . 'uploads/userfiles/' . $userID;
			if (!(is_dir($userDir) OR is_file($userDir) OR is_link($userDir))) {
				$oldmask = umask(0);
				mkdir($userDir, 0777);
				umask($oldmask);
			}

			//Invoices
			$invoiceDir = FCPATH . 'uploads/userfiles/' . $userID . '/invoices/';
			if (!(is_dir($invoiceDir) OR is_file($invoiceDir) OR is_link($invoiceDir))) {
				$oldmask = umask(0);
				mkdir($invoiceDir, 0777);
				umask($oldmask);
			}

			$tempDir = FCPATH . 'uploads/';
			$mpdf = new \Mpdf\Mpdf(array('tempDir' => $tempDir));
			$mpdf->WriteHTML($html);
			$mpdf->Output($invoiceDir . $invoiceNumber . '.pdf', 'F');

			return $pid->contactEMail;
		}
		return false;
	}
}
