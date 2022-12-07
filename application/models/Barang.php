<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Model
{
    public function muatSemuaDataBarang()
    {
        $this->db->join('kategori k', 'db.kategori_id = k.id_kategori');
        return $this->db->get('databarang db')->result_array();
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
    public function muatDataBarang($id)
    {
        if ($id != null) {
            return $this->db->get_where('databarang', ['id_barang' => $id])->row_array();
        } else {
            return $this->db->get_where('databarang', ['id_barang' => $id])->result_array();
        }
    }
    public function updateDataBarang($id, $data)
    {
        $this->db->where('id_barang', $id);
        return $this->db->update('databarang', $data);
    }
    public function hapusDataBarang($id)
    {
        return $this->db->delete('databarang', ['id_barang' => $id]);
    }
}
