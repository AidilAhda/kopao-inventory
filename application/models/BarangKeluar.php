<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangKeluar extends CI_Model
{
    public function idBarangkeluarTerbesar()
    {
        $this->db->select('id_barang_keluar');
        $this->db->like('id_barang_keluar', 'BK', 'after');
        $this->db->order_by('id_barang_keluar', 'desc');
        $this->db->limit(1);
        return $this->db->get('barangkeluar')->row_array()['id_barang_keluar'];
    }
    public function muatBarangKeluar($user)
    {
        $this->db->join('kategori k', 'bk.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        $this->db->order_by('tanggal_masuk', 'desc');
        return $this->db->get_where('barangkeluar bk ', ['bk.nama_cabang' => $user])->result_array();
    }
    public function simpanBarangkeluar($data)
    {
        return $this->db->insert('barangkeluar', $data);
    }
}
