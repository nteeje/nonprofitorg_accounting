<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('references_model');
        $this->load->library("Mypdf");
        //  $this->load->model('report_model');

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $data['membersCredit'] = $this->references_model->getOrderdData('userinfo_view', array(), array('group' => 1), 'mmbr_account_id', 0, 0, 0);
        $data['membersShares'] = $this->references_model->getOrderdData('userinfo_view', array(), array('group' => 2), 'mmbr_account_id', 0, 0, 0);
        //$data['acc_credit'] = $this->Generic_model->getData('account', array(), array('transaction_id' => 4), 0, 0);
        //$data['acc_shares'] = $this->Generic_model->getData('account', array(), array('transaction_id' => 3), 0, 0);
        //load the view
        $data['main_content'] = 'admin/reports/home';
        $this->load->view('includes/template', $data);
    }
    
      public function cashaccount($param = null) {
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nalin Tharanga(Core Developers)');
        $pdf->SetTitle('SCID Credit Information');
        $pdf->SetSubject('Credit Information');
        $pdf->SetKeywords('Credit Information');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda-Cash Account", "www.codlgrid.com/scid");
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
        $header = array('Member #','ID #', 'Payment');
// data loading
        $cashInfo = $this->references_model->genericQuery('SELECT `account_id`,SUM(`cr_amount`)AS `Payment`,`entry_type`,`scid_member`.`mmbr_name` FROM `common_journal` JOIN `scid_member` ON `common_journal`.`account_id`=`scid_member`.`mmbr_nic` GROUP BY `account_id` ORDER BY `Payment` DESC');
        if (!is_null($cashInfo)) {
            foreach ($cashInfo as $cash) {
                $data = array(
                    $cash->mmbr_name,
                    $cash->account_id,
                    $cash->Payment,
                   
                );
                $creditData[] = $data;
            }
        }

// print colored table
        $pdf->cashPayment($header, $creditData);
// ---------------------------------------------------------
// close and output PDF document
        // Set some content to print
//        $html = '<div style="text-align:center;font-size:6pt;margin-top:20px"><b>core developers</b>.(www.codlgrid.com)077-8240001</div>';
//        $pdf->writeHTML($html, true, false, true, false, '');

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");
        $pdf->Output('Member_Payments"' . $date . '".pdf', 'I');
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
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda-Credit Account", "www.codlgrid.com/scid");
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
        $users = $this->references_model->getData('userinfo_view', array(), array('ledger' => $param), 0, 0);
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
        $creditInfo = $this->references_model->getData('credit_' . $param, array(), array(), 0, 0);
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

    public function shareInfo($param = null) {
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nalin Tharanga(Core Developers)');
        $pdf->SetTitle('SCID Share Information');
        $pdf->SetSubject('Share Information');
        $pdf->SetKeywords('Share Information');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda-Shares Account", "www.codlgrid.com/scid");
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
        $users = $this->references_model->getData('userinfo_view', array(), array('ledger' => $param), 0, 0);
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
        $sharesInfo = $this->references_model->getData('shares_' . $param, array(), array(), 0, 0);
        if (!is_null($sharesInfo)) {
            foreach ($sharesInfo as $shares) {
                $data = array(
                    $shares->description,
                    $shares->dr_amount,
                    $shares->cr_amount,
                    $shares->acc_date,
                );
                $sharesData[] = $data;
            }
        }

// print colored table
        $pdf->creditInformation($header, $sharesData);
// ---------------------------------------------------------
// close and output PDF document
        // Set some content to print
//        $html = '<div style="text-align:center;font-size:6pt;margin-top:20px"><b>core developers</b>.(www.codlgrid.com)077-8240001</div>';
//        $pdf->writeHTML($html, true, false, true, false, '');

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");
        $pdf->Output('Member_Payments"' . $date . '".pdf', 'I');
    }

    public function creditaccount() {
        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nalin Tharanga(Core Developers)');
        $pdf->SetTitle('SCID Credit Information');
        $pdf->SetSubject('Credit Information');
        $pdf->SetKeywords('Credit Information');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda-Credit Summary", "www.codlgrid.com/scid");
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
        $header = array('Member Name', 'NIC', 'Payment');
// data loading
        $creditInfo = $this->references_model->genericQuery('SELECT account_id,SUM(cr_amount) AS Payment,entry_type,scid_member.mmbr_name FROM common_journal JOIN scid_member ON common_journal.account_id=scid_member.mmbr_nic group by cr_ledger HAVING common_journal.entry_type=1 ORDER BY Payment DESC');
        if (!is_null($creditInfo)) {
            foreach ($creditInfo as $credit) {
                $data = array(
                    $credit->mmbr_name,
                    $credit->account_id,
                    $credit->Payment,
                    
                    
                );
                $creditData[] = $data;
            }
        }

// print colored table
       // $pdf->set
        $pdf->csummery($header, $creditData);
// ---------------------------------------------------------
// close and output PDF document
        // Set some content to print
//        $html = '<div style="text-align:center;font-size:6pt;margin-top:20px"><b>core developers</b>.(www.codlgrid.com)077-8240001</div>';
//        $pdf->writeHTML($html, true, false, true, false, '');

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");
        $pdf->Output('Member_Payments"' . $date . '".pdf', 'I');
    }

    public function sharesaccount() {
             // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nalin Tharanga(Core Developers)');
        $pdf->SetTitle('SCID Credit Information');
        $pdf->SetSubject('Credit Information');
        $pdf->SetKeywords('Credit Information');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Society of Commerce & Industries in Dodangoda-Shares Summary", "www.codlgrid.com/scid");
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
        $header = array('Member Name', 'NIC', 'Payment');
// data loading
        $creditInfo = $this->references_model->genericQuery('SELECT account_id,SUM(cr_amount) AS Payment,entry_type,scid_member.mmbr_name FROM common_journal JOIN scid_member ON common_journal.account_id=scid_member.mmbr_nic group by cr_ledger HAVING common_journal.entry_type=2 ORDER BY Payment DESC');
        if (!is_null($creditInfo)) {
            foreach ($creditInfo as $credit) {
                $data = array(
                    $credit->mmbr_name,
                    $credit->account_id,
                    $credit->Payment,
                    
                    
                );
                $creditData[] = $data;
            }
        }

// print colored table
        $pdf->ssummery($header, $creditData);
// ---------------------------------------------------------
// close and output PDF document
        // Set some content to print
//        $html = '<div style="text-align:center;font-size:6pt;margin-top:20px"><b>core developers</b>.(www.codlgrid.com)077-8240001</div>';
//        $pdf->writeHTML($html, true, false, true, false, '');

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");
        $pdf->Output('Member_Payments"' . $date . '".pdf', 'I');
    }

    function searchCredit() {
        $result['data'] = $this->references_model->genericQuery('SELECT mmbr_account_id, mmbr_nic, mmbr_name,mmbr_address,`group`,ledger FROM userinfo_view WHERE `group` = 1 AND mmbr_account_id LIKE "' . $_POST['keyword'] . '%" OR mmbr_nic LIKE "' . $_POST['keyword'] . '%"');
        echo json_encode($result);
    }

    function searchShare() {
        $result['data'] = $this->references_model->genericQuery('SELECT mmbr_account_id, mmbr_nic, mmbr_name,mmbr_address,`group`,ledger FROM userinfo_view WHERE `group` = 2 AND mmbr_account_id LIKE "' . $_POST['keyword'] . '%" OR mmbr_nic LIKE "' . $_POST['keyword'] . '%"');
        echo json_encode($result);
    }

}

/* End of file c_test.php */
/* Location: ./application/controllers/c_test.php */