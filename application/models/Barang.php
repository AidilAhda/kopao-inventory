<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Model
{
    public function muatSemuaDataBarang()
    {
        return $this->db->get('databarang')->result_array();
    }
    public function idBarangTerbesar()
    {
        $this->db->select_max('id_barang');
        return $this->db->get('databarang')->row_array()['id_barang'];
    }
    public function simpanDataBarang($data)
    {
        return $this->db->insert('databarang', $data);
    }
}
