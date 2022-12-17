<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends CI_Model
{
    public function idBarangMasukTerbesar()
    {
        $this->db->select('id_barang_masuk');
        $this->db->like('id_barang_masuk', 'BM', 'after');
        $this->db->order_by('id_barang_masuk', 'desc');
        $this->db->limit(1);
        return $this->db->get('barangmasuk')->row_array()['id_barang_masuk'];
    }

    public function muatBarangMasuk($user)
    {
        $this->db->join('kategori k', 'bm.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        $this->db->order_by('tanggal_masuk', 'desc');
        return $this->db->get_where('barangmasuk bm ', ['bm.nama_cabang' => $user])->result_array();
    }
    public function muatSemuaBarangMasuk($limit = null, $id_cabang = null, $range = null)
    {
        $this->db->join('kategori k', 'bm.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        if ($limit != null) {
            $this->db->limit($limit);
        }

        $this->db->where('id_user', $id_cabang);

        if ($range != null) {
            $this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
            $this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
        }
        $this->db->order_by('id_barang_masuk', 'DESC');
        return $this->db->get('barangmasuk bm')->result_array();
    }
    public function simpanBarangMasuk($data)
    {
        return $this->db->insert('barangmasuk', $data);
    }
}
