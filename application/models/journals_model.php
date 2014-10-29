<?php

class Journals_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    /**
     * Get product by his is
     * @param int $product_id 
     * @return array
     */
    public function get_journals_by_id($id) {
        $this->db->select('*');
        $this->db->from('common_journal');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch journals data from the database
     * possibility to mix search, filter and order
     * @param string $search_string 
     * @param strong $order
     * @param string $order_type 
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_journals($search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null) {
        $this->db->select('id');
        $this->db->select('account_id');
        $this->db->select('entry_type');
        $this->db->select('entry_reference');
        $this->db->select('dr_ledger');
        $this->db->select('cr_ledger');
        $this->db->select('dr_amount');
        $this->db->select('cr_amount');
        $this->db->select('entry_date');
        $this->db->from('common_journal');

        if ($search_string) {
            $this->db->like('account_id', $search_string);
        }
        $this->db->group_by('id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_journals($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('common_journal');
        if ($search_string) {
            $this->db->like('account_id', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean 
     */
    function store_journals($data) {
        $insert = $this->db->insert('common_journal', $data);
        return $insert;
    }

    /**
     * Update manufacture
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_journals($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('common_journal', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete manufacturer
     * @param int $id - manufacture id
     * @return boolean
     */
    function delete_journals($id) {
        $this->db->where('id', $id);
        $this->db->delete('common_journal');
    }

}
