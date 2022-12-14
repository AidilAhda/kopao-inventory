<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Model
{
    public function muatSemuaKategori()
    {

        return $this->db->get('kategori')->result_array();
    }
    public function simpanKategori($data)
    {
        return $this->db->insert('kategori', $data);
    }
    public function muatKategori($id)
    {
        if ($id != null) {
            return $this->db->get_where('kategori', ['id_kategori' => $id])->row_array();
        } else {
            return $this->db->get_where('kategori', ['id_kategori' => $id])->result_array();
        }
    }
    public function updateKategori($id, $data)
    {
        $this->db->where('id_kategori', $id);
        return $this->db->update('kategori', $data);
    }
    public function hapusKategori($id)
    {
        return $this->db->delete('kategori', ['id_kategori' => $id]);
    }
}
