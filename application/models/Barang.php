<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Model
{
    public function muatSemuaBarang()
    {
        $this->db->join('kategori k', 'db.kategori_id = k.id_kategori');
        return $this->db->get('barang db')->result_array();
    }
    public function idBarangTerbesar()
    {
        $this->db->select_max('id_barang');
        return $this->db->get('barang')->row_array()['id_barang'];
    }
    public function simpanBarang($data)
    {
        return $this->db->insert('barang', $data);
    }
    public function muatBarang($id)
    {
        if ($id != null) {
            return $this->db->get_where('barang', ['id_barang' => $id])->row_array();
        } else {
            return $this->db->get_where('barang', ['id_barang' => $id])->result_array();
        }
    }
    public function updateBarang($id, $data)
    {
        $this->db->where('id_barang', $id);
        return $this->db->update('barang', $data);
    }
    public function hapusBarang($id)
    {
        return $this->db->delete('barang', ['id_barang' => $id]);
    }
}
