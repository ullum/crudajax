<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_model extends CI_Model
{

    function ambildata()
    {
        $result = $this->db->query('select * from siswa ');
        return $result;
    }

    function tambahdata($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function ambilNim($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    // Fungsi Edit Data
    function editdata($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
}
