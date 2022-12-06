<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Model
{
    public function muatSemuaDataBarang()
    {
        return $this->db->get('databarang')->result_array();
    }
}
