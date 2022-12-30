<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangCabang extends CI_Model
{

    public function muatStokCabang($cabang)
    {
        $this->db->join('kategori k', 'sc.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'sc.barang_id = b.id_barang');
        return $this->db->get_where('barangcabang sc ', ['sc.id_user' => $cabang])->result_array();
    }

    public function simpanStokCabang($data)
    {
        return $this->db->insert('barangcabang', $data);
    }
}
