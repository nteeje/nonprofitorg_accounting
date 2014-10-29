<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * name of the folder responsible for the views 
 * which are manipulated by this controller
 * @constant string
 */
        const VIEW_FOLDER = 'admin/ledgers';

/**
 * Responsable for auto load the model
 * @return void
 */
class Admin_ledgers extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ledgers_model');
        $this->load->model('references_model');
        $this->load->library("Mypdf");
        $this->load->dbutil();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $dbs = $this->dbutil->list_databases();

        //var_dump($dbs[29]);die;
        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/ledgers';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session? 
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if (isset($filter_session_data)) {
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_products'] = $this->ledgers_model->count_ledgers($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['ledgers'] = $this->ledgers_model->get_ledgers($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['ledgers'] = $this->ledgers_model->get_ledgers($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['ledgers'] = $this->ledgers_model->get_ledgers('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['ledgers'] = $this->ledgers_model->get_ledgers('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['ledgers_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays

            $data['count_products'] = $this->ledgers_model->count_ledgers();
            $data['ledgers'] = $this->ledgers_model->get_ledgers('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/ledgers/list';
        $this->load->view('includes/template', $data);
    }

//index

    public function add() {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation

            $this->form_validation->set_rules('account_id', 'Account ID', 'required');
            $this->form_validation->set_rules('group_id', 'Account Type', 'required');
            $this->form_validation->set_rules('op_balance_dc', 'Op. Bal. Type', 'required');
            $this->form_validation->set_rules('open_balance', 'Open Balance', 'xss_clean|required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');


            //var_dump($ledger[0]->ledger);die;
            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $data_to_store = array(
                    'member' => $this->input->post('account_id'),
                    'group_id' => $this->input->post('group_id'),
                    'op_balance_dc' => $this->input->post('op_balance_dc'),
                    'op_balance' => $this->input->post('open_balance'),
                    'name' => $this->input->post('hdnAccount'),
                );
                //if the insert has returned true then we show the flash message
                if ($this->ledgers_model->store_ledgers($data_to_store)) {
                    //create ledger account
                    $this->references_model->genericQuery("SELECT max(id) INTO @varname FROM ledgers");
                    $this->references_model->genericQuery("call credit_ledgercreate(@varname,@outpr)");
                    $data['flash_message'] = TRUE;
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['ledgertypes'] = $this->references_model->getData('ledger_types', array('id', 'value'), array(), 0, 0);

        $data['accounts'] = $this->references_model->getOrderdData('userinfo_view', array('mmbr_nic', 'mmbr_account_id', 'mmbr_name', 'ledger'), array(), 'mmbr_account_id', 0, 0, 0);
        //var_dump($data['entrytypes']);
        //load the view
        $data['main_content'] = 'admin/ledgers/add';
        $this->load->view('includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id 
        $id = $this->uri->segment(4);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            $this->form_validation->set_rules('account_id', 'Account ID', 'required');
            $this->form_validation->set_rules('group_id', 'Account Type', 'required');
            $this->form_validation->set_rules('op_balance_dc', 'Op. Bal. Type', 'required');
            $this->form_validation->set_rules('open_balance', 'Open Balance', 'xss_clean|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');




//if the form has passed through the validation
            if ($this->form_validation->run()) {

                $data_to_store = array(
                    'member' => $this->input->post('account_id'),
                    'group_id' => $this->input->post('group_id'),
                    'op_balance_dc' => $this->input->post('op_balance_dc'),
                    'op_balance' => $this->input->post('open_balance'),
                    'name' => $this->input->post('hdnAccount'),
                );
                //if the insert has returned true then we show the flash message
                if ($this->ledgers_model->update_ledgers($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/ledgers/update/' . $id . '');
            }//validation run
        }
        $data['ledgertypes'] = $this->references_model->getData('ledger_types', array('id', 'value'), array(), 0, 0);

        $data['accounts'] = $this->references_model->getOrderdData('userinfo_view', array('mmbr_nic', 'mmbr_account_id', 'mmbr_name', 'ledger'), array(), 'mmbr_account_id', 0, 0, 0);
        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 
        $data['ledgers'] = $this->ledgers_model->get_ledgers_by_id($id);
        //var_dump($data);
        //load the view
        $data['main_content'] = 'admin/ledgers/edit';
        $this->load->view('includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id 
        $id = $this->uri->segment(4);
        $this->ledgers_model->delete_ledgers($id);
        redirect('admin/ledgers');
    }

//edit

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
        $result['data'] = $this->Codl_model->genericQuery('SELECT mmbr_account_id, mmbr_nic, mmbr_name,mmbr_address,ledger FROM userinfo_view WHERE mmbr_account_id LIKE "' . $_POST['keyword'] . '%" OR mmbr_nic LIKE "' . $_POST['keyword'] . '%"');
        echo json_encode($result);
    }

}

/* End of file c_test.php */
/* Location: ./application/controllers/c_test.php */