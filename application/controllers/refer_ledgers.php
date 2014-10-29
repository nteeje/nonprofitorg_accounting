<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class refer_ledgers extends CI_Controller {

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
        
        $data['main_content'] = 'reference/home';
        $this->load->view('includes/template', $data);
    }

}
