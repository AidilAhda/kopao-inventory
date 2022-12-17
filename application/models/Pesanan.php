<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Model
{

    public function muatSemuaPesanan($limit = null, $id = null, $range = null)
    {
        $this->db->join('kategori k', 'p.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'p.barang_id = b.id_barang');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        if ($id != null) {
            $this->db->where('p.id_user', $id);
        }
        if ($range != null) {
            $this->db->where('tanggal_pesanan' . ' >=', $range['mulai']);
            $this->db->where('tanggal_pesanan' . ' <=', $range['akhir']);
        }
        $this->db->where('p.status', 'Disetujui');

        $this->db->order_by('tanggal_pesanan', 'asc');
        return $this->db->get('pesanan p ')->result_array();
    }

    public function muatPesanan($isAdmin, $id)
    {
        $this->db->join('kategori k', 'p.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'p.barang_id = b.id_barang');
        if ($isAdmin) {
            $this->db->where('p.status', 'Pending');
        }
        $this->db->order_by('p.tanggal_pesanan', 'desc');
        return $this->db->get_where('pesanan p ', ['p.id_user' => $id])->result_array();
    }

    public function cetakPesanan($id)
    {
        $this->db->join('kategori k', 'p.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'p.barang_id = b.id_barang');
        $this->db->order_by('p.tanggal_pesanan', 'desc');
        return $this->db->get_where('pesanan p ', ['p.id_pesanan' => $id])->result_array();
    }
    public function idPesananTerbesar()
    {
        $this->db->select('id_pesanan');
        $this->db->like('id_pesanan', 'PC', 'after');
        $this->db->order_by('id_pesanan', 'desc');
        $this->db->limit(1);
        return $this->db->get('pesanan')->row_array()['id_pesanan'];
    }
    public function simpanPesanan($data)
    {
        return $this->db->insert('pesanan', $data);
    }
    public function updatePesanan($id, $data)
    {
        $this->db->where('id_pesanan', $id);
        return $this->db->update('pesanan', $data);
    }
}
