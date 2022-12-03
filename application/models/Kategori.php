<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Model
{
    public function muatSemuaKategori()
    {
        return $this->db->get('kategori')->result_array();
    }
    public function simpanData($data)
    {
        return $this->db->insert('kategori', $data);
    }
    public function getData($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }
    public function updateData($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }
    public function hapusData($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }
}
