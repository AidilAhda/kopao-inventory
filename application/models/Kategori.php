<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Model
{
    public function muatSemuaKategori()
    {
        return $this->db->get('kategori')->result_array();
    }
    public function simpanData($data)
    {
        return $this->db->insert('kategori', $data);
    }
}
