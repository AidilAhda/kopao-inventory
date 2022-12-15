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
    public function muatSemuaBarangKeluar($limit = null, $id_barang = null, $range = null)
    {
        $this->db->join('kategori k', 'bk.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }

        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        $this->db->order_by('id_barang_keluar', 'DESC');
        return $this->db->get('barangkeluar bk')->result_array();
    }
    public function simpanBarangkeluar($data)
    {
        return $this->db->insert('barangkeluar', $data);
    }
}
