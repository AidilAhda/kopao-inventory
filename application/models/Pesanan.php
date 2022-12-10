<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Model
{
    public function muatPesanan($user)
    {
        $this->db->join('kategori k', 'p.kategori_id = k.id_kategori');
        $this->db->join('barang b', 'p.barang_id = b.id_barang');
        return $this->db->get_where('pesanan p ', ['p.nama_cabang' => $user])->result_array();
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
}
