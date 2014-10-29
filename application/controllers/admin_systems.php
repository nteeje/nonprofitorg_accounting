<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * name of the folder responsible for the views 
 * which are manipulated by this controller
 * @constant string
 */
        const VIEW_FOLDER = 'admin/systems';

/**
 * Responsable for auto load the model
 * @return void
 */
class Admin_systems extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        
    }

    /*
     * Backup ledgers & jouranals into CSV
     */

    function backupLJs() {
        if ($this->dbutil->database_exists('codl_nationalgrid')) {
            //--------------------Ledgers----------------
            if ($this->dbutil->optimize_table('ledgers')) {
                $data['optled'] = 'Success!ledgers table optimized.';
            }
            $querylg = $this->db->query("SELECT * FROM ledgers");
            $delimiter = ",";
            $newline = "\r\n";
            $csvlg = $this->dbutil->csv_from_result($querylg, $delimiter, $newline);
            $data['filelg'] = 'ledgers.csv';
            if (!write_file('./dboperation/csv/ledgers.csv', $csvlg)) {
                $data['ledgermsg'] = 'Unable to write the ledgers.csv file';
            } else {
                $data['ledgermsg'] = 'File written to the ledgers.csv!';
            }
            //-------------common_journal----------------
            if ($this->dbutil->optimize_table('ledgers')) {
                $data['optcj'] = 'Success!Common_journal table optimized.';
            }
            $querycj = $this->db->query("SELECT * FROM common_journal");

            $csvcj = $this->dbutil->csv_from_result($querycj, $delimiter, $newline);
            $data['filecj'] = 'common_journal.csv';
            if (!write_file('./dboperation/csv/common_journal.csv', $csvcj)) {
                $data['cjournalmsg'] = 'Unable to write the common_journal.csv file';
            } else {
                $data['cjournalmsg'] = 'File written to the common_journal.csv!';
            }
        }
        $data['main_content'] = 'admin/systems/home';
        $this->load->view('includes/template', $data);
    }

    function getBackupDB() {
        if ($this->dbutil->database_exists('codl_nationalgrid')) {
            $prefs = array(
                //'tables' => array('table1', 'table2'), // Array of tables to backup.
                'ignore' => array(), // List of tables to omit from the backup
                'format' => 'zip', // gzip, zip, txt
                'filename' => 'mybackup.sql', // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
                'add_insert' => TRUE, // Whether to add INSERT data to backup file
                'newline' => "\n"               // Newline character used in backup file
            );
            // Load the file helper and write the file to your server
            $backup = & $this->dbutil->backup($prefs);

            write_file('./dboperation/backup/dbBackup.zip', $backup);
// Load the download helper and send the file to your desktop

            force_download('dbBackup.zip', $backup);
        }
    }

}

/* End of file c_test.php */
/* Location: ./application/controllers/c_test.php */