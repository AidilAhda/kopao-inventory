<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StokCabang extends CI_Model
{
    public function muatStok($cabang)
    {
        $this->db->join('kategori k', 'sc.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'sc.barang_id = b.id_barang');
        return $this->db->get_where('stokcabang sc ', ['sc.nama_cabang' => $cabang])->result_array();
    }
    public function muatStokCabang($cabang)
    {
        $this->db->join('kategori k', 'sc.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'sc.barang_id = b.id_barang');
        return $this->db->get_where('stokcabang sc ', ['sc.id_user' => $cabang])->result_array();
    }
    public function muatCabang($cabang)
    {
        return $this->db->get_where('stokcabang sc ', ['sc.id_user' => $cabang])->row_array();
    }
    public function updateStokCabang($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('stokcabang', $data);
    }
}
