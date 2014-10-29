<?php

class References_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {

        $this->load->database();
    }

    /**
     * Get data from relevent table
     * 
     */
    //makes this to work with columns and without where,limit and offset
    function getData($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0) {
        $limit = ($limit == 0) ? Null : $limit;
        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }
        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);
            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }
            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }
            $query = $this->db->get();
            return $query->result();
        }
    }

    /**
     * Get data from relevent table
     * 
     */
    //makes this to work with columns and without where,limit and offset
    function getOrderdData($tablename = '', $columns_arr = array(), $where_arr = array(), $order = null, $order_type = 'Asc', $limit = 0, $offset = 0) {
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            if ($order) {
                $this->db->order_by($order, $order_type);
            } else {
                $this->db->order_by('id', $order_type);
            }

            $query = $this->db->get();

            return $query->result();
        }
    }

    /**
     * Get product by his is
     * @param int $product_id 
     * @return array
     */
    public function get_references_by_id($id, $table = '', $arr_columns = array()) {
        $arr_cols = implode(',', $arr_columns);
        $this->db->select($arr_cols);
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch manufacturers data from the database
     * possibility to mix search, filter and order
     * @param string $search_string 
     * @param strong $order
     * @param string $order_type 
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_references($table = '', $arr_columns = array(), $arr_where = array(), $search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null) {

        $arr_cols = implode(',', $arr_columns);
        $this->db->select($arr_cols);
        $this->db->from($table);

        if ($search_string) {            
            $this->db->like('name', $search_string);
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
    function count_references($table, $search_field, $search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from($table);
        if ($search_string) {
            $this->db->like($search_field, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * 
     * Run generic Query
     */

    function genericQuery($strSQL) {
        if (!empty($strSQL)) {
            try {
                $query = $this->db->query($strSQL);
                if (!$query) {
                    throw new Exception($this->db->_error_message(), $this->db->_error_number());
                    return FALSE;
                } else {
                    return $query->result();
                }
            } catch (Exception $e) {
                return;
            }
        } else {
            return FALSE;
        }
    }

}
