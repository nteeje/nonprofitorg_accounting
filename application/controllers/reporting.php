<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporting extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("Mypdf");
        $this->load->model('Codl_model');
    }

    public function index() {
        $data['view'] = 'report_view';
        $data['title'] = 'Home';
        $data['membersCredit'] = $this->Codl_model->getData('userinfo_view', array(), array('group' => 1), 0, 0);
        $data['membersShares'] = $this->Codl_model->getData('userinfo_view', array(), array('group' => 2), 0, 0);
        //$data['acc_credit'] = $this->Generic_model->getData('account', array(), array('transaction_id' => 4), 0, 0);
        //$data['acc_shares'] = $this->Generic_model->getData('account', array(), array('transaction_id' => 3), 0, 0);
        //var_dump($data);
        $this->load->view('template', $data);
    }

    public function creditInfo($param = null) {
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nalin Tharanga(Core Developers)');
        $pdf->SetTitle('SCID Credit Information');
        $pdf->SetSubject('Credit Information');
        $pdf->SetKeywords('Credit Information');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda", "www.codlgrid.com/scid");
        $pdf->setFooterData(array('Tharanga'), array("www.codlgrid.com"));
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set font
        $pdf->SetFont('helvetica', '', 12);
// add a page
        $pdf->AddPage();
        // column titles
        $userheader = array('ID #', 'NIC #', 'Name', 'Address');

// data loading
        $users = $this->Codl_model->getData('userinfo_view', array(), array('ledger' => $param), 0, 0);
        if (!is_null($users)) {
            foreach ($users as $user) {
                $data = array(
                    $user->mmbr_account_id,
                    $user->mmbr_nic,
                    $user->mmbr_name,
                    $user->mmbr_address,
                );
                $userData[] = $data;
            }
        }

// print colored table
        $pdf->userInformation($userheader, $userData);
        $pdf->Ln(0);
// column titles
        $header = array('Description', 'Debit', 'Credit', 'Date');
// data loading
        $creditInfo = $this->Codl_model->getData('credit_' . $param, array(), array(), 0, 0);
        if (!is_null($creditInfo)) {
            foreach ($creditInfo as $credit) {
                $data = array(
                    $credit->description,
                    $credit->dr_amount,
                    $credit->cr_amount,
                    $credit->acc_date,
                );
                $creditData[] = $data;
            }
        }

// print colored table
        $pdf->creditInformation($header, $creditData);
// ---------------------------------------------------------
// close and output PDF document
        // Set some content to print
//        $html = '<div style="text-align:center;font-size:6pt;margin-top:20px"><b>core developers</b>.(www.codlgrid.com)077-8240001</div>';
//        $pdf->writeHTML($html, true, false, true, false, '');

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");
        $pdf->Output('Member_Payments"' . $date . '".pdf', 'I');
    }

    function getMembers() {
        //$arr_columns = array('mmbr_account_id', 'mmbr_nic', 'mmbr_name','mmbr_address','ledger');
        //$arr_where = array('group' => 1,'mmbr_account_id LIKE'=>$_POST['keyword'],'OR mmbr_nic LIKE'=>$_POST['keyword']);
        $result['data'] = $this->Codl_model->genericQuery('SELECT mmbr_account_id, mmbr_nic, mmbr_name,mmbr_address,ledger FROM userinfo_view WHERE mmbr_account_id LIKE "'.$_POST['keyword'].'%" OR mmbr_nic LIKE "'.$_POST['keyword'].'%"');
        echo json_encode($result);
    }

}

/* End of file c_test.php */
/* Location: ./application/controllers/c_test.php */